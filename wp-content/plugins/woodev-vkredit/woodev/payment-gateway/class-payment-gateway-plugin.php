<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Woodev_Payment_Gateway_Plugin' ) ) :


abstract class Woodev_Payment_Gateway_Plugin extends Woodev_Plugin {

	const FEATURE_CUSTOMER_ID = 'customer_id';

	const FEATURE_CAPTURE_CHARGE = 'capture_charge';

	const FEATURE_MY_PAYMENT_METHODS = 'my_payment_methods';

	private $gateways;

	private $currencies = array();

	private $supports = array();

	private $require_ssl;

	private $admin_user_edit_handler;

	private $my_payment_methods;

	public function __construct( $id, $version, $args ) {

		parent::__construct( $id, $version, $args );

		if ( isset( $args['gateways'] ) ) {

			foreach ( $args['gateways'] as $gateway_id => $gateway_class_name ) {
				$this->add_gateway( $gateway_id, $gateway_class_name );
			}
		}

		if ( isset( $args['currencies'] ) ) {
			$this->currencies   = $args['currencies'];
		}
		if ( isset( $args['supports'] ) ) {
			$this->supports     = $args['supports'];
		}
		if ( isset( $args['require_ssl'] ) ) {
			$this->require_ssl  = $args['require_ssl'];
		}

		if ( ! is_admin() && $this->supports( self::FEATURE_MY_PAYMENT_METHODS ) ) {
			add_action( 'wp', array( $this, 'maybe_init_my_payment_methods' ) );
		}

		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {

			if ( $this->supports( self::FEATURE_CAPTURE_CHARGE ) ) {

				add_filter( 'woocommerce_order_actions', array( $this, 'maybe_add_capture_charge_order_action' ) );
				add_action( 'woocommerce_order_action_wc_' . $this->get_id() . '_capture_charge', array( $this, 'maybe_capture_charge' ) );

				add_action( 'admin_footer-edit.php', array( $this, 'maybe_add_capture_charge_bulk_order_action' ) );
				add_action( 'load-edit.php',         array( $this, 'process_capture_charge_bulk_order_action' ) );
			}
		}

		add_filter( 'woocommerce_payment_gateways', array( $this, 'load_gateways' ) );
	}
	
	protected function init_rest_api_handler() {

		require_once( $this->get_payment_gateway_framework_path() . '/rest-api/class-payment-gateway-plugin-rest-api.php' );

		$this->rest_api_handler = new Woodev_Payment_Gateway_REST_API( $this );
	}


	public function load_gateways( $gateways ) {

		return array_merge( $gateways, $this->get_gateways() );
	}
	
	public function lib_includes() {

		parent::lib_includes();

		$payment_gateway_framework_path = $this->get_payment_gateway_framework_path();
		
		require_once( $payment_gateway_framework_path . '/api/interface-payment-gateway-api.php' );
		require_once( $payment_gateway_framework_path . '/api/interface-payment-gateway-api-request.php' );
		require_once( $payment_gateway_framework_path . '/api/interface-payment-gateway-api-response.php' );
		require_once( $payment_gateway_framework_path . '/api/interface-payment-gateway-api-authorization-response.php' );
		require_once( $payment_gateway_framework_path . '/api/interface-payment-gateway-api-create-payment-token-response.php' );
		require_once( $payment_gateway_framework_path . '/api/interface-payment-gateway-api-get-tokenized-payment-methods-response.php' );
		require_once( $payment_gateway_framework_path . '/api/interface-payment-gateway-api-payment-notification-response.php' );
		require_once( $payment_gateway_framework_path . '/api/interface-payment-gateway-api-payment-notification-credit-card-response.php' );
		require_once( $payment_gateway_framework_path . '/api/interface-payment-gateway-api-payment-notification-echeck-response.php' );
		require_once( $payment_gateway_framework_path . '/api/interface-payment-gateway-api-customer-response.php' );

		require_once( $payment_gateway_framework_path . '/exceptions/class-payment-gateway-exception.php' );

		require_once( $payment_gateway_framework_path . '/class-payment-gateway.php' );
		require_once( $payment_gateway_framework_path . '/class-payment-gateway-direct.php' );
		require_once( $payment_gateway_framework_path . '/class-payment-gateway-hosted.php' );
		require_once( $payment_gateway_framework_path . '/class-payment-gateway-payment-token.php' );
		require_once( $payment_gateway_framework_path . '/class-payment-gateway-payment-form.php' );
		require_once( $payment_gateway_framework_path . '/class-payment-gateway-my-payment-methods.php' );

		require_once( $payment_gateway_framework_path . '/api/class-payment-gateway-api-response-message-helper.php' );
		require_once( $payment_gateway_framework_path . '/class-payment-gateway-helper.php' );

		if ( is_admin() ) {
			require_once( $payment_gateway_framework_path . '/admin/class-payment-gateway-admin-user-edit-handler.php' );
			$this->get_admin_user_edit_handler();
		}
	}

