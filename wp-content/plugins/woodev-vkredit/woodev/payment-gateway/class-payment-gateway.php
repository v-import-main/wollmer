<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Woodev_Payment_Gateway' ) ) :

abstract class Woodev_Payment_Gateway extends WC_Payment_Gateway {

	const TRANSACTION_TYPE_CHARGE = 'charge';

	const TRANSACTION_TYPE_AUTHORIZATION = 'authorization';

	const ENVIRONMENT_PRODUCTION = 'production';

	const ENVIRONMENT_TEST = 'test';

	const DEBUG_MODE_LOG = 'log';

	const DEBUG_MODE_CHECKOUT = 'checkout';

	const DEBUG_MODE_BOTH = 'both';

	const DEBUG_MODE_OFF = 'off';

	const GATEWAY_TYPE_DIRECT = 'direct';

	const GATEWAY_TYPE_HOSTED = 'hosted';
	
	const PAYMENT_TYPE_CREDIT_CARD = 'credit-card';
	
	const PAYMENT_TYPE_ECHECK = 'echeck';
	
	const PAYMENT_TYPE_MULTIPLE = 'multiple';
	
	const PAYMENT_TYPE_BANK_TRANSFER = 'bank_transfer';
	
	const FEATURE_PRODUCTS = 'products';
	
	const FEATURE_CARD_TYPES = 'card_types';
	
	const FEATURE_TOKENIZATION = 'tokenization';
	
	const FEATURE_CREDIT_CARD_CHARGE = 'charge';
	
	const FEATURE_CREDIT_CARD_AUTHORIZATION = 'authorization';
	
	const FEATURE_CREDIT_CARD_CAPTURE = 'capture_charge';
	
	const FEATURE_DETAILED_CUSTOMER_DECLINE_MESSAGES = 'customer_decline_messages';
	
	const FEATURE_REFUNDS = 'refunds';
	
	const FEATURE_VOIDS = 'voids';
	
	const FEATURE_PAYMENT_FORM = 'payment_form';
	
	const FEATURE_CUSTOMER_ID = 'customer_id';
	
	private $plugin;
	
	private $payment_type;
	
	private $environments;
	
	private $available_card_types;
	
	private $currencies;
	
	private $environment;
	
	private $transaction_type;
	
	private $card_types;
	
	private $enable_csc;
	
	private $supported_check_fields;
	
	private $tokenization;
	
	private $enable_customer_decline_messages;
	
	private $debug_mode;
	
	private $inherit_settings;
	
	private $shared_settings = array();

	public function __construct( $id, $plugin, $args ) {
		
		$this->payment_type = isset( $args['payment_type'] ) ? $args['payment_type'] : self::PAYMENT_TYPE_CREDIT_CARD;
		
		if ( $this->is_credit_card_gateway() ) {
			$this->add_support( self::FEATURE_CREDIT_CARD_CHARGE );
		}
		
		$this->id          = $id;
		$this->plugin      = $plugin;
		$this->get_plugin()->set_gateway( $id, $this );
		
		if ( isset( $args['method_title'] ) ) {
			$this->method_title = $args['method_title'];
		}
		if ( isset( $args['method_description'] ) ) {
			$this->method_description = $args['method_description'];
		}
		if ( isset( $args['supports'] ) ) {
			$this->set_supports( $args['supports'] );
		}
		if ( isset( $args['card_types'] ) ) {
			$this->available_card_types = $args['card_types'];
		}
		if ( isset( $args['echeck_fields'] ) ) {
			$this->supported_check_fields = $args['echeck_fields'];
		}
		if ( isset( $args['environments'] ) ) {
			$this->environments = array_merge( $this->get_environments(), $args['environments'] );
		}
		if ( isset( $args['countries'] ) ) {
			$this->countries = $args['countries'];
		}
		if ( isset( $args['shared_settings'] ) ) {
			$this->shared_settings = $args['shared_settings'];
		}
		if ( isset( $args['currencies'] ) ) {
			$this->currencies = $args['currencies'];
		} else {
			$this->currencies = $this->get_plugin()->get_accepted_currencies();
		}
		if ( isset( $args['order_button_text'] ) ) {
			$this->order_button_text = $args['order_button_text'];
		} else {
			$this->order_button_text = $this->get_order_button_text();
		}
		
		$this->has_fields = true;
		$this->icon = apply_filters( 'wc_' . $this->get_id() . '_icon', '' );
		
		$this->init_form_fields();
		
		$this->init_settings();

		$this->load_settings();
		
		$this->add_pay_page_handler();
		
		add_filter( 'woocommerce_thankyou_order_received_text', array( $this, 'maybe_render_held_order_received_text' ), 10, 2 );
		
		if ( is_admin() ) {
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->get_id(), array( $this, 'process_admin_options' ) );
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
		$this->add_api_request_logging();
	}
	
	protected function load_settings() {
		
		foreach ( $this->settings as $setting_key => $setting ) {
			$this->$setting_key = $setting;
		}
		
		if ( $this->inherit_settings() ) {
		
			$other_gateway_ids = array_diff( $this->get_plugin()->get_gateway_ids(), array( $this->get_id() ) );
			
			foreach ( $other_gateway_ids as $other_gateway_id ) {

				$other_gateway_settings = $this->get_plugin()->get_gateway_settings( $other_gateway_id );
				
				if ( ! isset( $other_gateway_settings['inherit_settings'] ) || 'no' == $other_gateway_settings['inherit_settings'] ) {
				
					$other_gateway = $this->get_plugin()->get_gateway( $other_gateway_id );

					foreach ( $this->shared_settings as $setting_key ) {
						$this->$setting_key = $other_gateway->$setting_key;
					}
				}
			}
		}
	}
	
