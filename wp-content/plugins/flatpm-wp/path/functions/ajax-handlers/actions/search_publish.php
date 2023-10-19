<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_search_publish' ) ){
	function flat_pm_search_publish( $method, $meta ){
		$list       = explode( PHP_EOL, $meta['query'] );
		$post_types = $meta['post_types'];

		$output = array();
		$flat_post = array();

		if( empty( $list ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'Query is empty', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		if( empty( $post_types ) ){
			$args = array(
				'public' => true
			);

			$post_types = array_diff( array_values( get_post_types( $args, 'names', 'and' ) ), array('flat_pm_block','attachment') );
		}

		foreach( $list as $value ){
			if( is_numeric( $value ) ){
				$flat_post []= $value;
				continue;
			}

			if( filter_var( $value, FILTER_VALIDATE_URL ) !== false && mb_strlen( $value ) >= 8 ){
				$value = url_to_postid( $value );
				$flat_post []= $value;
				continue;
			}

			if( mb_strlen( $value ) >= 4 ){
				$f_posts = flat_pm_get_posts_by_title( $value, $post_types );
				if( !$f_posts )
					continue;

				foreach( $f_posts as $f_post ){
					$flat_post []= $f_post->ID;

					wp_cache_delete( $f_post->ID, 'posts' );
					wp_cache_delete( $f_post->ID, 'post_meta' );
					clean_object_term_cache( $f_post->ID, $f_post->post_type );
				} unset( $f_post );

				continue;
			}
		} unset( $value );

		$flat_post = array_unique( $flat_post );

		foreach( $flat_post as $value ){
			$f_post = get_post( $value );

			if( in_array( $f_post->post_type, $post_types ) ){
				$post_type_object = get_post_type_object( $f_post->post_type );

				$output []= array(
					'id'    => $f_post->ID,
					'type'  => $f_post->post_type,
					'label' => $post_type_object->labels->singular_name,
					'title' => $f_post->post_title
				);
			}

			wp_cache_delete( $value, 'posts' );
			wp_cache_delete( $value, 'post_meta' );
			clean_object_term_cache( $value, $f_post->post_type );
			unset( $f_post );
		} unset( $value );

		if( empty( $output ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'Nothing found', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		die( json_encode( array(
			'method' => $method,
			'data' => $output
		) ) );
	}
}