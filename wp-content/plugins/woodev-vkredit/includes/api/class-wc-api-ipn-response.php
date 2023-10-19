<?php

defined( 'ABSPATH' ) or exit;

class WC_Gateway_Tinkoff_KVK_API_IPN_Response implements Woodev_Payment_Gateway_API_Payment_Notification_Response {
	
	protected $response;
	
	protected $shop_id;
	
	public function __construct( $response, $shop_id = '' ) {
		$this->response	= json_decode( $response );
		$this->shop_id	= $shop_id;
	}
	
	public function __get( $name ) {
		if( $this->response && property_exists( $this->response, $name ) ) {
			return $this->response->$name;
		}
		
		return null;
	}
	
	public function get_order_id() {
		if ( ! $this->response ) {
			throw new Woodev_Payment_Gateway_Exception( 'Возвращаемые данные с сервера банка не корректны.' );
		}
		
		if( empty( $this->response->id ) ) {
			throw new Woodev_Payment_Gateway_Exception( 'От сервера небыл получен обязательный параметр ID заказа.' );
		}
		
		
		return $this->response->id;
	}
	
	public function get_order() {
		return wc_get_order( $this->get_order_id() );
	}
	
	public function transaction_approved() {
		return $this->get_status_code() && 'signed' === $this->get_status_code() && $this->valid_response_data();
	}
	
	public function transaction_held() {
		return $this->get_status_code() && 'approved' === $this->get_status_code() && $this->valid_response_data();
	}
	
	public function transaction_cancelled() {
		return $this->get_status_code() && in_array( $this->get_status_code(), array( 'canceled', 'rejected' ), true );
	}
	
	public function get_transaction_id() {
		if( $this->response->loan_number ) {
			return $this->response->loan_number;
		}
		return null;
	}
	
	public function get_payment_type() {
		return 'bank_transfer';
	}
	
	public function get_account_number() {
		return null;
	}
	
	public function get_status_message() {
		if ( $this->transaction_approved() ) {
			return 'Кредит успешно одобрен банком.';
		} elseif( $this->transaction_cancelled() ) {
			switch( $this->get_status_code() ) {
				case 'canceled' : return 'Заявка на кредит была отменена покупателем';
				case 'rejected' : return 'Заявка на кредит была отклонена банком';
			}
		} elseif( $this->transaction_held() ) {
			return 'Заявка на кредит предварительно одобрена. Ожидается подтверждение от покупателя.';
		} elseif ( ! $this->valid_response_data() ) {
			return implode( '. ', $this->get_response_data_error_messages() );
		} else {
			return 'Во время запроса на получение инофрмации о кредите произошла неизвестная ошибка.';
		}
	}
	
	public function get_status_code() {
		if( $this->response->status ) {
			return $this->response->status;
		}
		return null;
	}
	
	public function get_credit_product_type() {
		if( $this->response->product ) {
			return $this->response->product;
		}
		return null;
	}
	
	public function get_user_message() {
		return null;
	}
	
	public function is_demo() {
		if( $this->response->demo ) {
			return $this->response->demo;
		}
		return null;
	}
	
	public function valid_response_data() {

		foreach ( $this->get_invalid_response_data() as $errors ) {
			if ( count( $errors ) > 0 ) {
				return false;
			}
		}
		return true;
	}
	
	public function get_response_data_error_messages() {
		$messages = array();

		foreach ( $this->get_invalid_response_data() as $name => $errors ) {
			if ( count( $errors ) > 0 ) {
				$messages[] = sprintf( 'Invalid %1$s data: %2$s', $name, implode( ', ', $errors ) );
			}
		}

		return $messages;
	}
	
	private function get_invalid_response_data() {
		
		$invalid_response_data = array();
		$require_response_data = apply_filters( 'wc_tinkoff_ipn_require_response_data', array(
			'id',
			'status',
			'order_amount',
			'credit_amount',
			'first_payment',
			'product',
			'signing_type',
			'loan_number'
		) );
		
		foreach( $require_response_data as $data ) {
			if( ! property_exists( $this->response, $data ) ) {
				$invalid_response_data[$data][] = 'Обязательный параметр';
			} else {
				switch( $data ) {
					case 'id' :
						if( ! $this->get_order() ) {
							$invalid_response_data[$data][] = 'ID заказа указан не верно. Такой заказ не найден';
						}
						break;
						
					case 'status' :
						if( ! in_array( $this->get_status_code(), array( 'signed', 'approved', 'rejected', 'canceled' ), true ) ) {
							$invalid_response_data[$data][] = 'Получен не допустимый статус заказа кредита';
						}
						break;
						
					case 'order_amount' :
						
						if( Woodev_Helper::number_format( $this->response->order_amount ) !== Woodev_Helper::number_format( $this->get_order()->get_total() ) ) {
							$invalid_response_data[$data][] = 'Итоговая сумма заказа не совпадает с суммой кредита';
						}
						break;
					case 'loan_number' :
					case 'signing_type' :
						if( in_array( $this->get_status_code(), array( 'signed' ), true ) && ( empty( $this->response->$data ) || is_null( $this->response->$data ) ) ) {
							$invalid_response_data[$data][] = 'Не может быть пустым значением';
						}
						break;
				}
			}
		}
		
		return $invalid_response_data;
	}
	
	public function to_string() {
		return print_r( $this->response, true );
	}
	
	public function to_string_safe() {
		return $this->to_string();
	}
}