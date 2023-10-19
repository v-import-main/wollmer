<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_folder_rename' ) ){
	function flat_pm_folder_rename( $method, $meta ){
		$folder_id = (int) $meta['id'];
		$name = $meta['name'];

		if( empty( $folder_id ) || empty( $name ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'ID or name is missing', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		update_term_meta( $folder_id, 'name', $name );

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => '<i class="material-icons">check</i> ' . __( 'Folder name updated', 'flatpm_l10n' ),
				'status' => 'success',
				'id' => $folder_id,
				'name' => $name
			)
		) ) );
	}
}