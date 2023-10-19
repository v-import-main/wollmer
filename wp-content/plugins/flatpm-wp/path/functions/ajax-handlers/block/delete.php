<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_block_delete' ) ){
	function flat_pm_block_delete( $method, $meta ){
		if( ! isset( $meta['ids'] ) || empty( $meta['ids'] ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'status' => 'error',
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'IDs missing', 'flatpm_l10n' )
				)
			) ) );
		}

		foreach ( $meta['ids'] as $id ) {
			wp_delete_post( $id, true );
		};

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