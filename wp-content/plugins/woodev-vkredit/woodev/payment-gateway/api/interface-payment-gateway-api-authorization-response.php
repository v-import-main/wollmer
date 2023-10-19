<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! interface_exists( 'Woodev_Payment_Gateway_API_Authorization_Response' ) ) :

interface Woodev_Payment_Gateway_API_Authorization_Response extends Woodev_Payment_Gateway_API_Response {

	public function get_authorization_code();
	
	public function get_avs_result();
	
	public function get_csc_result();
	
	public function csc_match();
}

endif;