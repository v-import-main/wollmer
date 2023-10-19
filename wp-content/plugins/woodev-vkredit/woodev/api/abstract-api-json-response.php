<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_API_JSON_Response' ) ) :


abstract class Woodev_API_JSON_Response implements Woodev_API_Response {

	protected $raw_response_json;
	
	public $response_data;
	
	public function __construct( $raw_response_json ) {
		$this->raw_response_json = $raw_response_json;
		$this->response_data = json_decode( $raw_response_json );
	}
	
	public function __get( $name ) {
		return isset( $this->response_data->$name ) ? $this->response_data->$name : null;
	}
	
	public function to_string() {
		return $this->raw_response_json;
	}
	
	public function to_string_safe() {
		return $this->to_string();
	}


}

endif;
