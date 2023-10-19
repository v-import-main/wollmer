<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_update_unfold' ) ){
	function flat_pm_update_unfold( $method, $meta ){

		$allow_options = array(
			'flat_pm_unfold',
		);

		foreach( $allow_options as $key ){
			update_option( $key, $meta[$key] );
		}


		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'status' => 'success'
			)
		) ) );
	}
}