<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_migration_process' ) ){
	function flat_pm_migration_process( $method, $meta ){
		$current = $meta['li_current'];

		global $dafault_block_setting, $dafault_folder_setting;

		$dafault_block_setting = include FLATPM_DEFAULTS . '/block.php';

		$dafault_folder_setting = include FLATPM_DEFAULTS . '/folder.php';

		$message = '';

		$is_done = ( (int) $meta['li_all'] - (int) $meta['li_yes'] - 1 ) <= 0;

		switch( $current['type'] ){
			case 'setting':

				$old_option = get_option( $current['id'] );

				$migrate = array(
					'flat_plugin_options_me' => function( $old, $current ){
						if( get_option( 'flat_pm_license' ) !== false ){
							update_option( 'flat_pm_license', $old );
						}
					},
					'flat_plugin_settings_me' => function( $old, $current ){
						$flat_pm_main      = get_option( 'flat_pm_main' );
						$flat_pm_pagespeed = get_option( 'flat_pm_pagespeed' );
						$flat_pm_advanced  = get_option( 'flat_pm_advanced' );

						$flat_pm_main['dublicate_adblock'] = (string) $old['adblock'];
						$flat_pm_main['editor_manage']     = (string) $old['editor_manage'];
						$flat_pm_main['auto_clear_cache']  = (string) $old['clear_cache'];

						$flat_pm_pagespeed['deffered']        = (string) $old['deferred'];
						$flat_pm_pagespeed['deffered_events'] = (string) $old['deferred_events'];
						$flat_pm_pagespeed['timeout']         = (string) $old['inseconds'];
						$flat_pm_pagespeed['timeout_time']    = (string) $old['inseconds_mseconds'];
						$flat_pm_pagespeed['pagespeed']       = (string) $old['lighthouse'];

						$flat_pm_advanced['sidebar']          = (string) $old['untilscroll'];

						$old['untilscroll_selector'] = str_replace(
							array( '.flat_pm_start', '.flat_pm_end' ),
							array( '.fpm_start', '.fpm_end' ),
							$old['untilscroll_selector']
						);

						$flat_pm_advanced['sidebar_selector'] = (string) $old['untilscroll_selector'];

						update_option( 'flat_pm_main',      $flat_pm_main );
						update_option( 'flat_pm_pagespeed', $flat_pm_pagespeed );
						update_option( 'flat_pm_advanced',  $flat_pm_advanced );
					},
					'flat_plugin_header_footer_me' => function( $old, $current ){
						$flat_pm_header_footer = get_option( 'flat_pm_header_footer' );

						$flat_pm_header_footer['header_code']     = $old['header'];
						$flat_pm_header_footer['header_deffered'] = $old['header_deferred'];
						$flat_pm_header_footer['footer_code']     = $old['footer'];
						$flat_pm_header_footer['footer_deffered'] = $old['footer_deferred'];

						update_option( 'flat_pm_header_footer', $flat_pm_header_footer );
					},
					'flat_plugin_video_me' => function( $old, $current ){
						if(
							( !isset( $old['enable'] )   || $old['enable'] != 'true'  ) &&
							( !isset( $old['code'] )     || empty( $old['code'] )     ) &&
							( !isset( $old['code_alt'] ) || empty( $old['code_alt'] ) )
						){
							return;
						}

						global $dafault_block_setting;

						$dafault_block_setting['name'] = __( 'Preroll video block (created during migration)', 'flatpm_l10n' );

						$dafault_block_setting['turned'] = $old['enable'];

						$dafault_block_setting['html']['block']['block_0']['html']['code'] = $old['code'];
						$dafault_block_setting['html']['block']['block_0']['adb']['code']  = $old['code_alt'];

						$old['selector'] = str_replace(
							array( '.flat_pm_start', '.flat_pm_end' ),
							array( '.fpm_start', '.fpm_end' ),
							$old['selector']
						);

						$dafault_block_setting['view']['preroll'] = array(
							'enabled' => 'true',
							'selector'=> $old['selector'],
							'xpath'   => $current['xpath'],
							'timer'   => $old['timer'],
							'cross'   => $old['cross'],
							'once'    => $old['once'],
						);

						flat_pm_block_update( NULL, $dafault_block_setting );
					},
					'flat_pm_cross_color' => function( $old, $current ){
						$flat_pm_stylization = get_option( 'flat_pm_stylization' );
						$flat_pm_stylization['cross']['crosshair'] = (string) $old;

						update_option( 'flat_pm_stylization', $flat_pm_stylization );
					},
					'flat_pm_cross_background' => function( $old, $current ){
						$flat_pm_stylization = get_option( 'flat_pm_stylization' );
						$flat_pm_stylization['cross']['background'] = (string) $old;

						update_option( 'flat_pm_stylization', $flat_pm_stylization );
					},
					'flat_pm_cross_text_color' => function( $old, $current ){
						$flat_pm_stylization = get_option( 'flat_pm_stylization' );
						$flat_pm_stylization['cross']['text'] = (string) $old;

						update_option( 'flat_pm_stylization', $flat_pm_stylization );
					},
					'flat_pm_cross_offset' => function( $old, $current ){
						$flat_pm_stylization = get_option( 'flat_pm_stylization' );
						$flat_pm_stylization['cross']['offset'] = (string) $old;

						update_option( 'flat_pm_stylization', $flat_pm_stylization );
					},
					'flat_pm_cross_width' => function( $old, $current ){
						$flat_pm_stylization = get_option( 'flat_pm_stylization' );
						$flat_pm_stylization['cross']['width'] = (string) $old;

						update_option( 'flat_pm_stylization', $flat_pm_stylization );
					},
					'flat_pm_cross_height' => function( $old, $current ){
						$flat_pm_stylization = get_option( 'flat_pm_stylization' );
						$flat_pm_stylization['cross']['height'] = (string) $old;

						update_option( 'flat_pm_stylization', $flat_pm_stylization );
					},
					'flat_pm_cross_weight' => function( $old, $current ){
						$flat_pm_stylization = get_option( 'flat_pm_stylization' );
						$flat_pm_stylization['cross']['thickness'] = (string) $old;

						update_option( 'flat_pm_stylization', $flat_pm_stylization );
					},
				);

				if( isset( $migrate[ $current['id'] ] ) ){
					$migrate[ $current['id'] ]( $old_option, $current );

					delete_option( $current['id'] );
				}

				break;

			case 'block':
				$message = 'block id: ' . $current['id'];

				global $dafault_block_setting;

				$old_metas = array();

				$keys = array(
					'flat_pm_order_ID',
					'flat_pm_block_enabled',

					'flat_pm_html',
					'flat_pm_view',

					'flat_pm_geo',
					'flat_pm_role',
					'flat_pm_os',
					'flat_pm_cookies',
					'flat_pm_utmget',
					'flat_pm_ip',
					'flat_pm_referer',
					'flat_pm_browser',
				);

				foreach( $keys as $key ){
					$all_meta = get_post_meta( (int) $current['id'], $key, true );

					if( $all_meta ){
						$old_metas[ $key ] = $all_meta;
					}
				}


				// global settings

				$dafault_block_setting['name'] = get_the_title( $current['id'] );

				$dafault_block_setting['id']     = (int) $current['id'];
				$dafault_block_setting['order']  = (int) $current['order'];
				$dafault_block_setting['turned'] = ( ! isset( $old_metas['flat_pm_block_enabled'] ) || boolval( $old_metas['flat_pm_block_enabled'] ) ) ? 'true' : 'false';


				// html settings

				$block = array();

				foreach( $old_metas['flat_pm_html'] as $sub_id => $value ){
					$name     = ( ! empty( $value['html_main_name'] ) ) ?
						$value['html_main_name'] : $value['html_block_name'];
					$minwidth = ( (int) $value['resolution_from'] !== 0 ) ?
						(int) $value['resolution_from'] : '';
					$maxwidth = ( (int) $value['resolution_to'] !== 0 ) ?
						(int) $value['resolution_to'] : '';
					$abgroup  = ( $value['group'] === '0' ) ? '' : $value['group'];
					$turned   = boolval( $value['enabled'] ) ? 'true' : 'false';

					$block['block_' . $sub_id] = array(
						'id'       => $sub_id,
						'name'     => $name,
						'minwidth' => $minwidth,
						'maxwidth' => $maxwidth,
						'abgroup'  => $abgroup,
						'turned'   => $turned,
						'html' => array(
							'code'        => $value['html_main'],
							'minheight'   => '',
							'autorefresh' => '',
							'timeout'     => ''
						),
						'adb' => array(
							'code'        => $value['html_block'],
							'minheight'   => '',
							'autorefresh' => '',
							'timeout'     => ''
						)
					);
				}

				$dafault_block_setting['html']['block'] = $block;


				// view settings

				if( isset( $old_metas['flat_pm_view']['how']['simple'] ) ){
					$simple = $old_metas['flat_pm_view']['how']['simple'];

					if( $simple['position'] == '1' ){
						$dafault_block_setting['view']['once'] = array(
							'enabled'     => 'true',
							'derection'   => 'top',
							'insert_type' => 'before',
							'selector'    => '.fpm_start',
							'xpath'       => './/*[contains(concat(" ",normalize-space(@class)," ")," fpm_start ")]',
							'n'           => '1',
							'document'    => 'false',
						);
					}

					if( $simple['position'] == '2' ){
						$dafault_block_setting['view']['symbols'] = array(
							'enabled' => 'true',
							'type'    => 'center',
							'exclude' => $dafault_block_setting['view']['symbols']['exclude'],
							'n'       => '',
							'm'       => '',
							'start'   => '',
							'max'     => ''
						);
					}

					if( $simple['position'] == '3' ){
						$dafault_block_setting['view']['once'] = array(
							'enabled'     => 'true',
							'derection'   => 'top',
							'insert_type' => 'before',
							'selector'    => '.fpm_end',
							'xpath'       => './/*[contains(concat(" ",normalize-space(@class)," ")," fpm_end ")]',
							'n'           => '1',
							'document'    => 'false',
						);
					}

					if( $simple['position'] == '4' ){
						$numbs = explode( '/', $simple['fraction'] );

						if( $numbs[0] == '' ){
							$numbs[0] = 0;
						}

						if( $numbs[1] == '0' || $numbs[1] == '' ){
							$numbs[1] = 1;
						}

						$dafault_block_setting['view']['symbols'] = array(
							'enabled' => 'true',
							'type'    => 'percent_once',
							'exclude' => $dafault_block_setting['view']['symbols']['exclude'],
							'n'       => 100 * (int) $numbs[0] / (int) $numbs[1],
							'm'       => '',
							'start'   => '',
							'max'     => ''
						);
					}

					if( $simple['position'] == '5' ){
						$dafault_block_setting['view']['symbols'] = array(
							'enabled' => 'true',
							'type'    => 'symbol_once',
							'exclude' => $dafault_block_setting['view']['symbols']['exclude'],
							'n'       => $simple['fraction'],
							'm'       => '',
							'start'   => '',
							'max'     => ''
						);
					}

					if( $simple['position'] == '6' ){
						$dafault_block_setting['view']['symbols'] = array(
							'enabled' => 'true',
							'type'    => 'percent_once',
							'exclude' => $dafault_block_setting['view']['symbols']['exclude'],
							'n'       => $simple['fraction'],
							'm'       => $simple['interval'],
							'start'   => '',
							'max'     => ''
						);
					}
				}

				if( isset( $old_metas['flat_pm_view']['how']['onсe'] ) ){
					$once = $old_metas['flat_pm_view']['how']['onсe'];

					$derection = ( $once['direction'] == 'top_to_bottom' ) ? 'top' : 'bottom';

					$once['selector'] = str_replace(
						array( '.flat_pm_start', '.flat_pm_end', ':header' ),
						array( '.fpm_start', '.fpm_end', 'h1, h2, h3, h4, h5, h6' ),
						$once['selector']
					);

					$dafault_block_setting['view']['once'] = array(
						'enabled'     => 'true',
						'derection'   => $derection,
						'insert_type' => $once['before_after'],
						'selector'    => $once['selector'],
						'xpath'       => $current['xpath'],
						'n'           => $once['N'],
						'document'    => $once['search_all'],
					);
				}

				if( isset( $old_metas['flat_pm_view']['how']['iterable'] ) ){
					$iterable = $old_metas['flat_pm_view']['how']['iterable'];

					$derection = ( $iterable['direction'] == 'top_to_bottom' ) ? 'top' : 'bottom';

					$iterable['selector'] = str_replace(
						array( '.flat_pm_start', '.flat_pm_end', ':header' ),
						array( '.fpm_start', '.fpm_end', 'h1, h2, h3, h4, h5, h6' ),
						$iterable['selector']
					);

					$dafault_block_setting['view']['iterable'] = array(
						'enabled'     => 'true',
						'derection'   => $derection,
						'insert_type' => $iterable['before_after'],
						'selector'    => $iterable['selector'],
						'xpath'       => $current['xpath'],
						'n'           => $iterable['N'],
						'start'       => '',
						'max'         => '',
						'document'    => $iterable['search_all'],
					);
				}

				if( isset( $old_metas['flat_pm_view']['how']['popup'] ) ){
					$popup = $old_metas['flat_pm_view']['how']['popup'];

					$type = ( $popup['px_s'] == 'seconds' ) ? 'sec' : 'px';

					$dafault_block_setting['view']['outgoing'] = array(
						'enabled'  => 'true',
						'side'     => 'center',
						'show'     => $popup['after'],
						'type'     => $type,
						'hide'     => '',
						'cross'    => $popup['cross'],
						'timer'    => $popup['timer'],
						'timeout'  => $popup['timer_count'],
						'cookie'   => $popup['cookie'],
						'close'    => $popup['close_window'],
						'action'   => 'false',
						'selector' => '',
					);
				}

				if( isset( $old_metas['flat_pm_view']['how']['outgoing'] ) ){
					$outgoing = $old_metas['flat_pm_view']['how']['outgoing'];

					$type = ( $outgoing['px_s'] == 'seconds' ) ? 'sec' : 'px';
					$side = 'left-bottom';
					if( $outgoing['whence'] == '1' ){
						$side = 'top-center';
					}
					if( $outgoing['whence'] == '2' ){
						$side = 'bottom-center';
					}
					if( $outgoing['whence'] == '3' ){
						$side = 'left-bottom';
					}
					if( $outgoing['whence'] == '4' ){
						$side = 'right-bottom';
					}

					$dafault_block_setting['view']['outgoing'] = array(
						'enabled'  => 'true',
						'side'     => $side,
						'show'     => $outgoing['after'],
						'type'     => $type,
						'hide'     => '',
						'cross'    => $outgoing['cross'],
						'timer'    => $outgoing['timer'],
						'timeout'  => $outgoing['timer_count'],
						'cookie'   => $outgoing['cookie'],
						'close'    => $outgoing['close_window'],
						'action'   => 'false',
						'selector' => '',
					);
				}


				// content settings

				$where = $old_metas['flat_pm_view']['where'];

				if( !isset( $where['show_in_404'] ) ){
					$where['show_in_404'] = '0';
				}

				$post_types = array();
				if( isset( $where['type_of_posts'] ) && is_array( $where['type_of_posts'] ) ){
					foreach( $where['type_of_posts'] as $type ){
						$post_types[ $type ] = 'true';
					}
				}else{
					$post_types = array(
						'post' => 'true',
						'page' => 'true'
					);
				}

				$singular = 'true';
				if(
					$where['show_in_cat']    == '2' ||
					$where['show_in_home']   == '2' ||
					$where['show_in_search'] == '2' ||
					$where['show_in_404']    == '2'
				){
					$singular = 'false';
				}

				$taxonomy_enabled  = array();
				$taxonomy_disabled = array();
				$publish_enabled   = array();
				$publish_disabled  = array();

				if( isset( $where['tax_enabled'] ) && is_array( $where['tax_enabled'] ) ){
					foreach( $where['tax_enabled'] as $type => $arr ){
						$taxonomy_enabled[ $type ] = array();

						if( is_array( $arr ) ){
							foreach( $arr as $id ){
								$taxonomy_enabled[ $type ][ $id ] = $id;
							}
						}
					}
				}

				if( isset( $where['tax_disabled'] ) && is_array( $where['tax_disabled'] ) ){
					foreach( $where['tax_disabled'] as $type => $arr ){
						$taxonomy_disabled[ $type ] = array();

						if( is_array( $arr ) ){
							foreach( $arr as $id ){
								$taxonomy_disabled[ $type ][ $id ] = $id;
							}
						}
					}
				}

				if( isset( $where['posts_enabled'] ) && is_array( $where['posts_enabled'] ) ){
					foreach( $where['posts_enabled'] as $type => $arr ){
						$publish_enabled[ $type ] = array();

						if( is_array( $arr ) ){
							foreach( $arr as $id ){
								$publish_enabled[ $type ][ $id ] = $id;
							}
						}
					}
				}

				if( isset( $where['posts_disabled'] ) && is_array( $where['posts_disabled'] ) ){
					foreach( $where['posts_disabled'] as $type => $arr ){
						$publish_disabled[ $type ] = array();

						if( is_array( $arr ) ){
							foreach( $arr as $id ){
								$publish_disabled[ $type ][ $id ] = $id;
							}
						}
					}
				}

				$dafault_block_setting['content'] = array(
					'post_types' => $post_types,
					'templates' => array(
						'404'        => boolval( $where['show_in_404'] )    ? 'true' : 'false',
						'home'       => boolval( $where['show_in_home'] )   ? 'true' : 'false',
						'archives'   => boolval( $where['show_in_cat'] )    ? 'true' : 'false',
						'categories' => boolval( $where['show_in_cat'] )    ? 'true' : 'false',
						'search'     => boolval( $where['show_in_search'] ) ? 'true' : 'false',
						'paged'      => 'true',
						'singular'   => $singular,
					),
					'restriction' => array(
						'content_less' => $old_metas['flat_pm_view']['chapter_limit'],
						'content_more' => $old_metas['flat_pm_view']['chapter_sub'],
						'title_less'   => $old_metas['flat_pm_view']['title_limit'],
						'title_more'   => $old_metas['flat_pm_view']['title_sub'],
					),
					'taxonomy_enabled'  => $taxonomy_enabled,
					'taxonomy_disabled' => $taxonomy_disabled,
					'publish_enabled'   => $publish_enabled,
					'publish_disabled'  => $publish_disabled,
				);


				// content settings

				if( isset( $old_metas['flat_pm_geo'] ) ){
					$dafault_block_setting['user']['geo'] = array(
						'enabled'  => $old_metas['flat_pm_geo']['geo_enabled'],
						'country'  => array(
							'allow'    => implode( PHP_EOL, $old_metas['flat_pm_geo']['country_enabled'] ),
							'disallow' => implode( PHP_EOL, $old_metas['flat_pm_geo']['country_disabled'] ),
						),
						'city'     => array(
							'allow'    => implode( PHP_EOL, $old_metas['flat_pm_geo']['city_enabled'] ),
							'disallow' => implode( PHP_EOL, $old_metas['flat_pm_geo']['city_disabled'] ),
						),
					);
				}

				if( isset( $old_metas['flat_pm_referer'] ) ){
					$dafault_block_setting['user']['referer'] = array(
						'enabled'  => $old_metas['flat_pm_referer']['enabled'],
						'allow'    => implode( PHP_EOL, $old_metas['flat_pm_referer']['referer_enabled'] ),
						'disallow' => implode( PHP_EOL, $old_metas['flat_pm_referer']['referer_disabled'] ),
					);
				}

				if( isset( $old_metas['flat_pm_browser'] ) ){
					$dafault_block_setting['user']['browser'] = array(
						'enabled'  => $old_metas['flat_pm_browser']['enabled'],
						'allow'    => $old_metas['flat_pm_browser']['browser_enabled'],
						'disallow' => $old_metas['flat_pm_browser']['browser_disabled'],
					);
				}

				if( isset( $old_metas['flat_pm_os'] ) ){
					$dafault_block_setting['user']['os'] = array(
						'enabled'  => $old_metas['flat_pm_os']['enabled'],
						'allow'    => $old_metas['flat_pm_os']['os_enabled'],
						'disallow' => $old_metas['flat_pm_os']['os_disabled'],
					);
				}

				if( isset( $old_metas['flat_pm_utmget'] ) ){
					if( isset( $old_metas['flat_pm_utmget']['enabled'] ) ){
						$dafault_block_setting['user']['utm']['enabled'] = $old_metas['flat_pm_utmget']['enabled'];
					}
					if( isset( $old_metas['flat_pm_utmget']['utmget_enabled'] ) ){
						$dafault_block_setting['user']['utm']['allow'] = str_replace( ':', '=', implode( PHP_EOL, $old_metas['flat_pm_utmget']['utmget_enabled'] ) );
					}
					if( isset( $old_metas['flat_pm_utmget']['utmget_disabled'] ) ){
						$dafault_block_setting['user']['utm']['disallow'] = str_replace( ':', '=', implode( PHP_EOL, $old_metas['flat_pm_utmget']['utmget_disabled'] ) );
					}
				}

				if( isset( $old_metas['flat_pm_cookies'] ) ){
					if( isset( $old_metas['flat_pm_cookies']['enabled'] ) ){
						$dafault_block_setting['user']['cookies']['enabled'] = $old_metas['flat_pm_cookies']['enabled'];
					}
					if( isset( $old_metas['flat_pm_cookies']['cookies_enabled'] ) ){
						$dafault_block_setting['user']['cookies']['allow'] = str_replace( ':', '=', implode( PHP_EOL, $old_metas['flat_pm_cookies']['cookies_enabled'] ) );
					}
					if( isset( $old_metas['flat_pm_cookies']['cookies_disabled'] ) ){
						$dafault_block_setting['user']['cookies']['disallow'] = str_replace( ':', '=', implode( PHP_EOL, $old_metas['flat_pm_cookies']['cookies_disabled'] ) );
					}
				}

				if( isset( $old_metas['flat_pm_role'] ) ){
					$allow = ( isset( $old_metas['flat_pm_role']['role_enabled'] ) ) ? array_keys( $old_metas['flat_pm_role']['role_enabled'] ) : array();
					$disallow = ( isset( $old_metas['flat_pm_role']['role_disabled'] ) ) ? array_keys( $old_metas['flat_pm_role']['role_disabled'] ) : array();

					$dafault_block_setting['user']['role'] = array(
						'enabled'  => $old_metas['flat_pm_role']['enabled'],
						'allow'    => $allow,
						'disallow' => $disallow,
					);
				}

				if( isset( $old_metas['flat_pm_ip'] ) ){
					$dafault_block_setting['user']['ip'] = array(
						'enabled'  => $old_metas['flat_pm_ip']['enabled'],
					);
				}

				$update = flat_pm_block_update( NULL, $dafault_block_setting );

				if( $update ){
					foreach( $keys as $key ){
						delete_post_meta( (int) $current['id'], $key );
					}
				}else{
					die( json_encode( array(
						'method' => $method,
						'data' => array(
							'message' => __( 'Something went wrong while migrating a block!', 'flatpm_l10n' ),
							'status' => 'error',
							'done' => $is_done,
							'id' => $meta['li_current']['id']
						)
					) ) );
				}

				break;

			case 'folder':
				$message = 'folder id: ' . $current['id'];

				$folder_obj = get_term( (int) $current['id'] );

				global $dafault_folder_setting;

				$old_metas = array();

				$keys = array(
					'flat_pm_folder_enabled',

					'flat_pm_view',

					'flat_pm_geo',
					'flat_pm_role',
					'flat_pm_os',
					'flat_pm_cookies',
					'flat_pm_utmget',
					'flat_pm_ip',
					'flat_pm_referer',
					'flat_pm_browser',
				);

				foreach( $keys as $key ){
					$all_meta = get_term_meta( (int) $current['id'], $key, true );

					if( $all_meta ){
						$old_metas[ $key ] = $all_meta;
					}
				}


				// global settings

				$dafault_folder_setting['name'] = $folder_obj->name;

				$dafault_folder_setting['id']     = (int) $current['id'];
				$dafault_folder_setting['turned'] = boolval( $old_metas['flat_pm_folder_enabled'] ) ? 'true' : 'false';


				// content settings

				$where = $old_metas['flat_pm_view']['where'];

				$post_types = array();
				if( isset( $where['type_of_posts'] ) && is_array( $where['type_of_posts'] ) ){
					foreach( $where['type_of_posts'] as $type ){
						$post_types[ $type ] = 'true';
					}
				}else{
					$post_types = array();
				}

				$taxonomy_enabled  = array();
				$taxonomy_disabled = array();
				$publish_enabled   = array();
				$publish_disabled  = array();

				if( isset( $where['tax_enabled'] ) && is_array( $where['tax_enabled'] ) ){
					foreach( $where['tax_enabled'] as $type => $arr ){
						$taxonomy_enabled[ $type ] = array();

						if( is_array( $arr ) ){
							foreach( $arr as $id ){
								$taxonomy_enabled[ $type ][ $id ] = $id;
							}
						}
					}
				}

				if( isset( $where['tax_disabled'] ) && is_array( $where['tax_disabled'] ) ){
					foreach( $where['tax_disabled'] as $type => $arr ){
						$taxonomy_disabled[ $type ] = array();

						if( is_array( $arr ) ){
							foreach( $arr as $id ){
								$taxonomy_disabled[ $type ][ $id ] = $id;
							}
						}
					}
				}

				if( isset( $where['posts_enabled'] ) && is_array( $where['posts_enabled'] ) ){
					foreach( $where['posts_enabled'] as $type => $arr ){
						$publish_enabled[ $type ] = array();

						if( is_array( $arr ) ){
							foreach( $arr as $id ){
								$publish_enabled[ $type ][ $id ] = $id;
							}
						}
					}
				}

				if( isset( $where['posts_disabled'] ) && is_array( $where['posts_disabled'] ) ){
					foreach( $where['posts_disabled'] as $type => $arr ){
						$publish_disabled[ $type ] = array();

						if( is_array( $arr ) ){
							foreach( $arr as $id ){
								$publish_disabled[ $type ][ $id ] = $id;
							}
						}
					}
				}

				$dafault_folder_setting['content']['post_types']        = $post_types;
				$dafault_folder_setting['content']['taxonomy_enabled']  = $taxonomy_enabled;
				$dafault_folder_setting['content']['taxonomy_disabled'] = $taxonomy_disabled;
				$dafault_folder_setting['content']['publish_enabled']   = $publish_enabled;
				$dafault_folder_setting['content']['publish_disabled']  = $publish_disabled;


				// content settings

				if( isset( $old_metas['flat_pm_geo'] ) ){
					$dafault_folder_setting['user']['geo'] = array(
						'enabled'  => $old_metas['flat_pm_geo']['geo_enabled'],
						'country'  => array(
							'allow'    => implode( PHP_EOL, $old_metas['flat_pm_geo']['country_enabled'] ),
							'disallow' => implode( PHP_EOL, $old_metas['flat_pm_geo']['country_disabled'] ),
						),
						'city'     => array(
							'allow'    => implode( PHP_EOL, $old_metas['flat_pm_geo']['city_enabled'] ),
							'disallow' => implode( PHP_EOL, $old_metas['flat_pm_geo']['city_disabled'] ),
						),
					);
				}

				if( isset( $old_metas['flat_pm_referer'] ) ){
					$dafault_folder_setting['user']['referer'] = array(
						'enabled'  => $old_metas['flat_pm_referer']['enabled'],
						'allow'    => implode( PHP_EOL, $old_metas['flat_pm_referer']['referer_enabled'] ),
						'disallow' => implode( PHP_EOL, $old_metas['flat_pm_referer']['referer_disabled'] ),
					);
				}

				if( isset( $old_metas['flat_pm_browser'] ) ){
					$dafault_folder_setting['user']['browser'] = array(
						'enabled'  => $old_metas['flat_pm_browser']['enabled'],
						'allow'    => $old_metas['flat_pm_browser']['browser_enabled'],
						'disallow' => $old_metas['flat_pm_browser']['browser_disabled'],
					);
				}

				if( isset( $old_metas['flat_pm_os'] ) ){
					$dafault_folder_setting['user']['os'] = array(
						'enabled'  => $old_metas['flat_pm_os']['enabled'],
						'allow'    => $old_metas['flat_pm_os']['os_enabled'],
						'disallow' => $old_metas['flat_pm_os']['os_disabled'],
					);
				}

				if( isset( $old_metas['flat_pm_utmget'] ) ){
					if( isset( $old_metas['flat_pm_utmget']['enabled'] ) ){
						$dafault_folder_setting['user']['utm']['enabled'] = $old_metas['flat_pm_utmget']['enabled'];
					}
					if( isset( $old_metas['flat_pm_utmget']['utmget_enabled'] ) ){
						$dafault_folder_setting['user']['utm']['allow'] = implode( PHP_EOL, $old_metas['flat_pm_utmget']['utmget_enabled'] );
					}
					if( isset( $old_metas['flat_pm_utmget']['utmget_disabled'] ) ){
						$dafault_folder_setting['user']['utm']['disallow'] = implode( PHP_EOL, $old_metas['flat_pm_utmget']['utmget_disabled'] );
					}
				}

				if( isset( $old_metas['flat_pm_cookies'] ) ){
					$dafault_folder_setting['user']['cookies'] = array(
						'enabled'  => $old_metas['flat_pm_cookies']['enabled'],
						'allow'    => implode( PHP_EOL, $old_metas['flat_pm_cookies']['cookies_enabled'] ),
						'disallow' => implode( PHP_EOL, $old_metas['flat_pm_cookies']['cookies_disabled'] ),
					);
				}

				if( isset( $old_metas['flat_pm_role'] ) ){
					$allow = ( isset( $old_metas['flat_pm_role']['role_enabled'] ) ) ? array_keys( $old_metas['flat_pm_role']['role_enabled'] ) : array();
					$disallow = ( isset( $old_metas['flat_pm_role']['role_disabled'] ) ) ? array_keys( $old_metas['flat_pm_role']['role_disabled'] ) : array();

					$dafault_folder_setting['user']['role'] = array(
						'enabled'  => $old_metas['flat_pm_role']['enabled'],
						'allow'    => $allow,
						'disallow' => $disallow,
					);
				}

				if( isset( $old_metas['flat_pm_ip'] ) ){
					$dafault_folder_setting['user']['ip'] = array(
						'enabled'  => $old_metas['flat_pm_ip']['enabled'],
					);
				}

				$update = flat_pm_folder_update( NULL, $dafault_folder_setting );

				if( $update ){
					foreach( $keys as $key ){
						delete_term_meta( (int) $current['id'], $key );
					}
				}else{
					die( json_encode( array(
						'method' => $method,
						'data' => array(
							'message' => __( 'Something went wrong while migrating a folder!', 'flatpm_l10n' ),
							'status' => 'error',
							'done' => $is_done,
							'id' => $meta['li_current']['id']
						)
					) ) );
				}

				break;

			default:
				die( json_encode( array(
					'method' => $method,
					'data' => array(
						'message' => __( 'Wrong migration type!', 'flatpm_l10n' ),
						'status' => 'error',
						'done' => $is_done,
						'id' => $meta['li_current']['id']
					)
				) ) );

				break;
		}

		$message = ( $is_done ) ? __( 'The migration process is complete!', 'flatpm_l10n' ) : $message;

		die( json_encode( array(
			'method' => $method,
			'data' => array(
				'message' => $message,
				'status' => 'success',
				'done' => $is_done,
				'id' => $meta['li_current']['id']
			)
		) ) );
	}
}