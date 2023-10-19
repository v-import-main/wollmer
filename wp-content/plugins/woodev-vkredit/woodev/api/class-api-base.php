<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_API_Base' ) ) :

abstract class Woodev_API_Base {

	protected $request_method = 'POST';

	protected $request_uri;
	
	protected $request_headers = array();
	
	protected $request_user_agent;
	
	protected $request_http_version = '1.0';
	
	protected $request_duration;
	
	protected $request;
	
	protected $response_code;
	
	protected $response_message;
	
	protected $response_headers;
	
	protected $raw_response_body;
	
	protected $response_handler;
	
	protected $response;

	protected function perform_request( $request ) {

		$this->reset_response();
		$this->request = $request;
		$start_time = microtime( true );
		
		if ( $this->require_tls_1_2() ) {
			add_action( 'http_api_curl', array( $this, 'set_tls_1_2_request' ), 10, 3 );
		}
		
		$response = $this->do_remote_request( $this->get_request_uri(), $this->get_request_args() );
		
		$this->request_duration = round( microtime( true ) - $start_time, 5 );

		try {
			
			$response = $this->handle_response( $response );

		} catch ( Woodev_Plugin_Exception $e ) {
			$this->broadcast_request();

			throw $e;
		}

		return $response;
	}
	
	protected function do_remote_request( $request_uri, $request_args ) {
		return wp_safe_remote_request( $request_uri, $request_args );
	}
	
	protected function handle_response( $response ) {
	
		if ( is_wp_error( $response ) ) {
			throw new Woodev_API_Exception( $response->get_error_message(), (int) $response->get_error_code() );
		}
		
		$this->response_code     = wp_remote_retrieve_response_code( $response );
		$this->response_message  = wp_remote_retrieve_response_message( $response );
		$this->raw_response_body = wp_remote_retrieve_body( $response );

		$response_headers = wp_remote_retrieve_headers( $response );
		
		if ( is_object( $response_headers ) ) {
			$response_headers = $response_headers->getAll();
		}

		$this->response_headers = $response_headers;
		
		$this->do_pre_parse_response_validation();
		
		$this->response = $this->get_parsed_response( $this->raw_response_body );
		
		$this->do_post_parse_response_validation();
		
		$this->broadcast_request();

		return $this->response;
	}
	
	protected function do_pre_parse_response_validation() {}
	
	protected function do_post_parse_response_validation() {}
	
	protected function get_parsed_response( $raw_response_body ) {

		$handler_class = $this->get_response_handler();

		return new $handler_class( $raw_response_body );
	}
	
	protected function broadcast_request() {

		$request_data = array(
			'method'     => $this->get_request_method(),
			'uri'        => $this->get_request_uri(),
			'user-agent' => $this->get_request_user_agent(),
			'headers'    => $this->get_sanitized_request_headers(),
			'body'       => $this->request->to_string_safe(),
			'duration'   => $this->get_request_duration() . 's', // seconds
		);

		$response_data = array(
			'code'    => $this->get_response_code(),
			'message' => $this->get_response_message(),
			'headers' => $this->get_response_headers(),
			'body'    => $this->get_sanitized_response_body() ? $this->get_sanitized_response_body() : $this->get_raw_response_body(),
		);
		
		do_action( 'woodev_' . $this->get_api_id() . '_api_request_performed', $request_data, $response_data, $this );
	}
	
	protected function reset_response() {
		$this->response_code     = null;
		$this->response_message  = null;
		$this->response_headers  = null;
		$this->raw_response_body = null;
		$this->response          = null;
		$this->request_duration  = null;
	}
	
	protected function get_request_uri() {
	
		$uri = $this->request_uri . ( $this->get_request() ? $this->get_request()->get_path() : '' );
		
		return apply_filters( 'woodev_' . $this->get_api_id() . '_api_request_uri', $uri, $this );
	}
	
