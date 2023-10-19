<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


include_once 'ajax-handlers/actions/geo_role_ip.php';


// !--sub_functions


add_action( 'wp_ajax_flat_pm_ajax',        'ajax_hendler_flat_pm_ajax' );
add_action( 'wp_ajax_nopriv_flat_pm_ajax', 'ajax_hendler_flat_pm_ajax' );
if( !function_exists( 'ajax_hendler_flat_pm_ajax' ) ){
	function ajax_hendler_flat_pm_ajax(){
		$allow_unfiltered_html = current_user_can( 'unfiltered_html' );

		// if( ! $allow_unfiltered_html ){
		// 	$_REQUEST['data_me']['meta'] = wp_kses_post_deep( $_REQUEST['data_me']['meta'] );
		// }

		// $meta   = ! empty( $_REQUEST['data_me']['meta'] ) ? $_REQUEST['data_me']['meta'] : array();
		$meta   = ! empty( $_REQUEST['data_me']['meta'] ) ? wp_kses_post_deep( $_REQUEST['data_me']['meta'] ) : array();
		$method = $meta['method'];

		$fpm_fn = 'flat_pm_' . $method;

		$allow_methods = array(
			'flat_pm_block_geo_role_ip'
		);

		if( !in_array( $fpm_fn, $allow_methods ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'Wrong method', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		$fpm_fn( $method, $meta );
	}
}
?>