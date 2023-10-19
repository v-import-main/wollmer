<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Plugin' ) ) :

abstract class Woodev_Plugin {
	
	/** Plugin Framework Version */
	const VERSION = '1.1.3';
	
	protected static $instance;
	
	private $id;
	
	private $version;
	
	private $plugin_path;
	
	private $plugin_url;
	
	private $template_path;
	
	private $logger;
	
	protected $license;
	
	private $message_handler;
	
	private $text_domain;
	
	private $dependencies = array();
	
	private $function_dependencies = array();
	
	private $admin_notice_handler;
	
	protected $rest_api_handler;
	
	protected $setup_wizard_handler;
	
	private $display_php_notice = false;
	
	public function __construct( $id, $version, $args = array() ) {
		
		$this->id          = $id;
		$this->version     = $version;
		
		$args = wp_parse_args( $args, array(
			'text_domain'   => '',
			'dependencies'  => array()
		) );

		$dependencies = $args['dependencies'];
		$this->text_domain = $args['text_domain'];
		
		if ( empty( $dependencies['functions'] ) && ! empty( $args['function_dependencies'] ) ) {
			$dependencies['functions'] = $args['function_dependencies'];
		}

		$this->set_dependencies( $dependencies );

		if ( isset( $args['display_php_notice'] ) ) {
			$this->display_php_notice = $args['display_php_notice'];
		}
		
		if ( ! class_exists( 'Woodev_Plugins_License' ) ) {
			require_once( $this->get_framework_path() . '/plugin-updater/class-plugin-license.php');
		}
		
		if( ! is_object( $this->license ) ) {
			$this->license = new Woodev_Plugins_License( $this->get_file(), $this->get_plugin_path(), $this->get_plugin_url(), $this->get_plugin_name(), $this->get_version(), $this->get_download_id() );
		}
		
		$this->includes();
		
		$this->init_admin_message_handler();
		
		$this->init_admin_notice_handler();
		
		$this->init_rest_api_handler();
		
		$this->init_setup_wizard_handler();
		
		$this->add_hooks();
	}
	
	public function __clone() {}
	
	public function __wakeup() {}
	
	private function add_hooks() {
		
		add_action( 'plugins_loaded', array( $this, 'init_plugin' ), 15 );
		
		add_action( 'admin_init', array( $this, 'init_admin' ), 0 );
		
		add_action( 'init', array( $this, 'load_translations' ) );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_woodev_verify_license', array( $this, 'ajax_verify_license' ) );
		
		foreach( array( 'shipping', 'checkout', 'integration' ) as $tab ) {
			add_action( 'woocommerce_before_settings_' . $tab, array( $this, 'add_class_form_wrap_start' ) );
			add_action( 'woocommerce_after_settings_' . $tab, array( $this, 'add_class_form_wrap_end' ) );
		}
		
		add_action( 'admin_notices', array( $this, 'add_admin_notices' ) );
		add_action( 'admin_footer',  array( $this, 'add_delayed_admin_notices' ) );
		
		add_filter( 'plugin_action_links_' . plugin_basename( $this->get_plugin_file() ), array( $this, 'plugin_action_links' ) );
		
		add_action( 'wp_loaded', array( $this, 'do_install' ) );
			
		register_activation_hook(   $this->get_file(), array( $this, 'activate' ) );
		register_deactivation_hook( $this->get_file(), array( $this, 'deactivate' ) );
		
		$this->add_api_request_logging();
		
		add_action( 'woodev_plugins_loaded', array( $this, 'lib_includes' ) );
	}
	
	public function init_plugin() {}
	
	public function init_admin() {}
	
	public function load_translations() {
		if ( $this->text_domain ) {
			$this->load_plugin_textdomain();
		}
	}
	
	protected function load_plugin_textdomain() {
		$this->load_textdomain( $this->text_domain, dirname( plugin_basename( $this->get_plugin_file() ) ) );
	}
	
