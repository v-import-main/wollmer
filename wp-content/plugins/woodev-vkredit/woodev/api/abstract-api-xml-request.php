<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_API_XML_Request' ) ) :


abstract class Woodev_API_XML_Request implements Woodev_API_Request {

	protected $request_data;
	
	protected $root_element;
	
	protected $xml;
	
	protected $request_xml;
	
	public function get_method() {}
	
	public function get_path() {
		return '';
	}
	
	protected function to_xml() {

		if ( ! empty( $this->request_xml ) ) {
			return $this->request_xml;
		}

		$this->xml = new XMLWriter();
		
		$this->xml->openMemory();
		
		$this->xml->startDocument( '1.0', 'UTF-8' );

		$request_data = $this->get_request_data();

		Woodev_Helper::array_to_xml( $this->xml, $this->get_root_element(), $request_data[ $this->get_root_element() ] );

		$this->xml->endDocument();

		return $this->request_xml = $this->xml->outputMemory();
	}
	
	public function get_request_data() {
		return $this->request_data;
	}
	
	public function to_string() {
		return $this->to_xml();
	}
	
	public function to_string_safe() {
		return $this->prettify_xml( $this->to_string() );
	}
	
	public function prettify_xml( $xml_string ) {

		$dom = new DOMDocument();
		
		if ( @$dom->loadXML( $xml_string ) ) {
			$dom->formatOutput = true;
			$xml_string = $dom->saveXML();
		}

		return $xml_string;
	}
	
	abstract protected function get_root_element();
}

endif;
