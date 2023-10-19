<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! interface_exists( 'Woodev_Payment_Gateway_API_Payment_Notification_Response' ) ) :

interface Woodev_Payment_Gateway_API_Payment_Notification_Response extends Woodev_Payment_Gateway_API_Response {

	public function get_order_id();
	
	public function get_order();
	
	public function transaction_cancelled();
	
	public function get_payment_type();
	
	public function get_account_number();
}

endif;