<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_shortcode_post_id' ) ){
	function flat_pm_shortcode_post_id(){
		$output = get_queried_object()->ID;
		return $output;
	}
}

if( !function_exists( 'flat_pm_shortcode_post_type' ) ){
	function flat_pm_shortcode_post_type(){
		$output = get_queried_object()->post_type;
		return $output;
	}
}

if( !function_exists( 'flat_pm_shortcode_post_date' ) ){
	function flat_pm_shortcode_post_date(){
		$output = explode( ' ', get_queried_object()->post_date );
		return $output[0];
	}
}

if( !function_exists( 'flat_pm_shortcode_post_time' ) ){
	function flat_pm_shortcode_post_time(){
		$output = explode( ' ', get_queried_object()->post_date );
		return $output[1];
	}
}

if( !function_exists( 'flat_pm_shortcode_post_modified' ) ){
	function flat_pm_shortcode_post_modified(){
		$output = explode( ' ', get_queried_object()->post_modified );
		return $output[0];
	}
}

if( !function_exists( 'flat_pm_shortcode_post_slug' ) ){
	function flat_pm_shortcode_post_slug(){
		$output = get_queried_object()->post_name;
		return $output;
	}
}

if( !function_exists( 'flat_pm_shortcode_post_title' ) ){
	function flat_pm_shortcode_post_title(){
		$output = get_queried_object()->post_title;
		return $output;
	}
}

if( !function_exists( 'flat_pm_shortcode_url' ) ){
	function flat_pm_shortcode_url(){
		$output = sanitize_text_field( $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		return $output;
	}
}

if( !function_exists( 'flat_pm_shortcode_title' ) ){
	function flat_pm_shortcode_title(){
		$output = wp_title( ' - ', false );
		return $output;
	}
}

if( !function_exists( 'flat_pm_shortcode_description' ) ){
	function flat_pm_shortcode_description(){
		$output = '';
		if( is_singular() ){
			$id = get_queried_object()->ID;
			$_aioseop_title = get_post_meta( $id, '_aioseop_title', true );
			$_yoast_wpseo_metadesc = get_post_meta( $id, '_yoast_wpseo_metadesc', true );
			$rank_math_description = get_post_meta( $id, 'rank_math_description', true );

			if( $_aioseop_title ){
				$output = $_aioseop_title;
			}

			if( $_yoast_wpseo_metadesc ){
				$output = $_yoast_wpseo_metadesc;
			}

			if( $rank_math_description ){
				$output = $rank_math_description;
			}
		}else{
			$id = get_queried_object()->term_id;
			if( class_exists( 'WPSEO_Frontend' ) ){
				$wpseo_object = WPSEO_Frontend::get_instance();
				$output = sanitize_text_field( $wpseo_object->metadesc( false ) );
			}
		}
		return $output;
	}
}

if( !function_exists( 'flat_pm_shortcode_term_id' ) ){
	function flat_pm_shortcode_term_id(){
		if( is_singular() && !is_front_page() ){
			$taxonomy_names = get_object_taxonomies( get_queried_object()->post_type );
			if( $taxonomy_names ){
				foreach( $taxonomy_names as $taxonomy_name ){
					$term = get_the_terms( get_queried_object()->ID, $taxonomy_name );
					if( $term )
						break;
				}
			}
			$output = $term[0]->term_id;
			return $output;
		}else{
			$output = get_queried_object()->term_id;
			return $output;
		}
	}
}

if( !function_exists( 'flat_pm_shortcode_term_name' ) ){
	function flat_pm_shortcode_term_name(){
		if( is_singular() && !is_front_page() ){
			$taxonomy_names = get_object_taxonomies( get_queried_object()->post_type );
			if( $taxonomy_names ){
				foreach( $taxonomy_names as $taxonomy_name ){
					$term = get_the_terms( get_queried_object()->ID, $taxonomy_name );
					if( $term )
						break;
				}
			}
			$output = $term[0]->name;
			return $output;
		}else{
			$output = get_queried_object()->name;
			return $output;
		}
	}
}

if( !function_exists( 'flat_pm_shortcode_term_slug' ) ){
	function flat_pm_shortcode_term_slug(){
		if( is_singular() && !is_front_page() ){
			$taxonomy_names = get_object_taxonomies( get_queried_object()->post_type );
			if( $taxonomy_names ){
				foreach( $taxonomy_names as $taxonomy_name ){
					$term = get_the_terms( get_queried_object()->ID, $taxonomy_name );
					if( $term )
						break;
				}
			}
			$output = $term[0]->slug;
			return $output;
		}else{
			$output = get_queried_object()->slug;
			return $output;
		}
	}
}

if( !function_exists( 'flat_pm_shortcode_block_id' ) ){
	function flat_pm_shortcode_block_id(){
		global $fpm_block_id;

		return $fpm_block_id;
	}
}

// !--sub_functions



add_shortcode( 'fpm_post_id',       'flat_pm_shortcode_post_id' );
add_shortcode( 'fpm_post_type',     'flat_pm_shortcode_post_type' );
add_shortcode( 'fpm_post_date',     'flat_pm_shortcode_post_date' );
add_shortcode( 'fpm_post_time',     'flat_pm_shortcode_post_time' );
add_shortcode( 'fpm_post_modified', 'flat_pm_shortcode_post_modified' );
add_shortcode( 'fpm_post_slug',     'flat_pm_shortcode_post_slug' );
add_shortcode( 'fpm_post_title',    'flat_pm_shortcode_post_title' );

add_shortcode( 'fpm_url',           'flat_pm_shortcode_url' );
add_shortcode( 'fpm_title',         'flat_pm_shortcode_title' );
add_shortcode( 'fpm_description',   'flat_pm_shortcode_description' );

add_shortcode( 'fpm_term_id',       'flat_pm_shortcode_term_id' );
add_shortcode( 'fpm_term_name',     'flat_pm_shortcode_term_name' );
add_shortcode( 'fpm_term_slug',     'flat_pm_shortcode_term_slug' );

add_shortcode( 'fpm_block_id',      'flat_pm_shortcode_block_id' );
?>