	public function maybe_init_my_payment_methods() {

		if ( is_account_page() && is_user_logged_in() ) {

			$this->my_payment_methods = $this->get_my_payment_methods_instance();
		}
	}
	
	protected function get_my_payment_methods_instance() {

		return new Woodev_Payment_Gateway_My_Payment_Methods( $this );
	}
	
	public function is_plugin_settings() {

		foreach ( $this->get_gateway_class_names() as $gateway_class_name ) {
			if ( $this->is_payment_gateway_configuration_page( $gateway_class_name ) ) {
				return true;
			}
		}

		return false;
	}
	
	public function add_delayed_admin_notices() {

		parent::add_delayed_admin_notices();

		$this->add_ssl_admin_notices();

		$this->add_currency_admin_notices();
	}
	
	protected function add_ssl_admin_notices() {

		if ( $this->requires_ssl() && $this->get_admin_notice_handler()->should_display_notice( 'ssl-required' ) ) {

			foreach ( $this->get_gateway_ids() as $gateway_id ) {

				$settings = $this->get_gateway_settings( $gateway_id );

				if ( isset( $settings['enabled'] ) && 'yes' == $settings['enabled'] ) {

					if ( isset( $settings['environment'] ) && 'production' == $settings['environment'] ) {

						if ( 'no' === get_option( 'woocommerce_force_ssl_checkout' ) ) {

							$message = sprintf( "%s: WooCommerce не использует защищённое SSL соединение. Платёжные данные ваших покупателей могут быть похищены злоумышлиниками.", '<strong>' . $this->get_plugin_name() . '</strong>' );

							$this->get_admin_notice_handler()->add_admin_notice( $message, 'ssl-required' );
							
							break;
						}

					}
				}
			}
		}
	}
	
	protected function add_currency_admin_notices() {

		if ( $this->get_accepted_currencies() ) {
			
			$gateways = array();
			
			foreach ( $this->get_gateways() as $gateway ) {
				if ( $gateway->is_enabled() && ! $gateway->currency_is_accepted() ) {
					$gateways[] = $gateway;
				}
			}

			if ( count( $gateways ) == 0 ) {
				return;
			} elseif ( count( $gateways ) == 1 && count( $this->get_gateways() ) > 1 ) {
				$suffix              = '-' . $gateway->get_id();
				$name                = $gateway->get_method_title();
				$accepted_currencies = $gateway->get_accepted_currencies();
			} else {
				$suffix              = '';
				$name                = $this->get_plugin_name();
				$accepted_currencies = $this->get_accepted_currencies();
			}

			$message = sprintf(
				'%s может работать только с валютами %s. <a href="%s">Настройте</a> WooCommerce валюту %s что бы включить данный платёжный шлюз.',
				$name,
				'<strong>' . implode( ', ', $accepted_currencies ) . '</strong>',
				$this->get_general_configuration_url(),
				'<strong>' . implode( ', ', $accepted_currencies ) . '</strong>'
			);

			$this->get_admin_notice_handler()->add_admin_notice( $message, 'accepted-currency' . $suffix );

		}
	}
	
	public function plugin_action_links( $actions ) {

		$actions = parent::plugin_action_links( $actions );

		if ( isset( $actions['configure'] ) ) {
			unset( $actions['configure'] );
		}

		$custom_actions = array();

		foreach ( $this->get_gateway_ids() as $gateway_id ) {
			$custom_actions[ 'configure_' . $gateway_id ] = $this->get_settings_link( $gateway_id );
		}

		return array_merge( $custom_actions, $actions );
	}
	
