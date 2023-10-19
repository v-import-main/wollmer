<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_block_abgroup' ) ){
	function flat_pm_block_abgroup( $method, $meta ){
		$id = $meta['id'];
		$abgroup = $meta['abgroup'];

		if( empty( $id ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'ID is missing', 'flatpm_l10n' ),
					'status' => 'error',
				)
			) ) );
		}

		update_post_meta( (int) $id, 'abgroup', $abgroup );

		flat_pm_clear_all_cache();

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => '<i class="material-icons">check</i> ' . __( 'AB group updated', 'flatpm_l10n' ),
				'status' => 'success',
			)
		) ) );
	}
}