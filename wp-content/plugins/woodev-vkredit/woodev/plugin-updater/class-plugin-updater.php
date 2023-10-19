<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'WD_Plugin_Updater' ) ) :
	
	class WD_Plugin_Updater {

		private $api_url;
		
		private $api_data = array();
		
		private $plugin_file;
		
		private $name;
		
		private $slug;
		
		private $version;
		
		private $wp_override = false;
		
		private $cache_key;
		
		private $api_url_available = array();
		
		public function __construct( $_plugin_file, $_api_data, $_api_url = 'https://woodev.ru/' ) {
			global $woodev_plugin_data;

			$this->api_url     = trailingslashit( $_api_url );
			$this->api_data    = $_api_data;
			$this->plugin_file = $_plugin_file;
			$this->name        = plugin_basename( $_plugin_file );
			$this->slug        = basename( $_plugin_file, '.php' );
			$this->version     = $_api_data['version'];
			$this->wp_override = isset( $_api_data['wp_override'] ) ? (bool) $_api_data['wp_override'] : false;
			$this->beta        = ! empty( $this->api_data['beta'] ) ? true : false;
			$this->cache_key   = 'woodev_sl_' . md5( serialize( $this->slug . $this->api_data['license'] . $this->beta ) );

			$woodev_plugin_data[ $this->slug ] = $this->api_data;
			
			$this->init();
		}
		
		public function init() {

			add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_update' ) );

			add_filter( 'plugins_api', array( $this, 'plugins_api_filter' ), 10, 3 );

			remove_action( "after_plugin_row_{$this->name}", 'wp_plugin_update_row', 10 );

			add_action( "after_plugin_row_{$this->name}", array( $this, 'show_update_notification' ), 10, 2 );
			add_action( 'admin_init', array( $this, 'show_changelog' ) );
		}
		
		public function check_update( $_transient_data ) {
			global $pagenow;

			if ( ! is_object( $_transient_data ) ) {
				$_transient_data = new stdClass;
			}

			if ( 'plugins.php' === $pagenow && is_multisite() ) {
				return $_transient_data;
			}

			if ( ! empty( $_transient_data->response ) && ! empty( $_transient_data->response[ $this->name ] ) && false === $this->wp_override ) {
				return $_transient_data;
			}

			$version_info = $this->get_cached_version_info();

			if ( false === $version_info ) {

				$version_info = $this->api_request( 'plugin_latest_version', array( 'slug' => $this->slug, 'beta' => $this->beta ) );

				$this->set_version_info_cache( $version_info );
			}

			if ( false !== $version_info && is_object( $version_info ) && isset( $version_info->new_version ) ) {

				if ( version_compare( $this->version, $version_info->new_version, '<' ) ) {
					$_transient_data->response[ $this->name ] = $version_info;
				}

				$_transient_data->last_checked           = current_time( 'timestamp' );
				$_transient_data->checked[ $this->name ] = $this->version;
			}

			return $_transient_data;
		}
		
		public function show_update_notification( $file, $plugin ) {

			if ( is_network_admin() || ! is_multisite() || ! current_user_can( 'update_plugins' ) || $this->name != $file ) {
				return;
			}
			
			remove_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_update' ), 10 );

			$update_cache = get_site_transient( 'update_plugins' );
			$update_cache = is_object( $update_cache ) ? $update_cache : new stdClass();

			if ( empty( $update_cache->response ) || empty( $update_cache->response[ $this->name ] ) ) {

				$version_info = $this->get_cached_version_info();

				if ( false === $version_info ) {

					$version_info = $this->api_request( 'plugin_latest_version', array( 'slug' => $this->slug, 'beta' => $this->beta ) );
					
					if ( isset( $version_info->banners ) && ! is_array( $version_info->banners ) ) {
						$version_info->banners = $this->convert_object_to_array( $version_info->banners );
					}

					if ( isset( $version_info->sections ) && ! is_array( $version_info->sections ) ) {
						$version_info->sections = $this->convert_object_to_array( $version_info->sections );
					}

					if ( isset( $version_info->icons ) && ! is_array( $version_info->icons ) ) {
						$version_info->icons = $this->convert_object_to_array( $version_info->icons );
					}

					$this->set_version_info_cache( $version_info );
				}

				if ( ! is_object( $version_info ) ) {
					return;
				}

				if ( version_compare( $this->version, $version_info->new_version, '<' ) ) {
					$update_cache->response[ $this->name ] = $version_info;
				}

				$update_cache->last_checked           = current_time( 'timestamp' );
				$update_cache->checked[ $this->name ] = $this->version;

				set_site_transient( 'update_plugins', $update_cache );

			} else {
				$version_info = $update_cache->response[ $this->name ];
			}
			
			add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_update' ) );

			if ( ! empty( $update_cache->response[ $this->name ] ) && version_compare( $this->version, $version_info->new_version, '<' ) ) {
			
				$wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );
				
				echo '<tr class="plugin-update-tr" id="' . $this->slug . '-update" data-slug="' . $this->slug . '" data-plugin="' . $this->slug . '/' . $file . '">';
				echo '<td colspan="3" class="plugin-update colspanchange">';
				echo '<div class="update-message notice inline notice-warning notice-alt">';

				$changelog_link = self_admin_url( 'index.php?edd_sl_action=view_plugin_changelog&plugin=' . $this->name . '&slug=' . $this->slug . '&TB_iframe=true&width=772&height=911' );

				if ( empty( $version_info->download_link ) ) {

					printf(
						'Доступна новая версия для %1$s. %2$sПосмотерть детали версии %3$s%4$s.',
						esc_html( $version_info->name ),
						'<a target="_blank" class="thickbox" href="' . esc_url( $changelog_link ) . '">',
						esc_html( $version_info->new_version ),
						'</a>'
					);

				} else {

					printf(
						'Доступна новая версия для %1$s. %2$sПосмотреть детали версии %3$s%4$s или %5$sобновить сейчас%6$s.',
						esc_html( $version_info->name ),
						'<a target="_blank" class="thickbox" href="' . esc_url( $changelog_link ) . '">',
						esc_html( $version_info->new_version ),
						'</a>',
						'<a href="' . esc_url( wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $this->name, 'upgrade-plugin_' . $this->name ) ) .'">',
						'</a>'
					);
				}

				do_action( "in_plugin_update_message-{$file}", $plugin, $version_info );

				echo '</div></td></tr>';
			}
		}
		
		public function plugins_api_filter( $_data, $_action = '', $_args = null ) {

			if ( $_action !== 'plugin_information' || ! isset( $_args->slug ) || ( $_args->slug !== $this->slug ) ) {
				return $_data;
			}

			$to_send = array(
				'slug'   => $this->slug,
				'is_ssl' => is_ssl(),
				'fields' => array(
					'banners' => array(),
					'reviews' => false
				)
			);

			$cache_key = 'woodev_api_request_' . md5( serialize( $this->slug . $this->api_data['license'] . $this->beta ) );
			
			$api_request_transient = $this->get_cached_version_info( $cache_key );
			
			if ( empty( $api_request_transient ) ) {

				$api_response = $this->api_request( 'plugin_information', $to_send );
				
				$this->set_version_info_cache( $api_response, $cache_key );

				if ( false !== $api_response ) {
					$_data = $api_response;
				}

			} else {
				$_data = $api_request_transient;
			}
			
			if ( isset( $_data->sections ) && ! is_array( $_data->sections ) ) {
				$_data->sections = $this->convert_object_to_array( $_data->sections );
			}

			if ( isset( $_data->banners ) && ! is_array( $_data->banners ) ) {
				$_data->banners = $this->convert_object_to_array( $_data->banners );
			}

			if ( isset( $_data->icons ) && ! is_array( $_data->icons ) ) {
				$_data->icons = $this->convert_object_to_array( $_data->icons );
			}

			return $_data;
		}
		
		public function http_request_args( $args, $url ) {

			$verify_ssl = $this->verify_ssl();

			if ( strpos( $url, 'https://' ) !== false && strpos( $url, 'edd_action=package_download' ) ) {
				$args['sslverify'] = $verify_ssl;
			}

			return $args;
		}
		
		private function api_request( $_action, $_data ) {

			$data = array_merge( $this->api_data, $_data );

			if ( $data['slug'] !== $this->slug || ! $this->api_status_check() ) {
				return false;
			}

			if ( $this->api_url == trailingslashit( home_url() ) ) {
				return false;
			}

			$api_params = array(
				'edd_action' => 'get_version',
				'license'    => ! empty( $data['license'] ) ? $data['license'] : '',
				'item_name'  => isset( $data['item_name'] ) ? $data['item_name'] : false,
				'item_id'    => isset( $data['item_id'] ) ? $data['item_id'] : false,
				'version'    => isset( $data['version'] ) ? $data['version'] : false,
				'slug'       => $data['slug'],
				'author'     => $data['author'],
				'url'        => home_url(),
				'beta'       => ! empty( $data['beta'] ),
			);

			$request = wp_remote_post( $this->api_url, array(
				'timeout'   => 25,
				'sslverify' => $this->verify_ssl(),
				'body'      => $api_params,
			) );

			if ( ! is_wp_error( $request ) ) {
				$request = json_decode( wp_remote_retrieve_body( $request ) );
			}

			if ( $request && isset( $request->sections ) ) {
				$request->sections = maybe_unserialize( $request->sections );
			} else {
				$request = false;
			}

			if ( $request && isset( $request->banners ) ) {
				$request->banners = maybe_unserialize( $request->banners );
			}

			if ( $request && isset( $request->icons ) ) {
				$request->icons = maybe_unserialize( $request->icons );
			}
			
			$custom_icons = apply_filters( "woodev_plugin_updater_{$this->name}_icon", array(
				'1x' => plugin_dir_url( __FILE__ ) . 'assets/img/plugin-icon-128.png',
				'2x' => plugin_dir_url( __FILE__ ) . 'assets/img/plugin-icon-256.png'
			), $request );

			if ( ! empty( $custom_icons ) ) {
				$request->icons = (array) $custom_icons;
			}

			if ( ! empty( $request->sections ) ) {

				foreach ( $request->sections as $key => $section ) {
					$request->$key = (array) $section;
				}
			}

			return $request;
		}
		
		protected function api_status_check() {
		
			$store_hash = md5( $this->api_url );

			if ( ! is_array( $this->api_url_available ) || ! isset( $this->api_url_available[ $store_hash ] ) ) {

				$test_url_parts = parse_url( $this->api_url );

				$scheme = ! empty( $test_url_parts['scheme'] ) ? $test_url_parts['scheme']     : 'http';
				$host   = ! empty( $test_url_parts['host'] )   ? $test_url_parts['host']       : '';
				$port   = ! empty( $test_url_parts['port'] )   ? ':' . $test_url_parts['port'] : '';

				if ( empty( $host ) ) {

					$this->api_url_available[ $store_hash ] = false;

				} else {

					$test_url = "{$scheme}://{$host}{$port}";
					$response = wp_remote_get( $test_url, array(
						'timeout'   => 25,
						'sslverify' => $this->verify_ssl(),
					) );

					$this->api_url_available[ $store_hash ] = ! is_wp_error( $response );
				}
			}

			return $this->api_url_available[ $store_hash ];
		}
		
		public function show_changelog() {
			global $woodev_plugin_data;

			if ( empty( $_REQUEST['edd_sl_action'] ) || 'view_plugin_changelog' != $_REQUEST['edd_sl_action'] ) {
				return;
			}

			if ( empty( $_REQUEST['plugin'] ) || empty( $_REQUEST['slug'] ) ) {
				return;
			}

			if ( ! current_user_can( 'update_plugins' ) ) {
				wp_die( 'У вас нету полномочий на обновление плагинов.', 'Ошибка', array( 'response' => 403 ) );
			}

			$data         = $woodev_plugin_data[ $_REQUEST['slug'] ];
			$beta         = ! empty( $data['beta'] ) ? true : false;
			$cache_key    = md5( 'woodev_plugin_' . sanitize_key( $_REQUEST['plugin'] ) . '_' . $beta . '_version_info' );
			$version_info = $this->get_cached_version_info( $cache_key );

			if ( false === $version_info ) {

				$api_params = array(
					'edd_action' => 'get_version',
					'item_name'  => isset( $data['item_name'] ) ? $data['item_name'] : false,
					'item_id'    => isset( $data['item_id'] ) ? $data['item_id'] : false,
					'slug'       => $_REQUEST['slug'],
					'author'     => $data['author'],
					'url'        => home_url(),
					'beta'       => ! empty( $data['beta'] )
				);

				$request = wp_remote_post( $this->api_url, array(
					'timeout'   => 25,
					'sslverify' => $this->verify_ssl(),
					'body'      => $api_params,
				) );

				if ( ! is_wp_error( $request ) ) {
					$version_info = json_decode( wp_remote_retrieve_body( $request ) );
				}

				if ( ! empty( $version_info ) && isset( $version_info->sections ) ) {
					$version_info->sections = maybe_unserialize( $version_info->sections );
				} else {
					$version_info = false;
				}

				if ( ! empty( $version_info ) ) {

					foreach( $version_info->sections as $key => $section ) {
						$version_info->$key = (array) $section;
					}
				}

				$this->set_version_info_cache( $version_info, $cache_key );
			}

			if ( ! empty( $version_info ) && isset( $version_info->sections['changelog'] ) ) {
				echo '<div style="background:#fff;padding:10px;">' . $version_info->sections['changelog'] . '</div>';
			}

			exit;
		}
		
		private function convert_object_to_array( $data ) {

			$new_data = array();

			foreach ( $data as $key => $value ) {
				$new_data[ $key ] = $value;
			}

			return $new_data;
		}
		
		public function get_cached_version_info( $cache_key = '' ) {

			if ( empty( $cache_key ) ) {
				$cache_key = $this->cache_key;
			}

			$cache = get_option( $cache_key );

			if ( empty( $cache['timeout'] ) || current_time( 'timestamp' ) > $cache['timeout'] ) {
				return false;
			}


			return json_decode( $cache['value'] );
		}
		
		public function set_version_info_cache( $value = '', $cache_key = '' ) {

			if ( empty( $cache_key ) ) {
				$cache_key = $this->cache_key;
			}
			
			if( ! is_object( $value ) ) {
				$value = new stdClass;
			}
			
			$custom_icons = apply_filters( "woodev_plugin_updater_{$this->name}_icon", array(
				'1x' => plugin_dir_url( __FILE__ ) . 'assets/img/plugin-icon-128.png',
				'2x' => plugin_dir_url( __FILE__ ) . 'assets/img/plugin-icon-256.png',
			), $value );

			if ( ! empty( $custom_icons ) ) {
				$value->icons = (array) $custom_icons;
			}

			$data = array(
				'timeout' => strtotime( '+3 hours', current_time( 'timestamp' ) ),
				'value'   => json_encode( $value )
			);

			update_option( $cache_key, $data, 'no' );
		}
		
		private function verify_ssl() {
			return (bool) apply_filters( 'woodev_sl_api_request_verify_ssl', true, $this );
		}
	}

endif;