	public function enqueue_scripts() {
		
		if ( ! $this->is_available() || wp_script_is( 'woodev-payment-gateway-frontend', 'enqueued' ) || wp_script_is( 'wc-' . $this->get_plugin()->get_id_dasherized(), 'enqueued' ) ) {
			return false;
		}

		$localized_script_handle = '';
		
		if ( $this->supports_payment_form() || $this->supports( 'add_payment_method' ) || ( $this->get_plugin()->supports( 'my_payment_methods' ) && is_account_page() ) ) {

			wp_enqueue_script( 'jquery-payment' );
			
			wp_enqueue_script( 'woodev-payment-gateway-frontend', $this->get_plugin()->get_payment_gateway_framework_assets_url() . '/js/frontend/woodev-payment-gateway-frontend.js', array(), $this->get_plugin()->get_version(), true );
			
			wp_enqueue_style( 'woodev-payment-gateway-frontend', $this->get_plugin()->get_payment_gateway_framework_assets_url() . '/css/frontend/woodev-payment-gateway-frontend.css', array(), $this->get_plugin()->get_version() );

			$localized_script_handle = 'woodev-payment-gateway-frontend';
		}
		
		if ( is_readable( $this->get_plugin()->get_plugin_path() . '/assets/js/frontend/wc-' . $this->get_plugin()->get_id_dasherized() . '.js' ) ) {

			$script_src = apply_filters( 'wc_payment_gateway_' . $this->get_plugin()->get_id() . '_javascript_url', $this->get_plugin()->get_plugin_url() . '/assets/js/frontend/wc-' . $this->get_plugin()->get_id_dasherized() . '.js' );

			wp_enqueue_script( 'wc-' . $this->get_plugin()->get_id_dasherized(), $script_src, array(), $this->get_plugin()->get_version(), true );

			$localized_script_handle = 'wc-' . $this->get_plugin()->get_id_dasherized();
		}
		
		if ( $localized_script_handle ) {

			$params = apply_filters( 'wc_gateway_' . $this->get_plugin()->get_id() . '_js_localize_script_params', $this->get_js_localize_script_params() );

			wp_localize_script( $localized_script_handle, $this->get_plugin()->get_id() . '_params', $params );
		}

		return true;
	}
	
	public function is_pay_page_gateway() {

		if ( is_checkout_pay_page() ) {

			$order_id  = $this->get_checkout_pay_page_order_id();

			if ( $order_id ) {
				$order = wc_get_order( $order_id );

				return $order->payment_method == $this->get_id();
			}

		}

		return null;
	}
	
	protected function get_js_localize_script_params() {

		return array(
			'card_number_missing'            => 'Номер карты отсутствует',
			'card_number_invalid'            => 'Номер карты недействителен',
			'card_number_digits_invalid'     => 'Номер карты недействителен (разрешены только цифры)',
			'card_number_length_invalid'     => 'Номер карты недействителен (неправильная длина)',
			'cvv_missing'                    => 'Код безопасности карты отсутствует',
			'cvv_digits_invalid'             => 'Код безопасности карты недействителен (разрешены только цифры)',
			'cvv_length_invalid'             => 'Код безопасности карты недействителен (должено быть 3 или 4 цифры)',
			'card_exp_date_invalid'          => 'Срок действия карты недействителен',
			'check_number_digits_invalid'    => 'Номер проверки недействителен (разрешены только цифры)',
			'check_number_missing'           => 'Номер проверки отсутствует',
			'drivers_license_state_missing'  => 'Вы не указали ваше водительское удостоверение',
			'drivers_license_number_missing' => 'Вы не указали номер вашего водительского удостоверения',
			'drivers_license_number_invalid' => 'Номер водительского удостоверения недействителен',
			'account_number_missing'         => 'Номер счета отсутствует',
			'account_number_invalid'         => 'Номер счета недействителен (разрешены только цифры)',
			'account_number_length_invalid'  => 'Номер счета недействителен (должено быть от 5 до 17 цифр)',
			'routing_number_missing'         => 'Routing Number is missing',
			'routing_number_digits_invalid'  => 'Routing Number is invalid (only digits are allowed)',
			'routing_number_length_invalid'  => 'Routing number is invalid (must be 9 digits)',
		);

	}
	
	protected function get_order_button_text() {

		$text = $this->is_hosted_gateway() ? 'Продолжить' : 'Разместить заказ';

		return apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_order_button_text', $text, $this );
	}
	
	protected function add_pay_page_handler() {
		add_action( 'woocommerce_receipt_' . $this->get_id(), array( $this, 'payment_page' ) );
	}
	
	public function payment_page( $order_id ) {
		echo '<p>Спасибо за ваш заказ.</p>';
	}
	
	public function supports_payment_form() {

		return $this->supports( self::FEATURE_PAYMENT_FORM );
	}
	
	public function payment_fields() {

		if ( $this->supports_payment_form() ) {

			$form = new Woodev_Payment_Gateway_Payment_Form( $this );

			$form->render();

		} else {

			parent::payment_fields();
		}
	}
	
	public function get_payment_method_defaults() {

		assert( $this->supports_payment_form() );

		$defaults = array(
			'account-number' => '',
			'routing-number' => '',
			'expiry'         => '',
			'csc'            => '',
		);

		if ( $this->is_test_environment() ) {
			$defaults['expiry'] = '01/' . ( date( 'Y' ) + 1 );
			$defaults['csc'] = '123';
		}

		return $defaults;
	}
	
	protected function get_default_title() {
		
		if ( $this->is_credit_card_gateway() ) {
			return 'Банковская карта';
		} elseif ( $this->is_echeck_gateway() ) {
			return 'eCheck';
		}
	}
	
	protected function get_default_description() {

		if ( $this->is_credit_card_gateway() ) {
			return 'Оплатить с помощью вашей банковской карты.';
		} elseif ( $this->is_echeck_gateway() ) {
			return 'Оплатить с помощью вашего банковского счёта.';
		}
	}
	
