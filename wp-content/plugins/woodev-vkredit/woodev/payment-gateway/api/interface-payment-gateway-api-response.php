<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! interface_exists( 'Woodev_Payment_Gateway_API_Response' ) ) :

interface Woodev_Payment_Gateway_API_Response extends Woodev_API_Response {

	public function transaction_approved();
	
	public function transaction_held();
	
	public function get_status_message();
	
	public function get_status_code();
	
	public function get_transaction_id();
	
	public function get_user_message();
}

endif;