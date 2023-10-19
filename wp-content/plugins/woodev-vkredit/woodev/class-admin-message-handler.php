<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Admin_Message_Handler' ) ) :


class Woodev_Admin_Message_Handler {

	const MESSAGE_TRANSIENT_PREFIX = '_wp_admin_message_';

	const MESSAGE_ID_GET_NAME = 'wdamhid';

	private $message_id;

	private $messages = array();

	private $errors = array();
	
	private $warnings = array();
	
	private $infos = array();

	public function __construct( $message_id = null ) {

		$this->message_id = $message_id;

		$this->load_messages();

		add_filter( 'wp_redirect', array( $this, 'redirect' ), 1, 2 );
	}
	
	public function set_messages() {
	
		if ( $this->message_count() > 0 || $this->info_count() > 0 || $this->warning_count() > 0 || $this->error_count() > 0 ) {

			set_transient(
				self::MESSAGE_TRANSIENT_PREFIX . $this->get_message_id(),
				array(
					'errors'   => $this->errors,
					'warnings' => $this->warnings,
					'infos'    => $this->infos,
					'messages' => $this->messages,
				),
				60 * 60
			);

			return true;
		}

		return false;
	}
	
	public function load_messages() {

		if ( isset( $_GET[ self::MESSAGE_ID_GET_NAME ] ) && $this->get_message_id() == $_GET[ self::MESSAGE_ID_GET_NAME ] ) {

			$memo = get_transient( self::MESSAGE_TRANSIENT_PREFIX . $_GET[ self::MESSAGE_ID_GET_NAME ] );

			if ( isset( $memo['errors'] ) )   $this->errors   = $memo['errors'];
			if ( isset( $memo['warnings'] ) ) $this->warnings = $memo['warnings'];
			if ( isset( $memo['infos'] ) )    $this->infos    = $memo['infos'];
			if ( isset( $memo['messages'] ) ) $this->messages = $memo['messages'];

			$this->clear_messages( $_GET[ self::MESSAGE_ID_GET_NAME ] );
		}
	}
	
	public function clear_messages( $id ) {
		delete_transient( self::MESSAGE_TRANSIENT_PREFIX . $id );
	}
	
	public function add_error( $error ) {
		$this->errors[] = $error;
	}
	
	public function add_message( $message ) {
		$this->messages[] = $message;
	}
	
	public function add_warning( $message ) {
		$this->warnings[] = $message;
	}
	
	public function add_info( $message ) {
		$this->infos[] = $message;
	}
	
	public function error_count() {
		return sizeof( $this->errors );
	}
	
	public function message_count() {
		return sizeof( $this->messages );
	}
	
	public function warning_count() {
		return sizeof( $this->warnings );
	}
	
	public function info_count() {
		return sizeof( $this->infos );
	}
	
	public function get_errors() {
		return $this->errors;
	}
	
	public function get_error( $index ) {
		return isset( $this->errors[ $index ] ) ? $this->errors[ $index ] : '';
	}
	
	public function get_warnings() {
		return $this->warnings;
	}
	
	public function get_warning( $index ) {
		return isset( $this->warnings[ $index ] ) ? $this->warnings[ $index ] : '';
	}
	
	public function get_messages() {
		return $this->messages;
	}
	
	public function get_message( $index ) {
		return isset( $this->messages[ $index ] ) ? $this->messages[ $index ] : '';
	}
	
	public function get_infos() {
		return $this->infos;
	}
	
	public function get_info( $index ) {
		return isset( $this->infos[ $index ] ) ? $this->infos[ $index ] : '';
	}
	
	public function show_messages( $params = array() ) {

		$params = wp_parse_args( $params, array(
			'capabilities' => array(
				'manage_woocommerce',
			),
		) );

		$check_user_capabilities = array();
		
		foreach ( $params['capabilities'] as $capability ) {
			$check_user_capabilities[] = current_user_can( $capability );
		}
		
		if ( ! in_array( true, $check_user_capabilities, true ) ) {
			return;
		}

		$output = '';

		if ( $this->error_count() > 0 ) {
			$output .= '<div id="wp-admin-message-handler-error" class="notice-error notice inline"><ul><li><strong>' . implode( '</strong></li><li><strong>', $this->get_errors() ) . '</strong></li></ul></div>';
		}

		if ( $this->warning_count() > 0 ) {
			$output .= '<div id="wp-admin-message-handler-warning"  class="notice-warning notice inline"><ul><li><strong>' . implode( '</strong></li><li><strong>', $this->get_warnings() ) . '</strong></li></ul></div>';
		}

		if ( $this->info_count() > 0 ) {
			$output .= '<div id="wp-admin-message-handler-info"  class="notice-info notice inline"><ul><li><strong>' . implode( '</strong></li><li><strong>', $this->get_infos() ) . '</strong></li></ul></div>';
		}

		if ( $this->message_count() > 0 ) {
			$output .= '<div id="wp-admin-message-handler-message"  class="notice-success notice inline"><ul><li><strong>' . implode( '</strong></li><li><strong>', $this->get_messages() ) . '</strong></li></ul></div>';
		}

		echo wp_kses_post( $output );
	}
	
	public function redirect( $location, $status ) {
	
		if ( $this->set_messages() ) {
			$location = add_query_arg( self::MESSAGE_ID_GET_NAME, $this->get_message_id(), $location );
		}

		return $location;
	}
	
	protected function get_message_id() {

		if ( ! isset( $this->message_id ) ) $this->message_id = __FILE__;

		return wp_create_nonce( $this->message_id );

	}


}

endif;
