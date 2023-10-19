<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_update_license' ) ){
	function flat_pm_update_license( $method, $meta ){

		$allow_options = array(
			'flat_pm_license',
		);

		foreach( $allow_options as $key ){
			update_option( $key, $meta[$key] );
		}


		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => '<i class="material-icons">check</i> ' . __( 'License updated!', 'flatpm_l10n' ),
				'status' => 'success'
			)
		) ) );
	}
}