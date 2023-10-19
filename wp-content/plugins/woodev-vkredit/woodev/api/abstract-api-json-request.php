<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_API_JSON_Request' ) ) :

abstract class Woodev_API_JSON_Request implements Woodev_API_Request {

	protected $method;
	
	protected $path;
	
	protected $params = array();

	public function get_method() {
		return $this->method;
	}

	public function get_path() {
		return $this->path;
	}

	public function get_params() {
		return $this->params;
	}
	
	public function to_string() {

		$params = $this->get_params();

		return ! empty( $params ) ? json_encode( $params ) : '';
	}

	public function to_string_safe() {

		return $this->to_string();
	}


}

endif;
