<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_import' ) ){
	function flat_pm_import( $method, $meta ){
		if( ! flat_do_some() ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'You don\'t have PRO version', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		$import = $meta['import'];

		$data = json_decode( stripslashes( $meta['import']['json'] ), true );

		if( ! $data ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'Your data is broken', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		if( $import['delete_existing'] === 'yes' ){
			$fpm_query = new WP_Query;

			$posts = $fpm_query->query( array(
				'post_type' => 'flat_pm_block',
				'fields' => 'ids',
				'posts_per_page' => -1
			) );

			foreach ( $posts as $id ) {
				wp_delete_post( $id, true );
			};


			$folders = get_terms( array(
				'taxonomy' => 'flat_pm_block_folders',
				'hide_empty' => false,
				'fields' => 'ids',
				'suppress_filter' => true
			) );

			foreach( $folders as $id ){
				wp_delete_term( (int) $id, 'flat_pm_block_folders', array( 'force_default' => true ) );
			}
		}

		if( $import['license'] === 'true' && isset( $data['license'] ) && isset( $data['license']['flat_pm_license'] ) ){
			update_option( 'flat_pm_license', $data['license']['flat_pm_license'] );

			delete_transient( 'license_transient' );
		}

		if( $import['styles'] === 'true' && isset( $data['styles'] ) && isset( $data['styles']['flat_pm_css'] ) ){
			update_option( 'flat_pm_css', $data['styles']['flat_pm_css'] );
		}

		if( $import['settings'] === 'true' && isset( $data['settings'] ) ){
			$allow = array(
				'flat_pm_unfold',
				'flat_pm_main',
				'flat_pm_pagespeed',
				'flat_pm_stylization',
				'flat_pm_advanced',
				'flat_pm_personalization'
			);

			foreach( $allow as $value ){
				if( isset( $data['settings'][ $value ] ) ){
					update_option( $value, $data['settings'][ $value ] );
				}
			}
		}

		if( $import['ip'] === 'true' && isset( $data['ip'] ) ){
			$file = ABSPATH . '/ip.txt';

			file_put_contents( $file, $data['ip'] );
		}

		if( $import['header_footer'] === 'true' && isset( $data['header_footer'] ) && isset( $data['header_footer']['flat_pm_header_footer'] ) ){
			update_option( 'flat_pm_header_footer', $data['header_footer']['flat_pm_header_footer'] );
		}

		if( $import['folders'] === 'true' && isset( $data['folders'] ) && is_array( $data['folders'] ) ){
			foreach( $data['folders'] as $folder_data ){
				$old_term = get_term_by( 'name', $folder_data['name'], 'flat_pm_block_folders' );

				if( $old_term !== false ){
					$folder_data['id'] = $old_term->term_id;
				}

				$folder_data['origin'] = 'programmatically';

				flat_pm_folder_update( NULL, $folder_data );
			}
		}

		if( $import['blocks'] === 'true' && isset( $data['blocks'] ) && is_array( $data['blocks'] ) ){
			foreach( $data['blocks'] as $block_data ){
				$folder = get_term_by( 'name', $block_data['folder_name'], 'flat_pm_block_folders' );

				if( $folder !== false ){
					$block_data['folder_id'] = $folder->term_id;
				}

				$block_data['origin'] = 'programmatically';

				flat_pm_block_update( NULL, $block_data );
			}
		}

		flat_pm_clear_all_cache();

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => '<i class="material-icons">check</i> ' . __( 'Import completed successfully!', 'flatpm_l10n' ),
				'status' => 'success'
			)
		) ) );
	}
}