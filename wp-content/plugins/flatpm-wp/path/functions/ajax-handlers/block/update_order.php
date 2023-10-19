<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_update_order' ) ){
	function flat_pm_update_order( $method, $meta ){
		$items = $meta['items'];

		if( empty( $items ) || ! is_array( $items ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'Something went wrong...', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		foreach( $items as $item ){
			update_post_meta( $item['id'], 'order', $item['order'] );
		};

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