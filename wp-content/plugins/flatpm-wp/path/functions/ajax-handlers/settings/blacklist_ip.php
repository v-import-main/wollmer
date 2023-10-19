<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_blacklist_ip_update' ) ){
	function flat_pm_blacklist_ip_update( $method, $meta ){
		$file = ABSPATH . '/ip.txt';

		file_put_contents( $file, $meta['ip'] );

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => '<i class="material-icons">check</i> ' . __( 'Settings updated', 'flatpm_l10n' ),
				'status' => 'success'
			)
		) ) );
	}
}