	public function init_form_fields() {
		
		$this->form_fields = array(

			'enabled' => array(
				'title'   => 'Вкл/Выкл',
				'label'   => 'Использовать этот шлюз.',
				'type'    => 'checkbox',
				'default' => 'no',
			),

			'title' => array(
				'title'    => 'Название',
				'type'     => 'text',
				'desc_tip' => 'Название данного платёжного шлюза которое будет видеть покупатель при офорлении заказа.',
				'default'  => $this->get_default_title(),
			),

			'description' => array(
				'title'    => 'Описание',
				'type'     => 'textarea',
				'desc_tip' => 'Описание данного метода оплаты которое увидит покупатель когда выбирет данный шлюз.',
				'default'  => $this->get_default_description(),
			),

		);
		
		if ( $this->is_credit_card_gateway() ) {
			$this->form_fields = $this->add_csc_form_fields( $this->form_fields );
		}
		
		if ( $this->supports_credit_card_authorization() && $this->supports_credit_card_charge() ) {
			$this->form_fields = $this->add_authorization_charge_form_fields( $this->form_fields );
		}
		
		if ( $this->supports_card_types() ) {
			$this->form_fields = $this->add_card_types_form_fields( $this->form_fields );
		}
		
		if ( $this->supports_tokenization() ) {
			$this->form_fields = $this->add_tokenization_form_fields( $this->form_fields );
		}
		
		if ( count( $this->get_environments() ) > 1 ) {
			$this->form_fields = $this->add_environment_form_fields( $this->form_fields );
		}
		
		if ( count( $this->shared_settings ) ) {
			$this->form_fields = $this->add_shared_settings_form_fields( $this->form_fields );
		}
		
		$gateway_form_fields = $this->get_method_form_fields();
		$this->form_fields = array_merge( $this->form_fields, $gateway_form_fields );
		
		if ( $this->supports( self::FEATURE_DETAILED_CUSTOMER_DECLINE_MESSAGES ) ) {
			$this->form_fields['enable_customer_decline_messages'] = array(
				'title'   => 'Сообщения об отказе',
				'type'    => 'checkbox',
				'label'   => 'Установите этот чекбокс, чтобы включить подробные сообщения об отказе клиенту во время оформления заказа, а не общее сообщение об отказе.',
				'default' => 'no',
			);
		}
		
		$this->form_fields['debug_mode'] = array(
			'title'   => 'Режим отладки',
			'type'    => 'select',
			'desc'    => sprintf( 'Показать отчёты об ошибках и запросы/ответы API на странице оформления заказа и/или сохранить их в <a href="%s">лог</a>', Woodev_Helper::get_wc_log_file_url( $this->get_id() ) ),
			'default' => self::DEBUG_MODE_OFF,
			'options' => array(
				self::DEBUG_MODE_OFF      => 'Выкл',
				self::DEBUG_MODE_CHECKOUT => 'Показывать на странице оформления заказа',
				self::DEBUG_MODE_LOG      => 'Записывать в лог',
				self::DEBUG_MODE_BOTH     => 'Оба варианта (и показывать и записывать)'
			),
		);
		
		foreach ( $this->shared_settings as $field_name ) {
			$this->form_fields[ $field_name ]['class'] = trim( isset( $this->form_fields[ $field_name ]['class'] ) ? $this->form_fields[ $field_name ]['class'] : '' ) . ' shared-settings-field';
		}
		
		$this->form_fields = apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_form_fields', $this->form_fields, $this );
	}
	
	abstract protected function get_method_form_fields();
	
	protected function add_environment_form_fields( $form_fields ) {

		$form_fields['environment'] = array(
			'title'    => 'Режим/среда',
			'type'     => 'select',
			'default'  => key( $this->get_environments() ),
			'desc_tip' => 'Выберите режим работы шлюза, которая будет использоваться для транзакций.',
			'options'  => $this->get_environments(),
		);

		return $form_fields;
	}
	
	protected function add_shared_settings_form_fields( $form_fields ) {
		
		$other_gateway_ids                  = array_diff( $this->get_plugin()->get_gateway_ids(), array( $this->get_id() ) );
		$configured_other_gateway_ids       = array();
		$inherit_settings_other_gateway_ids = array();
		
		foreach ( $other_gateway_ids as $other_gateway_id ) {

			$other_gateway_settings = $this->get_plugin()->get_gateway_settings( $other_gateway_id );
			
			if ( isset( $other_gateway_settings['inherit_settings'] ) && 'yes' == $other_gateway_settings['inherit_settings'] ) {
				$inherit_settings_other_gateway_ids[] = $other_gateway_id;
			}

			foreach ( $this->shared_settings as $setting_name ) {
			
				if ( isset( $other_gateway_settings[ $setting_name ] ) && $other_gateway_settings[ $setting_name ] ) {

					$configured_other_gateway_ids[] = $other_gateway_id;
					break;
				}
			}
		}
		
		$form_fields['inherit_settings'] = array(
			'title'       => 'Поделиться настройками соединения',
			'type'        => 'checkbox',
			'label'       => 'Использовать настройки подключения/аутентификации с другого шлюза',
			'default'     => count( $configured_other_gateway_ids ) > 0 ? 'yes' : 'no',
			'disabled'    => count( $inherit_settings_other_gateway_ids ) > 0 ? true : false,
			'description' => count( $inherit_settings_other_gateway_ids ) > 0 ? 'Отключено, потому что другой шлюз использует эти настройки' : '',
		);

		return $form_fields;
	}
	
	protected function add_csc_form_fields( $form_fields ) {

		$form_fields['enable_csc'] = array(
			'title'   => 'Проверка карты (CSC)',
			'label'   => 'Отображение поля кода безопасности карты (CV2) при оформлении заказа',
			'type'    => 'checkbox',
			'default' => 'yes',
		);

		return $form_fields;
	}
	
	public function admin_options() {

		parent::admin_options();

		?>
		<style type="text/css">.nowrap { white-space: nowrap; }</style>
		<?php

		if ( count( $this->get_environments() ) > 1 ) {

			ob_start();
			?>
				$( '#woocommerce_<?php echo $this->get_id(); ?>_environment' ).change( function() {

					var inheritSettings = $( '#woocommerce_<?php echo $this->get_id(); ?>_inherit_settings' ).is( ':checked' );
					var environment = $( this ).val();
					
					$( '.environment-field' ).closest( 'tr' ).hide();
					
					var $environmentFields = $( '.' + environment + '-field' );
					
					if ( inheritSettings ) {
						$environmentFields = $environmentFields.not( '.shared-settings-field' );
					}

					$environmentFields.not( '.hidden' ).closest( 'tr' ).show();

				} ).change();
			<?php

			wc_enqueue_js( ob_get_clean() );

		}

		if ( ! empty( $this->shared_settings ) ) {
			ob_start();
			?>
				$( '#woocommerce_<?php echo $this->get_id(); ?>_inherit_settings' ).change( function() {

					var enabled = $( this ).is( ':checked' );

					if ( enabled ) {
						$( '.shared-settings-field' ).closest( 'tr' ).hide();
					} else {
						$( '.shared-settings-field' ).closest( 'tr' ).show();
						$( '#woocommerce_<?php echo $this->get_id(); ?>_environment' ).change();
					}

				} ).change();
			<?php

			wc_enqueue_js( ob_get_clean() );

		}

	}
	
