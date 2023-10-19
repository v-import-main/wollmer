<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_block_copy' ) ){
	function flat_pm_block_copy( $method, $meta ){
		$ids = $meta['ids'];
		$output = array();

		if( empty( $ids ) || ! is_array( $ids ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'Please select at least one block to copy', 'flatpm_l10n' ),
					'status' => 'error',
				)
			) ) );
		}

		foreach( $ids as $id ){
			$post = get_post( $id );

			if ( ! isset( $post ) || $post == null ){
				die( json_encode( array(
					'method' => $method,
					'data' => array(
						'message' => '<i class="material-icons">report_problem</i> ' . __( 'Can`t find the block', 'flatpm_l10n' ),
						'status' => 'error',
					)
				) ) );
			}

			$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => $post->post_status,
				'post_title'     => $post->post_title . ' ' . __( '(copy)', 'flatpm_l10n' ),
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);

			$new_post_id = wp_insert_post( $args );

			if( $new_post_id == 0 || is_wp_error( $new_post_id ) ){
				die( json_encode( array(
					'method' => $method,
					'data' => array(
						'message' => '<i class="material-icons">report_problem</i> ' . __( 'Something went wrong', 'flatpm_l10n' ),
						'status' => 'error',
					)
				) ) );
			}

			$output []= array(
				'old'  => $id,
				'new'  => $new_post_id,
				'name' => $args['post_title']
			);

			$post_terms = wp_get_object_terms( $id, 'flat_pm_block_folders', array( 'fields' => 'slugs' ) );
			wp_set_object_terms( $new_post_id, $post_terms, 'flat_pm_block_folders', false );

			$post_meta = get_post_meta( $id );
			if( $post_meta ){

				foreach( $post_meta as $meta_key => $meta_values ){

					if( '_wp_old_slug' == $meta_key ){
						continue;
					}

					foreach( $meta_values as $meta_value ){
						$data = @unserialize( $meta_value );

						if( $data !== false ){
							$meta_value = $data;
						}

						add_post_meta( (int) $new_post_id, $meta_key, $meta_value );
					}
				}
			}

			update_post_meta( (int) $new_post_id, 'name', $args['post_title'] );

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

			update_post_meta( (int) $new_post_id, 'order', $order );
		}

		flat_pm_clear_all_cache();

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => '<i class="material-icons">check</i> ' . __( 'Block has been copied', 'flatpm_l10n' ),
				'status' => 'success',
				'output' => $output,
			)
		) ) );
	}
}