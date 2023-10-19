<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! interface_exists( 'Woodev_Payment_Gateway_API' ) ) :

interface Woodev_Payment_Gateway_API {

	public function credit_card_authorization( WC_Order $order );
	
	public function credit_card_charge( WC_Order $order );
	
	public function credit_card_capture( WC_Order $order );
	
	public function check_debit( WC_Order $order );
	
	public function refund( WC_Order $order );
	
	public function void( WC_Order $order );
	
	public function tokenize_payment_method( WC_Order $order );
	
	public function remove_tokenized_payment_method( $token, $customer_id );
	
	public function supports_remove_tokenized_payment_method();
	
	public function get_tokenized_payment_methods( $customer_id );
	
	public function supports_get_tokenized_payment_methods();
	
	public function get_request();
	
	public function get_response();

}

endif;