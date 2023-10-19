<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Payment_Gateway_REST_API' ) ) :

class Woodev_Payment_Gateway_REST_API extends Woodev_REST_API {
	
	public function get_system_status_data() {

		$data = parent::get_system_status_data();

		$data['gateways'] = array();

		foreach ( $this->get_plugin()->get_gateways() as $gateway ) {

			if ( $gateway->debug_log() && $gateway->debug_checkout() ) {
				$debug_mode = 'both';
			} elseif ( $gateway->debug_log() || $gateway->debug_checkout() ) {
				$debug_mode = $gateway->debug_log() ? 'log' : 'checkout';
			} else {
				$debug_mode = false;
			}

			$gateway_data = array(
				'is_enabled'              => $gateway->is_enabled(),
				'is_available'            => $gateway->is_available(),
				'environment'             => $gateway->is_test_environment() ? 'sandbox' : 'production',
				'debug_mode'              => $debug_mode,
				'supports_tokenization'   => $gateway->supports_tokenization(),
				'is_tokenization_enabled' => $gateway->supports_tokenization() ? (bool) $gateway->tokenization_enabled() : null,
			);

			$gateway_data = apply_filters( 'wc_' . $gateway->get_id() . '_rest_api_system_status_data', $gateway_data );

			$data['gateways'][ $gateway->get_id() ] = $gateway_data;
		}

		return $data;
	}
}


endif;