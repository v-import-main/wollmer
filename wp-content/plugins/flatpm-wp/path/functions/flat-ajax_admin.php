<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// blocks
include_once 'ajax-handlers/block/update.php';
include_once 'ajax-handlers/block/abgroup.php';
include_once 'ajax-handlers/block/activate.php';
include_once 'ajax-handlers/block/copy.php';
include_once 'ajax-handlers/block/delete.php';
include_once 'ajax-handlers/block/move_to_folder.php';
include_once 'ajax-handlers/block/copy_to_folder.php';
include_once 'ajax-handlers/block/update_order.php';

// folders
include_once 'ajax-handlers/folder/delete.php';
include_once 'ajax-handlers/folder/rename.php';
include_once 'ajax-handlers/folder/update.php';

// settings
include_once 'ajax-handlers/settings/license.php';
include_once 'ajax-handlers/settings/settings.php';
include_once 'ajax-handlers/settings/header_footer.php';
include_once 'ajax-handlers/settings/blacklist_ip.php';
include_once 'ajax-handlers/settings/unfold.php';
include_once 'ajax-handlers/settings/import.php';
include_once 'ajax-handlers/settings/migration.php';
include_once 'ajax-handlers/settings/clear_all_html.php';
include_once 'ajax-handlers/settings/css_editor_update.php';
include_once 'ajax-handlers/settings/import.php';
include_once 'ajax-handlers/settings/export.php';

// actions
include_once 'ajax-handlers/actions/clear_all_cache.php';
include_once 'ajax-handlers/actions/search_publish.php';
include_once 'ajax-handlers/actions/search_taxonomy.php';
include_once 'ajax-handlers/actions/exclude_block.php';


// !--sub_functions


add_action( 'wp_ajax_flat_pm_admin', 'ajax_hendler_flat_pm_admin' );
if( !function_exists( 'ajax_hendler_flat_pm_admin' ) ){
	function ajax_hendler_flat_pm_admin(){
		$allow_unfiltered_html = current_user_can( 'unfiltered_html' );

		if( ! $allow_unfiltered_html ){
			$_REQUEST['data_me']['meta'] = wp_kses_post_deep( $_REQUEST['data_me']['meta'] );
		}

		$meta   = ! empty( $_REQUEST['data_me']['meta'] ) ? $_REQUEST['data_me']['meta'] : array();
		$method = $meta['method'];

		$fpm_fn = 'flat_pm_' . $method;

		$allow_methods = array(
			'flat_pm_block_update',
			'flat_pm_block_abgroup',
			'flat_pm_block_activate',
			'flat_pm_block_copy',
			'flat_pm_block_delete',
			'flat_pm_move_to_folder',
			'flat_pm_copy_to_folder',
			'flat_pm_update_order',

			'flat_pm_folder_update',
			'flat_pm_folder_delete',
			'flat_pm_folder_rename',

			'flat_pm_settings_update',
			'flat_pm_header_footer_update',
			'flat_pm_blacklist_ip_update',
			'flat_pm_update_license',
			'flat_pm_clear_all_html',
			'flat_pm_css_editor_update',

			'flat_pm_search_publish',
			'flat_pm_search_taxonomy',

			'flat_pm_import',
			'flat_pm_export',

			'flat_pm_exclude_block',
			'flat_pm_update_unfold',
			'flat_pm_migration_process'
		);

		if( ! in_array( $fpm_fn, $allow_methods ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'Wrong method', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		if( ! wp_verify_nonce( $meta['_wpnonce'], 'flat_pm_nonce') ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'Nonce check failed', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		$settings = get_option( 'flat_pm_main' );
		$cap = ( ! isset($settings['editor_manage'] ) || $settings['editor_manage'] != 'true' ) ? 'manage_options' : 'read_private_posts';

		if( !current_user_can( $cap ) ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">report_problem</i> ' . __( 'User does not have appropriate rights', 'flatpm_l10n' ),
					'status' => 'error'
				)
			) ) );
		}

		$fpm_fn( $method, $meta );
	}
}
?>