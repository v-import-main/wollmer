<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! interface_exists( 'Woodev_Payment_Gateway_API_Get_Tokenized_Payment_Methods_Response' ) ) :


interface Woodev_Payment_Gateway_API_Get_Tokenized_Payment_Methods_Response extends Woodev_Payment_Gateway_API_Response {

	public function get_payment_tokens();
}

endif; 