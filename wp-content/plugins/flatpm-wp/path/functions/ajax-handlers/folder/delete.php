<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_folder_delete' ) ){
	function flat_pm_folder_delete( $method, $meta ){
		$ids = $meta['ids'];

		if( empty( $ids ) || ! is_array( $ids ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'ID is missing', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		foreach( $ids as $id ){
			wp_delete_term( (int) $id, 'flat_pm_block_folders', array( 'force_default' => true ) );
		}

		flat_pm_clear_all_cache();

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => '<i class="material-icons">check</i> ' . __( 'Folder deleted', 'flatpm_l10n' ),
				'status' => 'success',
				'ids' => $ids
			)
		) ) );
	}
}