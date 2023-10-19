<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_array_merge' ) ){
	function flat_pm_array_merge( $arr ){
		$temp_arr = array();

		if( is_array( $arr ) && ! empty( $arr ) ){
			foreach( $arr as $inner_arr ){
				$temp_arr = array_merge( $temp_arr, $inner_arr );
			}
		}

		return $temp_arr;
	}
}


if( !function_exists( 'flat_pm_pre_filter_content_startEnd' ) ){
	function flat_pm_pre_filter_content_startEnd( $content ){
		if( is_feed() )
			return $content;

		return '<div class="fpm_start"></div>' . PHP_EOL . $content . PHP_EOL . '<div class="fpm_end"></div>';
	}
}


if( !function_exists( 'flat_pm_pre_filter_content_fastStart' ) ){
	function flat_pm_pre_filter_content_fastStart( $content ){
		if( is_feed() || mb_strlen( $content ) < 10 )
			return $content;

		$content = explode( '</p>', $content, 10 );
		$content[ count( $content ) - 1 ] = wp_get_inline_script_tag( 'fpm_start( "true" );', array( 'data-noptimize' => '', 'data-wpfc-render' => 'false' ) ) . $content[ count( $content ) - 1 ];
		$content = implode( '</p>', $content );

		return $content;
	}
}


