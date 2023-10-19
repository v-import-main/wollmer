<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_REST_API' ) ) :

class Woodev_REST_API {
	
	private $plugin;
	
	public function __construct( Woodev_Plugin $plugin ) {

		$this->plugin = $plugin;

		$this->add_hooks();
	}
	
	protected function add_hooks() {
		add_filter( 'woocommerce_rest_prepare_system_status', array( $this, 'add_system_status_data' ), 10, 3 );
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}
	
	public function add_system_status_data( $response, $system_status, $request ) {
		
		$data = array(
			'is_payment_gateway' => $this->get_plugin() instanceof Woodev_Payment_Gateway_Plugin
		);

		$data = array_merge( $data, $this->get_system_status_data() );
		
		$data = apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_rest_api_system_status_data', $data, $response, $request );

		$response->data[ 'wc_' . $this->get_plugin()->get_id() ] = $data;

		return $response;
	}
	
	protected function get_system_status_data() {

		return array();
	}
	
	public function register_routes() {

		if ( $settings = $this->get_plugin()->get_settings_handler() ) {

			$settings_controller = new Woodev_REST_API_Settings( $settings );

			$settings_controller->register_routes();
		}
	}
	
	protected function get_plugin() {

		return $this->plugin;
	}
}


endif;