	public function is_available() {
		
		$is_available = parent::is_available();
		
		if ( ! $this->is_configured() ) {
			$is_available = false;
		}
		
		if ( count( $this->get_plugin()->get_missing_dependencies() ) > 0 ) {
			$is_available = false;
		}
		
		if ( ! $this->currency_is_accepted() ) {
			$is_available = false;
		}
		
		if ( $this->countries && WC()->customer && WC()->customer->get_country() && ! in_array( WC()->customer->get_country(), $this->countries ) ) {
			$is_available = false;
		}

		return apply_filters( 'wc_gateway_' . $this->get_id() . '_is_available', $is_available );
	}
	
	protected function is_configured() {
		return true;
	}
	
	public function get_icon() {

		$icon = '';
		
		if ( $this->icon ) {
			$icon = sprintf( '<img src="%s" alt="%s" class="woodev-payment-gateway-icon wc-%s-payment-gateway-icon" />', esc_url( WC_HTTPS::force_https_url( $this->icon ) ), esc_attr( $this->get_title() ), esc_attr( $this->get_id_dasherized() ) );
		}
		
		if ( ! $icon && $this->supports_card_types() && $this->get_card_types() ) {
			
			foreach ( $this->get_card_types() as $card_type ) {

				if ( $url = $this->get_payment_method_image_url( $card_type ) ) {
					$icon .= sprintf( '<img src="%s" alt="%s" class="woodev-payment-gateway-icon wc-%s-payment-gateway-icon" width="40" height="25" />', esc_url( $url ), esc_attr( strtolower( $card_type ) ), esc_attr( $this->get_id_dasherized() ) );
				}
			}
		}
		
		if ( ! $icon && $this->is_echeck_gateway() ) {

			if ( $url = $this->get_payment_method_image_url( 'echeck' ) ) {
				$icon .= sprintf( '<img src="%s" alt="%s" class="woodev-payment-gateway-icon wc-%s-payment-gateway-icon" width="40" height="25" />', esc_url( $url ), esc_attr( 'echeck' ), esc_attr( $this->get_id_dasherized() ) );
			}
		}

		return apply_filters( 'woocommerce_gateway_icon', $icon, $this->get_id() );
	}
	
	public function get_payment_method_image_url( $type ) {

		$image_type = strtolower( $type );
		
		switch( $image_type ) {

			case 'american express':
				$image_type = 'amex';
			break;

			case 'discover':
				$image_type = 'disc';
			break;

			case 'mastercard':
				$image_type = 'mc';
			break;

			case 'paypal':
				$image_type = 'paypal-1';
			break;

			case 'visa debit':
				$image_type = 'visa-debit';
			break;

			case 'visa electron':
				$image_type = 'visa-electron';
			break;

			case 'card':
				$image_type = 'cc-plain';
			break;
		}
		
		if ( ! $image_type ) {
			if ( $this->is_credit_card_gateway() ) {
				$image_type = 'cc-plain';
			}
		}
		
		$image_extension = apply_filters( 'wc_payment_gateway_' . $this->get_plugin()->get_id() . '_use_svg', true ) ? '.svg' : '.png';
		
		if ( is_readable( $this->get_plugin()->get_payment_gateway_framework_assets_path() . '/images/card-' . $image_type . $image_extension ) ) {
			return WC_HTTPS::force_https_url( $this->get_plugin()->get_payment_gateway_framework_assets_url() . '/images/card-' . $image_type . $image_extension );
		}
		
		if ( is_readable( $this->get_plugin()->get_payment_gateway_framework_assets_path() . '/images/card-' . $image_type . $image_extension ) ) {
			return WC_HTTPS::force_https_url( $this->get_plugin()->get_payment_gateway_framework_assets_url() . '/images/card-' . $image_type . $image_extension );
		}

		return null;
	}
	
	protected function get_order( $order ) {

		if ( is_numeric( $order ) ) {
			$order = wc_get_order( $order );
		}
		
		$order->payment_total = number_format( $order->get_total(), 2, '.', '' );
		
		if ( 0 != $order->get_user_id() && false !== ( $customer_id = $this->get_customer_id( $order->get_user_id(), array( 'order' => $order ) ) ) ) {
			$order->customer_id = $customer_id;
		}
		
		$order->payment = new stdClass();
		
		$order->payment->type = str_replace( '-', '_', $this->get_payment_type() );

		$order->description = sprintf( '%s - Заказ %s', esc_html( get_bloginfo( 'name' ) ), $order->get_order_number() );

		$order = $this->get_order_with_unique_transaction_ref( $order );
		
		return apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_get_order_base', $order, $this );
	}
	
	public function supports_refunds() {
		return $this->supports( self::FEATURE_REFUNDS );
	}
	
	public function process_refund( $order_id, $amount = null, $reason = '' ) {
		
		$order = $this->get_order_for_refund( $order_id, $amount, $reason );
		
		if ( is_wp_error( $order ) ) {
			return $order;
		}
		
		if ( $this->supports_voids() && $this->authorization_valid_for_capture( $order ) ) {
			return $this->process_void( $order );
		}

		try {

			$response = $response = $this->get_api()->refund( $order );
			
			if ( $this->supports_voids() && $this->maybe_void_instead_of_refund( $order, $response ) ) {
				return $this->process_void( $order );
			}

			if ( $response->transaction_approved() ) {
			
				$this->add_refund_data( $order, $response );
				
				$this->add_payment_gateway_refund_data( $order, $response );
				
				$this->add_refund_order_note( $order, $response );
				
				if ( $order->get_total() == $order->get_total_refunded() ) {

					$this->mark_order_as_refunded( $order );
				}

				return true;

			} else {

				$error = $this->get_refund_failed_wp_error( $response->get_status_code(), $response->get_status_message() );

				$order->add_order_note( $error->get_error_message() );

				return $error;
			}

		} catch ( Woodev_Plugin_Exception $e ) {

			$error = $this->get_refund_failed_wp_error( $e->getCode(), $e->getMessage() );

			$order->add_order_note( $error->get_error_message() );

			return $error;
		}
	}
	
