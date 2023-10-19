<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Woodev_Payment_Gateway_Direct' ) ) :

abstract class Woodev_Payment_Gateway_Direct extends Woodev_Payment_Gateway {

	const FEATURE_ADD_PAYMENT_METHOD = 'add_payment_method';
	
	protected $tokens;

	public function __construct( $id, $plugin, $args ) {
		parent::__construct( $id, $plugin, $args );
	}
	
	public function validate_fields() {

		$is_valid = parent::validate_fields();

		if ( $this->supports_tokenization() ) {
			
			if ( Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-payment-token' ) ) {
				
				if ( ! $this->has_payment_token( get_current_user_id(), Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-payment-token' ) ) ) {
					Woodev_Helper::wc_add_notice( 'Ошибка оплаты, попробуйте другой способ оплаты или свяжитесь с нами для завершения транзакции.', 'error' );
					$is_valid = false;
				}
				
				return $is_valid;
			}
		}
		
		if ( $this->is_credit_card_gateway() ) {
			return $this->validate_credit_card_fields( $is_valid );
		} elseif ( $this->is_echeck_gateway() ) {
			return $this->validate_check_fields( $is_valid );
		} else {
			$method_name = 'validate_' . str_replace( '-', '_', strtolower( $this->get_payment_type() ) ) . '_fields';
			if ( method_exists( $this, $method_name ) ) {
				$this->$method_name( $is_valid );
			}
		}
	}
	
	protected function validate_credit_card_fields( $is_valid ) {

		$account_number   = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-account-number' );
		$expiration_month = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-exp-month' );
		$expiration_year  = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-exp-year' );
		$expiry           = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-expiry' );
		$csc              = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-csc' );
		
		if ( ! $expiration_month & ! $expiration_year && $expiry ) {
			list( $expiration_month, $expiration_year ) = array_map( 'trim', explode( '/', $expiry ) );
		}

		$is_valid = $this->validate_credit_card_account_number( $account_number ) && $is_valid;

		$is_valid = $this->validate_credit_card_expiration_date( $expiration_month, $expiration_year ) && $is_valid;
		
		if ( $this->csc_enabled() ) {
			$is_valid = $this->validate_csc( $csc ) && $is_valid;
		}

		return $is_valid;
	}
	
	protected function validate_credit_card_expiration_date( $expiration_month, $expiration_year ) {

		$is_valid = true;

		if ( 2 === strlen( $expiration_year ) ) {
			$expiration_year = '20' . $expiration_year;
		}
		
		$current_year  = date( 'Y' );
		$current_month = date( 'n' );

		if ( ! ctype_digit( $expiration_month ) || ! ctype_digit( $expiration_year ) ||
			$expiration_month > 12 ||
			$expiration_month < 1 ||
			$expiration_year < $current_year ||
			( $expiration_year == $current_year && $expiration_month < $current_month ) ||
			$expiration_year > $current_year + 20
		) {
			Woodev_Helper::wc_add_notice( 'Срок действия карты недействителен', 'error' );
			$is_valid = false;
		}

		return $is_valid;
	}
	
	protected function validate_credit_card_account_number( $account_number ) {

		$is_valid = true;
		
		$account_number = str_replace( array( ' ', '-' ), '', $account_number );

		if ( empty( $account_number ) ) {

			Woodev_Helper::wc_add_notice( 'Номер карты отсутствует', 'error' );
			$is_valid = false;

		} else {

			if ( strlen( $account_number ) < 12 || strlen( $account_number ) > 19 ) {
				Woodev_Helper::wc_add_notice( 'Номер карты недействителен (неправильная длина)', 'error' );
				$is_valid = false;
			}

			if ( ! ctype_digit( $account_number ) ) {
				Woodev_Helper::wc_add_notice( 'Номер карты недействителен (разрешены только цифры)', 'error' );
				$is_valid = false;
			}

			if ( ! Woodev_Payment_Gateway_Helper::luhn_check( $account_number ) ) {
				Woodev_Helper::wc_add_notice( 'Номер карты недействителен', 'error' );
				$is_valid = false;
			}

		}

		return $is_valid;
	}
	
	protected function validate_csc( $csc ) {

		$is_valid = true;
		
		if ( empty( $csc ) ) {

			Woodev_Helper::wc_add_notice( 'Код безопасности карты отсутствует', 'error' );
			$is_valid = false;

		} else {
		
			if ( ! ctype_digit( $csc ) ) {
				Woodev_Helper::wc_add_notice( 'Код безопасности карты недействителен (разрешены только цифры)', 'error' );
				$is_valid = false;
			}
			
			if ( strlen( $csc ) < 3 || strlen( $csc ) > 4 ) {
				Woodev_Helper::wc_add_notice( 'Код безопасности карты недействителен (должено быть 3 или 4 цифры)', 'error' );
				$is_valid = false;
			}

		}

		return $is_valid;
	}
	
	protected function validate_check_fields( $is_valid ) {

		$account_number         = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-account-number' );
		$routing_number         = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-routing-number' );
		$drivers_license_number = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-drivers-license-number' );
		$check_number           = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-check-number' );
		
		if ( empty( $routing_number ) ) {
			Woodev_Helper::wc_add_notice( 'Routing Number is missing', 'error' );
			$is_valid = false;

		} else {
			
			if ( ! ctype_digit( $routing_number ) ) {
				Woodev_Helper::wc_add_notice( 'Routing Number is invalid (only digits are allowed)', 'error' );
				$is_valid = false;
			}
			
			if ( 9 != strlen( $routing_number ) ) {
				Woodev_Helper::wc_add_notice( 'Routing number is invalid (must be 9 digits)', 'error' );
				$is_valid = false;
			}

		}
		
		if ( empty( $account_number ) ) {
			Woodev_Helper::wc_add_notice( 'Account Number is missing', 'error' );
			$is_valid = false;
		} else {
		
			if ( ! ctype_digit( $account_number ) ) {
				Woodev_Helper::wc_add_notice( 'Account Number is invalid (only digits are allowed)', 'error' );
				$is_valid = false;
			}
			
			if ( strlen( $account_number ) < 5 || strlen( $account_number ) > 17 ) {
				Woodev_Helper::wc_add_notice( 'Account number is invalid (must be between 5 and 17 digits)', 'error' );
				$is_valid = false;
			}
		}
		
		if ( ! empty( $drivers_license_number ) &&  preg_match( '/^[a-zA-Z0-9 -]+$/', $drivers_license_number ) ) {
			Woodev_Helper::wc_add_notice( 'Drivers license number is invalid', 'error' );
			$is_valid = false;
		}
		
		if ( ! empty( $check_number ) && ! ctype_digit( $check_number ) ) {
			Woodev_Helper::wc_add_notice( 'Check Number is invalid (only digits are allowed)', 'error' );
			$is_valid = false;
		}

		return $is_valid;
	}
	
	public function tokenize_before_sale() {
		return false;
	}
	
	public function tokenize_with_sale() {
		return false;
	}
	
	public function tokenize_after_sale() {
		return false;
	}
	
	public function process_payment( $order_id ) {
		
		if ( true !== ( $result = apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_process_payment', true, $order_id, $this ) ) ) {
			return $result;
		}
		
		$order = $this->get_order( $order_id );

		try {
			
			if ( $this->supports_tokenization() && 0 != $order->get_user_id() && $this->should_tokenize_payment_method() &&
				( 0 == $order->payment_total || $this->tokenize_before_sale() ) ) {
				$order = $this->create_payment_token( $order );
			}
			
			if ( ( 0 == $order->payment_total && ! $this->transaction_forced() ) || $this->do_transaction( $order ) ) {
			
				if ( 0 == $order->payment_total ) {
					$this->add_transaction_data( $order );
				}

				if ( $order->has_status( 'on-hold' ) ) {
					$order->reduce_order_stock();
				} else {
					$order->payment_complete();
				}

				WC()->cart->empty_cart();

				return array(
					'result'   => 'success',
					'redirect' => $this->get_return_url( $order ),
				);
			}

		} catch ( Woodev_Plugin_Exception $e ) {

			$this->mark_order_as_failed( $order, $e->getMessage() );

		}
	}
	
	protected function get_order( $order_id ) {

		$order = parent::get_order( $order_id );
		
		if ( Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-account-number' ) && ! Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-payment-token' ) ) {
			
			$order->payment->account_number = str_replace( array( ' ', '-' ), '', Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-account-number' ) );
			$order->payment->last_four = substr( $order->payment->account_number, -4 );

			if ( $this->is_credit_card_gateway() ) {
				
				$order->payment->card_type      = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-card-type' );
				$order->payment->exp_month      = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-exp-month' );
				$order->payment->exp_year       = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-exp-year' );
				
				if ( empty( $order->payment->card_type ) ) {
					$order->payment->card_type = Woodev_Payment_Gateway_Helper::card_type_from_account_number( $order->payment->account_number );
				}
				
				if ( Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-expiry' ) ) {
					list( $order->payment->exp_month, $order->payment->exp_year ) = array_map( 'trim', explode( '/', Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-expiry' ) ) );
				}
				
				if ( $this->csc_enabled() ) {
					$order->payment->csc = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-csc' );
				}

			} elseif ( $this->is_echeck_gateway() ) {
				
				$order->payment->routing_number         = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-routing-number' );
				$order->payment->account_type           = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-account-type' );
				$order->payment->check_number           = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-check-number' );
				$order->payment->drivers_license_number = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-drivers-license-number' );
				$order->payment->drivers_license_state  = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-drivers-license-state' );

			}

		} elseif ( Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-payment-token' ) ) {
			
			$token = $this->get_payment_token( $order->get_user_id(), Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-payment-token' ) );

			$order->payment->token          = $token->get_token();
			$order->payment->account_number = $token->get_last_four();
			$order->payment->last_four      = $token->get_last_four();

			if ( $this->is_credit_card_gateway() ) {
				
				$order->payment->card_type = $token->get_card_type();
				$order->payment->exp_month = $token->get_exp_month();
				$order->payment->exp_year  = $token->get_exp_year();

				if ( $this->csc_enabled() ) {
					$order->payment->csc      = Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-csc' );
				}

			} elseif ( $this->is_echeck_gateway() ) {
				$order->payment->account_type = $token->get_account_type();
			}
			
			$this->set_default_payment_token( $order->get_user_id(), $token );
		}
		
		return apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_get_order', $order, $this );
	}
	
	protected function get_order_for_capture( $order ) {
		
		$order->capture_total = number_format( $order->get_total(), 2, '.', '' );
		
		$order->description = sprintf( '%s - Capture for Order %s', esc_html( get_bloginfo( 'name' ) ), $order->get_order_number() );

		return apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_get_order_for_capture', $order, $this );
	}
	
	protected function do_check_transaction( $order ) {

		$response = $this->get_api()->check_debit( $order );
		
		if ( $response->transaction_approved() ) {

			$last_four = substr( $order->payment->account_number, -4 );
			
			$message = sprintf( '%s Check Transaction Approved: %s account ending in %s', $this->get_method_title(), $order->payment->account_type, $last_four );
			
			if ( ! empty( $order->payment->check_number ) ) {
				$message .= '. ' . sprintf( 'Check number %s', $order->payment->check_number );
			}
			
			if ( $response->get_transaction_id() ) {
				$message .= ' ' . sprintf( '(Transaction ID %s)', $response->get_transaction_id() );
			}

			$order->add_order_note( $message );

		}

		return $response;

	}
	
	protected function do_credit_card_transaction( $order, $response = null ) {

		if ( is_null( $response ) ) {
			if ( $this->perform_credit_card_charge() ) {
				$response = $this->get_api()->credit_card_charge( $order );
			} else {
				$response = $this->get_api()->credit_card_authorization( $order );
			}
		}
		
		if ( $response->transaction_approved() ) {

			$last_four = substr( $order->payment->account_number, -4 );
			
			if ( ! empty( $order->payment->card_type ) ) {
				$card_type = $order->payment->card_type;
			} elseif ( $first_four = substr( $order->payment->account_number, 0, 4 ) ) {
				$card_type = Woodev_Payment_Gateway_Helper::card_type_from_account_number( $first_four );
			} else {
				$card_type = 'card';
			}
			
			$message = sprintf(
				'%s %s %s Approved: %s ending in %s (expires %s)',
				$this->get_method_title(),
				$this->is_test_environment() ? 'Test' : '',
				$this->perform_credit_card_authorization() ? 'Authorization' : 'Charge',
				Woodev_Payment_Gateway_Helper::payment_type_to_name( $card_type ),
				$last_four,
				$order->payment->exp_month . '/' . substr( $order->payment->exp_year, -2 )
			);
			
			if ( $response->get_transaction_id() ) {
				$message .= ' ' . sprintf( '(Transaction ID %s)', $response->get_transaction_id() );
			}

			$order->add_order_note( $message );

		}

		return $response;

	}
	
	protected function do_transaction( $order ) {
	
		if ( $this->is_credit_card_gateway() ) {
			$response = $this->do_credit_card_transaction( $order );
		} elseif ( $this->is_echeck_gateway() ) {
			$response = $this->do_check_transaction( $order );
		} else {
			$do_payment_type_transaction = 'do_' . $this->get_payment_type() . '_transaction';
			$response = $this->$do_payment_type_transaction( $order );
		}
		
		if ( $response->transaction_approved() || $response->transaction_held() ) {

			if ( $this->supports_tokenization() && 0 != $order->get_user_id() && $this->should_tokenize_payment_method() &&
				( $order->payment_total > 0 && ( $this->tokenize_with_sale() || $this->tokenize_after_sale() ) ) ) {

				try {
					$order = $this->create_payment_token( $order, $response );
				} catch ( Woodev_Plugin_Exception $e ) {
					
					if ( ! $response->transaction_held() && ! ( $this->supports( self::FEATURE_CREDIT_CARD_AUTHORIZATION ) && $this->perform_credit_card_authorization() ) ) {
					
						$message = sprintf(
							'Tokenization Request Failed: %s',
							$e->getMessage()
						);

						$this->mark_order_as_held( $order, $message, $response );

					} else {
					
						$message = sprintf(
							'%s Tokenization Request Failed: %s',
							$this->get_method_title(),
							$e->getMessage()
						);

						$order->add_order_note( $message );
					}
				}
			}
			
			$this->add_transaction_data( $order, $response );
			
			$this->add_payment_gateway_transaction_data( $order, $response );
			
			if ( $response->transaction_held() || ( $this->supports( self::FEATURE_CREDIT_CARD_AUTHORIZATION ) && $this->perform_credit_card_authorization() ) ) {
				$this->mark_order_as_held( $order, $this->supports( self::FEATURE_CREDIT_CARD_AUTHORIZATION ) && $this->perform_credit_card_authorization() ? 'Authorization only transaction' : $response->get_status_message(), $response );
			}

			return true;

		} else {
			return $this->do_transaction_failed_result( $order, $response );

		}
	}
	
	public function do_credit_card_capture( $order ) {

		$order = $this->get_order_for_capture( $order );

		try {

			$response = $this->get_api()->credit_card_capture( $order );

			if ( $response->transaction_approved() ) {

				$message = sprintf(
					'%s Capture of %s Approved',
					$this->get_method_title(),
					get_woocommerce_currency_symbol() . wc_format_decimal( $order->capture_total )
				);
				
				if ( $response->get_transaction_id() ) {
					$message .= ' ' . sprintf( '(Transaction ID %s)', $response->get_transaction_id() );
				}

				$order->add_order_note( $message );
				
				add_filter( 'woocommerce_payment_complete_reduce_order_stock', '__return_false', 100 );
				
				$order->payment_complete();
				
				$this->add_capture_data( $order, $response );
				
				$this->add_payment_gateway_capture_data( $order, $response );

			} else {

				$message = sprintf(
					'%s Capture Failed: %s - %s',
					$this->get_method_title(),
					$response->get_status_code(),
					$response->get_status_message()
				);

				$order->add_order_note( $message );

			}

			return $response;

		} catch ( Woodev_Plugin_Exception $e ) {

			$message = sprintf(
				'%s Capture Failed: %s',
				$this->get_method_title(),
				$e->getMessage()
			);

			$order->add_order_note( $message );

			return null;
		}
	}
	
	protected function add_transaction_data( $order, $response = null ) {
	
		parent::add_transaction_data( $order, $response );
		
		if ( isset( $order->payment->token ) && $order->payment->token ) {
			$this->update_order_meta( $order->id, 'payment_token', $order->payment->token );
		}
		
		if ( isset( $order->payment->account_number ) && $order->payment->account_number ) {
			$this->update_order_meta( $order->id, 'account_four', substr( $order->payment->account_number, -4 ) );
		}

		if ( $this->is_credit_card_gateway() ) {
		
			if ( $response && $response instanceof Woodev_Payment_Gateway_API_Authorization_Response ) {

				if ( $response->get_authorization_code() ) {
					$this->update_order_meta( $order->id, 'authorization_code', $response->get_authorization_code() );
				}

				if ( $order->payment_total > 0 ) {
				
					if ( $this->perform_credit_card_charge() ) {
						$captured = 'yes';
					} else {
						$captured = 'no';
					}
					$this->update_order_meta( $order->id, 'charge_captured', $captured );
				}

			}

			if ( isset( $order->payment->exp_year ) && $order->payment->exp_year && isset( $order->payment->exp_month ) && $order->payment->exp_month ) {
				$this->update_order_meta( $order->id, 'card_expiry_date', $order->payment->exp_year . '-' . $order->payment->exp_month );
			}

			if ( isset( $order->payment->card_type ) && $order->payment->card_type ) {
				$this->update_order_meta( $order->id, 'card_type', $order->payment->card_type );
			}

		} elseif ( $this->is_echeck_gateway() ) {
		
			if ( isset( $order->payment->account_type ) && $order->payment->account_type ) {
				$this->update_order_meta( $order->id, 'account_type', $order->payment->account_type );
			}
			
			if ( isset( $order->payment->check_number ) && $order->payment->check_number ) {
				$this->update_order_meta( $order->id, 'check_number', $order->payment->check_number );
			}
		}
	}
	
	protected function add_capture_data( $order, $response ) {
	
		$this->update_order_meta( $order->id, 'charge_captured', 'yes' );
		
		if ( $response && $response->get_transaction_id() ) {
			$this->update_order_meta( $order->id, 'capture_trans_id', $response->get_transaction_id() );
		}
	}
	
	protected function add_payment_gateway_capture_data( $order, $response ) {}

	public function update_failing_payment_method( WC_Order $original_order, WC_Order $renewal_order ) {

		if ( $this->get_order_meta( $renewal_order->id, 'customer_id' ) ) {
			$this->update_order_meta( $original_order->id, 'customer_id',   $this->get_order_meta( $renewal_order->id, 'customer_id' ) );
		}

		$this->update_order_meta( $original_order->id, 'payment_token', $this->get_order_meta( $renewal_order->id, 'payment_token' ) );
	}

	public function build_payment_token( $token, $data ) {
		assert( $this->supports_tokenization() );
		return new Woodev_Payment_Gateway_Payment_Token( $token, $data );

	}
	
	protected function create_payment_token( $order, $response = null, $environment_id = null ) {

		assert( $this->supports_tokenization() );
		
		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}
		
		if ( ! $response || $this->tokenize_after_sale() ) {
			$response = $this->get_api()->tokenize_payment_method( $order );
		}

		if ( $response->transaction_approved() ) {
		
			$token                 = $response->get_payment_token();
			$order->payment->token = $token->get_token();
			
			if ( $this->is_credit_card_gateway() && $token->get_card_type() ) {
				$order->payment->card_type = $token->get_card_type();
			}
			
			if ( $this->is_echeck_gateway() && $token->get_account_type() ) {
				$order->payment->account_type = $token->get_account_type();
			}
			
			if ( $order->get_user_id() ) {
				$this->add_payment_token( $order->get_user_id(), $token, $environment_id );
			}
			
			if ( $this->is_credit_card_gateway() ) {
				$message = sprintf( '%s Payment Method Saved: %s ending in %s (expires %s)',
					$this->get_method_title(),
					$token->get_type_full(),
					$token->get_last_four(),
					$token->get_exp_date()
				);
			} elseif ( $this->is_echeck_gateway() ) {
			
				$message = sprintf( '%s eCheck Payment Method Saved: %s account ending in %s',
					$this->get_method_title(),
					$token->get_account_type(),
					$token->get_last_four()
				);
			}

			$order->add_order_note( $message );
			
			$this->add_transaction_data( $order, $response );
			
			if ( $transient_key = $this->get_payment_tokens_transient_key( $order->get_user_id() ) ) {
				delete_transient( $transient_key );
			}

		} else {

			if ( $response->get_status_code() && $response->get_status_message() ) {
				$message = sprintf( 'Status code %s: %s', $response->get_status_code(), $response->get_status_message() );
			} elseif ( $response->get_status_code() ) {
				$message = sprintf( 'Status code: %s', $response->get_status_code() );
			} elseif ( $response->get_status_message() ) {
				$message = sprintf( 'Status message: %s', $response->get_status_message() );
			} else {
				$message = 'Unknown Error';
			}
			
			if ( $response->get_transaction_id() ) {
				$message .= ' ' . sprintf( 'Transaction ID %s', $response->get_transaction_id() );
			}

			throw new Woodev_Payment_Gateway_Exception( $message );
		}

		return $order;
	}


	public function tokenization_forced() {
		assert( $this->supports_tokenization() );
		return apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_tokenization_forced', false, $this );
	}
	
	protected function should_tokenize_payment_method() {
		assert( $this->supports_tokenization() );
		return Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-tokenize-payment-method' ) && ! Woodev_Helper::get_post( 'wc-' . $this->get_id_dasherized() . '-payment-token' );
	}
	
	public function get_payment_token_user_meta_name( $environment_id = null ) {

		assert( $this->supports_tokenization() );
		
		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}
		
		return $this->get_order_meta_prefix() . 'payment_tokens' . ( ! $this->is_production_environment( $environment_id ) ? '_' . $environment_id : '' );
	}
	
	public function get_payment_tokens( $user_id, $args = array() ) {

		assert( $this->supports_tokenization() );
		
		if ( ! isset( $args['environment_id'] ) ) {
			$args['environment_id'] = $this->get_environment();
		}

		if ( ! isset( $args['customer_id'] ) ) {
			$args['customer_id'] = $this->get_customer_id( $user_id, array( 'environment_id' => $args['environment_id'] ) );
		}

		$environment_id = $args['environment_id'];
		$customer_id    = $args['customer_id'];
		$transient_key  = $this->get_payment_tokens_transient_key( $user_id );
		
		if ( isset( $this->tokens[ $environment_id ][ $user_id ] ) ) {
			return $this->tokens[ $environment_id ][ $user_id ];
		}
		
		if ( $transient_key && ( false !== ( $this->tokens[ $environment_id ][ $user_id ] = get_transient( $transient_key ) ) ) ) {
			return $this->tokens[ $environment_id ][ $user_id ];
		}

		$this->tokens[ $environment_id ][ $user_id ] = array();
		$tokens = array();
		
		if ( $user_id ) {

			$_tokens = get_user_meta( $user_id, $this->get_payment_token_user_meta_name( $environment_id ), true );
			
			if ( is_array( $_tokens ) ) {
				foreach ( $_tokens as $token => $data ) {
					$tokens[ $token ] = $this->build_payment_token( $token, $data );
				}
			}

			$this->tokens[ $environment_id ][ $user_id ] = $tokens;
		}
		
		if ( $this->get_api()->supports_get_tokenized_payment_methods() && $customer_id ) {

			try {
				
				$response = $this->get_api()->get_tokenized_payment_methods( $customer_id );
				$this->tokens[ $environment_id ][ $user_id ] = $response->get_payment_tokens();
				
				$default_token = null;
				foreach ( $tokens as $default_token ) {
					if ( $default_token->is_default() ) {
						break;
					}
				}
				
				if ( $default_token && $default_token->is_default() && isset( $this->tokens[ $environment_id ][ $user_id ][ $default_token->get_token() ] ) ) {
					$this->tokens[ $environment_id ][ $user_id ][ $default_token->get_token() ]->set_default( true );
				}
				
				$this->tokens[ $environment_id ][ $user_id ] = $this->merge_payment_token_data( $tokens, $this->tokens[ $environment_id ][ $user_id ] );
				
				$this->update_payment_tokens( $user_id, $this->tokens[ $environment_id ][ $user_id ], $environment_id );

			} catch( Woodev_Plugin_Exception $e ) {

				$this->add_debug_message( $e->getMessage(), 'error' );

				$this->tokens[ $environment_id ][ $user_id ] = $tokens;
			}

		}
		
		foreach ( $this->tokens[ $environment_id ][ $user_id ] as $key => $token ) {
			$this->tokens[ $environment_id ][ $user_id ][ $key ]->set_image_url( $this->get_payment_method_image_url( $token->is_credit_card() ? $token->get_card_type() : 'echeck' ) );
		}

		if ( $transient_key ) {
			set_transient( $transient_key, $this->tokens[ $environment_id ][ $user_id ], 60 );
		}
		
		do_action( 'wc_payment_gateway_' . $this->get_id() . '_payment_tokens_loaded', $this->tokens[ $environment_id ][ $user_id ], $this );

		return $this->tokens[ $environment_id ][ $user_id ];
	}
	
	protected function merge_payment_token_data( $local_tokens, $remote_tokens ) {

		foreach ( $remote_tokens as &$remote_token ) {

			$remote_token_id = $remote_token->get_token();
			
			if ( ! isset( $local_tokens[ $remote_token_id ] ) ) {
				continue;
			}

			foreach ( $this->get_payment_token_merge_attributes() as $attribute ) {

				$get_method = "get_{$attribute}";
				$set_method = "set_{$attribute}";
				
				if ( ! $remote_token->$get_method() && $local_tokens[ $remote_token_id ]->$get_method() ) {
					$remote_token->$set_method( $local_tokens[ $remote_token_id ]->$get_method() );
				}
			}
		}

		return $remote_tokens;
	}
	
	protected function get_payment_token_merge_attributes() {
		return array( 'last_four', 'card_type', 'account_type', 'exp_month', 'exp_year' );
	}
	
	protected function get_payment_tokens_transient_key( $user_id = null ) {

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}
		
		$key = sprintf( 'wc_woodev_tokens_%s', md5( $this->get_id() . '_' . $user_id . '_' . $this->get_environment() ) );
		
		return apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_payment_tokens_transient_key', $key, $user_id, $this );
	}
	
	public function clear_payment_tokens_transient( $user_id ) {
		delete_transient( $this->get_payment_tokens_transient_key( $user_id ) );
	}
	
	protected function update_payment_tokens( $user_id, $tokens, $environment_id = null ) {
	
		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}
		
		$this->tokens[ $environment_id ][ $user_id ] = $tokens;
		
		$this->clear_payment_tokens_transient( $user_id );
		
		return update_user_meta( $user_id, $this->get_payment_token_user_meta_name( $environment_id ), $this->payment_tokens_to_database_format( $tokens ) );
	}
	
	public function get_payment_token( $user_id, $token, $environment_id = null ) {

		assert( $this->supports_tokenization() );
		
		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}

		$tokens = $this->get_payment_tokens( $user_id, array( 'environment_id' => $environment_id ) );

		if ( isset( $tokens[ $token ] ) ) return $tokens[ $token ];

		return null;
	}
	