	protected function load_textdomain( $textdomain, $path ) {
		$locale = is_admin() && is_callable( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, $textdomain );
		load_textdomain( $textdomain, WP_LANG_DIR . '/' . $textdomain . '/' . $textdomain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $textdomain, false, untrailingslashit( $path ) . '/languages' );
	}
	
	public function lib_includes() {

		if ( is_admin() ) {
			$this->get_admin_notice_handler();
		}
		
	}
	
	public function enqueue_scripts() {
		
		if( $this->is_plugin_settings() ) {
			
			wp_enqueue_style( 'jquery-confirm', $this->get_framework_assets_url() . '/css/admin/jquery-confirm.min.css', array(), '3.3.2' );
			wp_enqueue_style( 'font-awesome', $this->get_framework_assets_url() . '/css/admin/font-awesome.min.css', null, '4.7.0' );
			wp_enqueue_style( 'admin-confirm', $this->get_framework_assets_url() . '/css/admin/admin-confirm.css', null, $this->get_version() );
			
			wp_register_script( 'jquery-confirm', $this->get_framework_assets_url() . '/js/admin/jquery.jquery-confirm.min.js', array( 'jquery' ), '3.3.2', false );
			wp_enqueue_script( 'woodev-admin-script', $this->get_framework_assets_url() . '/js/admin/woodev-admin-script.js', array( 'jquery-confirm' ), $this->get_version() );
			
			wp_localize_script( 'woodev-admin-script', 'woodev_admin_strings', $this->get_admin_js_strings() );
		}
	}
	
	protected function get_admin_js_strings() {
		return array(
			'admin_url'			=> admin_url( 'admin-ajax.php', 'relative' ),
			'license_prompt'	=> esc_html__( sprintf( 'Для использования плагина <strong>"%s"</strong>, вам необходимо активировать вашу лицензию для этого сайта', $this->get_plugin_name() ) ),
			'enter_license'		=> esc_html__( 'Указать лицензию' ),
			'close'				=> esc_html__( 'Закрыть' ),
			'admin_nonce'		=> wp_create_nonce( 'woodev-admin' ),
			'load_error_text'	=> esc_html__( 'Во время загрузки данных о лицензии произошла ошибка. Закройте это окно и попробуйте снова.' ),
			'license_page_url'	=> esc_url( $this->get_license_instance()->get_license_settings_url() )
		);
	}
	
	public function ajax_verify_license() {
		check_ajax_referer( 'woodev-admin', 'nonce' );
		
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}
		
		$license = $this->get_license_instance()->get_license();