	protected function get_order_for_refund( $order, $amount, $reason ) {

		if ( is_numeric( $order ) ) {
			$order = wc_get_order( $order );
		}
		
		$order->refund = new stdClass();
		$order->refund->amount = number_format( $amount, 2, '.', '' );
		$order->refund->reason = $reason ? $reason : sprintf( '%s - Возврат для заказа %s', esc_html( get_bloginfo( 'name' ) ), $order->get_order_number() );
		$order->refund->trans_id = $this->get_order_meta( $order->get_id(), 'trans_id' );

		return apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_get_order_for_refund', $order, $this );
	}
	
	protected function add_refund_data( WC_Order $order, $response ) {
		
		$this->add_order_meta( $order->get_id(), 'refund_amount', $order->refund->amount );
		
		if ( $response && $response->get_transaction_id() ) {
			$this->add_order_meta( $order->get_id(), 'refund_trans_id', $response->get_transaction_id() );
		}
	}
	
	protected function add_payment_gateway_refund_data( WC_Order $order, $response ) {}
	
	protected function add_refund_order_note( WC_Order $order, $response ) {

		$message = sprintf(
			'%s Возврат в размере %s подтверждён.',
			$this->get_method_title(),
			wc_price( $order->refund->amount, array( 'currency' => $order->get_order_currency() ) )
		);
		
		if ( $response->get_transaction_id() ) {
			$message .= ' ' . sprintf( '(ID транзакции %s)', $response->get_transaction_id() );
		}

		$order->add_order_note( $message );
	}
	
	protected function get_refund_failed_wp_error( $error_code, $error_message ) {

		if ( $error_code ) {
			$message = sprintf(
				'%s Возврат не выполнен: %s - %s',
				$this->get_method_title(),
				$error_code,
				$error_message
			);
		} else {
			$message = sprintf(
				'%s Возврат не выполнен: %s',
				$this->get_method_title(),
				$error_message
			);
		}

		return new WP_Error( 'wc_' . $this->get_id() . '_refund_failed', $message );
	}
	
	protected function mark_order_as_refunded( $order ) {

		$order_note = sprintf( '%s Заказ полностью возмещен.', $this->get_method_title() );
		
		if ( ! $order->has_status( 'refunded' ) ) {
			$order->update_status( 'refunded', $order_note );
		} else {
			$order->add_order_note( $order_note );
		}
	}
	
	public function supports_voids() {
		return $this->supports( self::FEATURE_VOIDS ) && $this->supports_credit_card_capture();
	}
	
	protected function maybe_void_instead_of_refund( $order, $response ) {
		return false;
	}
	
	protected function process_void( WC_Order $order ) {
	
		if ( $order->refund->amount != $order->get_total() ) {
			return new WP_Error( 'wc_' . $this->get_id() . '_void_error', 'К сожалению, вы не можете частично аннулировать этот заказ. Пожалуйста, используйте полную сумму заказа.' );
		}

		try {

			$response = $this->get_api()->void( $order );

			if ( $response->transaction_approved() ) {

				$this->add_void_data( $order, $response );

				$this->add_payment_gateway_void_data( $order, $response );

				$this->mark_order_as_voided( $order, $response );

				return true;

			} else {

				$error = $this->get_void_failed_wp_error( $response->get_status_code(), $response->get_status_message() );

				$order->add_order_note( $error->get_error_message() );

				return $error;
			}

		} catch ( Woodev_Plugin_Exception $e ) {

			$error = $this->get_void_failed_wp_error( $e->getCode(), $e->getMessage() );

			$order->add_order_note( $error->get_error_message() );

			return $error;
		}
	}
	
	protected function add_void_data( WC_Order $order, $response ) {

		$this->update_order_meta( $order->get_id(), 'void_amount', $order->refund->amount );

		if ( $response && $response->get_transaction_id() ) {
			$this->add_order_meta( $order->get_id(), 'void_trans_id', $response->get_transaction_id() );
		}
	}
	
	protected function add_payment_gateway_void_data( WC_Order $order, $response ) {}
	
	protected function get_void_failed_wp_error( $error_code, $error_message ) {

		if ( $error_code ) {
			$message = sprintf(
				'%s Void Failed: %s - %s',
				$this->get_method_title(),
				$error_code,
				$error_message
			);
		} else {
			$message = sprintf(
				'%s Void Failed: %s',
				$this->get_method_title(),
				$error_message
			);
		}

		return new WP_Error( 'wc_' . $this->get_id() . '_void_failed', $message );
	}
	
	protected function mark_order_as_voided( $order, $response ) {

		$message = sprintf(
			'%s Void in the amount of %s approved.',
			$this->get_method_title(),
			wc_price( $order->refund->amount, array( 'currency' => $order->get_order_currency() ) )
		);
		
		if ( $response->get_transaction_id() ) {
			$message .= ' ' . sprintf( '(ID транзакции %s)', $response->get_transaction_id() );
		}
		
		if ( ! $order->has_status( 'cancelled' ) ) {

			$this->voided_order_message = $message;
			
			add_filter( 'woocommerce_order_fully_refunded_status', array( $this, 'maybe_cancel_voided_order' ), 10, 2 );

		} else {

			$order->add_order_note( $message );
		}
	}
	
	public function maybe_cancel_voided_order( $order_status, $order_id ) {

		if ( empty( $this->voided_order_message ) ) {
			return $order_status;
		}

		$order = wc_get_order( $order_id );
		
		$order->add_order_note( $this->voided_order_message );

		return 'cancelled';
	}
	
	protected function get_order_with_unique_transaction_ref( $order ) {
		
		if ( is_numeric( $this->get_order_meta( $order->get_id(), 'retry_count' ) ) ) {
			$retry_count = $this->get_order_meta( $order->get_id(), 'retry_count' );
			$retry_count++;
		} else {
			$retry_count = 0;
		}
		
		$this->update_order_meta( $order->get_id(), 'retry_count', $retry_count );
		
		$order->unique_transaction_ref = ltrim( $order->get_order_number(),  '#' ) . ( $retry_count > 0 ? '-' . $retry_count : '' );

		return $order;
	}
	
