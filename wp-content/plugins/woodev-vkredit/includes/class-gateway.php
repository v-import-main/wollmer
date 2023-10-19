<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC_Gateway_Tinkoff_KVK extends Woodev_Payment_Gateway_Hosted {
	
	const URL_ENDPOINT = 'https://forma.tinkoff.ru/api/partners/v2/orders';
	
	protected $shop_id;
	
	protected $showcase_id;
	
	protected $promo_codes;
	
	protected $api;
	
	public function __construct() {
		
		parent::__construct(
			Woodev_TCB::GATEWAY_ID,
			wc_tinkoff_kredit(),
			array(
				'method_title'       => 'Тинькоф - Купи в кредит',
				'method_description' => 'Метод добавляет метод оплаты, для создания заявки на покупку в кредит.',
				'supports'           => array(
					self::FEATURE_PRODUCTS
				),
				'payment_type'       => self::PAYMENT_TYPE_BANK_TRANSFER,
				'environments'       => array(
					self::ENVIRONMENT_PRODUCTION => 'Боевой режим',
					self::ENVIRONMENT_TEST       => 'Тестовый режим'
				),
				'countries'	 => array( 'RU' ),
				'currencies' => array( 'EUR', 'RUB', 'USD' )
			)
		);
		
		if( $this->is_production_environment() ) {
			
			remove_action( 'woocommerce_api_' . strtolower( get_class( $this ) ), array( $this, 'process_ipn' ) );
			
			$generate_ipn_endpoint = 'wc_gateway_tinkoff_kvk_ipn_' . md5( json_encode( array( $this->get_shop_id(), $this->get_showcase_id() ) ) );
			
			$this->transaction_response_handler_url = add_query_arg( 'wc-api', $generate_ipn_endpoint, home_url( '/' ) );
			
			if ( ( is_ssl() && ! is_admin() ) || 'yes' == get_option( 'woocommerce_force_ssl_checkout' ) ) {
				$this->transaction_response_handler_url = str_replace( 'http:', 'https:', $this->transaction_response_handler_url );
			}
		
			if ( ! has_action( 'woocommerce_api_' . $generate_ipn_endpoint, array( $this, 'process_ipn' ) ) ) {
				add_action( 'woocommerce_api_' . $generate_ipn_endpoint, array( $this, 'process_ipn' ) );
			}
		}
		
		
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
				$input_radio = sprintf( '<label for="%1$s" class="radio"><input type="radio" name="%2$s" id="%1$s" value="%3$s" %5$s />%4$s</label>', $this->get_order_meta_prefix() . 'promo_code_' . esc_attr( $code ), $this->get_order_meta_prefix() . 'promo_code', esc_attr( $code ), $name, checked( $code == $promo_default, true, false ) );
				printf( '<div class="input-radio-group">%s</div>', $input_radio );
				
				
			}
			
			
		
		} else {
			printf( '<input type="hidden" name="%s" value="%s" />', $this->get_order_meta_prefix() . 'promo_code', $promo_default );
		}
		
		if( ! $this->is_production_environment() && current_user_can( 'manage_woocommerce' ) ) {
			echo '<h4>Параметры для демо заявки</h4>';
			
			woocommerce_form_field( $this->get_order_meta_prefix() . 'demo_flow', array(
				'type' 		=> 'select',
				'required'	=> true,
				'class' 	=> array( 'form-row-wide' ),
				'label'		=> 'Тип поддтверждения демо заявки',
				'default'	=> 'no',
				'options'	=> array(
					'sms'					=> 'СМС',
					'appointment'			=> 'Личная встреча',
					'reject'				=> 'Отклонена',
					'appointment-reject'	=> 'Отклонена при встрече'
				)
			) );
			
			woocommerce_form_field( $this->get_order_meta_prefix() . 'initial_stage', array(
				'type' 		=> 'select',
				'required'	=> true,
				'class' 	=> array( 'form-row-wide' ),
				'label'		=> 'Начальный экран для демо заявки',
				'default'	=> 'filling',
				'options'	=> array(
					'filling'					=> 'Полный процесс заполнения',
					'wait-offer'				=> 'Ожидание решения по заявке',
					'wait-offer-timeout'		=> 'Заявка принята (в ожидании)',
					'kvk-signing-sms'			=> 'Ожидание подтвеждения по СМС',
					'kvk-issued'				=> 'Кредит одобрен',
					'canceled'					=> 'Отменена покупателем',
					'canceled-by-partner'		=> 'Отменена партнёром',
				)
			) );
		}
	}
	
	public function is_available() {
		
		$is_available = parent::is_available();
		
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_POST['action'] ) && $_POST['action'] == 'woocommerce_update_order_review' ) {
			$is_available = false;
		}
		
		if( $this->get_order_total() < 3000 ) {
			$is_available = false;
		}
		
		return apply_filters( 'wc_gateway_' . $this->get_id() . '_is_available', $is_available );
	}
	
	protected function get_method_form_fields() {
		
		$pay_url = wc_get_endpoint_url( 'order-pay', '', wc_get_page_permalink( 'checkout' ) );

		if ( 'yes' == get_option( 'woocommerce_force_ssl_checkout' ) || is_ssl() ) {
			$pay_url = str_replace( 'http:', 'https:', $pay_url );
		}
		
		$fields = array(
			'shop_id'          => array(
				'title'       => 'Идентификатор магазина',
				'type'        => 'text',
				'description' => 'Уникальный идентификатор магазина, выдается банком при подключении.',
				'default'     => '',
				'desc_tip'    => true
			),
			'showcase_id'         => array(
				'title'       => 'Идентификатор витрины магазина',
				'type'        => 'text',
				'description' => 'Идентификатор витрины магазина. Витрины —это различные сайты, зарегистрированные на одно юридическое лицо. В случае единственной витрины можно не указывать.',
				'default'     => '',
				'desc_tip'    => true
			),
			'order_button_text' => array(
				'title'       => 'Текст на кнопке',
				'type'        => 'text',
				'description' => 'Этот текст будет отображатся на кнопках для перехода к этапу оформления заявки на кредит.',
				'default'     => 'Купить в кредит',
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
			)
		);
		
		return apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_form_fields', $fields, $this );
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
	
	protected function get_default_title() {
		return 'Тинькоф кредит';
	}
	
	protected function get_default_description() {
		return 'Отправить заявку на получение кредита.';
	}
	
	protected function is_configured() {

		$is_configured = parent::is_configured();

		// missing configuration
		if ( ! $this->get_shop_id() || ! $this->get_showcase_id() ) {
			$is_configured = false;
		}

		return $is_configured;
	}
	
	public function get_shop_id() {
		
		if( $this->shop_id ) {
			return $this->shop_id;
		}
		
		return null;
	}
	
	public function get_showcase_id() {
		
		if( $this->showcase_id ) {
			return $this->showcase_id;
		}
		
		return null;
	}
	
	public function get_hosted_pay_page_url( $order = null ) {
		try {
			
			$api = $this->get_api()->create( $order );
			return $api->get_form_url();
		
		} catch( Woodev_API_Exception $e ) {
			$this->get_plugin()->log( $e->getMessage() );
			throw new Woodev_Payment_Gateway_Exception( $e->getMessage() );
		}
	}
	
	/*
	* В функцию передаются параметры в переменной $request_response_data которая по сути является обычным $_REQUEST
	* Т.е. если данные от сервера прилетают в виде $_REQUEST то в обработчик передаём просто $request_response_data иначе php://input
	*/
	protected function get_transaction_response( $request_response_data ) {
		require_once( $this->get_plugin()->get_plugin_path() . '/includes/api/class-wc-api-ipn-response.php' );
		return new WC_Gateway_Tinkoff_KVK_API_IPN_Response( $request_response_data );
	}
	
	public function log_transaction_response_request( $response, $message = NULL ) {
		
		if ( $this->debug_log() ) {

			$this->get_plugin()->log( sprintf( 'От сервера Тинькофф пришел ответ: %s', print_r( $response, true ) ), $this->get_id() );
		}
	}
	
	public function add_payment_gateway_transaction_data( $order, $response ) {
		if( $response && $response->get_order_id() && $order->get_id() == $response->get_order_id() ) {
			
			$this->update_order_meta( $order, 'status_message', $response->get_status_message() );
			
			if( $response->first_payment ) {
				$this->update_order_meta( $order, 'first_payment', $response->first_payment );
			}
			if( $response->order_amount ) {
				$this->update_order_meta( $order, 'order_amount', $response->order_amount );
			}
			if( $response->credit_amount ) {
				$this->update_order_meta( $order, 'credit_amount', $response->credit_amount );
			}
			if( $response->get_credit_product_type() ) {
				$this->update_order_meta( $order, 'credit_product', $response->get_credit_product_type() );
			}
			if( $response->term ) {
				$this->update_order_meta( $order, 'credit_term', $response->term );
			}
			if( $response->monthly_payment ) {
				$this->update_order_meta( $order, 'monthly_payment', $response->monthly_payment );
			}
			if( $response->signing_type ) {
				$this->update_order_meta( $order, 'signing_type', $response->signing_type );
			}
		}
	}
	
	protected function mark_order_as_held( $order, $message, $response = null ) {

		$order_note = sprintf( '%s заявка на получение кредита отложенна до подтвеждения покупателем (%s)', $this->get_method_title(), $message );
		
		if ( ! $order->has_status( 'pending' ) ) {
			$order->update_status( 'pending', $order_note );
		} else {
			$order->add_order_note( $order_note );
		}
		
		if ( isset( WC()->session ) ) {
			WC()->session->held_order_received_text = 'На данный момент заявка на получение кредита ожидает вашего подтвеждения.';
		}
	}
	
	protected function process_transaction_response( $order, $response ) {
		
		if( $response->transaction_approved() || $response->transaction_held() ) {
			
			$this->do_transaction_approved( $order, $response );
			
			$this->add_transaction_data( $order, $response );

			$this->add_payment_gateway_transaction_data( $order, $response );
			
			if ( $response->transaction_held() ) {
				$this->mark_order_as_held( $order, $response->get_status_message(), $response );
			}
			
			return true;
		
		} elseif ( $response->transaction_cancelled() ) {

			$this->mark_order_as_cancelled( $order, $response->get_status_message(), $response );

			return true;

		} else {
			return $this->do_transaction_failed_result( $order, $response );
		}
	}
	
	public function process_ipn() {
	
		$input_data = file_get_contents( 'php://input' );
		
		$this->log_transaction_response_request( $input_data );

		$response = null;
		
		try {

			$response = $this->get_transaction_response( $input_data );
			$order = $response->get_order();
			
			if( ! $response->valid_response_data() ) {
				
				$error_messages = $response->get_response_data_error_messages();
				
				if ( $this->debug_log() ) {
					$this->get_plugin()->log( sprintf( 'Пришли некорректные данные IPN: %s', implode( '. ', $error_messages ) ), $this->get_id() );
				}
				
				if( $this->is_test_environment() ) {
					wp_send_json_error( $error_messages, 400 );
				}
				
				wp_send_json_error( 'Переданы невалидные данные.', 400 );
				
			}

			if ( ! $order || ! $order->id ) {
				
				$message = sprintf( 'Ошибка обработки IPN: Не удалось найти заказ %s', $response->get_order_id() );
				
				if ( $this->debug_log() ) {
					$this->get_plugin()->log( $message, $this->get_id() );
				}
				
				wp_send_json_error( $message, 400 );
			}
			
			if ( ! $order->needs_payment() ) {

				if ( $this->debug_log() ) {
					$this->get_plugin()->log( sprintf( "Ошибка обработки IPN: Заказ %s уже оплачен.", $order->get_order_number() ), $this->get_id() );
				}

				$order_note = sprintf( 'Ошибка обработки IPN: %s получен дубликат транзакции', $this->get_method_title() );
				$order->add_order_note( $order_note );

				wp_send_json_error( 'Получен дубликат транзакции', 400 );
			}

			if ( $this->process_transaction_response( $order, $response ) ) {

				if ( $order->has_status( 'on-hold' ) ) {
					$order->reduce_order_stock();
				} elseif ( ! $order->has_status( 'cancelled' ) && $response->transaction_approved() ) {
					$order->payment_complete();
				}
				
				wp_send_json_success( 'OK' );
			}

		} catch ( Woodev_Plugin_Exception $e ) {

			if ( isset( $order ) && $order ) {
				$this->mark_order_as_failed( $order, $e->getMessage(), $response );
			}

			if ( $this->debug_log() ) {
				$this->get_plugin()->log( sprintf( 'Ошибка обработки IPN: %s', $e->getMessage() ), $this->get_id() );
			}
			
			wp_send_json_error( $e->getMessage(), 400 );
		}
		
		status_header( 200 );
		die;
	}
	
	public function get_api() {
		if ( isset( $this->api ) ) {
			return $this->api;
		}
		
		require_once( $this->get_plugin()->get_plugin_path() . '/includes/api/class-wc-tinkoff-api.php' );
		require_once( $this->get_plugin()->get_plugin_path() . '/includes/api/class-wc-api-response.php' );
		require_once( $this->get_plugin()->get_plugin_path() . '/includes/api/class-wc-api-request.php' );
		
		return $this->api = new WC_Tinkoff_API( $this );
	}
}

?>