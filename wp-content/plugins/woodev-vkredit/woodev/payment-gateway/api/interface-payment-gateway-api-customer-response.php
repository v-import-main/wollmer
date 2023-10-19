<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! interface_exists( 'Woodev_Payment_Gateway_API_Customer_Response' ) ) :

interface Woodev_Payment_Gateway_API_Customer_Response extends Woodev_Payment_Gateway_API_Response {
	
	public function get_customer_id();

}

endif;