	protected function do_transaction_failed_result( WC_Order $order, Woodev_Payment_Gateway_API_Response $response ) {

		$order_note = '';
		
		if ( $response->get_status_code() && $response->get_status_message() ) {
			$order_note = sprintf( 'Код статуса %s: %s', $response->get_status_code(), $response->get_status_message() );
		} elseif ( $response->get_status_code() ) {
			$order_note = sprintf( 'Код статуса: %s', $response->get_status_code() );
		} elseif ( $response->get_status_message() ) {
			$order_note = sprintf( 'Сообщение статуса: %s', $response->get_status_message() );
		}
		
		if ( $response->get_transaction_id() ) {
			$order_note .= ' ' . sprintf( 'ID транзакции %s', $response->get_transaction_id() );
		}

		$this->mark_order_as_failed( $order, $order_note, $response );

		return false;
	}
	
	protected function add_transaction_data( $order, $response = null ) {

		if ( $response && $response->get_transaction_id() ) {
			$this->update_order_meta( $order->get_id(), 'trans_id', $response->get_transaction_id() );
			update_post_meta( $order->get_id(), '_transaction_id', $response->get_transaction_id() );
		}
		
		$this->update_order_meta( $order->get_id(), 'trans_date', current_time( 'mysql' ) );
		
		if ( count( $this->get_environments() ) > 1 ) {
			$this->update_order_meta( $order->get_id(), 'environment', $this->get_environment() );
		}
		
		if ( $this->supports_customer_id() ) {
			$this->add_customer_data( $order, $response );
		}
	}
	
	protected function add_payment_gateway_transaction_data( $order, $response ) {}
	
	protected function add_customer_data( $order, $response = null ) {

		$user_id = $order->get_user_id();

		if ( $response && method_exists( $response, 'get_customer_id' ) && $response->get_customer_id() ) {

			$order->customer_id = $customer_id = $response->get_customer_id();

		} else {
			$customer_id = $order->customer_id;
		}
		
		$this->update_order_meta( $order->get_id(), 'customer_id', $customer_id );
		
		if ( 0 != $user_id ) {
			$this->update_customer_id( $user_id, $customer_id );
		}
	}
	
	protected function mark_order_as_held( $order, $message, $response = null ) {

		$order_note = sprintf( '%s платёж отложен для проверки (%s)', $this->get_method_title(), $message );
		
		$order_status = apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_held_order_status', 'on-hold', $order, $response, $this );
		
		$order_status = apply_filters( 'wc_' . $this->get_id() . '_held_order_status', $order_status, $order, $response );
		
		if ( ! $order->has_status( $order_status ) ) {
			$order->update_status( $order_status, $order_note );
		} else {
			$order->add_order_note( $order_note );
		}

		$this->add_debug_message( $message, 'message', true );
		
		$user_message = '';
		if ( $response && $this->is_detailed_customer_decline_messages_enabled() ) {
			$user_message = $response->get_user_message();
		}
		
		if ( ! $user_message || ( $this->supports_credit_card_authorization() && $this->perform_credit_card_authorization( $order ) ) ) {
			$user_message = 'Ваш заказ был получен и проверяется.';
		}
		
		if ( isset( WC()->session ) ) {
			WC()->session->held_order_received_text = $user_message;
		}
	}
	
	public function maybe_render_held_order_received_text( $text, $order ) {

		if ( $order && $order->has_status( 'on-hold') && isset( WC()->session->held_order_received_text ) ) {

			$text = WC()->session->held_order_received_text;

			unset( WC()->session->held_order_received_text );
		}

		return $text;
	}
	
	protected function mark_order_as_failed( $order, $error_message, $response = null ) {

		$order_note = sprintf( '%s Платеж не прошел (%s)', $this->get_method_title(), $error_message );

		if ( ! $order->has_status( 'failed' ) ) {
			$order->update_status( 'failed', $order_note );
		} else {
			$order->add_order_note( $order_note );
		}

		$this->add_debug_message( $error_message, 'error' );
		
		$user_message = '';
		if ( $response && $this->is_detailed_customer_decline_messages_enabled() ) {
			$user_message = $response->get_user_message();
		}
		if ( ! $user_message ) {
			$user_message = 'Произошла ошибка. Повторите попытку или воспользуйтесь альтернативным способом оплаты.';
		}
		
		Woodev_Helper::wc_add_notice( $user_message, 'error' );
	}
	
	protected function mark_order_as_cancelled( $order, $message, $response = null ) {

		$order_note = sprintf( '%s Транзакция отменена (%s)', $this->get_method_title(), $message );
		
		if ( ! $order->has_status( 'cancelled' ) ) {
			$order->update_status( 'cancelled', $order_note );
		} else {
			$order->add_order_note( $order_note );
		}

		$this->add_debug_message( $message, 'error' );
	}
	
	public function supports_customer_id() {
		return $this->supports( self::FEATURE_CUSTOMER_ID );
	}
	
	public function get_customer_id( $user_id, $args = array() ) {

		$defaults = array(
			'environment_id' => $this->get_environment(),
			'autocreate'     => true,
			'order'          => null,
		);

		$args = array_merge( $defaults, $args );
		
		$customer_id = get_user_meta( $user_id, $this->get_customer_id_user_meta_name( $args['environment_id'] ), true );

		if ( ! $customer_id && $args['autocreate'] ) {
			
			if ( $args['order'] && isset( $args['order']->billing_email ) && $args['order']->billing_email ) {
				$customer_id = 'wc-' . md5( $args['order']->billing_email );
			} else {
				$customer_id = uniqid( 'wc-' . $user_id . '-' );
			}

			$this->update_customer_id( $user_id, $customer_id, $args['environment_id'] );
		}

		return $customer_id;
	}
	
	public function update_customer_id( $user_id, $customer_id, $environment_id = null ) {
		
		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}

