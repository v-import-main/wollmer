<?php


defined( 'ABSPATH' ) or exit;

if ( ! interface_exists( 'Woodev_API_Request' ) ) :

interface Woodev_API_Request {

	public function get_method();

	public function get_path();
	
	public function to_string();
	
	public function to_string_safe();

}

endif;
