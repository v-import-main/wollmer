<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_clear_all_html' ) ){
	function flat_pm_clear_all_html( $method, $meta ){

		$args = array(
			'posts_per_page' => -1,
			'post_type'      => 'flat_pm_block',
			'post_status'    => 'publish',
			'fields'         => 'ids'
		);

		$query = new WP_Query;
		$ids = $query->query( $args );

		if( is_array( $ids ) && ! empty( $ids ) ){
			foreach( $ids as $id ){
				$html = get_post_meta( $id, 'html', true );
				foreach( $html['block'] as $key => $value ){
					$html['block'][ $key ]['html']['code'] = '';
					$html['block'][ $key ]['adb']['code'] = '';
				}
				update_post_meta( $id, 'html', $html );
			}

			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">check</i> ' . __( 'HTML cleaned up', 'flatpm_l10n' ),
					'status' => 'success'
				)
			) ) );
		}

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => '<i class="material-icons">report_problem</i> ' . __( 'Something went wrong', 'flatpm_l10n' ),
				'status' => 'error'
			)
		) ) );
	}
}