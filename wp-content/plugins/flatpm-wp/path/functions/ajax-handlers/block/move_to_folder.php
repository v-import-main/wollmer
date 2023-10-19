<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_move_to_folder' ) ){
	function flat_pm_move_to_folder( $method, $meta ){
		$folder = (int) $meta['folder'];
		$ids = $meta['ids'];

		if( empty( $ids ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'Please select at least one block to transfer', 'flatpm_l10n' ),
					'status' => 'error',
				)
			) ) );
		}

		$args = ( $folder !== 'all' ) ? array( $folder ) : NULL;

		foreach( $ids as $id ){
			wp_set_object_terms( $id, $args, 'flat_pm_block_folders', false );
		}

		flat_pm_clear_all_cache();

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => '<i class="material-icons">check</i> ' . __( 'Blocks have been moved to the folder', 'flatpm_l10n' ),
				'status' => 'success',
				'ids' => $ids,
				'folder' => $folder
			)
		) ) );
	}
}