<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! interface_exists( 'Woodev_Payment_Gateway_API_Create_Payment_Token_Response' ) ) :

interface Woodev_Payment_Gateway_API_Create_Payment_Token_Response extends Woodev_Payment_Gateway_API_Response {
	
	public function get_payment_token();
}

endif;