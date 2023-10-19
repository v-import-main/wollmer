<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class WC_Gateway_Tinkoff_KVK extends Woodev_Payment_Gateway_Hosted {
	
	const PRODUCTION_URL_ENDPOINT = 'https://loans.tinkoff.ru/api/partners/v1/lightweight/create';
	
	const TEST_URL_ENDPOINT = 'https://loans-qa.tcsbank.ru/api/partners/v1/lightweight/create';
	
	const ENVIRONMENT_TEST = 'sandbox';
	
	protected $shop_id;
	
	protected $showcase_id;
	
	protected $promo_codes;
	
	public function __construct() {
		
		parent::__construct(
			Woodev_TCB::PLUGIN_ID,
			wc_tinkoff_kredit(),
			array(
				'method_title'       => 'Тинькоф - Купи в кредит',
				'method_description' => 'Метод добавляет метод оплаты, для создания заявки на покупку в кредит.',
				'supports'           => array( self::FEATURE_PRODUCTS ),
				'environments'       => array(
					'production' => 'Боевой режим',
					'test'       => 'Тестовый режим'
				),
				'payment_type'	=> self::PAYMENT_TYPE_MULTIPLE
			)
		);
		
		$this->set_settings();
		
		//add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	public function process_admin_options() {
		
		if( ! $this->get_plugin()->get_license_instance()->is_active() ) {
			return;
		}
		
		parent::process_admin_options();

		$this->set_settings();
	}
	
	private function set_settings() {
		
		$this->promo_codes		= $this->get_option( 'promo_codes', array() );
		
		return true;
	}
	
	public function payment_fields() {
		parent::payment_fields();
		
		$promo_options = array();
		$promo_default = '';
			
		foreach( ( array ) $this->promo_codes as $promo ) {
				
			if( ! $promo['enabled'] ) {
				continue;
			}
			
			if( empty( $promo_options ) ) {
				$promo_default = $promo['code'];
			}
				
			$promo_options[ $promo['code'] ] = $promo['name'];
		}
		
		$promo_default = ! empty( $promo_default ) ? $promo_default : 'default';
		
		if ( $promo_options && count( $promo_options ) > 1 ) {
			
			echo "
				<style>
					.input-radio-group input[type=radio] {
						margin-right:5px;
					}
					.input-radio-group input[type=radio],
					.input-radio-group .radio {
						display:inline;
					}
				</style>
			";
			
			foreach( $promo_options as $code => $name ) {
				$input_radio = sprintf( '<label for="%1$s" class="radio"><input type="radio" name="%2$s" id="%1$s" value="%3$s" %5$s />%4$s</label>', $this->id . '_promo_code_' . esc_attr( $code ), $this->id . '_promo_code', esc_attr( $code ), $name, checked( $code == $promo_default, true, false ) );
				printf( '<div class="input-radio-group">%s</div>', $input_radio );
			}
			
			
		
		} else {
			printf( '<input type="hidden" name="%s" value="%s" />', $this->id . '_promo_code', $promo_default );
		}
	}
	
	protected function get_method_form_fields() {
		
		return array(
			'receipt_text' => array(
				'title'       => 'Текст на странице оплаты.',
				'type'        => 'textarea',
				'description' => 'Этот текст отображается покупателям на странице оплаты. После подтверждения заказа.',
				'default'     => 'Спасибо за ваш заказ. Пожалуйста нажмите на кнопку ниже что бы перейти к оформлению кредита.',
				'desc_tip'    => true,
			),
			'order_button_text' => array(
				'title'       => 'Текст на кнопке',
				'type'        => 'text',
				'description' => 'Этот текст будет отображатся на кнопках для перехода к этапу оформления заявки на кредит.',
				'default'     => 'Купить в кредит',
				'desc_tip'    => true,
			),
			'redirect_button_text' => array(
				'title'       => 'Текст на кнопке переадресации',
				'type'        => 'text',
				'description' => 'Этот текст будет отображатся на кнопке для переадресации на сайт Тинькофф.',
				'default'     => 'Перейти к заполнению анкеты',
				'desc_tip'    => true,
			),
			'shop_id'          => array(
				'title'       => 'Идентификатор магазина',
				'type'        => 'text',
				'description' => 'Уникальный идентификатор магазина, выдается банком при подключении.',
				'default'     => '',
				'desc_tip'    => true,
			),
			'showcase_id'         => array(
				'title'       => 'Идентификатор витрины магазина',
				'type'        => 'text',
				'description' => 'Идентификатор витрины магазина. Витрины —это различные сайты, зарегистрированные на одно юридическое лицо. В случае единственной витрины можно не указывать.',
				'default'     => '',
				'desc_tip'    => true,
			),
			'promo_codes'	=> array(
				'title'       => 'Промокод',
				'type'        => 'promo_codes',
				'description' => 'Указывается в случае, если на товар распространяется акции (например, рассрочки). Подробности уточняйте у персонального менеджера.',
				'default'     => '',
				'desc_tip'    => true,
			),
			'single_page_informer'	=> array(
				'title'			=> 'Информация на странице товара',
				'type'			=> 'textarea',
				'description'	=> 'Укажите инофрмационный текст который будет отображаться над кнопкой добавить в кредит. Можно использовать шаблон %payment_amount% для указания минимального месяцного платежа (стоимость товара делённое на 19).',
				'placeholder'	=> 'Пример: данный товар тожно купить в кредит всего за %payment_amount% руб в месяц.'
			),
			'use_auto_form_post'	=> array(
				'title'       => 'Автоматически переадресовывать на сайт Тинькофф',
				'type'        => 'checkbox',
				'label'       => 'Автоматическая переадресация',
				'description' => 'Включите эту опцию если хотите что бы покупатель был переадресован на сайт Тинькофф сразу после подтверждения заказа.',
				'default'     => 'yes'
			)
		);
	}
	
	public function is_available() {
		
		$is_available = parent::is_available();
		
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_POST['action'] ) && $_POST['action'] == 'woocommerce_update_order_review' ) {
			$is_available = false;
		}
		
		if ( is_checkout_pay_page() ) {
			$is_available = false;
		}
		
		if( $this->get_order_total() < 3000 ) {
			$is_available = false;
		}
		
		return $is_available;
	}
	
	protected function is_configured() {
		
		$is_configured = parent::is_configured();
		
		if ( ( $this->is_production_environment() ) && ! $this->get_shop_id() ) {
			$is_configured = false;
		}
		
		return $is_configured;
	}
	
	public function get_shop_id() {
		return $this->is_test_environment() ? 'test_online' : $this->shop_id;
	}
	
	public function get_showcase_id() {
		return $this->is_test_environment() ? 'test_online' : $this->showcase_id;
	}
	
	public function generate_promo_codes_html() {
		ob_start();
		include( 'html-promo-codes.php' );
		return ob_get_clean();
	}
	
	public function validate_promo_codes_field( $key ) {
		$promo_name		= isset( $_POST['promo_name'] ) ? $_POST['promo_name'] : array();
		$promo_codes	= isset( $_POST['promo_code'] ) ? $_POST['promo_code'] : array();
		$promo_enabled	= isset( $_POST['promo_enabled'] ) ? $_POST['promo_enabled'] : array();

		$codes = array();

		if ( ! empty( $promo_name ) && sizeof( $promo_codes ) > 0 ) {
			for ( $i = 0; $i <= max( array_keys( $promo_codes ) ); $i ++ ) {

				if ( ! isset( $promo_codes[ $i ] ) ) continue;

				if ( $promo_name[ $i ] && $promo_codes[ $i ] ) {

					$codes[] = array(
						'name'		=> wc_clean( $promo_name[ $i ] ),
						'code'		=> esc_html( $promo_codes[ $i ] ),
						'enabled'	=> isset( $promo_enabled[ $i ] ) ? true : false
					);
				}
			}
		}
		
		return $codes;
	}
	
	protected function get_order_button_text() {
		if( $this->order_button_text ) {
			return $this->order_button_text;
		}
		
		return parent::get_order_button_text();
	}
	
	protected function get_transaction_response( $request_response_data ) {}
	
	protected function get_hosted_pay_page_params( $order ) {
		
		$promo_code = get_post_meta( $order->get_id(), '_' . $this->id . '_promo_code', true );
		$promo_code = $promo_code ? $promo_code : 'default';
		
		$form_data = array(
			'shopId' 			=> $this->get_shop_id(),
			'showcaseId'		=> $this->get_showcase_id(),
			'sum'	 			=> wc_format_decimal( $order->get_total(), wc_get_price_decimals() ),
			'orderNumber'		=> $order->get_order_key(),
			'promoCode'			=> $promo_code,
			'customerEmail'		=> $order->get_billing_email(),
			'customerPhone'		=> $order->get_billing_phone(),
			'customerNumber'	=> $order->get_user_id(),
			'integrationType'	=> sprintf( 'Woocommerce/%s', WC_VERSION )
		);
		
		$item_index = 0;
		$order_items = Woodev_Helper::get_order_line_items( $order );
		
		foreach( $order_items as $item ) {
			$form_data[ 'itemName_' . $item_index ] 	= $item->name;
			$form_data[ 'itemQuantity_' . $item_index ] = $item->quantity;
			$form_data[ 'itemPrice_' . $item_index ] 	= wc_format_decimal( $item->item_total, wc_get_price_decimals() );
			if( ! empty( $item->description ) ) {
				$form_data[ 'itemDescription_' . $item_index ] = Woodev_Helper::str_truncate( $item->description, 255, '' );
			}
			
			$item_index++;
		}
		
		foreach ( $order->get_shipping_methods() as $shipping_item ) {
			
			if( $shipping_item->get_total() > 0 ) {
				
				$form_data[ 'itemName_' . $item_index ] 	= sprintf( 'Доставка: %s', $shipping_item->get_name() );
				$form_data[ 'itemQuantity_' . $item_index ] = 1;
				$form_data[ 'itemPrice_' . $item_index ] 	= wc_format_decimal( $shipping_item->get_total(), wc_get_price_decimals() );
				
				$item_index++;
			}
		}
		
		if ( 0 < $order->get_total_fees() ) {
			foreach( $order->get_fees() as $item_fee ) {
				
				$form_data[ 'itemName_' . $item_index ] 	= $item_fee->get_name();
				$form_data[ 'itemQuantity_' . $item_index ] = 1;
				$form_data[ 'itemPrice_' . $item_index ] 	= wc_format_decimal( $item_fee->get_total(), wc_get_price_decimals() );
				
				$item_index++;
			}
		}
		
		if ( wc_tax_enabled() ) {
			foreach ( $order->get_tax_totals() as $tax_total ) {
				$form_data[ 'itemName_' . $item_index ] 	= esc_html( $tax_total->label );
				$form_data[ 'itemQuantity_' . $item_index ] = 1;
				$form_data[ 'itemPrice_' . $item_index ] 	= wc_format_decimal( $tax_total->amount, wc_get_price_decimals() );
				
				$item_index++;
			}
		}
		
		if ( 0 < $order->get_total_fees() ) {
			$form_data[ 'itemName_' . $item_index ] 	= esc_html_e( 'Fees:', 'woocommerce' );
			$form_data[ 'itemQuantity_' . $item_index ] = 1;
			$form_data[ 'itemPrice_' . $item_index ] 	= wc_format_decimal( $order->get_total_fees(), wc_get_price_decimals() );
		}
		
		return $form_data;
	}
	
	public function get_hosted_pay_page_url( $order = null ) {
		return $this->is_production_environment() ? self::PRODUCTION_URL_ENDPOINT : self::TEST_URL_ENDPOINT;
	}
	
	protected function get_default_title() {
		return 'Тинькоф кредит';
	}
	
	protected function get_default_description() {
		return 'Отправить заявку на получение кредита.';
	}

	public function use_form_post() {
		return true;
	}
	
	public function use_auto_form_post() {
		return $this->use_auto_form_post === 'yes';
	}
	
	public function render_pay_page_form( $order, $request_params ) {
		if( $this->receipt_text ) {
			printf( '<p>%s</p>', esc_attr( $this->receipt_text ) );
		}
		
		$form = sprintf( '<form action="%s" method="post">', esc_url( $this->get_hosted_pay_page_url( $order ) ) );
		
		foreach ( $request_params as $key => $value ) {
			$form .= '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" />';
		}
		
		$form .= sprintf( '<button class="button alt" id="kvk_button" type="submit">%s</button>', $this->redirect_button_text );
		$form .= sprintf( '<a class="button cancel" href="%s">Отменить заказ</a>', esc_url( $order->get_cancel_order_url() ) );
		$form .= '</form>';
		
		echo $form;
	}
}