		return update_user_meta( $user_id, $this->get_customer_id_user_meta_name( $environment_id ), $customer_id );
	}
	
	public function remove_customer_id( $user_id, $environment_id = null ){

		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}
		
		return delete_user_meta( $user_id, $this->get_customer_id_user_meta_name( $environment_id ) );
	}
	
	public function get_guest_customer_id( WC_Order $order ) {
	
		$customer_id = $this->get_order_meta( $order->get_id(), 'customer_id' );

		if ( $customer_id ) {
			return $customer_id;
		}
		
		return 'wc-guest-' . $order->get_id();
	}
	
	public function get_customer_id_user_meta_name( $environment_id = null ) {

		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}
		
		return 'wc_' . $this->get_plugin()->get_id() . '_customer_id' . ( ! $this->is_production_environment( $environment_id ) ? '_' . $environment_id : '' );
	}
	
	public function supports_credit_card_authorization() {
		return $this->is_credit_card_gateway() && $this->supports( self::FEATURE_CREDIT_CARD_AUTHORIZATION );
	}
	
	public function supports_credit_card_charge() {
		return $this->is_credit_card_gateway() && $this->supports( self::FEATURE_CREDIT_CARD_CHARGE );
	}
	
	public function supports_credit_card_capture() {
		return $this->supports( self::FEATURE_CREDIT_CARD_CAPTURE );
	}
	
	protected function add_authorization_charge_form_fields( $form_fields ) {

		assert( $this->supports_credit_card_authorization() && $this->supports_credit_card_charge() );

		$form_fields['transaction_type'] = array(
			'title'    => 'Тип транзакции',
			'type'     => 'select',
			'desc_tip' => 'Выберите, как транзакции должны быть обработаны. Charge отправляет все транзакции для расчета, авторизация просто авторизует итоговую сумму заказа для последующего захвата.',
			'default'  => self::TRANSACTION_TYPE_CHARGE,
			'options'  => array(
				self::TRANSACTION_TYPE_CHARGE        => 'Charge',
				self::TRANSACTION_TYPE_AUTHORIZATION => 'Авторизация',
			),
		);

		return $form_fields;
	}
	
	public function authorization_valid_for_capture( $order ) {

		$charge_captured = $this->get_order_meta( $order->get_id(), 'charge_captured' );

		if ( 'yes' == $charge_captured ) {
			return false;
		}
		
		$auth_can_be_captured = $this->get_order_meta( $order->get_id(), 'auth_can_be_captured' );

		if ( 'no' == $auth_can_be_captured ) {
			return false;
		}
		
		return ! $this->has_authorization_expired( $order );
	}
	
	public function has_authorization_expired( $order ) {

		$transaction_time = strtotime( $this->get_order_meta( $order->get_id(), 'trans_date' ) );

		return floor( ( time() - $transaction_time ) / 3600 ) > $this->get_authorization_time_window();
	}
	
	protected function get_authorization_time_window() {
		return 720;
	}
	
	public function perform_credit_card_charge() {

		assert( $this->supports_credit_card_charge() );

		return self::TRANSACTION_TYPE_CHARGE == $this->transaction_type;
	}
	
	public function perform_credit_card_authorization() {

		assert( $this->supports_credit_card_authorization() );

		return self::TRANSACTION_TYPE_AUTHORIZATION == $this->transaction_type;
	}
	
	public function supports_card_types() {
		return $this->is_credit_card_gateway() && $this->supports( self::FEATURE_CARD_TYPES );
	}
	
	public function get_card_types() {

		assert( $this->supports_card_types() );

		return $this->card_types;
	}
	
	protected function add_card_types_form_fields( $form_fields ) {

		assert( $this->supports_card_types() );

		$form_fields['card_types'] = array(
			'title'    => 'Разрешенный типы карт',
			'type'     => 'multiselect',
			'desc_tip' => 'Выберите какие типы карт можно использовать',
			'default'  => array_keys( $this->get_available_card_types() ),
			'class'    => 'wc-enhanced-select chosen_select',
			'css'      => 'width: 350px;',
			'options'  => $this->get_available_card_types(),
		);

		return $form_fields;
	}
	
	public function get_available_card_types() {

		assert( $this->supports_card_types() );

		if ( ! isset( $this->available_card_types ) ) {

			$this->available_card_types = array(
				'VISA'   => 'Visa',
				'MC'     => 'MasterCard',
				'AMEX'   => 'American Express',
				'DISC'   => 'Discover',
				'DINERS' => 'Diners',
				'JCB'    => 'JCB',
				'MIR'	 => 'МИР'
			);

		}
		
		return apply_filters( 'wc_' . $this->get_id() . '_available_card_types', $this->available_card_types );
	}
	
	public function supports_tokenization() {
		return $this->supports( self::FEATURE_TOKENIZATION );
	}
	
	public function tokenization_enabled() {

		assert( $this->supports_tokenization() );

		return 'yes' == $this->tokenization;
	}
	
	protected function add_tokenization_form_fields( $form_fields ) {

		assert( $this->supports_tokenization() );

		$form_fields['tokenization'] = array(
			'title'   => 'Токенизация',
			'label'   => 'Разрешить клиентам безопасно сохранять свои платежные реквизиты для последующего оформления заказа.',
			'type'    => 'checkbox',
			'default' => 'no',
		);

		return $form_fields;
	}
	
	protected function get_post( $key ) {

		if ( isset( $_POST[ $key ] ) ) {
			return trim( $_POST[ $key ] );
		}

		return '';
	}
	
	protected function get_request( $key ) {

		if ( isset( $_REQUEST[ $key ] ) ) {
			return trim( $_REQUEST[ $key ] );
		}

		return '';
	}
	
	public function add_api_request_logging() {

		if ( ! has_action( 'woodev_' . $this->get_id() . '_api_request_performed' ) ) {
			add_action( 'woodev_' . $this->get_id() . '_api_request_performed', array( $this, 'log_api_request' ), 10, 2 );
		}
	}
	
	public function log_api_request( $request, $response ) {

		$this->add_debug_message( $this->get_plugin()->get_api_log_message( $request ), 'message' );
		
		if ( ! empty( $response ) ) {
			$this->add_debug_message( $this->get_plugin()->get_api_log_message( $response ), 'message' );
		}
	}
	
	protected function add_debug_message( $message, $type = 'message' ) {

		if ( 'off' == $this->debug_off() || ! $message ) {
			return;
		}
		
		if ( $this->debug_log() ) {
			$this->get_plugin()->log( $message, $this->get_id() );
		}
		
		if ( in_array( 'wp_ajax_woocommerce_refund_line_items', $GLOBALS['wp_current_filter'] ) ) {
			return;
		}
		
		if ( ( $this->debug_checkout() || ( 'error' === $type && $this->is_test_environment() ) ) && ( ! is_admin() || defined( 'DOING_AJAX' ) ) ) {

			if ( 'message' === $type ) {
				Woodev_Helper::wc_add_notice( str_replace( "\n", "<br/>", htmlspecialchars( $message ) ), 'notice' );
			} else {
				Woodev_Helper::wc_add_notice( str_replace( "\n", "<br/>", htmlspecialchars( $message ) ), 'error' );
			}
		}
	}
	
	protected function get_payment_currency() {

		$currency = get_woocommerce_currency();
		$order_id = $this->get_checkout_pay_page_order_id();
		
		if ( $order_id ) {

			$order    = wc_get_order( $order_id );
			$currency = $order->get_currency();
		}

		return $currency;
	}
	
	public function currency_is_accepted( $currency = null ) {
		
		if ( ! $this->currencies ) {
			return true;
		}
		
		if ( null === $currency ) {
			$currency = $this->get_payment_currency();
		}

		return in_array( $currency, $this->currencies, false );
	}
	
	protected function order_needs_shipping( $order ) {

		if ( get_option( 'woocommerce_calc_shipping' ) == 'no' ) {
			return false;
		}

		foreach ( $order->get_items() as $item ) {
			$product = $order->get_product_from_item( $item );

			if ( $product->needs_shipping() ) {
				return true;
			}
		}
		
		return false;
	}
	
	public function add_order_meta( $order, $key, $value, $unique = false ) {

		if ( is_numeric( $order ) ) {
			$order = wc_get_order( $order );
		}

		if ( $order instanceof WC_Order ) {
			$order->add_meta_data( $this->get_order_meta_prefix() . $key, $value, $unique );
			$order->save_meta_data();
		}

		return $order instanceof WC_Order;
	}
	
	public function get_order_meta( $order, $key ) {

		if ( is_numeric( $order ) ) {
			$order = wc_get_order( $order );
		}

		if ( ! $order instanceof WC_Order ) {
			$meta = false;
		} else {
			$meta = $order->get_meta( $this->get_order_meta_prefix() . $key, true, 'edit' );
		}

		return $meta;
	}
	
	public function update_order_meta( $order, $key, $value ) {

		if ( is_numeric( $order ) ) {
			$order = wc_get_order( $order );
		}

		if ( $order instanceof WC_Order ) {
			$order->update_meta_data( $this->get_order_meta_prefix() . $key, $value );
			$order->save_meta_data();
		}

		return $order instanceof WC_Order;
	}
	
	public function delete_order_meta( $order, $key ) {

		if ( is_numeric( $order ) ) {
			$order = wc_get_order( $order );
		}

		if ( $order instanceof WC_Order ) {
			$order->delete_meta_data( $this->get_order_meta_prefix() . $key );
			$order->save_meta_data();
		}

		return $order instanceof WC_Order ;
	}
	
	public function get_order_meta_prefix() {

		return '_wc_' . $this->get_id() . '_';
	}
	
	public function get_id() {
		return $this->id;
	}
	
	public function get_id_dasherized() {
		return str_replace( '_', '-', $this->get_id() );
	}
	
	public function get_plugin() {
		return $this->plugin;
	}
	
	public function get_method_title() {
		return $this->method_title;
	}
	
	public function csc_enabled() {
		return 'yes' == $this->enable_csc;
	}
	
	public function inherit_settings() {
		return 'yes' == $this->inherit_settings;
	}
	
	public function get_available_countries() {
		return $this->countries;
	}
	
	public function add_support( $feature ) {

		if ( ! is_array( $feature ) ) {
			$feature = array( $feature );
		}

		foreach ( $feature as $name ) {
		
			if ( ! in_array( $name, $this->supports ) ) {

				$this->supports[] = $name;
				
				do_action( 'wc_payment_gateway_' . $this->get_id() . '_supports_' . str_replace( '-', '_', $name ), $this, $name );
			}

		}
	}
	
	public function set_supports( $features ) {
		$this->supports = $features;
	}
	
	public function supports_check_field( $field_name ) {

		assert( $this->is_echeck_gateway() );

		return is_array( $this->supported_check_fields ) && in_array( $field_name, $this->supported_check_fields );
	}
	
	public function get_environments() {
	
		if ( ! isset( $this->environments ) ) {
			$this->environments = array( self::ENVIRONMENT_PRODUCTION => 'Боевой режим' );
		}

		return $this->environments;
	}
	
	public function get_environment() {
		return $this->environment;
	}
	
	public function is_environment( $environment_id ) {
		return $environment_id == $this->get_environment();
	}
	
	public function is_production_environment( $environment_id = null ) {
	
		if ( ! is_null( $environment_id ) ) {
			return self::ENVIRONMENT_PRODUCTION == $environment_id;
		}
		
		return $this->is_environment( self::ENVIRONMENT_PRODUCTION );
	}
	
	public function is_test_environment( $environment_id = null ) {
	
		if ( ! is_null( $environment_id ) ) {
			return self::ENVIRONMENT_TEST == $environment_id;
		}
		
		return $this->is_environment( self::ENVIRONMENT_TEST );
	}
	
	public function is_enabled() {
		return 'yes' == $this->enabled;
	}
	
	public function is_detailed_customer_decline_messages_enabled() {
		return 'yes' == $this->enable_customer_decline_messages;
	}
	
	public function get_accepted_currencies() {
		return $this->currencies;
	}
	
	public function debug_off() {
		return self::DEBUG_MODE_OFF === $this->debug_mode;
	}
	
	public function debug_log() {
		return self::DEBUG_MODE_LOG === $this->debug_mode || self::DEBUG_MODE_BOTH === $this->debug_mode;
	}
	
	public function debug_checkout() {
		return self::DEBUG_MODE_CHECKOUT === $this->debug_mode || self::DEBUG_MODE_BOTH === $this->debug_mode;
	}
	
	public function is_direct_gateway() {
		return false;
	}
	
	public function is_hosted_gateway() {
		return false;
	}
	
	public function get_payment_type() {
		return $this->payment_type;
	}
	
	public function is_credit_card_gateway() {
		return self::PAYMENT_TYPE_CREDIT_CARD == $this->get_payment_type();
	}
	
	public function is_echeck_gateway() {
		return self::PAYMENT_TYPE_ECHECK == $this->get_payment_type();
	}
	
	public function get_api() {
		assert( false );
	}
	
	public function get_checkout_pay_page_order_id() {
		global $wp;

		return isset( $wp->query_vars['order-pay'] ) ? absint( $wp->query_vars['order-pay'] ) : 0;
	}
	
	public function get_checkout_order_received_order_id() {
		global $wp;

		return isset( $wp->query_vars['order-received'] ) ? absint( $wp->query_vars['order-received'] ) : 0;
	}


}

endif;