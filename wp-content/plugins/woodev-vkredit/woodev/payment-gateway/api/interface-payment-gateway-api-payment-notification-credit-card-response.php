<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! interface_exists( 'Woodev_Payment_Gateway_API_Payment_Notification_Credit_Card_Response' ) ) :


interface Woodev_Payment_Gateway_API_Payment_Notification_Credit_Card_Response extends Woodev_Payment_Gateway_API_Payment_Notification_Response, Woodev_Payment_Gateway_API_Authorization_Response {

	public function is_authorization();
	
	public function is_charge();
	
	public function get_card_type();
	
	public function get_exp_month();
	
	public function get_exp_year();
}

endif;