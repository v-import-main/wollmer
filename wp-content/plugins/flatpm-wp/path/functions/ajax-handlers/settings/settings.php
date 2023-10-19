<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_settings_update' ) ){
	function flat_pm_settings_update( $method, $meta ){

		$allow_options = array(
			'flat_pm_advanced',
			'flat_pm_main',
			'flat_pm_pagespeed',
			'flat_pm_stylization',
			'flat_pm_personalization',
		);

		foreach( $allow_options as $key ){
			update_option( $key, $meta[$key] );
		}

		flat_pm_clear_all_cache();

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => '<i class="material-icons">check</i> ' . __( 'Settings updated', 'flatpm_l10n' ),
				'status' => 'success'
			)
		) ) );
	}
}