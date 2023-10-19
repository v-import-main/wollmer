<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Plugins_License' ) ) :

	class Woodev_Plugins_License {

		protected $api_url;
		
		protected $file;
		
		protected $plugin_url;
		
		protected $item_name;
		
		protected $item_id;
		
		protected $version;
		
		protected $author;
		
		private $item_shortname;
		
		private $license;
		
		protected $updater_url = 'https://woodev.ru/';
		
		protected $settings;
		
		public function __construct( $_file, $_path, $_plugin_url, $_item_name, $_version, $_item_id, $_author = 'Woodev' ) {

			$this->api_url        = $this->updater_url;
			$this->file           = $_file;
			$this->path           = $_path;
			$this->plugin_url     = $_plugin_url;
			$this->item_id        = absint( $_item_id );
			$this->item_name      = $_item_name;
			$this->version        = $_version;
			$this->author         = $_author;
			$this->item_shortname = $this->get_short_name( $this->item_name );
			$this->license        = trim( get_option( "{$this->item_shortname}_license_key", '' ) );

			$this->includes();
			$this->add_hooks();
			
			if ( $this->get_license() ) {
				$this->maybe_validate_key();
			}
			
		}
		
		public function get_license() {
			return ! empty( $this->license ) ? $this->license : false;
		}
		
		public function get_short_name( $name ) {
			if( ! class_exists( 'Woodev_Helper' ) ) {
				require_once( $this->path . '/woodev/class-helper.php' );
			}
			
			return preg_replace( '/[^a-zA-Z0-9_\s]/', '', str_replace( ' ', '_', strtolower( Woodev_Helper::str_convert( $name ) ) ) );
		}
		
		public function includes() {
			if ( ! class_exists( 'Woodev_License_Settings' ) ) {
				require_once( plugin_dir_path( __FILE__ ) . 'class-plugin-license-settings.php' );
				$this->settings = new Woodev_License_Settings( $this->plugin_url );
			}

			if ( ! class_exists( 'WD_Plugin_Updater' ) ) {
				require_once( plugin_dir_path( __FILE__ ) . 'class-plugin-updater.php' );
			}
		}
		
		private function add_hooks() {
		
			add_action( 'admin_init', array( $this, 'auto_updater' ), 0 );
			
			add_filter( 'cron_schedules', array( $this, 'add_cron_schedule' ) );
			add_action( 'wp', array( $this, 'schedule_events' ) );
			
			add_filter( 'woodev_plugin_license_settings', array( $this, 'add_settings' ), 1 );
			
			add_action( 'admin_enqueue_scripts', array( $this, 'add_styles' ) );
			
			add_action( 'admin_init', array( $this, 'activate_license' ) );
			
			add_action( 'admin_init', array( $this, 'deactivate_license' ) );
			
			add_action( 'woodev_weekly_scheduled_events', array( $this, 'weekly_license_check' ) );
			
			add_action( 'admin_notices', array( $this, 'notices' ) );

			add_action( 'in_plugin_update_message-' . plugin_basename( $this->file ), array( $this, 'plugin_row_license_missing' ), 10, 2 );
		}
		
		public function auto_updater() {
			
			$license = $this->get_license();
			
			if( $license ) {
				
				$data = array(
					'version' => $this->version,
					'license' => $license,
					'author'  => $this->author,
				);

				if ( ! empty( $this->item_id ) ) {
					$data['item_id'] = $this->item_id;
				} else {
					$data['item_name'] = $this->item_name;
				}
				
				new WD_Plugin_Updater( $this->file, $data );
			}
		}
		
		public function add_cron_schedule( $schedules = array() ) {
		
			$schedules['weekly'] = array(
				'interval' => 604800,
				'display'  => 'Раз в неделю',
			);

			return $schedules;
		}
		
		public function schedule_events() {

			if ( ! wp_next_scheduled( 'woodev_weekly_scheduled_events' ) ) {
				wp_schedule_event( current_time( 'timestamp', true ), 'weekly', 'woodev_weekly_scheduled_events' );
			}
		}
		
		public function add_settings( $settings ) {

			$plugin_license_settings = array(
				array(
					'id'      => "{$this->item_shortname}_license_key",
					'name'    => $this->item_name,
					'desc'    => '',
					'type'    => 'license_key',
					'options' => array( 'is_valid_license_option' => "{$this->item_shortname}_license_active" ),
					'size'    => 'regular',
				)
			);

			return array_merge( $settings, $plugin_license_settings );
		}
		
		public function add_styles() {
			wp_enqueue_style( 'woodev-plugin-license-settings', plugin_dir_url( __FILE__ ) . 'assets/css/woodev-updater-styles.css', array(), $this->version );
		}
		
		public function dispatch_license( $action = 'check_license', $license = '' ) {
			
			if( ! in_array( $action, array( 'activate_license', 'deactivate_license', 'check_license', 'get_version' ) ) ) {
				return false;
			}
			
			$data = array(
				'timeout' 	=> 25,
				'sslverify'	=> apply_filters( 'woodev_sl_api_request_verify_ssl', true ),
				'body'    	=> array(
					'edd_action' => $action,
					'license'    => $license,
					'item_id'    => absint( $this->item_id ),
					'url'        => home_url(),
					'beta'		 => false
				),
			);
			
			$response = wp_remote_post( $this->api_url, $data );
			
			if ( is_wp_error( $response ) ) {
				return false;
			}
			
			return json_decode( wp_remote_retrieve_body( $response ) );
		}
		
		public function activate_license() {

			if ( ! isset( $_REQUEST["{$this->item_shortname}_license_key-nonce"] ) || ! wp_verify_nonce( $_REQUEST["{$this->item_shortname}_license_key-nonce"], "{$this->item_shortname}_license_key-nonce" ) || ! current_user_can( 'manage_options' ) ) {
				return;
			}

			if ( empty( $_POST["{$this->item_shortname}_license_key"] ) ) {
				delete_option( "{$this->item_shortname}_license_active" );
				return;
			}
			
			foreach ( $_POST as $key => $value ) {
				if ( false !== strpos( $key, 'license_key_deactivate' ) ) {
					return;
				}
			}

			$details = get_option( "{$this->item_shortname}_license_active" );

			if ( is_object( $details ) && 'valid' === $details->license ) {
				return;
			}

			$license = sanitize_text_field( $_POST["{$this->item_shortname}_license_key"] );

			if ( empty( $license ) ) {
				return;
			}
			
			$license_data = $this->dispatch_license( 'activate_license', $license );
			
			if( ! $license_data ) {
				return;
			}
			
			set_site_transient( 'update_plugins', null );

			update_option( "{$this->item_shortname}_license_active", $license_data );
			
			$license_options = array(
				'key'			=> $license,
				'is_expired'	=> false,
				'is_disabled'	=> false,
				'is_invalid'	=> false
			);
			
			if( isset( $license_data->data ) ) {
				$license_options['data'] = $license_data->data;
			}
			
			update_option( "{$this->item_shortname}_license", $license_options );
		}
		
		public function update_license( $license = '' ) {	
			return $this->dispatch_license( 'check_license', trim( $license ) );
		}
		
		public function deactivate_license( $ajax = false ) {

			if ( ! isset( $_POST["{$this->item_shortname}_license_key"] ) || ! current_user_can( 'manage_options' ) ) {
				return;
			}

			if ( ! wp_verify_nonce( $_REQUEST["{$this->item_shortname}_license_key-nonce"], "{$this->item_shortname}_license_key-nonce" ) ) {
				wp_die( 'Ключи запроса не совпадают.', 'Ошибка', array( 'response' => 403 ) );
			}
			
			if ( isset( $_POST["{$this->item_shortname}_license_key_deactivate"] ) ) {
				
				$license_data = $this->dispatch_license( 'deactivate_license', $this->license );
				
				if ( ! $license_data ) {
					return;
				}

				delete_option( "{$this->item_shortname}_license_active" );
				delete_option( "{$this->item_shortname}_license" );
				delete_transient( '_woodev_addons' );
				
				if ( $license_data->success && $ajax ) {
					wp_send_json_success( 'Вы успешно деактивировали ключ с этого сайта.' );
				}
			}
		}
		
		public function is_license_valid() {

			$details = get_option( "{$this->item_shortname}_license_active" );

			return is_object( $details ) && 'valid' === $details->license;
		}
		
		public function weekly_license_check() {

			if ( ! empty( $_POST["{$this->item_shortname}_license_key"] ) ) {
				return false;
			}

			if ( empty( $this->license ) ) {
				return false;
			}
			
			$license_data = $this->update_license( $this->license );

			if( ! $license_data ) {
				update_option( "{$this->item_shortname}_license_active", $license_data );
			}
		}
		
		public function notices() {
			global $current_screen;

			static $showed_invalid_message = false;

			$prefix  = sanitize_title( 'Woodev' );
			$screens = array( "{$prefix}_page_woodev-licenses", "{$prefix}_page_woodev-plugins", "{$prefix}_page_woodev-settings", 'plugins' );
			$key     = trim( get_option( "{$this->item_shortname}_license_key", '' ) );

			if ( empty( $key ) || ! current_user_can( 'manage_options' ) ) {
				return;
			}

			$messages = array();
			$license  = get_option( "{$this->item_shortname}_license_active" );

			if ( in_array( $current_screen->id, $screens, true ) && is_object( $license ) && 'valid' !== $license->license && ! $showed_invalid_message ) {
			
				$messages[] = sprintf(
					'У плагина %3$s неверный или закончился срок действия лицензионного ключа. Пожалуйста %1$sперейдите на страницу лицензий%2$s что бы исправить это.',
					'<a href="' . $this->get_license_settings_url() . '">',
					'</a>',
					$this->item_name
				);

				$showed_invalid_message = true;
			}

			if ( ! empty( $messages ) ) {

				foreach( $messages as $message ) {
					echo '<div class="error"><p>' . $message . '</p></div>';
				}
			}
		}
		
		public function plugin_row_license_missing( $plugin_data, $version_info ) {

			static $showed_missing_key_message = array();

			$license = get_option( "{$this->item_shortname}_license_active" );

			if ( ( ! is_object( $license ) || 'valid' !== $license->license ) && empty( $showed_missing_key_message[ $this->item_shortname ] ) ) {

				echo '&nbsp;<strong><a href="' . esc_url( $this->get_license_settings_url() ) . '">Введите лицензионный ключ для автоматического обновления.</a></strong>';
				$showed_missing_key_message[ $this->item_shortname ] = true;
			}
		}
		
		public function get_license_settings_url() {
			return admin_url( 'admin.php?page=woodev-licenses' );
		}
		
		public function get_license_settings_instance() {
			return $this->settings;
		}
		
		public function maybe_validate_key() {

			$license = $this->get_license();

			if ( ! $license ) {
				return;
			}

			$timestamp = get_option( "{$this->item_shortname}_license_updates" );

			if ( ! $timestamp ) {
				$timestamp = strtotime( '+24 hours' );
				update_option( "{$this->item_shortname}_license_updates", $timestamp );
				$this->validate_license( $license );
			} else {
				$current_timestamp = time();
				if ( $current_timestamp < $timestamp ) {
					return;
				} else {
					update_option( "{$this->item_shortname}_license_updates", strtotime( '+24 hours' ) );
					$this->validate_license( $license );
				}
			}
		}
		
		public function verify_license( $license = '', $ajax = false ) {

			if ( empty( $license ) ) {
				return false;
			}
			
			$verify = $this->dispatch_license( 'check_license', trim( $license ) );
			
			if ( ! $verify ) {
				$message = 'Во время проверки лицензии произошла ошибка соединения с сервером API. Пожалуйста, попробуйте ещё раз.';
				if ( $ajax ) {
					wp_send_json_error( $message );
				} else {
					$this->errors[] = $message;
					return false;
				}
			}
			
			if ( ( isset( $verify->success ) && false === $verify->success ) && ! empty( $verify->error ) ) {
				if ( $ajax ) {
					wp_send_json_error( $verify->error );
				} else {
					$this->errors[] = $verify->error;
					return false;
				}
			}

			$success = isset( $verify->success ) ? $verify->success : 'Поздравляем! Ваша лицензия действительна. Вы можете получать обновления на этом сайте.';
			
			$option                = ( array ) get_option( "{$this->item_shortname}_license", array() );
			$option['key']         = $license;
			$option['is_expired']  = false;
			$option['is_disabled'] = false;
			$option['is_invalid']  = false;
			
			if( isset( $verify->data ) ) {
				$option['data'] = $verify->data;
			}
			
			update_option( "{$this->item_shortname}_license", $option );
			delete_transient( '_woodev_addons' );

			wp_clean_plugins_cache( true );

			if ( $ajax ) {
				wp_send_json_success( $success );
			}
		}
		
		public function validate_license( $license = '', $forced = false, $ajax = false ) {

			$validate = $this->dispatch_license( 'check_license', trim( $license ) );

			if ( ! $validate ) {
				
				if ( $forced ) {
					$message = 'Во время проверки лицензии произошла ошибка соединения с сервером API. Пожалуйста, попробуйте ещё раз.';
					if ( $ajax ) {
						wp_send_json_error( $message );
					} else {
						$this->errors[] = $message;
					}
				}

				return;
			}
			
			if ( isset( $validate->success ) && false === $validate->success ) {
				$option                = get_option( "{$this->item_shortname}_license" );
				$option['is_expired']  = false;
				$option['is_disabled'] = false;
				$option['is_invalid']  = true;
				$option['data']		   = array();
				update_option( "{$this->item_shortname}_license", $option );
				if ( $ajax ) {
					wp_send_json_error( sprintf( 'Ваш лицензионный ключ для <strong>%s</strong> недействителен. Ключ больше не существует или пользователь, связанный с ключом, был удален. Пожалуйста, используйте другой ключ, чтобы продолжить получать автоматические обновления.', $this->item_name ) );
				}

				return;
			}
			
			if ( isset( $validate->license ) && 'expired' == $validate->license ) {
				$option                = get_option( "{$this->item_shortname}_license" );
				$option['is_expired']  = true;
				$option['is_disabled'] = false;
				$option['is_invalid']  = false;
				$option['data']		   = array();
				update_option( "{$this->item_shortname}_license", $option );
				if ( $ajax ) {
					wp_send_json_error( sprintf( 'Срок действия лицензионного ключа для <strong>%s</strong> истёк. Для того что бы продолжить получать обновления, пожалуйста <a href="%s" target="_blank">продлите вашу лицензию</a>.', $this->item_name, esc_url( edd_software_licensing()->get_renewal_url( $license ) ) ) );
				}

				return;
			}
			
			if ( isset( $validate->license ) && in_array( $validate->license, array( 'inactive', 'site_inactive' ) ) ) {
				$option                = get_option( "{$this->item_shortname}_license" );
				$option['is_expired']  = false;
				$option['is_disabled'] = true;
				$option['is_invalid']  = false;
				$option['data']		   = array();
				update_option( "{$this->item_shortname}_license", $option );
				if ( $ajax ) {
					wp_send_json_error( sprintf( 'Ваш лицензионный ключ для <strong>%s</strong> не активен для этого сайта. Пожалуйста, используйте другой ключ, чтобы продолжить использовать плагин в полной мере и получать автоматические обновления.', $this->item_name ) );
				}

				return;
			}
			
			$option                = get_option( "{$this->item_shortname}_license" );
			$option['is_expired']  = false;
			$option['is_disabled'] = false;
			$option['is_invalid']  = false;
			
			if( isset( $validate->data ) ) {
				$option['data'] = $validate->data;
			}
			
			update_option( "{$this->item_shortname}_license", $option );
			
			if ( $forced ) {
				$message = 'Ваш ключ был успешно обновлен.';
				if ( $ajax ) {
					wp_send_json_success( $message );
				}
			}
		}
		
		public function get_license_data() {
			$license = get_option( "{$this->item_shortname}_license", false );
			$data = array();
			
			if( $this->is_active() && ! empty( $license['data'] ) ) {
				$data = $license['data'];
			}
			
			return $data;
		}
		
		public function is_active() {

			$license = get_option( "{$this->item_shortname}_license", false );

			if (
				empty( $license ) ||
				! empty( $license['is_expired'] ) ||
				! empty( $license['is_disabled'] ) ||
				! empty( $license['is_invalid'] )
			) {
				return false;
			}

			return true;
		}
	}

endif;