if( !function_exists( 'flat_pm_filter_content' ) ){
	function flat_pm_filter_content( $content ){
		if( is_feed() ) return;

		$exclude_block = 'yes';

		if( wp_doing_ajax() ){
			global $post;

			$we_are_hear       = 'is_single';
			$post_id           = $post->ID;
			$post_type         = $post->post_type;
			$post_taxs         = get_object_taxonomies( $post_type );
			$post_terms        = array();
			$post_terms_parent = array();

			if( is_array( $post_taxs ) ){
				foreach( $post_taxs as $tax_value ){
					$terms_arr = get_the_terms( $post_id, $tax_value );
					if( is_array( $terms_arr ) ){
						foreach( $terms_arr as $term_value ){
							$post_terms []= $term_value->term_id;

							$term_parent = $term_value->parent;
							while( $term_parent != 0 ){
								$post_terms_parent []= $term_parent;

								$term_parent = get_term( $term_parent )->parent;
							}
						}
					}
				}
			}
		}else{
			if( is_admin() )
				return;

			wp_reset_query();
			wp_reset_postdata();

			switch ( true ) {
				case ( is_home() || is_front_page() ) :
					$we_are_hear     = 'is_home';
					break;

				case ( is_search() ) :
					$we_are_hear     = 'is_search';
					break;

				case ( is_404() ) :
					$we_are_hear     = 'is_404';
					break;

				case ( is_post_type_archive() && is_archive() ) :
					$we_are_hear     = 'is_archive';
					$post_type_name  = get_queried_object()->name;
					break;

				case ( ( is_tax() || is_category() || is_tag() ) && is_archive() ) :
					$we_are_hear     = 'is_tax';
					$term_id         = get_queried_object()->term_id;
					break;

				case ( is_single() || is_page() ) :
					$we_are_hear       = 'is_single';
					$post_id           = get_queried_object()->ID;
					$post_type         = get_queried_object()->post_type;
					$post_taxs         = get_object_taxonomies( $post_type );
					$post_terms        = array();
					$post_terms_parent = array();

					$author_id = get_queried_object()->post_author;

					$exclude_block_flat_pm = get_post_meta( $post_id, 'exclude_block_flat_pm', true );
					$exclude_block = ( $exclude_block_flat_pm == 'yes' || $exclude_block_flat_pm == '' ) ? 'yes' : 'no';

					if( is_array( $post_taxs ) ){
						foreach ( $post_taxs as $tax_value ) {
							$terms_arr = get_the_terms( $post_id, $tax_value );
							if( is_array( $terms_arr ) ){
								foreach ( $terms_arr as $term_value) {
									$post_terms []= $term_value->term_id;

									$term_parent = $term_value->parent;
									while( $term_parent != 0 ){
										$post_terms_parent []= $term_parent;

										$term_parent = get_term( $term_parent )->parent;
									}
								} unset( $term_value );
							}
						} unset( $tax_value );
					}
					break;

				default:
					return;
					break;
			}
		}

		$global_output = array();

		$folder_meta = array();
		$folder_meta_keys = array(
			'turned',
			'content',
			'user',
		);

		$block_meta = array();
		$block_meta_keys = array(
			'id',
			'turned',
			'fast',
			'lazy',
			'abgroup',
			'html',
			'view',
			'content',
			'user',
		);

		$args_flat_pm = array(
			'posts_per_page' => -1,
			'post_type'      => 'flat_pm_block',
			'order'          => 'ASC',
			'orderby'        => 'meta_value_num',
			'meta_key'       => 'order',
			'post_status'    => 'publish',
		);

		$flat_query = new WP_Query;
		$flat_query_posts = $flat_query->query( $args_flat_pm );



		if( is_array( $flat_query_posts ) && $exclude_block == 'yes' ) :



		foreach( $flat_query_posts as $flat_query_post ){
			global $fpm_block_id;

			$blockID = $flat_query_post->ID;

			$fpm_block_id = $blockID;

			foreach( $block_meta_keys as $key ){
				$block_meta[ $key ] = get_post_meta( $blockID, $key, true );
			}

			if(
				$block_meta['turned'] === 'false' ||
				wp_doing_ajax() && 
				$block_meta['view']['once']['enabled']     !== 'true' &&
				$block_meta['view']['iterable']['enabled'] !== 'true' &&
				$block_meta['view']['pixels']['enabled']   !== 'true' &&
				$block_meta['view']['symbols']['enabled']  !== 'true'
			) continue;



			/**
			 * ****************************************************************************
			 *   VIEW rule ckeck
			 * ****************************************************************************
			 */

			foreach( array( 'once', 'iterable', 'preroll', 'hoverroll' ) as $key ){
				$block_meta['view'][ $key ]['selector'] = htmlspecialchars_decode( $block_meta['view'][ $key ]['selector'], ENT_QUOTES );
				$block_meta['view'][ $key ]['xpath']    = htmlspecialchars_decode( $block_meta['view'][ $key ]['xpath'], ENT_QUOTES );
			}

			foreach( array( 'pixels', 'symbols', 'once', 'iterable', 'outgoing', 'preroll', 'hoverroll' ) as $key ){
				if( $block_meta['view'][ $key ]['enabled'] === 'false' ){
					unset( $block_meta['view'][ $key ] );
					continue;
				}

				unset( $block_meta['view'][ $key ]['enabled'] );
			}

			if( empty( $block_meta['view'] ) ){
				continue;
			}



			/**
			 * ****************************************************************************
			 *   HTML rule ckeck
			 * ****************************************************************************
			 */

			foreach( $block_meta['html']['block'] as $key => $value ){

				if( $value['turned'] === 'false' ){
					unset( $block_meta['html']['block'][ $key ] );

					continue;
				}

				$block_meta['html']['block'][ $key ]['html']['code'] = do_shortcode(
					htmlspecialchars_decode( $block_meta['html']['block'][ $key ]['html']['code'], ENT_QUOTES )
				);
				$block_meta['html']['block'][ $key ]['adb']['code'] = do_shortcode(
					htmlspecialchars_decode( $block_meta['html']['block'][ $key ]['adb']['code'], ENT_QUOTES )
				);

			}

			if( ! is_array( $block_meta['html']['block'] ) || count( $block_meta['html']['block'] ) === 0 )
				continue;



			/**
			 * ****************************************************************************
			 *   GET folder
			 * ****************************************************************************
			 */

			$filtered = false;
			$folderTerm        = get_the_terms( $blockID, 'flat_pm_block_folders' );
			if( ! is_wp_error( $folderTerm ) && $folderTerm ){

				$folderTerm = $folderTerm[0];
				$folderID   = $folderTerm->term_id;
				$filtered   = get_term_meta( $folderID, 'turned', true ) === 'true' ? true : false;

			}

			if( $filtered ){

				foreach( $folder_meta_keys as $key ){
					$folder_meta[ $key ] = get_term_meta( $folderID, $key, true );
				}


				foreach( array( 'taxonomy_enabled', 'taxonomy_disabled', 'publish_enabled', 'publish_disabled' ) as $key ){
					if( isset( $folder_meta['content'][ $key ] ) && ! empty( $folder_meta['content'][ $key ] ) ){
						$block_meta['content'][ $key ] = $folder_meta['content'][ $key ];
					}else
					if( ! isset( $block_meta['content'][ $key ] ) ) $block_meta['content'][ $key ] = array();
				}

				foreach( array( 'post_types', 'templates' ) as $key ){
					foreach( $folder_meta['content'][ $key ] as $sub => $value ){
						if( $value === 'true' ){
							$block_meta['content'][ $key ][ $sub ] = $value;
						}
					}
				}

				foreach( array( 'restriction', 'author' ) as $key ){
					if( ! isset( $folder_meta['content'][ $key ] ) )
						continue;

					foreach( $folder_meta['content'][ $key ] as $sub => $value ){
						if( ! empty( $value ) ){
							$block_meta['content'][ $key ][ $sub ] = $value;
						}
					}
				}

			}

			foreach( array( 'restriction' ) as $key ){
				foreach( $block_meta['content'][ $key ] as $sub => $value ){
					if( empty( $block_meta['content'][ $key ][ $sub ] ) ){
						unset( $block_meta['content'][ $key ][ $sub ] );
					}
				}

				if( empty( $block_meta['content'][ $key ] ) ){
					unset( $block_meta['content'][ $key ] );
				}
			}



			/**
			 * ****************************************************************************
			 *   GEO rule ckeck
			 * ****************************************************************************
			 */

			foreach( array( 'geo' ) as $key ){
				if( $filtered && $folder_meta['user'][ $key ]['enabled'] === 'true' ){
					$block_meta['user'][ $key ]['enabled'] = 'true';
				}

				if( $block_meta['user'][ $key ]['enabled'] === 'false' ){
					unset( $block_meta['user'][ $key ] );
					continue;
				}

				if( $filtered && $folder_meta['user'][ $key ]['enabled'] === 'true' ){
					if( ! empty( $folder_meta['user'][ $key ]['country']['allow'] ) ){
						$block_meta['user'][ $key ]['country']['allow'] = $folder_meta['user'][ $key ]['country']['allow'];
					}

					if( ! empty( $folder_meta['user'][ $key ]['country']['disallow'] ) ){
						$block_meta['user'][ $key ]['country']['disallow'] = $folder_meta['user'][ $key ]['country']['disallow'];
					}

					if( ! empty( $folder_meta['user'][ $key ]['city']['allow'] ) ){
						$block_meta['user'][ $key ]['city']['allow'] = $folder_meta['user'][ $key ]['city']['allow'];
					}

					if( ! empty( $folder_meta['user'][ $key ]['city']['disallow'] ) ){
						$block_meta['user'][ $key ]['city']['disallow'] = $folder_meta['user'][ $key ]['city']['disallow'];
					}
				}

				if(
					empty( $block_meta['user'][ $key ]['country']['allow'] ) &&
					empty( $block_meta['user'][ $key ]['country']['disallow'] ) &&
					empty( $block_meta['user'][ $key ]['city']['allow'] ) &&
					empty( $block_meta['user'][ $key ]['city']['disallow'] )
				){
					unset( $block_meta['user'][ $key ] );
					continue;
				}

				if( ! empty( $block_meta['user'][ $key ]['country']['allow'] ) ){
					$block_meta['user'][ $key ]['country']['allow'] = array_map(
						'mb_strtolower',
						explode( PHP_EOL, $block_meta['user'][ $key ]['country']['allow'] )
					);
				}else{
					$block_meta['user'][ $key ]['country']['allow'] = array();
				}

				if( ! empty( $block_meta['user'][ $key ]['country']['disallow'] ) ){
					$block_meta['user'][ $key ]['country']['disallow'] = array_map(
						'mb_strtolower',
						explode( PHP_EOL, $block_meta['user'][ $key ]['country']['disallow'] )
					);
				}else{
					$block_meta['user'][ $key ]['country']['disallow'] = array();
				}

				if( ! empty( $block_meta['user'][ $key ]['city']['allow'] ) ) {
					$block_meta['user'][ $key ]['city']['allow'] = array_map(
						'mb_strtolower',
						explode( PHP_EOL, $block_meta['user'][ $key ]['city']['allow'] )
					);
				}else{
					$block_meta['user'][ $key ]['city']['allow'] = array();
				}

				if( ! empty( $block_meta['user'][ $key ]['city']['disallow'] ) ){
					$block_meta['user'][ $key ]['city']['disallow'] = array_map(
						'mb_strtolower',
						explode( PHP_EOL, $block_meta['user'][ $key ]['city']['disallow'] )
					);
				}else{
					$block_meta['user'][ $key ]['city']['disallow'] = array();
				}

				unset( $block_meta['user'][ $key ]['enabled'] );
			}



			/**
			 * ****************************************************************************
			 *   ISP, UTM, Cookies, User-agent rule ckeck
			 * ****************************************************************************
			 */

			foreach( array( 'isp', 'utm', 'cookies', 'agent', 'referer' ) as $key ){
				if( $filtered && $folder_meta['user'][ $key ]['enabled'] === 'true' ){
					$block_meta['user'][ $key ]['enabled'] = 'true';
				}

				if( $block_meta['user'][ $key ]['enabled'] === 'false' ){
					unset( $block_meta['user'][ $key ] );
					continue;
				}

				if( $filtered && $folder_meta['user'][ $key ]['enabled'] === 'true' ){
					if( ! empty( $folder_meta['user'][ $key ]['allow'] ) ){
						$block_meta['user'][ $key ]['allow'] = $folder_meta['user'][ $key ]['allow'];
					}

					if( ! empty( $folder_meta['user'][ $key ]['disallow'] ) ){
						$block_meta['user'][ $key ]['disallow'] = $folder_meta['user'][ $key ]['disallow'];
					}
				}

				if(
					empty( $block_meta['user'][ $key ]['allow'] ) &&
					empty( $block_meta['user'][ $key ]['disallow'] )
				){
					unset( $block_meta['user'][ $key ] );
					continue;
				}

				if( ! empty( $block_meta['user'][ $key ]['allow'] ) ){
					$block_meta['user'][ $key ]['allow'] = explode( PHP_EOL, $block_meta['user'][ $key ]['allow'] );
				}else{
					$block_meta['user'][ $key ]['allow'] = array();
				}

				if( ! empty( $block_meta['user'][ $key ]['disallow'] ) ){
					$block_meta['user'][ $key ]['disallow'] = explode( PHP_EOL, $block_meta['user'][ $key ]['disallow'] );
				}else{
					$block_meta['user'][ $key ]['disallow'] = array();
				}

				unset( $block_meta['user'][ $key ]['enabled'] );
			}



			/**
			 * ****************************************************************************
			 *   Browser, OS and Role rule ckeck
			 * ****************************************************************************
			 */

			foreach( array( 'browser', 'os', 'role' ) as $key ){
				if( $filtered && $folder_meta['user'][ $key ]['enabled'] === 'true' ){
					$block_meta['user'][ $key ]['enabled'] = 'true';
				}

				if( $block_meta['user'][ $key ]['enabled'] === 'false' ){
					unset( $block_meta['user'][ $key ] );
					continue;
				}

				if( $filtered && $folder_meta['user'][ $key ]['enabled'] === 'true' ){
					if( ! empty( $folder_meta['user'][ $key ]['allow'] ) ){
						$block_meta['user'][ $key ]['allow'] = $folder_meta['user'][ $key ]['allow'];
					}

					if( ! empty( $folder_meta['user'][ $key ]['disallow'] ) ){
						$block_meta['user'][ $key ]['disallow'] = $folder_meta['user'][ $key ]['disallow'];
					}
				}

				if(
					empty( $block_meta['user'][ $key ]['allow'] ) &&
					empty( $block_meta['user'][ $key ]['disallow'] )
				){
					unset( $block_meta['user'][ $key ] );
					continue;
				}

				if( ! empty( $block_meta['user'][ $key ]['allow'] ) ){
					$block_meta['user'][ $key ]['allow'] = array_map( 'mb_strtolower', $block_meta['user'][ $key ]['allow'] );
				}else{
					$block_meta['user'][ $key ]['allow'] = array();
				}

				if( ! empty( $block_meta['user'][ $key ]['disallow'] ) ){
					$block_meta['user'][ $key ]['disallow'] = array_map( 'mb_strtolower', $block_meta['user'][ $key ]['disallow'] );
				}else{
					$block_meta['user'][ $key ]['disallow'] = array();
				}

				unset( $block_meta['user'][ $key ]['enabled'] );
			}



			/**
			 * ****************************************************************************
			 *   Date and Time rule ckeck
			 * ****************************************************************************
			 */

			foreach( array( 'date', 'time' ) as $key ){
				if( $filtered && $folder_meta['user'][ $key ]['enabled'] === 'true' ){
					$block_meta['user'][ $key ]['enabled'] = 'true';
				}

				if( $block_meta['user'][ $key ]['enabled'] === 'false' ){
					unset( $block_meta['user'][ $key ] );
					continue;
				}

				if( $filtered && $folder_meta['user'][ $key ]['enabled'] === 'true' ){
					if( ! empty( $folder_meta['user'][ $key ]['from'] ) ){
						$block_meta['user'][ $key ]['from'] = $folder_meta['user'][ $key ]['from'];
					}

					if( ! empty( $folder_meta['user'][ $key ]['to'] ) ){
						$block_meta['user'][ $key ]['to'] = $folder_meta['user'][ $key ]['to'];
					}
				}

				if(
					empty( $block_meta['user'][ $key ]['from'] ) &&
					empty( $block_meta['user'][ $key ]['to'] )
				){
					unset( $block_meta['user'][ $key ] );
				}

				unset( $block_meta['user'][ $key ]['enabled'] );
			}



			/**
			 * ****************************************************************************
			 *   Schedule rule ckeck
			 * ****************************************************************************
			 */

			foreach( array( 'schedule' ) as $key ){
				if( $filtered && $folder_meta['user'][ $key ]['enabled'] === 'true' ){
					$block_meta['user'][ $key ]['enabled'] = 'true';
				}

				if( $block_meta['user'][ $key ]['enabled'] === 'false' ){
					unset( $block_meta['user'][ $key ] );
					continue;
				}

				if( $filtered && $folder_meta['user'][ $key ]['enabled'] === 'true' ){
					if( ! empty( $folder_meta['user'][ $key ]['value'] ) ){
						$block_meta['user'][ $key ]['value'] = $folder_meta['user'][ $key ]['value'];
					}
				}

				if(
					empty( $block_meta['user'][ $key ]['value'] )
				){
					unset( $block_meta['user'][ $key ] );
				}

				unset( $block_meta['user'][ $key ]['enabled'] );
			}



			/**
			 * ****************************************************************************
			 *   IP rule ckeck
			 * ****************************************************************************
			 */

			foreach( array( 'ip' ) as $key ){
				if( $filtered && $folder_meta['user'][ $key ]['enabled'] === 'true' ){
					$block_meta['user'][ $key ]['enabled'] = 'true';
				}

				if( $block_meta['user'][ $key ]['enabled'] === 'false' ){
					unset( $block_meta['user'][ $key ] );
					continue;
				}

				unset( $block_meta['user'][ $key ]['enabled'] );
			}



			/**
			 * ****************************************************************************
			 *   HOME, ARCHIVE, SEARCH, PAGED rule ckeck
			 * ****************************************************************************
			 */

			if(
				(
					$we_are_hear == 'is_home' &&
					$block_meta['content']['templates']['home'] === 'false'
				) ||
				(
					$we_are_hear == 'is_404' &&
					$block_meta['content']['templates']['404'] === 'false'
				) ||
				(
					$we_are_hear == 'is_search' &&
					$block_meta['content']['templates']['home'] === 'false'
				) ||
				(
					is_paged() &&
					$block_meta['content']['templates']['paged'] === 'false'
				) ||
				(
					$we_are_hear == 'is_archive' &&
					(
						$block_meta['content']['templates']['archives'] === 'false' ||
						(
							isset( $block_meta['content']['post_types'][ $post_type_name ] ) &&
							$block_meta['content']['post_types'][ $post_type_name ] === 'false'
						)
					)
				)
			) continue;



			/**
			 * ****************************************************************************
			 *   TAX rule ckeck
			 * ****************************************************************************
			 */

			if( $we_are_hear == 'is_tax' ){
				if( $block_meta['content']['templates']['categories'] === 'false' ){
					continue;
				}else{
					$block_meta['content']['taxonomy_enabled']  = isset( $block_meta['content']['taxonomy_enabled'] )  ? $block_meta['content']['taxonomy_enabled']  : array();
					$block_meta['content']['taxonomy_disabled'] = isset( $block_meta['content']['taxonomy_disabled'] ) ? $block_meta['content']['taxonomy_disabled'] : array();

					$taxonomy_enabled  = flat_pm_array_merge( $block_meta['content']['taxonomy_enabled'] );
					$taxonomy_disabled = flat_pm_array_merge( $block_meta['content']['taxonomy_disabled'] );

					if(
						( ! empty( $taxonomy_enabled )  && ! in_array( $term_id, $taxonomy_enabled  ) ) ||
						( ! empty( $taxonomy_disabled ) &&   in_array( $term_id, $taxonomy_disabled ) )
					) continue;
				}
			}



			/**
			 * ****************************************************************************
			 *   SINGLE rule ckeck
			 * ****************************************************************************
			 */

			if(
				$we_are_hear == 'is_single' &&
				(
					(
						$block_meta['content']['templates']['singular'] === 'false' ||
						! isset( $block_meta['content']['post_types'][ $post_type ] ) ||
						$block_meta['content']['post_types'][ $post_type ] === 'false'
					) ||
					(
						isset( $block_meta['content']['author'] ) &&
						(
							( ! empty( $block_meta['content']['author']['allow'] )    && ! in_array( $author_id, $block_meta['content']['author']['allow'] ) ) ||
							( ! empty( $block_meta['content']['author']['disallow'] ) &&   in_array( $author_id, $block_meta['content']['author']['disallow'] ) )
						)
					)
				)
			) continue;

			if(
				$we_are_hear == 'is_single' &&
				$block_meta['content']['templates']['singular'] === 'true' &&
				isset( $block_meta['content']['post_types'][ $post_type ] ) &&
				$block_meta['content']['post_types'][ $post_type ] === 'true'
			){
				$bool_out       = false;

				$block_meta['content']['taxonomy_enabled']  = isset( $block_meta['content']['taxonomy_enabled'] )  ? $block_meta['content']['taxonomy_enabled']  : array();
				$block_meta['content']['taxonomy_disabled'] = isset( $block_meta['content']['taxonomy_disabled'] ) ? $block_meta['content']['taxonomy_disabled'] : array();
				$block_meta['content']['publish_enabled']   = isset( $block_meta['content']['publish_enabled'] )   ? $block_meta['content']['publish_enabled']   : array();
				$block_meta['content']['publish_disabled']  = isset( $block_meta['content']['publish_disabled'] )  ? $block_meta['content']['publish_disabled']  : array();

				$tax_enabled    = flat_pm_array_merge( $block_meta['content']['taxonomy_enabled'] );
				$tax_disabled   = flat_pm_array_merge( $block_meta['content']['taxonomy_disabled'] );
				$posts_enabled  = flat_pm_array_merge( $block_meta['content']['publish_enabled'] );
				$posts_disabled = flat_pm_array_merge( $block_meta['content']['publish_disabled'] );

				$empty_tax_enabled    = empty( $tax_enabled );
				$empty_tax_disabled   = empty( $tax_disabled );
				$empty_posts_enabled  = empty( $posts_enabled );
				$empty_posts_disabled = empty( $posts_disabled );

				$tax_enabled_intersect_count  = count( array_intersect( array_merge( $post_terms, $post_terms_parent ), $tax_enabled ) );
				$tax_disabled_intersect_count = count( array_intersect( $post_terms, $tax_disabled ) );

				if(
					( ! $empty_tax_enabled && $empty_tax_disabled && 0 !== $tax_enabled_intersect_count ) ||
					( $empty_tax_enabled && ! $empty_tax_disabled && 0 === $tax_disabled_intersect_count ) ||
					(
						$empty_tax_disabled && $empty_tax_enabled &&
						0 != $tax_enabled_intersect_count && 0 == $tax_disabled_intersect_count
					)
				) $bool_out = true;

				if(
					! $bool_out && $empty_tax_disabled && $empty_tax_enabled &&
					(
						(   $empty_posts_enabled  &&   $empty_posts_disabled ) ||
						( ! $empty_posts_enabled  &&   in_array( $post_id, $posts_enabled ) ) ||
						( ! $empty_posts_disabled && ! in_array( $post_id, $posts_disabled ) )
					)
				) $bool_out = true;
				elseif(
					$bool_out && ! $empty_posts_disabled && in_array( $post_id, $posts_disabled )
				) $bool_out = false;
				elseif(
					! $bool_out && ! $empty_posts_enabled && in_array( $post_id, $posts_enabled )
				) $bool_out = true;

				if( ! $bool_out ) continue;
			}

			unset(
				$block_meta['turned'],
				$block_meta['content']['post_types'],
				$block_meta['content']['templates'],
				$block_meta['content']['taxonomy_enabled'],
				$block_meta['content']['taxonomy_disabled'],
				$block_meta['content']['publish_enabled'],
				$block_meta['content']['publish_disabled'],
				$block_meta['content']['author']
			);

			$global_output []= $block_meta;
		}



		endif; // end if is_array( $flat_query_posts )



		$flat_pm_pagespeed     = get_option( 'flat_pm_pagespeed' );
		$flat_pm_header_footer = get_option( 'flat_pm_header_footer' );



		if( wp_doing_ajax() ){
			$output = '<!--noptimize-->';
		}else{
			echo '<!--noptimize-->';
		}


		/**
		 * ****************************************************************************
		 *   HEADER deffered code
		 * ****************************************************************************
		 */

		if(
			$flat_pm_header_footer[ 'header_enabled' ] &&
			$flat_pm_header_footer[ 'header_deffered' ] === 'true' &&
			! empty( $flat_pm_header_footer[ 'header_code' ] ) &&
			! wp_doing_ajax()
		){
			$header_output = array(
				'id'      => 'header',
				'fast'    => 'true',
				'lazy'    => 'false',
				'abgroup' => '',
				'html'    => array(
					'block' => array(
						'block_0' => array(
							'id'   => '0', 'name' => '', 'minwidth' => '', 'maxwidth' => '', 'abgroup' => '', 'turned' => 'true',
							'html' => array(
								'code' => stripslashes( htmlspecialchars_decode( $flat_pm_header_footer['header_code'], ENT_QUOTES ) ),
								'minheight' => '', 'autorefresh' => '', 'timeout' => ''
							),
							'adb' => array( 'code' => '', 'minheight' => '', 'autorefresh' => '', 'timeout' => '' )
						)
					)
				),
				'view'    => array( 'once' => array( 'derection' => 'top', 'insert_type' => 'append', 'selector' => 'head', 'xpath' => './/head', 'n' => '1', 'document' => 'true' ) ),
				'content' => array(),
				'user'    => array()
			);

			$javascript = '
			window.fpm_arr = window.fpm_arr || [];
			window.fpm_arr = window.fpm_arr.concat(' . wp_json_encode( $header_output, JSON_UNESCAPED_UNICODE ) . ');';

			if( wp_doing_ajax() ){
				$output .= '
				<script data-noptimize>
					' . $javascript . '
				</script>';
			}else{
				echo wp_get_inline_script_tag( $javascript, array( 'data-noptimize' => '', 'data-wpfc-render' => 'false' ) );
			}
		}



		/**
		 * ****************************************************************************
		 *   MAIN code
		 * ****************************************************************************
		 */

		$javascript = '
		window.fpm_arr = window.fpm_arr || [];
		window.fpm_arr = window.fpm_arr.concat(' . wp_json_encode( $global_output, JSON_UNESCAPED_UNICODE ) . ');';

		if( wp_doing_ajax() ){
			$output .= '
			<script data-noptimize>
				' . $javascript . '
			</script>';
		}else{
			echo wp_get_inline_script_tag( $javascript, array( 'data-noptimize' => '', 'data-wpfc-render' => 'false' ) );
		}



		/**
		 * ****************************************************************************
		 *   FOOTER deffered code
		 * ****************************************************************************
		 */

		if(
			$flat_pm_header_footer[ 'footer_enabled' ] &&
			$flat_pm_header_footer[ 'footer_deffered' ] === 'true' &&
			! empty( $flat_pm_header_footer[ 'footer_code' ] ) &&
			! wp_doing_ajax()
		){
			$footer_output = array(
				'id'      => 'footer',
				'fast'    => 'false',
				'lazy'    => 'false',
				'abgroup' => '',
				'html'    => array(
					'block' => array(
						'block_0' => array(
							'id'   => '0', 'name' => '', 'minwidth' => '', 'maxwidth' => '', 'abgroup' => '', 'turned' => 'true',
							'html' => array(
								'code' => stripslashes( htmlspecialchars_decode( $flat_pm_header_footer['footer_code'], ENT_QUOTES ) ),
								'minheight' => '', 'autorefresh' => '', 'timeout' => ''
							),
							'adb' => array( 'code' => '', 'minheight' => '', 'autorefresh' => '', 'timeout' => '' )
						)
					)
				),
				'view'    => array( 'once' => array( 'derection' => 'top', 'insert_type' => 'append', 'selector' => 'body', 'xpath' => './/body', 'n' => '1', 'document' => 'true' ) ),
				'content' => array(),
				'user'    => array()
			);

			$javascript = '
			window.fpm_arr = window.fpm_arr || [];
			window.fpm_arr = window.fpm_arr.concat(' . wp_json_encode( $footer_output, JSON_UNESCAPED_UNICODE ) . ');';

			if( wp_doing_ajax() ){
				$output .= $javascript;
			}else{
				echo wp_get_inline_script_tag( $javascript, array( 'data-noptimize' => '', 'data-wpfc-render' => 'false' ) );
			}
		}



		/**
		 * ****************************************************************************
		 *   START code
		 * ****************************************************************************
		 */

		$default_options = include FLATPM_DEFAULTS . '/options.php';

		$flat_pm_pagespeed['deffered']        = ( $flat_pm_pagespeed['deffered'] != '' )        ? $flat_pm_pagespeed['deffered']        : $default_options['flat_pm_pagespeed']['deffered'];
		$flat_pm_pagespeed['deffered_events'] = ( $flat_pm_pagespeed['deffered_events'] != '' ) ? $flat_pm_pagespeed['deffered_events'] : $default_options['flat_pm_pagespeed']['deffered_events'];
		$flat_pm_pagespeed['timeout']         = ( $flat_pm_pagespeed['timeout'] != '' )         ? $flat_pm_pagespeed['timeout']         : $default_options['flat_pm_pagespeed']['timeout'];
		$flat_pm_pagespeed['timeout_time']    = ( $flat_pm_pagespeed['timeout_time'] != '' )    ? $flat_pm_pagespeed['timeout_time']    : $default_options['flat_pm_pagespeed']['timeout_time'];
		$flat_pm_pagespeed['pagespeed']       = ( $flat_pm_pagespeed['pagespeed'] != '' )       ? $flat_pm_pagespeed['pagespeed']       : $default_options['flat_pm_pagespeed']['pagespeed'];

		$javascript = '
		!function(){var a=' . esc_html( $flat_pm_pagespeed['deffered'] ) . ',r="' . esc_html( $flat_pm_pagespeed['deffered_events'] ) . '".trim().split(" "),o=' . esc_html( $flat_pm_pagespeed['timeout'] ) . ',i=' . esc_html( $flat_pm_pagespeed['timeout_time'] ) . ';' . esc_html( $flat_pm_pagespeed['pagespeed'] ) . '&&-1<navigator.userAgent.indexOf("Chrome-Lighthouse")||("loading"===document.readyState?document.addEventListener("readystatechange",function(t){var e,n;a||o||"interactive"!==t.target.readyState||fpm_start(),(a||o)&&"complete"===t.target.readyState&&(a&&(n=function(){fpm_start(),clearTimeout(e),r.forEach(function(t){document.removeEventListener(t,n)})},r.forEach(function(t){document.addEventListener(t,n)})),o&&(e=setTimeout(function(){fpm_start(),r.forEach(function(t){document.removeEventListener(t,n)})},i)))}):fpm_start())}();';

		if( wp_doing_ajax() ){
			$output .= '
			<script data-noptimize>
				' . $javascript . '
			</script>';
		}else{
			echo wp_get_inline_script_tag( $javascript, array( 'data-noptimize' => '', 'data-wpfc-render' => 'false' ) );
		}

		if( wp_doing_ajax() ){
			$output .= '<!--/noptimize-->';
		}else{
			echo '<!--/noptimize-->';
		}


		if( wp_doing_ajax() ){
			return $content . PHP_EOL . $output;
		}
	}
}


// !--sub_functions



if( wp_doing_ajax() ){
	add_filter( 'the_content', 'flat_pm_filter_content', FLATPM_INT_MAX );
}

add_filter( 'term_description', 'flat_pm_pre_filter_content_startEnd', 1 );
add_filter( 'the_content',      'flat_pm_pre_filter_content_startEnd', 1 );

$flat_pm_advanced = get_option( 'flat_pm_advanced' );
if( ! is_admin() && $flat_pm_advanced['fast_start'] === 'true' ){
	add_filter( 'term_description', 'flat_pm_pre_filter_content_fastStart', 10 );
	add_filter( 'the_content', 'flat_pm_pre_filter_content_fastStart', 10 );
}

add_filter( 'wp_head', 'flat_pm_filter_content', FLATPM_INT_MAX );
?>