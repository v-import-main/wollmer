<?php


if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Woodev_Payment_Gateway_Hosted' ) ) :

abstract class Woodev_Payment_Gateway_Hosted extends Woodev_Payment_Gateway {

	protected $transaction_response_handler_url;
	
	public function __construct( $id, $plugin, $args ) {
	
		parent::__construct( $id, $plugin, $args );
		
		if ( $this->has_ipn() ) {
			$api_method_name = 'process_ipn';
		} else {
			$api_method_name = 'process_redirect_back';
		}
		
		if ( ! has_action( 'woocommerce_api_' . strtolower( get_class( $this ) ), array( $this, $api_method_name ) ) ) {
			add_action( 'woocommerce_api_' . strtolower( get_class( $this ) ), array( $this, $api_method_name ) );
		}
	}
	
	public function payment_fields() {

		parent::payment_fields();
		?><style type="text/css">#payment ul.payment_methods li label[for='payment_method_<?php echo $this->get_id(); ?>'] img:nth-child(n+2) { margin-left:1px; }</style><?php
	}
	
	public function process_payment( $order_id ) {

		$payment_url = $this->get_payment_url( $order_id );

		if ( ! $payment_url ) {
			return array( 'result' => 'failure' );
		}

		WC()->cart->empty_cart();

		return array(
			'result'   => 'success',
			'redirect' => $payment_url,
		);
	}
	
	protected function get_payment_url( $order_id ) {

		if ( $this->use_form_post() ) {
			$order = wc_get_order( $order_id );
			return $order->get_checkout_payment_url( true );
		} else {
		
			$order = $this->get_order( $order_id );
			
			$pay_page_url = $this->get_hosted_pay_page_url( $order );

			if ( $pay_page_url ) {
				return add_query_arg( $this->get_hosted_pay_page_params( $order ), $pay_page_url );
			}
		}

		return false;
	}
	
	public function payment_page( $order_id ) {

		if ( ! $this->use_form_post() ) {
			parent::payment_page( $order_id );
		} else {
			$this->generate_pay_form( $order_id );
		}
	}
	
	public function generate_pay_form( $order_id ) {
	
		$order = $this->get_order( $order_id );

		$request_params = $this->get_hosted_pay_page_params( $order );
		
		$request = array(
			'method' => 'POST',
			'uri'    => $this->get_hosted_pay_page_url( $order ),
			'body'   => print_r( $request_params, true ),
		);
		
		$this->log_hosted_pay_page_request( $request );
		
		if ( $this->use_auto_form_post() ) {
			$this->render_auto_post_form( $order, $request_params );
		} else {
			$this->render_pay_page_form( $order, $request_params );
		}
	}
	
	public function render_pay_page_form( $order, $request_params ) {}
	
