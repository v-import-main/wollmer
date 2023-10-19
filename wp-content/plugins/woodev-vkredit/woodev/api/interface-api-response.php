<?php

defined( 'ABSPATH' ) or exit;

if ( ! interface_exists( 'Woodev_API_Response' ) ) :

interface Woodev_API_Response {

	public function to_string();
	
	public function to_string_safe();
}

endif;