	public function maybe_capture_charge( $order ) {

		if ( ! is_object( $order ) ) {
			$order = wc_get_order( $order );
		}
		
		if ( ! $this->has_gateway( $order->payment_method ) ) {
			return;
		}

		$gateway = $this->get_gateway( $order->payment_method );
		
		if ( ! $this->can_capture_charge( $gateway ) ) {
			return;
		}
		
		if ( ! $gateway->authorization_valid_for_capture( $order ) ) {
			return;
		}
		
		remove_action( 'woocommerce_order_action_wc_' . $this->get_id() . '_capture_charge', array( $this, 'maybe_capture_charge' ) );
		remove_action( 'woocommerce_process_shop_order_meta', 'WC_Meta_Box_Order_Data::save', 40, 2 );
		
		$gateway->do_credit_card_capture( $order );
	}
	
	public function maybe_add_capture_charge_order_action( $actions ) {
		
		if ( ! isset( $_REQUEST['post'] ) ) {
			return $actions;
		}

		$order = wc_get_order( $_REQUEST['post'] );
		
		if ( ! $this->has_gateway( $order->payment_method ) ) {
			return $actions;
		}

		$gateway = $this->get_gateway( $order->payment_method );
		
		if ( ! $this->can_capture_charge( $gateway ) ) {
			return $actions;
		}
		
		if ( ! $gateway->authorization_valid_for_capture( $order ) ) {
			return $actions;
		}

		return $this->add_order_action_charge_action( $actions );
	}
	
	public function maybe_add_capture_charge_bulk_order_action() {
		global $post_type, $post_status;

		if ( $post_type == 'shop_order' && $post_status != 'trash' ) {
			
			$can_capture_charge = false;
			foreach ( $this->get_gateways() as $gateway ) {
			
				if ( $this->can_capture_charge( $gateway ) ) {
					$can_capture_charge = true;
					break;
				}
			}

			if ( ! $can_capture_charge ) {
				return;
			}

			?>
				<script type="text/javascript">
					jQuery( document ).ready( function ( $ ) {
						if ( 0 == $( 'select[name^=action] option[value=wc_capture_charge]' ).size() ) {
							$( 'select[name^=action]' ).append(
								$( '<option>' ).val( '<?php echo esc_js( 'wc_capture_charge' ); ?>' ).text( 'Capture Charge' )
							);
						}
					});
				</script>
			<?php
		}
	}
	
	public function process_capture_charge_bulk_order_action() {
		global $typenow;

		if ( 'shop_order' == $typenow ) {
		
			$wp_list_table = _get_list_table( 'WP_Posts_List_Table' );
			$action        = $wp_list_table->current_action();
			
			if ( 'wc_capture_charge' !== $action ) {
				return;
			}
			
			check_admin_referer( 'bulk-posts' );

			if ( isset( $_REQUEST['post'] ) ) {
				$order_ids = array_map( 'absint', $_REQUEST['post'] );
			}
			
			if ( empty( $order_ids ) ) {
				return;
			}
			
			@set_time_limit( 0 );

			foreach ( $order_ids as $order_id ) {

				$order = wc_get_order( $order_id );

				$this->maybe_capture_charge( $order );
			}
		}
	}
	
	public function add_order_action_charge_action( $actions ) {

		$actions[ 'wc_' . $this->get_id() . '_capture_charge' ] = 'Capture Charge';

		return $actions;
	}
	
	public function supports( $feature ) {
		return in_array( $feature, $this->supports );
	}
	
	public function can_capture_charge( $gateway ) {
		return $this->supports( self::FEATURE_CAPTURE_CHARGE ) && $this->get_gateway()->is_available() && $gateway->supports( self::FEATURE_CAPTURE_CHARGE );
	}
	
	public function get_admin_user_edit_handler() {

		if ( ! is_null( $this->admin_user_edit_handler ) ) {
			return $this->admin_user_edit_handler;
		}

		return $this->admin_user_edit_handler = new Woodev_Payment_Gateway_Admin_User_Edit_Handler( $this );
	}
	
