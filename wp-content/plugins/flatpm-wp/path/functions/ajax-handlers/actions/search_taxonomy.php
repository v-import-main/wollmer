<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_search_taxonomy' ) ){
	function flat_pm_search_taxonomy( $method, $meta ){
		$list = explode( PHP_EOL, $meta['query'] );

		$output = array();
		$flat_tax = array();

		if( empty( $list ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'Search query is empty', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		$tax_transient = get_transient( 'tax_transient' );

		if( empty( $tax_transient ) ){
			$args = array(
				'public' => true
			);

			$post_types = array_diff( array_values( get_post_types( $args, 'names', 'and' ) ), array( 'flat_pm_block','attachment' ) );

			$terms_flat = get_terms( array(
				'taxonomy'   => get_object_taxonomies( $post_types ),
				'orderby'    => 'none',
				'hide_empty' => false,
			) );

			foreach( $terms_flat as $term ){
				$taxonomy = get_taxonomy( $term->taxonomy );

				$flat_tax []= array(
					'id'    => strval( $term->term_id ),
					'type'  => $term->taxonomy,
					'label' => $taxonomy->labels->singular_name,
					'title' => $term->name
				);
			}

			set_transient( 'tax_transient', $flat_tax, 60 * 30 );
		}else{
			$flat_tax = $tax_transient;
		}

		foreach( $flat_tax as $tax ){
			foreach( $list as $value ){
				if( is_numeric( $value ) && $tax['id'] == $value ){
					$output []= $tax;
					continue;
				}

				if(
					mb_strlen( $value ) >= 4 &&
					(
						strpos( mb_strtolower( $tax['title'] ), mb_strtolower( $value ) ) !== false ||
						strpos( mb_strtolower( $tax['type'] ), mb_strtolower( $value ) ) !== false
					)
				){
					$output []= $tax;
					continue;
				}
			} unset( $value );
		} unset( $tax );

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