		$this->get_license_instance()->validate_license( $license ? $license : __return_empty_string(), true, true );
	}
	
	public function add_class_form_wrap_start() {
		if( $this->is_plugin_settings() && ! $this->get_license_instance()->is_active() ) {
			echo '<div class="woodev-licence-need">';
		}
	}
	
	public function add_class_form_wrap_end() {
		if( $this->is_plugin_settings() && ! $this->get_license_instance()->is_active() ) {
			echo '</div><!-- .woodev-licence-need end-->';
		}
	}
	
	private function includes() {

		$framework_path = $this->get_framework_path();
		
		// common exception class
		require_once( $framework_path . '/class-plugin-exception.php' );
		
		// Settings API
		require_once( $framework_path . '/settings-api/abstract-class-settings.php' );
		require_once( $framework_path . '/settings-api/class-setting.php' );
		require_once( $framework_path . '/settings-api/class-control.php' );
		
		// common utility methods
		require_once( $framework_path . '/class-helper.php' );
		
		require_once( $framework_path . '/class-admin-message-handler.php' );
		require_once( $framework_path . '/class-admin-notice-handler.php' );
		
		require_once( $framework_path . '/class-plugin-compatibility.php' );
		require_once( $framework_path . '/compatibility/abstract-data-compatibility.php' );
		require_once( $framework_path . '/compatibility/class-order-compatibility.php' );
		require_once( $framework_path . '/compatibility/class-product-compatibility.php' );
		
		require_once( $framework_path . '/api/class-api-exception.php' );
		require_once( $framework_path . '/api/class-api-base.php' );
		require_once( $framework_path . '/api/interface-api-request.php' );
		require_once( $framework_path . '/api/interface-api-response.php' );
		
		require_once( $framework_path . '/api/abstract-api-xml-request.php' );
		require_once( $framework_path . '/api/abstract-api-xml-response.php' );
		
		require_once( $framework_path . '/api/abstract-api-json-request.php' );
		require_once( $framework_path . '/api/abstract-api-json-response.php' );
		
		require_once( $framework_path . '/utilities/class-woodev-async-request.php' );
		require_once( $framework_path . '/utilities/class-woodev-background-job-handler.php' );
		require_once( $framework_path . '/utilities/class-woodev-job-batch-handler.php' );
		
		// REST API Controllers
		require_once( $framework_path . '/rest-api/controllers/class-plugin-rest-api-settings.php' );
		require_once( $framework_path . '/rest-api/class-plugin-rest-api.php' );
	}
	
	public function is_plugin_settings() {
		return false;
	}
	
	public function get_license_instance() {
		return $this->license;
	}
	
	public function add_admin_notices() {
		$this->add_dependencies_admin_notices();
	}
	
	protected function init_rest_api_handler() {

		$this->rest_api_handler = new Woodev_REST_API( $this );
	}
	
	protected function init_setup_wizard_handler() {
		require_once( $this->get_framework_path() . '/admin/abstract-plugin-admin-setup-wizard.php' );
	}
	
	public function add_delayed_admin_notices() {}
	
	protected function add_dependencies_admin_notices() {
		global $woodev_php_notice_added;
		
		$missing_extensions = $this->get_missing_dependencies();

		if ( count( $missing_extensions ) > 0 ) {

			$message = sprintf(
				_n(
					'Для работы %1$s необходимо PHP расширение %2$s. Свяжитесь с вашим хостинг провайдером, что бы установить нужное расширение/библиотеку.',
					'Для работы %1$s необходимы PHP расширения %2$s. Свяжитесь с вашим хостинг провайдером, что бы установить все нужные для работы расширения/библиотеки.',
					count( $missing_extensions )
				),
				$this->get_plugin_name(),
				'<strong>' . implode( ', ', $missing_extensions ) . '</strong>'
			);

			$this->get_admin_notice_handler()->add_admin_notice( $message, 'missing-extensions', array(
				'notice_class' => 'error',
			) );

		}
		
		$missing_functions = $this->get_missing_function_dependencies();

		if ( count( $missing_functions ) > 0 ) {

			$message = sprintf(
				_n(
					'Для %1$s необходимо наличие PHP функции %2$s. Свяжитесь с вашим хостинг провайдером, что бы установить нужную функцию.',
					'Для %1$s необходимо наличие PHP функций %2$s. Свяжитесь с вашим хостинг провайдером, что бы установить нужные функции.',
					count( $missing_functions )
				),
				$this->get_plugin_name(),
				'<strong>' . implode( ', ', $missing_functions ) . '</strong>'
			);

			$this->get_admin_notice_handler()->add_admin_notice( $message, 'missing-functions', array(
				'notice_class' => 'error',
			) );

		}
		
		if ( $this->is_plugin_settings() || ( ! $this->get_settings_url() && $this->is_general_configuration_page() ) ) {

			$bad_settings = $this->get_incompatible_php_settings();

			if ( count( $bad_settings ) > 0 ) {

				$message = sprintf( 'Для корректной работы %s требуются следующие настройки PHP:', '<strong>' . $this->get_plugin_name() . '</strong>' );

				$message .= '<ul>';

					foreach ( $bad_settings as $setting => $values ) {

						$setting_message = '<code>' . $setting . ' = ' . $values['expected'] . '</code>';

						if ( ! empty( $values['type'] ) && 'min' === $values['type'] ) {

							$setting_message = sprintf( '%s или выше', $setting_message );
						}

						$message .= '<li>' . $setting_message . '</li>';
					}

				$message .= '</ul>';

				$message .= 'Пожалуйста свяжитесь с вашим хостинг провайдером для настройки вашего сервера до необходимых параметров.';

				$this->get_admin_notice_handler()->add_admin_notice( $message, 'bad-php-configuration', array(
					'notice_class' => 'error',
				) );
			}
		}
		
		if ( ! $woodev_php_notice_added && $this->display_php_notice && version_compare( PHP_VERSION, '5.4.0', '<' ) ) {
			
			$message = sprintf( '<p>Внимание! Версия PHP используемая на вашем сервере %s. Мы настоятельно рекомендуем установить версию PHP не ниже 5.4, в противном случае работа плагина %s может быть не корретной.</p>', PHP_VERSION, $this->get_plugin_name() );

			$this->get_admin_notice_handler()->add_admin_notice( $message, 'outdated-php-version', array(
				'notice_class' => 'error',
			) );

			$woodev_php_notice_added = true;
		}
	}
	
	public function plugin_action_links( $actions ) {

		$custom_actions = array();
		
		if ( $this->get_settings_link( $this->get_id() ) ) {
			$custom_actions['configure'] = $this->get_settings_link( $this->get_id() );
		}
		
		if ( $this->get_documentation_url() ) {
			$custom_actions['docs'] = sprintf( '<a href="%s">%s</a>', $this->get_documentation_url(), 'Документация' );
		}
		
		if ( $this->get_support_url() ) {
			$custom_actions['support'] = sprintf( '<a href="%s">%s</a>', $this->get_support_url(), 'Поддержка' );
		}
		
		if ( $this->get_reviews_url() ) {
			$custom_actions['review'] = sprintf( '<a href="%s">%s</a>', $this->get_reviews_url(), 'Оставить отзыв' );
		}
		
		if( $this->get_license_instance()->get_license_settings_url() ) {
			$license_text = $this->get_license_instance()->is_license_valid() ? 'Лицензия' : 'Указать лицензию';
			$custom_actions['license'] = sprintf( '<a href="%s">%s</a>', $this->get_license_instance()->get_license_settings_url(), esc_html( $license_text ) );
		}
		
		return array_merge( $custom_actions, $actions );
	}
	
	public function add_api_request_logging() {

		if ( ! has_action( 'woodev_' . $this->get_id() . '_api_request_performed' ) ) {
			add_action( 'woodev_' . $this->get_id() . '_api_request_performed', array( $this, 'log_api_request' ), 10, 2 );
		}
	}
	
	public function log_api_request( $request, $response, $log_id = null ) {

		$this->log( "Запрос\n" . $this->get_api_log_message( $request ), $log_id );

		if ( ! empty( $response ) ) {
			$this->log( "Ответ\n" . $this->get_api_log_message( $response ), $log_id );
		}
	}
	
	public function get_api_log_message( $data ) {

		$messages = array();

		$messages[] = isset( $data['uri'] ) && $data['uri'] ? 'Запрос' : 'Ответ';

		foreach ( (array) $data as $key => $value ) {
			$messages[] = sprintf( '%s: %s', $key, is_array( $value ) || ( is_object( $value ) && 'stdClass' == get_class( $value ) ) ? print_r( (array) $value, true ) : $value );
		}

		return implode( "\n", $messages );
	}
	
	public function get_missing_function_dependencies() {

		$missing_functions = array();

		foreach ( $this->get_function_dependencies() as $fcn ) {

			if ( ! function_exists( $fcn ) ) {
				$missing_functions[] = $fcn;
			}
		}

		return $missing_functions;
	}
	
	public function get_missing_dependencies() {

		return $this->get_missing_extension_dependencies();
	}
	
	public function get_missing_extension_dependencies() {

		$missing_extensions = array();

		foreach ( $this->get_extension_dependencies() as $ext ) {

			if ( ! extension_loaded( $ext ) ) {
				$missing_extensions[] = $ext;
			}
		}

		return $missing_extensions;
	}
	
	public function get_incompatible_php_settings() {

		$incompatible_settings = array();

		$dependences = $this->get_php_settings_dependencies();

		if ( function_exists( 'ini_get' ) && ! empty( $dependences ) ) {

			foreach ( $dependences as $setting => $expected ) {

				$actual = ini_get( $setting );

				if ( ! $actual ) {
					continue;
				}

				if ( is_integer( $expected ) ) {
					
					$is_size = ! is_numeric( substr( $actual, -1 ) );

					$actual_num = $is_size ? Woodev_Helper::let_to_num( $actual ) : $actual;

					if ( $actual_num < $expected ) {

						$incompatible_settings[ $setting ] = array(
							'expected' => $is_size ? size_format( $expected ) : $expected,
							'actual'   => $is_size ? size_format( $actual_num ) : $actual,
							'type'     => 'min',
						);
					}

				} elseif ( $actual !== $expected ) {

					$incompatible_settings[ $setting ] = array(
						'expected' => $expected,
						'actual'   => $actual,
					);
				}
			}
		}

		return $incompatible_settings;
	}
	
	protected function set_dependencies( $dependencies = array() ) {

		$default_dependencies = array(
			'extensions' => array(),
			'functions'  => array(),
			'settings'   => array(
				'suhosin.post.max_array_index_length'    => 256,
				'suhosin.post.max_totalname_length'      => 65535,
				'suhosin.post.max_vars'                  => 1024,
				'suhosin.request.max_array_index_length' => 256,
				'suhosin.request.max_totalname_length'   => 65535,
				'suhosin.request.max_vars'               => 1024,
			),
		);

		if ( isset( $dependencies[0] ) ) {

			$dependencies = array(
				'extensions' => $dependencies,
			);
		}
		
		if ( ! empty( $dependencies['settings'] ) ) {
			$dependencies['settings'] = array_merge( $default_dependencies['settings'], $dependencies['settings'] );
		}

		$this->dependencies = wp_parse_args( $dependencies, $default_dependencies );
	}
	
	public function log( $message, $log_id = null ) {

		if ( is_null( $log_id ) ) {
			$log_id = $this->get_id();
		}

		if ( ! is_object( $this->logger ) && class_exists( 'WC_Logger' ) ) {
			$this->logger = new WC_Logger();
		}

		if( method_exists( $this->logger, 'add' ) ) {
			$this->logger->add( $log_id, $message );
		}
	}
	
	public function load_class( $local_path, $class_name ) {
		
		$path = $this->get_plugin_path() . $local_path;
		
		if( ! is_readable( $path ) ) {
			throw new Woodev_Plugin_Exception( sprintf( 'Не возможно загрузить файл %s', $path ) );
		}
		
		require_once( $path );
		
		if( ! class_exists( $class_name ) ) {
			throw new Woodev_Plugin_Exception( sprintf( 'Имя класса %s неверное.', $class_name ) );
		}

		return new $class_name;
	}
	
	public function get_plugin_file() {
		$slug = dirname( plugin_basename( $this->get_file() ) );
		return trailingslashit( $slug ) . $slug . '.php';
	}
	
	abstract protected function get_file();
	
	public function get_id() {
		return $this->id;
	}
	
	public function get_id_dasherized() {
		return str_replace( '_', '-', $this->get_id() );
	}
	
	abstract public function get_plugin_name();
	
	abstract public function get_download_id();
	
	public function get_admin_notice_handler() {

		return $this->admin_notice_handler;
	}
	
	public function get_settings_handler() {

		return;
	}
	
	protected function init_admin_notice_handler() {

		$this->admin_notice_handler = new Woodev_Admin_Notice_Handler( $this );
	}
	
	protected function get_plugin_version_name() {
		return 'woodev_' . $this->get_id() . '_version';
	}
	
	public function get_version() {
		return $this->version;
	}
	
	protected function get_dependencies() {
		return $this->dependencies;
	}
	
	protected function get_extension_dependencies() {
		return $this->dependencies['extensions'];
	}
	
	protected function get_function_dependencies() {
		return $this->dependencies['functions'];
	}
	
	protected function get_php_settings_dependencies() {
		return $this->dependencies['settings'];
	}
	
	public function get_settings_link( $plugin_id = null ) {

		$settings_url = $this->get_settings_url( $plugin_id );

		if ( $settings_url ) {
			return sprintf( '<a href="%s">%s</a>', $settings_url, 'Настройки' );
		}
		
		return '';
	}
	
	public function get_settings_url( $plugin_id = null ) {
		return '';
	}
	
	public function is_general_configuration_page() {
		return isset( $_GET['page'] ) && 'woodev-settings' == $_GET['page'] && ( ! isset( $_GET['tab'] ) || 'general' == $_GET['tab'] );
	}
	
	public function get_general_configuration_url() {
		return admin_url( 'admin.php?page=woodev-settings&tab=general' );
	}
	
	public function get_documentation_url() {
		return null;
	}
	
	public function get_support_url() {
		return null;
	}
	
	public function get_sales_page_url() {
		return '';
	}

	public function get_reviews_url() {

		return $this->get_sales_page_url() ? $this->get_sales_page_url() . '#comments' : '';
	}
	
	public function get_plugin_path() {

		if ( $this->plugin_path ) {
			return $this->plugin_path;
		}

		return $this->plugin_path = untrailingslashit( plugin_dir_path( $this->get_file() ) );
	}
	
	public function get_plugin_url() {

		if ( $this->plugin_url ) {
			return $this->plugin_url;
		}

		return $this->plugin_url = untrailingslashit( plugins_url( '/', $this->get_file() ) );
	}
	
	public function get_framework_file() {
		return __FILE__;
	}
	
	public function get_framework_path() {
		return untrailingslashit( plugin_dir_path( $this->get_framework_file() ) );
	}
	
	public function get_framework_assets_path() {

		return $this->get_framework_path() . '/assets';
	}
	
	public function get_framework_assets_url() {
		return untrailingslashit( plugins_url( '/assets', $this->get_framework_file() ) );
	}
	
	public function get_template_path() {
		if ( null === $this->template_path ) {
			$this->template_path = $this->get_plugin_path() . '/templates';
		}
		return $this->template_path;
	}
	
	public function load_template( $template, array $args = [], $path = '', $default_path = '' ) {
		
		if ( '' === $default_path || ! is_string( $default_path ) ) {
			$default_path = trailingslashit( $this->get_template_path() );
		}
		
		if( function_exists( 'wc_get_template' ) ) {
			wc_get_template( $template, $args, $path, $default_path );
		}
	}
	
	public function get_setup_wizard_handler() {
		return $this->setup_wizard_handler;
	}
	
	protected function init_admin_message_handler() {
		$this->message_handler = new Woodev_Admin_Message_Handler( $this->get_id() );
	}
	
	public function get_message_handler() {

		return $this->message_handler;
	}
	
	public function is_plugin_active( $plugin_name ) {

		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, array_keys( get_site_option( 'active_sitewide_plugins', array() ) ) );
		}

		$plugin_filenames = array();

		foreach ( $active_plugins as $plugin ) {

			if ( Woodev_Helper::str_exists( $plugin, '/' ) ) {
				list( , $filename ) = explode( '/', $plugin );
			} else {
				$filename = $plugin;
			}

			$plugin_filenames[] = $filename;
		}

		return in_array( $plugin_name, $plugin_filenames );
	}
	
	public function do_install() {

		$installed_version = get_option( $this->get_plugin_version_name() );
		
		if ( version_compare( $installed_version, $this->get_version(), '<' ) ) {

			if ( ! $installed_version ) {
				$this->install();
			} else {
				$this->upgrade( $installed_version );
			}
			
			update_option( $this->get_plugin_version_name(), $this->get_version() );
		}
	}
	
	public function install_default_settings( array $settings ) {

		foreach ( $settings as $setting ) {

			if ( isset( $setting['id'] ) && isset( $setting['default'] ) ) {

				update_option( $setting['id'], $setting['default'] );
			}
		}
	}
	
	protected function install() {}
	
	protected function upgrade( $installed_version ) {}
	
	public function activate() {}
	
	public function deactivate() {}
}

endif;