	protected function get_request_args() {

		$args = array(
			'method'      => $this->get_request_method(),
			'timeout'     => MINUTE_IN_SECONDS,
			'redirection' => 0,
			'httpversion' => $this->get_request_http_version(),
			'sslverify'   => true,
			'blocking'    => true,
			'user-agent'  => $this->get_request_user_agent(),
			'headers'     => $this->get_request_headers(),
			'body'        => $this->get_request()->to_string(),
			'cookies'     => array(),
		);
		
		return apply_filters( 'woodev_' . $this->get_api_id() . '_http_request_args', $args, $this );
	}
	
	protected function get_request_method() {
		return $this->get_request() && $this->get_request()->get_method() ? $this->get_request()->get_method() : $this->request_method;
	}
	
	protected function get_request_http_version() {
		return $this->request_http_version;
	}
	
	protected function get_request_headers() {
		return $this->request_headers;
	}
	
	protected function get_sanitized_request_headers() {

		$headers = $this->get_request_headers();

		if ( ! empty( $headers['Authorization'] ) ) {
			$headers['Authorization'] = str_repeat( '*', strlen( $headers['Authorization'] ) );
		}

		return $headers;
	}
	
	protected function get_request_user_agent() {
		
		$plugin_name = $this->get_plugin()->get_plugin_name();
		$plugin_version = $this->get_plugin()->get_version();
		$wc_version = Woodev_Helper::get_wc_version();
		$wp_version = $GLOBALS['wp_version'];
		
		if( ! is_null( $wc_version ) ) {
			return sprintf( '%s/%s (WooCommerce/%s; WordPress/%s)', str_replace( ' ', '-', $plugin_name ), $plugin_version, $wc_version, $wp_version );
		}
		
		return sprintf( '%s/%s (WordPress/%s)', str_replace( ' ', '-', $plugin_name ), $plugin_version, $wp_version );
	}
	
	protected function get_request_duration() {
		return $this->request_duration;
	}
	
	protected function get_response_handler() {
		return $this->response_handler;
	}
	
	protected function get_response_code() {
		return $this->response_code;
	}
	
	protected function get_response_message() {
		return $this->response_message;
	}
	
	protected function get_response_headers() {
		return $this->response_headers;
	}
	
	protected function get_raw_response_body() {
		return $this->raw_response_body;
	}
	
	protected function get_sanitized_response_body() {
		return is_callable( array( $this->get_response(), 'to_string_safe' ) ) ? $this->get_response()->to_string_safe() : null;
	}
	
	public function get_request() {
		return $this->request;
	}
	
	public function get_response() {
		return $this->response;
	}
	
	protected function get_api_id() {

		return $this->get_plugin()->get_id();
	}
	
	abstract protected function get_new_request( $args = array() );
	
	abstract protected function get_plugin();
	
	protected function set_request_header( $name, $value ) {
		$this->request_headers[ $name ] = $value;
	}
	
	protected function set_request_headers( array $headers ) {

		foreach ( $headers as $name => $value ) {

			$this->request_headers[ $name ] = $value;
		}
	}
	
	protected function set_http_basic_auth( $username, $password ) {
		$this->request_headers['Authorization'] = sprintf( 'Basic %s', base64_encode( "{$username}:{$password}" ) );
	}
	
	protected function set_request_content_type_header( $content_type ) {
		$this->request_headers['content-type'] = $content_type;
	}
	
	protected function set_request_accept_header( $type ) {
		$this->request_headers['accept'] = $type;
	}
	
	protected function set_response_handler( $handler ) {
		$this->response_handler = $handler;
	}
	
	public function set_tls_1_2_request( $handle, $r, $url ) {

		if ( ! Woodev_Helper::str_starts_with( $url, 'https://' ) ) {
			return;
		}

		$versions     = curl_version();
		$curl_version = $versions['version'];
		list( $ssl_type, $ssl_version ) = explode( '/', $versions['ssl_version'] );

		$ssl_version = substr( $ssl_version, 0, -1 );
		
		if ( ! version_compare( $curl_version, '7.34.0', '>=' ) || ( 'OpenSSL' === $ssl_type && ! version_compare( $ssl_version, '1.0.1', '>=' ) ) ) {
			return;
		}

		curl_setopt( $handle, CURLOPT_SSLVERSION, 6 );
	}
	
	protected function require_tls_1_2() {
		return false;
	}

}

endif;