	protected function get_gateway_settings_name( $gateway_id ) {
		return 'woocommerce_' . $gateway_id . '_settings';

	}
	
	public function get_gateway_settings( $gateway_id ) {
		return get_option( $this->get_gateway_settings_name( $gateway_id ) );
	}
	
	protected function requires_ssl() {
		return $this->require_ssl;
	}
	
	public function get_settings_url( $gateway_id = null ) {
		
		if ( is_null( $gateway_id ) || $gateway_id === $this->get_id() ) {
			reset( $this->gateways );
			$gateway_id = key( $this->gateways );
		}

		return Woodev_Payment_Gateway_Helper::get_payment_gateway_configuration_url( $this->get_gateway_class_name( $gateway_id ) );
	}
	
	public function get_payment_gateway_configuration_url( $gateway_class_name ) {
		return admin_url( 'admin.php?page=wc-settings&tab=checkout&section=' . strtolower( $gateway_class_name ) );
	}
	
	public function is_payment_gateway_configuration_page( $gateway_class_name ) {

		return isset( $_GET['page'] ) && 'wc-settings' == $_GET['page'] &&
		isset( $_GET['tab'] ) && 'checkout' == $_GET['tab'] &&
		isset( $_GET['section'] ) && strtolower( $gateway_class_name ) == $_GET['section'];
	}
	
	public function add_gateway( $gateway_id, $gateway_class_name ) {
		$this->gateways[ $gateway_id ] = array( 'gateway_class_name' => $gateway_class_name, 'gateway' => null );
	}
	
	public function get_gateway_class_names() {

		assert( ! empty( $this->gateways ) );

		$gateway_class_names = array();

		foreach ( $this->gateways as $gateway ) {
			$gateway_class_names[] = $gateway['gateway_class_name'];
		}

		return $gateway_class_names;
	}
	
	public function get_gateway_class_name( $gateway_id ) {

		assert( isset( $this->gateways[ $gateway_id ]['gateway_class_name'] ) );

		return $this->gateways[ $gateway_id ]['gateway_class_name'];
	}
	
	public function get_gateways() {

		assert( ! empty( $this->gateways ) );

		$gateways = array();

		foreach ( $this->get_gateway_ids() as $gateway_id ) {
			$gateways[] = $this->get_gateway( $gateway_id );
		}

		return $gateways;
	}
	
	public function set_gateway( $gateway_id, $gateway ) {
		$this->gateways[ $gateway_id ]['gateway'] = $gateway;
	}
	
	public function get_gateway( $gateway_id = null ) {
		
		if ( is_null( $gateway_id ) ) {
			reset( $this->gateways );
			$gateway_id = key( $this->gateways );
		}

		if ( ! isset( $this->gateways[ $gateway_id ]['gateway'] ) ) {
			$gateway_class_name = $this->get_gateway_class_name( $gateway_id );
			$this->set_gateway( $gateway_id, new $gateway_class_name() );
		}

		return $this->gateways[ $gateway_id ]['gateway'];
	}
	
	public function has_gateway( $gateway_id ) {
		return isset( $this->gateways[ $gateway_id ] );
	}
	
	public function get_gateway_ids() {
		assert( ! empty( $this->gateways ) );
		return array_keys( $this->gateways );
	}
	
	public function get_gateway_from_token( $user_id, $token ) {

		foreach ( $this->get_gateways() as $gateway ) {

			if ( $gateway->has_payment_token( $user_id, $token ) ) {
				return $gateway;
			}
		}

		return null;
	}
	
	public function add_api_request_logging() {}
	
	public function get_accepted_currencies() {
		return $this->currencies;
	}
	
	public function get_payment_gateway_framework_file() {
		return __FILE__;
	}
	
	public function get_payment_gateway_framework_path() {
		return untrailingslashit( plugin_dir_path( $this->get_payment_gateway_framework_file() ) );
	}
	
	public function get_payment_gateway_framework_assets_path() {
		return $this->get_payment_gateway_framework_path() . '/assets';
	}
	
	public function get_payment_gateway_framework_assets_url() {
		return untrailingslashit( plugins_url( '/assets', $this->get_payment_gateway_framework_file() ) );
	}


}

endif;