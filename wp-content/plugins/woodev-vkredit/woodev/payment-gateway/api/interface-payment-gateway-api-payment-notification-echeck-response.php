<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! interface_exists( 'Woodev_Payment_Gateway_API_Payment_Notification_eCheck_Response' ) ) :

interface Woodev_Payment_Gateway_API_Payment_Notification_eCheck_Response extends Woodev_Payment_Gateway_API_Payment_Notification_Response {

	public function get_account_type();
	
	public function get_check_number();
}

endif;  // interface exists check