<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_block_update' ) ){
	function flat_pm_block_update( $method, $meta ){
		$origin = ( isset( $meta['origin'] ) && !empty( $meta['origin'] ) ) ? $meta['origin'] : 'ajax';
		$block_id = ( isset( $meta['id'] ) && !empty( $meta['id'] ) ) ? $meta['id'] : false;
		$order = ( isset( $meta['order'] ) && !empty( $meta['order'] ) ) ? $meta['order'] : false;

		if( $block_id ){

			$action = 'update';

			$args = array(
				'ID'          => (int) $block_id,
				'post_title'  => $meta['name'],
				'post_status' => 'publish',
				'post_type'   => 'flat_pm_block'
			);

			$block_id = wp_update_post( $args );

		}else{

			$action = 'insert';

			$args = array(
				'post_title'  => $meta['name'],
				'post_status' => 'publish',
				'post_type'   => 'flat_pm_block'
			);

			$block_id = wp_insert_post( $args );

			if( $block_id !== 0 && isset( $meta['folder_id'] ) && !empty( $meta['folder_id'] ) ){
				wp_set_object_terms( $block_id, (int) $meta['folder_id'], 'flat_pm_block_folders', false );
			}

		}

		if( $block_id === 0 ){
			if( $origin === 'ajax' ){
				die( json_encode( array(
					'method' => $method,
					'data' => array(
						'message' => '<i class="material-icons">report_problem</i> ' . __( 'Something went wrong...', 'flatpm_l10n' ),
						'status' => 'error'
					)
				) ) );
			}

			return false;
		}

		$meta['id'] = $block_id;

		$allow_options = array(
			'id',
			'turned',
			'name',
			'fast',
			'lazy',
			'abgroup',
			'order',
			'html',
			'view',
			'content',
			'user'
		);

		if( ! flat_do_some() ){
			$meta['user']['geo']['enabled']      = 'false';
			$meta['user']['isp']['enabled']      = 'false';
			$meta['user']['schedule']['enabled'] = 'false';
			$meta['user']['role']['enabled']     = 'false';
			$meta['user']['ip']['enabled']       = 'false';
		}

		foreach( $allow_options as $key ){
			if( ! isset( $meta[$key] ) ) continue;

			update_post_meta( $block_id, $key, $meta[$key] );
		}

		if( ! $order ){
			$blocks_args = array(
				'posts_per_page' => -1,
				'post_type'      => 'flat_pm_block',
				'no_found_rows'  => true,
				'post_status'    => 'publish',
				'fields'         => 'ids'
			);

			$blocks_query = new WP_Query;
			$blocks = $blocks_query->query( $blocks_args );
			$order = count( $blocks ) + 1;

			update_post_meta( $block_id, 'order', $order );
		}

		flat_pm_clear_all_cache();

		if( $origin === 'ajax' ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">check</i> ' . __( 'Settings updated', 'flatpm_l10n' ),
					'status' => 'success',
					'id' => $block_id,
					'action' => $action
				)
			) ) );
		}

		return true;
	}
}