<?php
/*
Plugin Name: FlatPM – Ad Manager, AdSense and Custom Code
Plugin URI: https://mehanoid.pro/flat-pm/
Description: Plugin for displaying ads and interactive content. Popups, GEO, referer, browser, OS, ISP, UTM, A/B tests and more <a href="https://t.me/joinchat/+peZspodMlelhZjIy">Our telegram channel</a>
Version: 3.0.41
Author: Mehanoid.pro
Author URI: https://mehanoid.pro/
Text Domain: flatpm_l10n
Domain Path: /l10n
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


__( 'FlatPM – Ad Manager, AdSense, Custom Code and more', 'flatpm_l10n' );
__( 'Plugin for displaying ads and interactive content. Popups, GEO, referer, browser, OS, ISP, UTM, A/B tests and more <a href="https://t.me/joinchat/+peZspodMlelhZjIy">Our telegram channel</a>', 'flatpm_l10n' );


define( 'FLATPM_SLUG', dirname( plugin_basename( __FILE__ ) ) );
define( 'FLATPM_VERSION', '?3.0.41' );
define( 'FLATPM_INT_MAX', PHP_INT_MAX - 100 );
define( 'FLATPM_URL', plugin_dir_url( __FILE__ ) );
define( 'FLATPM_DIR', __DIR__ );
define( 'FLATPM_PATH', 'path' );
define( 'FLATPM_L10N', FLATPM_DIR . '/l10n' );
define( 'FLATPM_UPPD', FLATPM_DIR . '/' . FLATPM_PATH . '/updater' );
define( 'FLATPM_FUNC', FLATPM_DIR . '/' . FLATPM_PATH . '/functions' );
define( 'FLATPM_DEFAULTS', FLATPM_DIR . '/' . FLATPM_PATH . '/defaults' );
define( 'FLATPM_NEWS', FLATPM_DIR . '/' . FLATPM_PATH . '/news/news.php' );
define( 'FLATPM_FOLDERS_LIST', FLATPM_DIR . '/' . FLATPM_PATH . '/folders/list.php' );
define( 'FLATPM_LOGO', include_once 'assets/admin/img/flat_pm.svg.php' );


include_once FLATPM_FUNC . '/flat-core.php';
include_once FLATPM_FUNC . '/flat-ajax_admin.php';
include_once FLATPM_FUNC . '/flat-ajax_front.php';
include_once FLATPM_FUNC . '/flat-shortcode.php';
include_once FLATPM_FUNC . '/flat-scripts.php';
include_once FLATPM_FUNC . '/flat-header_footer.php';
include_once FLATPM_FUNC . '/flat-filter_content.php';

class FlatPM_Obj{
	function __construct(){
		add_action( 'admin_enqueue_scripts', function( $suffix ){
			$accept_array = array(
				'toplevel_page_fpm_blocks',
				'flat-pm_page_fpm_add_blocks',
				'flat-pm_page_fpm_header_footer',
				'flat-pm_page_fpm_sliders',
				'flat-pm_page_fpm_statistics',
				'flat-pm_page_fpm_block_ip',
				'flat-pm_page_fpm_settings',
				'flat-pm_page_fpm_shortcodes',
				'flat-pm_page_fpm_license',
				'flat-pm_page_fpm_migration',
				'flat-pm_page_fpm_css_editor',
				'flat-pm_page_fpm_export_import'
			);

			if( ! in_array( $suffix, $accept_array ) )
				return;

			add_action( 'admin_footer', 'fpm_dequeue_deregister_js_css' );
			add_action( 'admin_print_styles', 'fpm_dequeue_deregister_js_css' );
			add_action( 'admin_print_scripts', 'fpm_dequeue_deregister_js_css' );
			function fpm_dequeue_deregister_js_css(){
				$deque_js = array(
					'selectize',
					'bootstrap',
					'jeg-form-builder-script',
					'jeg-form-menu-script',
					'jeg-form-archive-script',
					'jquery-widgetopts-option-tabs',
					'ilrcp_panel_select2'
				);

				foreach( $deque_js as $js ){
					wp_dequeue_script( $js );
					wp_deregister_script( $js );
				}

				$deque_css = array(
					'selectize',
					'font-awesome',
					'jeg-form-builder',
					'widgetopts-admin-styles',
					'zmseo'
				);

				foreach( $deque_css as $css ){
					wp_dequeue_style( $css );
					wp_deregister_style( $css );
				}
			}

			wp_enqueue_style( 'flat_pm_materialize', FLATPM_URL . 'assets/admin/css/materialize.css', array(), FLATPM_VERSION, 'all' );
			wp_enqueue_style( 'flat_pm_timesheet', FLATPM_URL . 'assets/admin/css/timesheet.css', array(), FLATPM_VERSION, 'all' );
			wp_enqueue_style( 'flat_pm_coloris', FLATPM_URL . 'assets/admin/css/coloris.css', array(), FLATPM_VERSION, 'all' );
			wp_enqueue_style( 'flat_pm_custom', FLATPM_URL . 'assets/admin/css/custom.css', array(), FLATPM_VERSION, 'all' );
			wp_enqueue_style( 'flat_pm_codemirror', FLATPM_URL . 'assets/admin/css/codemirror.css', array(), FLATPM_VERSION, 'all' );
			wp_enqueue_style( 'flat_pm_Fira-Code', 'https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;500;700&display=swap', array(), FLATPM_VERSION, 'all' );
			wp_enqueue_style( 'editor-buttons' );

			wp_enqueue_script( 'flat_pm_sortable', FLATPM_URL . 'assets/admin/js/sortable.js', array( 'jquery' ), FLATPM_VERSION, false );
			wp_enqueue_script( 'flat_pm_timesheet', FLATPM_URL . 'assets/admin/js/timesheet.js', array( 'jquery' ), FLATPM_VERSION, false );
			wp_enqueue_script( 'flat_pm_css2xpath', FLATPM_URL . 'assets/admin/js/css2xpath.js', array( 'jquery' ), FLATPM_VERSION, false );
			wp_enqueue_script( 'flat_pm_materialize', FLATPM_URL . 'assets/admin/js/materialize.js', array( 'jquery' ), FLATPM_VERSION, false );
			wp_enqueue_script( 'flat_pm_chartjs', FLATPM_URL . 'assets/admin/js/chartjs.js', array( 'jquery' ), FLATPM_VERSION, false );
			wp_enqueue_script( 'flat_pm_coloris', FLATPM_URL . 'assets/admin/js/coloris.js', array( 'jquery' ), FLATPM_VERSION, false );
			wp_enqueue_script( 'flat_pm_custom', FLATPM_URL . 'assets/admin/js/custom.js', array( 'jquery' ), FLATPM_VERSION, false );

			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

			include_once FLATPM_L10N . '/l10n-js.php';


			if( $suffix === 'flat-pm_page_fpm_css_editor' ){
				$args = array(
					'type' => 'text/css',
					'codemirror' => array(
						'theme' => 'material'
					)
				);
			}else{
				$args = array(
					'type' => 'text/html',
					'codemirror' => array(
						'theme' => 'material'
					)
				);
			}

			$settings = wp_enqueue_code_editor( $args );

			if ( $settings === false ) {
				return;
			}

			wp_add_inline_script(
				'code-editor',
				sprintf( '
					jQuery( function($){
						$(\'#tab-html textarea.default, .header_footer_update textarea.default, .fpm-example-code, .css_editor_update textarea.default\').each( function(){
							var textArea = this,
								editor = wp.codeEditor.initialize( textArea, %s );

							editor.codemirror.on( \'change\', function(){
								editor.codemirror.save();
								$( textArea ).trigger( \'flatpm_change\' );
							} );

							$( textArea ).on( \'change\', function(){
								editor.codemirror.setValue(this.value);
								$( textArea ).trigger( \'flatpm_change\' );
							} );
						} );
					} );',
					wp_json_encode( $settings )
				)
			);
		}, 1000000 );

		add_action( 'admin_menu', array( &$this, 'flat_admin' ) );

		add_action( 'admin_head', function(){
			flat_pm_init();

			echo '
			<script>localStorage.setItem( "visit_f_bool", "false" );</script>
			<style>.wp-submenu [href*="fpm_migration"]{background:#d63638!important;color:#fff!important;font-weight:600}</style>
			';
		} );

		add_action( 'plugins_loaded', function(){
			load_plugin_textdomain( 'flatpm_l10n', false, FLATPM_SLUG . '/l10n' );
		} );

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function( $actions ){
			$settings_link = '<a href="' . esc_attr( get_site_url() ) . '/wp-admin/admin.php?page=fpm_blocks">' . __( 'All blocks', 'flatpm_l10n' ) . '</a>';
			array_unshift( $actions, $settings_link );

			$actions []= '<a href="' . esc_attr( get_site_url() ) . '/wp-admin/admin.php?page=fpm_license">' . __( 'License', 'flatpm_l10n' ) . '</a>';

			return $actions;
		} );

		add_filter( 'plugin_row_meta', function( $meta, $file ){

			if( $file === plugin_basename( __FILE__ ) ){
				$meta[] = '<a href="https://mehanoid.pro/flat-pm/faq-po-plaginu-flat-pm/" target="_blank">' . __( 'Documentation', 'flatpm_l10n' ) . '</a>';
			}

			return $meta;
		}, 10, 4 );
	}


	function fpm_blocks(){
		include_once FLATPM_PATH . '/blocks.php';
	}

	function fpm_add_blocks(){
		include_once FLATPM_PATH . '/blocks/add.php';
	}

	function fpm_statistics(){
		include_once FLATPM_PATH . '/settings/statistics.php';
	}

	function fpm_header_footer(){
		include_once FLATPM_PATH . '/settings/header_footer.php';
	}

	function fpm_block_ip(){
		include_once FLATPM_PATH . '/settings/block_ip.php';
	}

	function fpm_settings(){
		include_once FLATPM_PATH . '/settings/settings.php';
	}

	function fpm_css_editor(){
		include_once FLATPM_PATH . '/settings/css_editor.php';
	}

	function fpm_export_import(){
		include_once FLATPM_PATH . '/settings/export_import.php';
	}

	function fpm_shortcodes(){
		include_once FLATPM_PATH . '/settings/shortcodes.php';
	}

	function fpm_license(){
		include_once FLATPM_PATH . '/settings/license.php';
	}

	function fpm_migration(){
		include_once FLATPM_PATH . '/settings/migration.php';
	}


	function flat_admin(){
		register_setting( 'flat_plugin_field', 'flat_plugin_options_me' );

		$default_options = include FLATPM_DEFAULTS . '/options.php';

		foreach ( $default_options as $key => $option ) {
			get_option( $key ) == false && update_option( $key, $option );
		} unset( $option, $key );

		$settings = get_option( 'flat_pm_main' );
		$cap = ( ! isset( $settings['editor_manage'] ) || $settings['editor_manage'] != 'true' ) ? 'manage_options' : 'read_private_posts';

		add_menu_page( __( 'All blocks', 'flatpm_l10n' ), 'Flat PM', $cap, 'fpm_blocks', '', FLATPM_LOGO );

		$submenu_list = array(
			'fpm_blocks'        => __( 'All blocks', 'flatpm_l10n' ),
		);

		if( flat_pm_is_need_to_migrate() ){
			$submenu_list = array_merge( $submenu_list, array(
				'fpm_migration' => __( 'Need to migrate', 'flatpm_l10n' ),
			) );
		}

		$submenu_list = array_merge( $submenu_list, array(
			'fpm_add_blocks'    => __( 'Add block', 'flatpm_l10n' ),
			'fpm_header_footer' => __( 'Header and footer', 'flatpm_l10n' ),
			// 'fpm_statistics'    => __( 'Statistics', 'flatpm_l10n' ),
			'fpm_block_ip'      => __( 'Blacklist IP', 'flatpm_l10n' ),
			'fpm_settings'      => __( 'Plugin settings', 'flatpm_l10n' ),
			'fpm_css_editor'    => __( 'Style editor', 'flatpm_l10n' ),
			'fpm_export_import' => __( 'Import / Export', 'flatpm_l10n' ),
			'fpm_shortcodes'    => __( 'Shortcodes', 'flatpm_l10n' ),
			'fpm_license'       => __( 'License', 'flatpm_l10n' ),
		) );

		foreach ( $submenu_list as $key => $value ) {
			add_submenu_page( 'fpm_blocks', $value, $value, $cap, $key, array( &$this, $key ) );
		} unset( $value, $key );
	}
}

$FlatPM_Obj = new FlatPM_Obj();
?>