	public function render_auto_post_form( $order, $request_params ) {
	
		wc_enqueue_js('
			$( document.body ).block( {
					message: "<img src=\"' . esc_url( $this->get_plugin()->get_framework_assets_url() . '/images/ajax-loader.gif' ) . '\" alt=\"Переадресация&hellip;\" style=\"float:left; margin-right: 10px;\" />Спасибо за ваш заказ. Сейчас мы перенаправим вас для завершения платежа.",
					overlayCSS: {
						background: "#fff",
						opacity: 0.6
					},
					css: {
						padding:         20,
						textAlign:       "center",
						color:           "#555",
						border:          "3px solid #aaa",
						backgroundColor: "#fff",
						cursor:          "wait",
						lineHeight:      "32px"
					}
				} );

			$( "#submit_' . $this->get_id() . '_payment_form" ).click();
		');

		$request_arg_fields = array();

		foreach ( $request_params as $key => $value ) {
			$request_arg_fields[] = '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" />';
		}

		echo '<p>Спасибо за ваш заказ, пожалуйста нажмите на кнопку ниже что бы оплатить.</p>' .
			'<form action="' . esc_url( $this->get_hosted_pay_page_url( $order ) ) . '" method="post">' .
				implode( '', $request_arg_fields ) .
				'<input type="submit" class="button-alt" id="submit_' . $this->get_id() . '_payment_form" value="Оплатить сейчас" />' .
				'<a class="button cancel" href="' . esc_url( $order->get_cancel_order_url() ) . '">Отменить заказ</a>' .
			'</form>';
	}
	
	protected function get_hosted_pay_page_params( $order ) {
		return array();
	}
	
	abstract public function get_hosted_pay_page_url( $order = null );
	
	public function process_ipn() {
	
		$this->log_transaction_response_request( $_REQUEST );

		$response = null;

		try {
			
			$response = $this->get_transaction_response( $_REQUEST );
			
			$order = $response->get_order();

			if ( ! $order || ! $order->id ) {

				if ( $this->debug_log() ) {
					$this->get_plugin()->log( sprintf( 'Ошибка обработки IPN: Не удалось найти заказ %s', $response->get_order_id() ), $this->get_id() );
				}

				status_header( 200 );
				die;
			}
			
			if ( ! $order->needs_payment() ) {

				if ( $this->debug_log() ) {
					$this->get_plugin()->log( sprintf( "Ошибка обработки IPN: Заказ %s уже оплачен.", $order->get_order_number() ), $this->get_id() );
				}

				$order_note = sprintf( 'Ошибка обработки IPN: %s duplicate transaction received', $this->get_method_title() );
				$order->add_order_note( $order_note );

				status_header( 200 );
				die;
			}

			if ( $this->process_transaction_response( $order, $response ) ) {

				if ( $order->has_status( 'on-hold' ) ) {
					$order->reduce_order_stock();
				} elseif ( ! $order->has_status( 'cancelled' ) ) {
					$order->payment_complete();
				}
			}

		} catch ( Woodev_Plugin_Exception $e ) {

			if ( isset( $order ) && $order ) {
				$this->mark_order_as_failed( $order, $e->getMessage(), $response );
			}

			if ( $this->debug_log() ) {
				$this->get_plugin()->log( sprintf( 'Ошибка обработки IPN: %s', $e->getMessage() ), $this->get_id() );
			}
		}
		
		status_header( 200 );
		die;
	}
	
	public function process_redirect_back() {
	
		$this->log_transaction_response_request( $_REQUEST );

		$response = null;

		try {
		
			$response = $this->get_transaction_response( $_REQUEST );
			
			$order = $response->get_order();

			if ( ! $order || ! $order->id ) {

				$this->add_debug_message( sprintf( "Заказ %s не найден", $response->get_order_id() ), 'error' );
				
				return wp_redirect( get_home_url( null, '' ) );
			}
			if ( ! $order->needs_payment() ) {

				$this->add_debug_message( sprintf( "Заказ '%s' уже обработан", $order->get_order_number() ), 'error' );

				$order_note = sprintf( '%s duplicate transaction received', $this->get_method_title() );
				$order->add_order_note( $order_note );
				
				return wp_redirect( $this->get_return_url( $order ) );
			}

			if ( $this->process_transaction_response( $order, $response ) ) {

				if ( $order->has_status( 'on-hold' ) ) {
					$order->reduce_order_stock();
				} elseif ( ! $order->has_status( 'cancelled' ) ) {
					$order->payment_complete();
				}
				
				return wp_redirect( $this->get_return_url( $order ) );
			} else {
			
				return wp_redirect( $order->get_checkout_payment_url( $this->use_form_post() && ! $this->use_auto_form_post() ) );
			}

		} catch( Woodev_Payment_Gateway_Exception $e ) {

			if ( isset( $order ) && $order ) {
				$this->mark_order_as_failed( $order, $e->getMessage(), $response );
				return wp_redirect( $order->get_checkout_payment_url( $this->use_form_post() && ! $this->use_auto_form_post() ) );
			}
			
			$this->add_debug_message( 'Ошибка перенаправления: ' . $e->getMessage(), 'error' );
			
			return wp_redirect( get_home_url( null, '' ) );
		}
	}
	
	protected function process_transaction_response( $order, $response ) {
		
		if ( $response->transaction_approved() || $response->transaction_held() ) {

			if ( $response->transaction_approved() ) {

				if ( self::PAYMENT_TYPE_CREDIT_CARD == $response->get_payment_type() ) {
					$this->do_credit_card_transaction_approved( $order, $response );
				} elseif ( self::PAYMENT_TYPE_ECHECK == $response->get_payment_type() ) {
					$this->do_check_transaction_approved( $order, $response );
				} else {
					$this->do_transaction_approved( $order, $response );
				}
			}

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
	
	protected function add_transaction_data( $order, $response = null ) {
	
		parent::add_transaction_data( $order, $response );
		
		if ( $response->get_account_number() ) {
			$this->update_order_meta( $order->id, 'account_four', substr( $response->get_account_number(), -4 ) );
		}

		if ( self::PAYMENT_TYPE_CREDIT_CARD == $response->get_payment_type() ) {

			if ( $response->get_authorization_code() ) {
				$this->update_order_meta( $order->id, 'authorization_code', $response->get_authorization_code() );
			}

			if ( $order->get_total() > 0 ) {
			
				if ( $response->is_charge() ) {
					$captured = 'yes';
				} else {
					$captured = 'no';
				}
				$this->update_order_meta( $order->id, 'charge_captured', $captured );
			}

			if ( $response->get_exp_month() && $response->get_exp_year() ) {
				$this->update_order_meta( $order->id, 'card_expiry_date', $response->get_exp_year() . '-' . $response->get_exp_month() );
			}

			if ( $response->get_card_type() ) {
				$this->update_order_meta( $order->id, 'card_type', $response->get_card_type() );
			}

		} elseif ( self::PAYMENT_TYPE_ECHECK == $response->get_payment_type() ) {
		
			if ( $response->get_account_type() ) {
				$this->update_order_meta( $order->id, 'account_type', $response->get_account_type() );
			}
			
			if ( $response->get_check_number() ) {
				$this->update_order_meta( $order->id, 'check_number', $response->get_check_number() );
			}
		}
	}
	
	protected function do_credit_card_transaction_approved( $order, $response ) {

		$last_four = substr( $response->get_account_number(), -4 );

		$transaction_type = '';
		if ( $response->is_authorization() ) {
			$transaction_type = 'Авторизация';
		} elseif ( $response->is_charge() ) {
			$transaction_type = 'Оплата';
		}
		
		$message = sprintf(
			'%s %s %s одобрена: %s заканчивается на %s (истекает %s)',
			$this->get_method_title(),
			$this->is_test_environment() ? 'Тест' : '',
			$transaction_type,
			Woodev_Payment_Gateway_Helper::payment_type_to_name( ( $response->get_card_type() ? $response->get_card_type() : 'card' ) ),
			$last_four,
			$response->get_exp_month() . '/' . substr( $response->get_exp_year(), -2 )
		);
		
		if ( $response->get_transaction_id() ) {
			$message .= ' ' . sprintf( '(ID транзакции %s)', $response->get_transaction_id() );
		}

		$order->add_order_note( $message );
	}
	
	protected function do_check_transaction_approved( $order, $response ) {

		$last_four = substr( $response->get_account_number(), -4 );
		
		$message = sprintf(
			'%s %s транзакция одобрена: %s заканчивается %s',
			$this->get_method_title(),
			$this->is_test_environment() ? 'Тест' : '',
			Woodev_Payment_Gateway_Helper::payment_type_to_name( ( $response->get_account_type() ? $response->get_account_type() : 'bank' ) ),
			$last_four
		);
		
		if ( $response->get_check_number() ) {
			$message .= ' ' . sprintf( '(истекает %s)', $response->get_check_number() );
		}
		
		if ( $response->get_transaction_id() ) {
			$message .= ' ' . sprintf( '(ID транзакции %s)', $response->get_transaction_id() );
		}

		$order->add_order_note( $message );
	}
	
	protected function do_transaction_approved( $order, $response ) {
	
		$message = sprintf(
			'%s %s транзакция одобрена',
			$this->get_method_title(),
			$this->is_test_environment() ? 'Тест' . ' ' : ''
		);
		
		if ( $response->get_transaction_id() ) {
			$message .= ' ' . sprintf( '(ID транзакции %s)', $response->get_transaction_id() );
		}

		$order->add_order_note( $message );
	}
	
	abstract protected function get_transaction_response( $request_response_data );
	
	public function get_transaction_response_handler_url() {

		if ( $this->transaction_response_handler_url ) {
			return $this->transaction_response_handler_url;
		}

		$this->transaction_response_handler_url = add_query_arg( 'wc-api', get_class( $this ), home_url( '/' ) );
		
		if ( ( is_ssl() && ! is_admin() ) || 'yes' == get_option( 'woocommerce_force_ssl_checkout' ) ) {
			$this->transaction_response_handler_url = str_replace( 'http:', 'https:', $this->transaction_response_handler_url );
		}

		return $this->transaction_response_handler_url;
	}
	
	public function doing_transaction_response_handler() {
		return isset( $_REQUEST['wc-api'] ) && get_class( $this ) == $_REQUEST['wc-api'];
	}
	
	public function log_hosted_pay_page_request( $request ) {

		$this->add_debug_message(
			sprintf( "Request Method: %s\nRequest URI: %s\nRequest Body: %s",
				$request['method'],
				$request['uri'],
				$request['body']
			),
			'message',
			true
		);
	}
	
	public function log_transaction_response_request( $response, $message = null ) {
	
		if ( $this->debug_log() ) {
		
			if ( is_null( $message ) ) {
				$message = ( $this->has_ipn() ? 'IPN' : 'Перенаправление' ) . ' Запрос: %s';
			}

			$this->get_plugin()->log( sprintf( $message, print_r( $response, true ) ), $this->get_id() );
		}
	}
	
	public function is_hosted_gateway() {
		return true;
	}
	
	public function use_form_post() {
		return false;
	}
	
	public function use_auto_form_post() {
		return $this->use_form_post() && true;
	}
	
	public function has_ipn() {
		return true;
	}
}

endif;