<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_API_XML_Response' ) ) :

abstract class Woodev_API_XML_Response implements Woodev_API_Response {

	protected $raw_response_xml;
	
	protected $response_xml;
	
	protected $response_data;

	public function __construct( $raw_response_xml ) {

		$this->raw_response_xml = $raw_response_xml;
		$this->response_xml = new SimpleXMLElement( $raw_response_xml, LIBXML_NOCDATA );
		$this->response_data = json_decode( json_encode( $this->response_xml ) );
	}
	
	public function __get( $key ) {

		if ( ! isset( $this->response_data->$key ) ) {
			return null;
		}

		$array = (array) $this->response_data->$key;

		if ( empty( $array ) ) {
			return null;
		}

		return $this->response_data->$key;
	}
	
	public function to_string() {

		$response = $this->raw_response_xml;

		$dom = new DOMDocument();
		
		if ( @$dom->loadXML( $response ) ) {
			$dom->formatOutput = true;
			$response = $dom->saveXML();
		}

		return $response;
	}
	
	public function to_string_safe() {
		return $this->to_string();
	}


}

endif;
