<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_block_activate' ) ){
	function flat_pm_block_activate( $method, $meta ){
		foreach ( $meta['ids'] as $id ) {
			update_post_meta( (int) $id, 'turned', (string) $meta['action'] );
		} unset( $value );

		flat_pm_clear_all_cache();

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'status' => 'success',
				'ids' => $meta['ids']
			)
		) ) );
	}
}