<?php

defined( 'ABSPATH' ) or exit;

class WC_Tinkoff_API extends Woodev_API_Base {
	
	protected $gateway;
	
	public function __construct( $gateway ) {
		
		$this->set_request_content_type_header( 'application/json' );
		$this->set_request_accept_header( 'application/json' );
		$this->set_response_handler( 'WC_Tinkoff_API_Response' );
		$this->set_request_header( 'integrationType', 'woodev' );
		
		$this->gateway = $gateway;
		
		$this->request_uri = $this->gateway::URL_ENDPOINT;
	}
	
	public function create( $order ) {
		
		$request = $this->get_new_request();
		
		$request->create( $this->get_order_params( $order ), $this->gateway->is_production_environment() );
		
		return $response = $this->perform_request( $request );
	}
	
	private function get_order_params( WC_Order $order ) {
		
		$params = array(
			'shopId'			=> $this->gateway->get_shop_id(),
			'showcaseId'		=> $this->gateway->get_showcase_id(),
			'sum'				=> $order->payment_total,
			'items'				=> array(),
			'integrationType' 	=> 'woodev',
			'orderNumber'		=> $order->get_order_number(),
			'failURL'			=> esc_url_raw( $order->get_checkout_payment_url() ), // URL для возврата в случае неуспешного завершения заявки, если не указан то будет использован URL из настроек магазина
			'successURL'		=> esc_url_raw( $order->get_checkout_order_received_url() ), // URL для возврата в случае успешного завершения заявки, если не указан то будет использован URL из настроек магазина
			'returnURL'			=> esc_url_raw( $order->get_cancel_order_url_raw() ), // URL для возврата в случае отмены заявки клиентом, если не указан то будет использован URL из настроек магазина
			'webhookURL'		=> $this->gateway->get_transaction_response_handler_url(), // URL для отправки вебхуков, если не указан, то будет использован URL из настроек магазина
			'values'			=> array(
				'contact'	=> array(
					'fio'	=> array(
						'lastName'	=> $order->get_billing_first_name(),
						'firstName'	=> $order->get_billing_last_name()
					),
					'mobilePhone'	=> wc_sanitize_phone_number( $order->get_billing_phone() ),
					'email'			=> $order->get_billing_email()
				)
			)
		);
		
		if( $promo_code = Woodev_Helper::get_post( $this->gateway->get_order_meta_prefix() . 'promo_code' ) ) {
			$this->gateway->update_order_meta( $order, 'promo_code', $promo_code );
			$params['promoCode'] = $this->gateway->get_order_meta( $order, 'promo_code' ); // Идентификатор кредитного продукта(кредит/рассрочка)
		}
		
		if( ! $this->gateway->is_production_environment() ) {
			
			$demo_flow = Woodev_Helper::get_post( $this->gateway->get_order_meta_prefix() . 'demo_flow' );
			$initial_stage = Woodev_Helper::get_post( $this->gateway->get_order_meta_prefix() . 'initial_stage' );
			
			if( $demo_flow ) {
				$params['demoFlow'] = $demo_flow;
			}
			
			if( $initial_stage ) {
				$params['initialStage'] = $initial_stage;
			}
		}
		
		$order_items = Woodev_Helper::get_order_line_items( $order );
		
		$item_index = 0;
		
		foreach( $order_items as $item ) {
			
			$params['items'][ $item_index ] = array(
				'name'			=> $item->name,
				'quantity'		=> $item->quantity,
				'price'			=> wc_format_decimal( $item->item_total, wc_get_price_decimals() )
			);
			
			if( $item->product->get_sku() ) {
				$params['items'][ $item_index ][ 'vendorCode' ] = $item->product->get_sku();
			}
			
			$item_index++;
		}
		
		foreach ( $order->get_shipping_methods() as $shipping_item ) {
			
			if( $shipping_item->get_total() > 0 ) {
				
				$params['items'][ $item_index ] = array(
					'name'			=> sprintf( 'Доставка: %s', $shipping_item->get_name() ),
					'quantity'		=> 1,
					'price'			=> wc_format_decimal( $shipping_item->get_total(), wc_get_price_decimals() )
				);
			}
			
			$item_index++;
		}
		
		if ( 0 < $order->get_total_fees() ) {
			
			foreach( $order->get_fees() as $item_fee ) {
				
				$params['items'][ $item_index ] = array(
					'name'			=> $item_fee->get_name(),
					'quantity'		=> 1,
					'price'			=> wc_format_decimal( $item_fee->get_total(), wc_get_price_decimals() )
				);
				
				$item_index++;
			}
			
		}
		
		if ( wc_tax_enabled() ) {
			foreach ( $order->get_tax_totals() as $tax_total ) {
				
				$params['items'][ $item_index ] = array(
					'name'			=> esc_html( $tax_total->label ),
					'quantity'		=> 1,
					'price'			=> wc_format_decimal( $tax_total->amount, wc_get_price_decimals() )
				);
				
				$item_index++;
			}
		}
		
		if ( 0 < $order->get_total_fees() ) {
			
			$params['items'][ $item_index ] = array(
				'name'			=> esc_html_e( 'Fees:', 'woocommerce' ),
				'quantity'		=> 1,
				'price'			=> wc_format_decimal( $order->get_total_fees(), wc_get_price_decimals() )
			);
			
			$item_index++;
		}
		
		return apply_filters( 'wc_tinkoff_api_create_request_params', $params, $order, $this->gateway );
	}
	
	protected function do_post_parse_response_validation() {
		$response 		= $this->get_response();
		$errors   		= $response->get_errors();
		$validations 	= $response->get_validations();
		
		if( $validations ) {
			//$errors[] = $validations;
		}
		
		//Если в момент запроса будет какая то ошибка то отбрасываем её в Throw
		if ( $errors ) {
			
			throw new Woodev_API_Exception( Woodev_Helper::list_array_items( $errors ) );
		}
	}
	
	protected function get_new_request( $args = array() ) {
		return new WC_Tinkoff_API_Request();
	}
	
	protected function get_plugin() {
		return wc_tinkoff_kredit();
	}
}