	public function update_payment_token( $user_id, $token, $environment_id = null ) {

		assert( $this->supports_tokenization() );
		
		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}

		$tokens = $this->get_payment_tokens( $user_id, array( 'environment_id' => $environment_id ) );

		if ( isset( $tokens[ $token->get_id() ] ) ) {
			$tokens[ $token->get_id() ] = $token;
		}

		return $this->update_payment_tokens( $user_id, $tokens, $environment_id );
	}
	
	public function has_payment_token( $user_id, $token, $environment_id = null ) {

		assert( $this->supports_tokenization() );
		
		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}

		if ( is_object( $token ) ) {
			$token = $token->get_token();
		}
		
		if ( ! $this->get_api()->supports_get_tokenized_payment_methods() && ! $user_id ) {
			return true;
		}
		
		return ! is_null( $this->get_payment_token( $user_id, $token, $environment_id ) );
	}
	
	public function add_payment_token( $user_id, $token, $environment_id = null ) {

		assert( $this->supports_tokenization() );
		
		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}
		
		$tokens = $this->get_payment_tokens( $user_id, array( 'environment_id' => $environment_id ) );
		
		if ( $token->is_default() ) {
			foreach ( array_keys( $tokens ) as $key ) {
				$tokens[ $key ]->set_default( false );
			}
		}
		
		$tokens[ $token->get_token() ] = $token;
		
		return $this->update_payment_tokens( $user_id, $tokens, $environment_id );
	}
	
	public function remove_payment_token( $user_id, $token, $environment_id = null ) {

		assert( $this->supports_tokenization() );
		
		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}
		
		if ( ! $this->has_payment_token( $user_id, $token, $environment_id ) ) {
			return false;
		}
		
		if ( ! is_object( $token ) ) {
			$token = $this->get_payment_token( $user_id, $token, $environment_id );
		}
		
		if ( $this->get_api()->supports_remove_tokenized_payment_method() ) {

			try {

				$response = $this->get_api()->remove_tokenized_payment_method( $token->get_token(), $this->get_customer_id( $user_id, array( 'environment_id' => $environment_id ) ) );

				if ( ! $response->transaction_approved() ) {
					return false;
				}

			} catch( Woodev_Plugin_Exception $e ) {
				if ( $this->debug_log() ) {
					$this->get_plugin()->log( $e->getMessage() . "\n" . $e->getTraceAsString(), $this->get_id() );
				}
				return false;
			}
		}
		
		$tokens = $this->get_payment_tokens( $user_id, array( 'environment_id' => $environment_id ) );

		unset( $tokens[ $token->get_token() ] );
		
		if ( $token->is_default() ) {
			foreach ( array_keys( $tokens ) as $key ) {
				$tokens[ $key ]->set_default( true );
				break;
			}
		}
		
		return $this->update_payment_tokens( $user_id, $tokens );
	}
	
	public function set_default_payment_token( $user_id, $token, $environment_id = null ) {

		assert( $this->supports_tokenization() );
		
		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment();
		}
		
		if ( ! $this->has_payment_token( $user_id, $token ) )
			return false;
			
		if ( ! is_object( $token ) ) {
			$token = $this->get_payment_token( $user_id, $token, $environment_id );
		}
		
		$tokens = $this->get_payment_tokens( $user_id, array( 'environment_id' => $environment_id ) );
		
		foreach ( $tokens as $key => $_token ) {

			if ( $token->get_token() == $_token->get_token() ) {
				$tokens[ $key ]->set_default( true );
			} else {
				$tokens[ $key ]->set_default( false );
			}

		}
		
		return $this->update_payment_tokens( $user_id, $tokens, $environment_id );

	}
	
	protected function payment_tokens_to_database_format( $tokens ) {

		assert( $this->supports_tokenization() );

		$_tokens = array();
		
		foreach ( $tokens as $key => $token ) {
			$_tokens[ $key ] = $token->to_datastore_format();
		}

		return $_tokens;
	}
	
	public function supports_add_payment_method() {
		return $this->supports( self::FEATURE_ADD_PAYMENT_METHOD );
	}
	
	public function add_payment_method() {

		assert( $this->supports_add_payment_method() );

		$order = $this->get_order_for_add_payment_method();

		try {

			$result = $this->do_add_payment_method_transaction( $order );

		} catch ( Woodev_Plugin_Exception $e ) {

			$result = array(
				'message' => sprintf( 'Oops, adding your new payment method failed: %s', $e->getMessage() ),
				'success' => false,
			);
		}

		Woodev_Helper::wc_add_notice( $result['message'], $result['success'] ? 'success' : 'error' );
		
		wp_safe_redirect( $result['success'] ? wc_get_page_permalink( 'myaccount' ) : wc_get_endpoint_url( 'add-payment-method' ) );

		exit();
	}
	
	protected function do_add_payment_method_transaction( WC_Order $order ) {

		$response = $this->get_api()->tokenize_payment_method( $order );

		if ( $response->transaction_approved() ) {

			$token = $response->get_payment_token();
			
			$this->add_payment_token( $order->customer_user, $token );
			
			if ( $this->is_credit_card_gateway() ) {

				$message = sprintf( 'Nice! New payment method added: %s ending in %s (expires %s)',
					$token->get_type_full(),
					$token->get_last_four(),
					$token->get_exp_date()
				);

			} elseif ( $this->is_echeck_gateway() ) {
			
				$message = sprintf( 'Nice! New payment method added: %s account ending in %s',
					$token->get_account_type(),
					$token->get_last_four()
				);

			} else {
				$message = 'Nice! New payment method added.';
			}
			
			$this->add_add_payment_method_transaction_data( $response );
			
			$this->add_add_payment_method_customer_data( $order, $response );

			$result = array( 'message' => $message, 'success' => true );

		} else {

			if ( $response->get_status_code() && $response->get_status_message() ) {
				$message = sprintf( 'Status codes %s: %s', $response->get_status_code(), $response->get_status_message() );
			} elseif ( $response->get_status_code() ) {
				$message = sprintf( 'Status code: %s', $response->get_status_code() );
			} elseif ( $response->get_status_message() ) {
				$message = sprintf( 'Status message: %s', $response->get_status_message() );
			} else {
				$message = 'Unknown Error';
			}

			$result = array( 'message' => $message, 'success' => false );
		}
		
		return apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_add_payment_method_transaction_result', $result, $response, $order, $this );
	}
	
	protected function get_order_for_add_payment_method() {

		$order = new WC_Order( 0 );
		
		$order = $this->get_order( $order );

		$user = get_userdata( get_current_user_id() );

		$order->customer_user = $user->ID;
		
		$fields = array(
			'billing_first_name', 'billing_last_name', 'billing_address_1', 'billing_company',
			'billing_address_2', 'billing_city', 'billing_postcode', 'billing_state',
			'billing_country', 'billing_phone', 'billing_email', 'shipping_first_name',
			'shipping_last_name', 'shipping_company', 'shipping_address_1', 'shipping_address_2',
			'shipping_city', 'shipping_postcode', 'shipping_state', 'shipping_country',
		);

		foreach ( $fields as $field ) {
			$order->$field = $user->$field;
		}
		
		$order->customer_id = $this->get_customer_id( $order->customer_user );
		$order->description = sprintf( '%s - Add Payment Method for %s', sanitize_text_field( get_bloginfo( 'name' ) ), $order->billing_email );
		$order->payment_total = '0.00';
		
		return apply_filters( 'wc_payment_gateway_' . $this->get_id() . '_get_order_for_add_payment_method', $order, $this );
	}
	
	protected function add_add_payment_method_customer_data( $order, $response ) {

		$user_id = $order->get_user_id();
		
		if ( $this->supports_customer_id() && method_exists( $response, 'get_customer_id' ) && $response->get_customer_id() ) {
			$order->customer_id = $customer_id = $response->get_customer_id();

		} else {
		
			$customer_id = $order->customer_id;
		}
		
		if ( 0 != $user_id ) {
			$this->update_customer_id( $user_id, $customer_id );
		}
	}
	
	protected function add_add_payment_method_transaction_data( $response ) {

		$user_meta_key = '_wc_' . $this->get_id() . '_add_payment_method_transaction_data';

		$data = (array) get_user_meta( get_current_user_id(), $user_meta_key, true );

		$new_data = array(
			'trans_id'    => $response->get_transaction_id() ? $response->get_transaction_id() : null,
			'trans_date'  => current_time( 'mysql' ),
			'environment' => $this->get_environment(),
		);

		$data[] = array_merge( $new_data, $this->get_add_payment_method_payment_gateway_transaction_data( $response ) );
		
		if ( count( $data ) > 5 ) {
			array_shift( $data );
		}

		update_user_meta( get_current_user_id(), $user_meta_key, array_filter( $data ) );
	}
	
	protected function get_add_payment_method_payment_gateway_transaction_data( $response ) {
		return array();
	}
	
	public function is_direct_gateway() {
		return true;
	}
	
	public function transaction_forced() {
		return false;
	}
}

endif;