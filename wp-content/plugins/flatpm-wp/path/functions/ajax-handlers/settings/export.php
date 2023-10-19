<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_export' ) ){
	function flat_pm_export( $method, $meta ){
		if( ! flat_do_some() ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'You don\'t have PRO version', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		$data = array();
		$export = $meta['export'];

		if( $export['blocks']['enabled'] === 'true' ){
			$data['blocks'] = array();

			$dafault_block_setting = include FLATPM_DEFAULTS . '/block.php';

			if( isset( $export['blocks']['list'] ) && is_array( $export['blocks']['list'] ) ){
				foreach( $export['blocks']['list'] as $id => $bool ){
					if( $bool !== 'true' ) continue;

					$block_settings = array();

					foreach( $dafault_block_setting as $meta_key => $value ){
						$block_settings[ $meta_key ] = get_post_meta( (int) $id, $meta_key, true );

						$term_name = '';
						$terms = wp_get_post_terms( (int) $id, 'flat_pm_block_folders', array( 'fields' => 'ids' ) );

						if( ! is_wp_error( $terms ) && $terms && is_array( $terms ) ){
							$term_name = get_term( $terms[0] )->name;
						}

						$block_settings['folder_name'] = $term_name;
					}

					unset( $block_settings['id'] );

					$data['blocks'] []= $block_settings;
				}
			}
		}

		if( $export['folders']['enabled'] === 'true' ){
			$data['folders'] = array();

			$dafault_folder_setting = include FLATPM_DEFAULTS . '/folder.php';

			if( isset( $export['folders']['list'] ) && is_array( $export['folders']['list'] ) ){
				foreach( $export['folders']['list'] as $id => $bool ){
					if( $bool !== 'true' ) continue;

					$folder_settings = array();

					foreach( $dafault_folder_setting as $meta_key => $value ){
						$folder_settings[ $meta_key ] = get_term_meta( (int) $id, $meta_key, true );
					}

					unset( $folder_settings['id'] );

					if( ! $folder_settings['name'] ){
						$folder_settings['name'] = get_term( (int) $id )->name;
					}

					$data['folders'] []= $folder_settings;
				}
			}
		}

		if( $export['header_footer']['enabled'] === 'true' ){
			$data['header_footer'] = array();

			$data['header_footer'][ 'flat_pm_header_footer' ] = get_option( 'flat_pm_header_footer' );
		}

		if( $export['ip']['enabled'] === 'true' ){
			$file = ABSPATH . '/ip.txt';

			if( file_exists( $file ) ){
				$data['ip'] = file_get_contents( $file, true );
			}
		}

		if( $export['settings']['enabled'] === 'true' ){
			$data['settings'] = array();

			$data['settings'][ 'flat_pm_unfold' ] = get_option( 'flat_pm_unfold' );
			$data['settings'][ 'flat_pm_main' ] = get_option( 'flat_pm_main' );
			$data['settings'][ 'flat_pm_pagespeed' ] = get_option( 'flat_pm_pagespeed' );
			$data['settings'][ 'flat_pm_stylization' ] = get_option( 'flat_pm_stylization' );
			$data['settings'][ 'flat_pm_advanced' ] = get_option( 'flat_pm_advanced' );
			$data['settings'][ 'flat_pm_personalization' ] = get_option( 'flat_pm_personalization' );
		}

		if( $export['styles']['enabled'] === 'true' ){
			$data['styles'] = array();

			$data['styles'][ 'flat_pm_css' ] = get_option( 'flat_pm_css' );
		}

		if( $export['license']['enabled'] === 'true' ){
			$data['license'] = array();

			$data['license'][ 'flat_pm_license' ] = get_option( 'flat_pm_license' );
		}

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => '<i class="material-icons">cloud_download</i> ' . __( 'Export file ready', 'flatpm_l10n' ),
				'status' => 'success',
				'data' => $data
			)
		) ) );
	}
}