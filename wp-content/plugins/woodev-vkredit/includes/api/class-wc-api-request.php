<?php

defined( 'ABSPATH' ) or exit;

class WC_Tinkoff_API_Request extends Woodev_API_JSON_Request {
	
	public function create( $params = array(), $is_production = false ) {
		
		$this->method = 'POST';
		
		if( $is_production ) {
			$this->path = '/create';
		} else {
			$this->path = '/create-demo';
		}
		
		$this->params = $params;
	}
	
	public function get_path() {

		$path   = $this->path;
		$params = $this->get_params();

		if ( 'GET' === $this->get_method() && ! empty( $params ) ) {

			$path .= '?' . http_build_query( $this->get_params(), '', '&' );
		}

		return $path;
	}
	
	public function to_string() {

		if ( 'GET' === $this->get_method() ) {
			return array();
		} elseif( in_array( $this->get_method(), array( 'POST', 'PUT', 'DELETE' ) ) ) {
			return wp_json_encode( $this->get_params() );
		} else {
			return http_build_query( $this->get_params() );
		}
	}
}