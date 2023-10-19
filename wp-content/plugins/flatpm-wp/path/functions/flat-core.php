<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'wp_inline_script_attributes', function( $attr ){
	if( isset( $attr['type'] ) && isset( $attr['data-noptimize'] ) ){
		unset( $attr['type'] );
	}

	return $attr;
} );

if( !function_exists( 'js_excludes_flat_pm' ) ){
	function js_excludes_flat_pm( $array ){
		$array []= 'fpm_';

		return $array;
	}
}
add_filter( 'rocket_exclude_defer_js', 'js_excludes_flat_pm' );
add_filter( 'rocket_delay_js_exclusions', 'js_excludes_flat_pm' );
add_filter( 'litespeed_optimize_js_excludes', 'js_excludes_flat_pm' );
add_filter( 'litespeed_optm_js_defer_exc', 'js_excludes_flat_pm' );


if( !function_exists( 'register_post_types_flat_pm' ) ){
	function register_post_types_flat_pm(){
		register_post_type( 'flat_pm_block', array(
			'label'                  => null,
			'labels'                 => array(
				'name'               => __( 'Advertising blocks', 'flatpm_l10n' ),
				'singular_name'      => __( 'Advertising blocks', 'flatpm_l10n' ),
				'add_new'            => __( 'Add ad block', 'flatpm_l10n' ),
				'add_new_item'       => __( 'Adding an ad block', 'flatpm_l10n' ),
				'edit_item'          => __( 'Editing an ad block', 'flatpm_l10n' ),
				'new_item'           => __( 'New ad block', 'flatpm_l10n' ),
				'view_item'          => __( 'View ad block', 'flatpm_l10n' ),
				'search_items'       => __( 'Search ad block', 'flatpm_l10n' ),
				'not_found'          => __( 'Not found', 'flatpm_l10n' ),
				'not_found_in_trash' => __( 'Not found in tresh', 'flatpm_l10n' ),
				'parent_item_colon'  => '',
				'menu_name'          => __( 'Advertising blocks', 'flatpm_l10n' )
			),
			'description'            => __( 'Advertising blocks', 'flatpm_l10n' ),
			'public'                 => false,
			'hierarchical'           => false,
			'supports'               => array( 'title' ),
			'taxonomies'             => array( 'flat_pm_block_folders' ),
			'has_archive'            => false
		) );

		register_taxonomy( 'flat_pm_block_folders', array( 'flat_pm_block' ), array(
			'label'                  => null,
			'labels'                 => array(
				'name'               => __( 'Folders', 'flatpm_l10n' ),
				'singular_name'      => __( 'Folders', 'flatpm_l10n' ),
				'search_items'       => __( 'Find folder', 'flatpm_l10n' ),
				'all_items'          => __( 'All folders', 'flatpm_l10n' ),
				'view_item '         => __( 'View folder', 'flatpm_l10n' ),
				'parent_item'        => __( 'Parent folder', 'flatpm_l10n' ),
				'parent_item_colon'  => __( 'Parent folder:', 'flatpm_l10n' ),
				'edit_item'          => __( 'Edit folder', 'flatpm_l10n' ),
				'update_item'        => __( 'Update Folder', 'flatpm_l10n' ),
				'add_new_item'       => __( 'Add new folder', 'flatpm_l10n' ),
				'new_item_name'      => __( 'New folder name', 'flatpm_l10n' ),
				'menu_name'          => __( 'Folders', 'flatpm_l10n' )
			),
			'description'            => __( 'Folders', 'flatpm_l10n' ),
			'hierarchical'           => true,
			'public'                 => false
		) );
	}
}


if( !function_exists( 'flat_do_some' ) ){
	function flat_do_some(){
		global $license_transient;

		if( $license_transient != '' )
			return ( $license_transient == 'true' ) ? true : false;

		$license_transient = get_transient( 'license_transient' );

		if ( false !== $license_transient )
			return ( $license_transient == 'true' ) ? true : false;

		$args = array(
			'body' => array(
				'conva'       => $_SERVER['HTTP_HOST'],
				'plovr'       => get_option( 'flat_pm_license' ),
				'admin_email' => get_option( 'admin_email' )
			),
			'sslverify' => false
		);

		$response = wp_remote_post( 'https://mehanoid.pro/api/license/flatpm/', $args );

		if ( !is_wp_error( $response ) ) {
			$license_transient = $response['body'];
		}else{
			$license_transient = 'false';
		}

		set_transient( 'license_transient', $license_transient, 60 * 30 );

		return ( $license_transient == 'true' ) ? true : false;
	}
}


if( !function_exists( 'flat_pm_init' ) ){
	function flat_pm_init(){
		$flat_pm_personalization = get_option( 'flat_pm_personalization' );
		?>
		<script>
		var $ = jQuery,
			ajax_url_flat_pm = '<?php echo esc_html( admin_url( 'admin-ajax.php' ) ); ?>',
			base_url_flat_pm = '<?php echo esc_html( get_site_url() ); ?>',
			disabled_tooltip_flat_pm = <?php echo esc_html( $flat_pm_personalization['disabled_tooltip'] ); ?>;
		</script>
		<?php
	}
}


if( !function_exists( 'add_custom_box_flat_pm' ) ){
	function add_custom_box_flat_pm(){
		$screens = null;
		add_meta_box( 'sectionid_flat_pm', __( 'FlatPM, display blocks?', 'flatpm_l10n' ), 'meta_box_callback_flat_pm', $screens, 'side');
	}
}


if( !function_exists( 'meta_box_callback_flat_pm' ) ){
	function meta_box_callback_flat_pm( $post, $meta ){
		$screens = $meta['args'];

		wp_nonce_field( plugin_basename(__FILE__), 'noncename_flat_pm' );

		$value = get_post_meta( $post->ID, 'exclude_block_flat_pm', true );
	?>
	<div class="exclude_block_flat_pm">
		<input type="radio" id="exclude_block_flat_pm_1" name="exclude_block_flat_pm" value="yes" <?php if( $value == 'yes' || $value == '' ) echo ' checked="checked"' ?>>
		<label for="exclude_block_flat_pm_1">
			<?php _e( 'Yes', 'flatpm_l10n' ) ?>
		</label>

		<input type="radio" id="exclude_block_flat_pm_2" name="exclude_block_flat_pm" value="no" <?php if( $value == 'no' ) echo ' checked="checked"' ?>>
		<label for="exclude_block_flat_pm_2">
			<?php _e( 'No', 'flatpm_l10n' ) ?>
		</label>
	</div>
	<style>
	.exclude_block_flat_pm{background:#eaeefd;display:flex;border-radius:5px;overflow:hidden}
	.exclude_block_flat_pm input{display:none}
	.exclude_block_flat_pm label{display:block;text-align:center;height:30px;line-height:30px;background:#b2b5d5;width:50%;color:#fff;transition:all .2s ease}
	.exclude_block_flat_pm input:checked+label{background:#8890c2}
	</style>
	<?php
	}
}


if( !function_exists( 'save_postdata_flat_pm' ) ){
	function save_postdata_flat_pm( $post_id ) {
		if( ! isset( $_POST['exclude_block_flat_pm'] ) )
			return;

		if( ! wp_verify_nonce( $_POST['noncename_flat_pm'], plugin_basename(__FILE__) ) )
			return;

		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if( ! current_user_can( 'edit_post', $post_id ) )
			return;

		$my_data = sanitize_text_field( $_POST['exclude_block_flat_pm'] );

		update_post_meta( $post_id, 'exclude_block_flat_pm', $my_data );
	}
}


if( !function_exists( 'flat_pm_get_export_data' ) ){
	function flat_pm_get_export_data(){
		$export = array(
			'folders' => array(),
			'blocks' => array(),
		);

		$args_blocks = array(
			'posts_per_page' => -1,
			'post_type'      => 'flat_pm_block',
			'orderby'        => 'none',
			'post_status'    => 'publish',
		);

		$flat_query = new WP_Query;
		$flat_blocks = $flat_query->query( $args_blocks );

		foreach( $flat_blocks as $flat_block ){

			$block_ID = $flat_block->ID;

			$meta_keys = array(
				'flat_pm_order_ID',
				'flat_pm_block_enabled',
				'flat_pm_html',
				'flat_pm_view',
				'flat_pm_date',
				'flat_pm_geo',
				'flat_pm_role',
				'flat_pm_os',
				'flat_pm_cookies',
				'flat_pm_ip',
				'flat_pm_referer',
				'flat_pm_browser',
				'flat_pm_count_sub',
				'flat_pm_AB',
			);

			$block_meta = array();

			foreach ( $meta_keys as $key ) {

				$block_meta[$key] = get_post_meta( $block_ID, $key, true );

			} unset( $key );

			$folder_terms = wp_get_post_terms( $block_ID, 'flat_pm_block_folders', array( 'fields' => 'names' ) );

			$folder_name = ( isset( $folder_terms[0] ) ) ? $folder_terms[0] : '';

			$export['blocks'] []= array(
				'block_title'  => $flat_block->post_title,
				'block_status' => $flat_block->post_status,
				'block_meta'   => $block_meta,
				'folder_name'  => $folder_name,
			);

		} unset( $flat_block );




		$args_folders = array(
			'taxonomy'   => 'flat_pm_block_folders',
			'hide_empty' => false,
			'orderby'    => 'none'
		);

		$folders = get_terms( $args_folders );

		foreach( $folders as $folder ){

			$folder_ID = $folder->term_id;

			$meta_keys = array(
				'flat_pm_folder_enabled',
				'flat_pm_view',
				'flat_pm_date',
				'flat_pm_geo',
				'flat_pm_role',
				'flat_pm_cookies',
				'flat_pm_ip',
				'flat_pm_os',
				'flat_pm_referer',
				'flat_pm_browser',
			);

			$folder_meta = array();

			foreach ( $meta_keys as $key ) {

				$folder_meta[$key] = get_term_meta( $folder_ID, $key, true );

			} unset( $key );

			$export['folders'] []= array(
				'folder_title' => $folder->name,
				'folder_meta'  => $folder_meta,
			);

		} unset( $folder );

		return base64_encode( gzdeflate( json_encode( $export, JSON_UNESCAPED_UNICODE ), 9 ) );
	}
}


if( !function_exists( 'flat_pm_remove_jquery_migrate_default' ) ){
	function flat_pm_remove_jquery_migrate_default( $scripts ) {
		if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
			$script = $scripts->registered['jquery'];
			if ( $script->deps ) {
				$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
			}
		}
	}
}




if( !function_exists( 'flat_pm_get_real_ip' ) ){
	function flat_pm_get_real_ip(){
		$ip = '';

		$client  = isset( $_SERVER['HTTP_CLIENT_IP'] )       ? sanitize_text_field( $_SERVER['HTTP_CLIENT_IP'] )       : '';
		$forward = isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? sanitize_text_field( $_SERVER['HTTP_X_FORWARDED_FOR'] ) : '';
		$remote  = isset( $_SERVER['REMOTE_ADDR'] )          ? sanitize_text_field( $_SERVER['REMOTE_ADDR'] )          : '';

		if( filter_var( $client, FILTER_VALIDATE_IP ) )
			$ip = $client;
		elseif( filter_var( $forward, FILTER_VALIDATE_IP ) )
			$ip = $forward;
		else
			$ip = $remote;

		return $ip;
	}
}




if( !function_exists( 'flat_pm_admin_head_column_style' ) ){
	function flat_pm_admin_head_column_style() { ?>
	<style>
	#flat_pm_column{width:4em}
	.flat_pm_column_span{overflow:visible;display:inline-block;vertical-align:middle;padding:8px 0;position:relative;font-size:0}
	.flat_pm_column_span:before{content:'';display:inline-block;width:20px;height:20px;padding:0;vertical-align:top;text-decoration:none!important;color:#444;background:transparent url(<?php echo esc_html( FLATPM_LOGO ); ?>) no-repeat center / contain}
	.flat_pm_column_score{display:inline-block!important;width:12px!important;height:12px!important;border-radius:50%!important;margin:3px 10px 0 3px;background:#0c0;vertical-align:top;position:relative;cursor:pointer;transition:all .15s ease}
	.flat_pm_column_score:not(.ajax-spin-holder):hover{transform:scale(1.25)}
	.flat_pm_column_score:after{content:'';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:300%;height:300%;z-index:1}
	.flat_pm_column_score[data-enabled="no"]{background-color:#d87a87}
	.flat_pm_column_score .exclude_block_flat_pm input:not(:checked)+label:hover{background:#66699c}
	.flat_pm_column_score.ajax-spin-holder{position:relative;color:transparent!important;background:transparent!important}
	.flat_pm_column_score.ajax-spin-holder:before{content:'';position:absolute;top:50%;left:50%;margin:auto;width:20px;height:20px;border-radius:50%;border:4px solid transparent;border-top-color:#26a69a;transform:translate(-50%,-50%)}
	.flat_pm_column_score.ajax-spin-holder:before{z-index:100;animation:mini-spin 1s infinite linear;width:22px;height:22px}
	@keyframes mini-spin {
	0%{transform:translate(-50%,-50%) rotate(0deg)}
	100%{transform:translate(-50%,-50%) rotate(360deg)}
	}
	</style>

	<script>
	jQuery( function($){
		window['flat_pm_ajax_mini_handler'] = function( data, param, url ){
			data = data || {};
			param = param || {}

			url = url || ajax_url_flat_pm || '/wp-admin/admin-ajax.php';

			$.ajax( {
				type: 'POST',
				url: url,
				dataType: 'json',
				data: {
					action: param.action || 'flat_pm_admin',
					data_me: data
				},
				success: function( res ){
					switch( res.method ) {
						case 'exclude_block':
							param.that && param.that.removeClass( param.name );

							param.that.attr( 'data-enabled', res.data )

							break;

						default:
							param.that && param.that.removeClass( param.name );

							break;
					}
				},
				error: function( error ){
					param.that.removeClass( param.name );
					console.log( 'ajax error:' ), console.error( 'php script returned error, response:', error );
				}
			} );
		}

		$('body').on( 'click', '.flat_pm_column_score', function(e){
			e.preventDefault();

			var that = $(this),
				name = 'ajax-spin-holder',
				data = {};

			if( that.hasClass( name ) ){
				return;
			}

			that.addClass( name );

			e.preventDefault();

			flat_pm_ajax_mini_handler( {
				meta: {
					method: 'exclude_block',
					id: that.data( 'post-id' ),
					_wpnonce: '<?php echo wp_create_nonce( 'flat_pm_nonce' ); ?>',
					_wp_http_referer: $('#_wp_http_referer').val()
				}
			}, { that: that, name: name } );
		} )
	} );
	</script>
	<?php }
}

if( !function_exists( 'flat_pm_set_custom_edit_columns' ) ){
	function flat_pm_set_custom_edit_columns( $columns ) {
		$columns['flat_pm_column'] = '<span class="flat_pm_column_span" title="FlatPM">FlatPM</span>';

		return $columns;
	}
}

if( !function_exists( 'flat_pm_custom_column' ) ){
	function flat_pm_custom_column( $column, $post_id ) {
		if( $column == 'flat_pm_column' ){
			$text = get_post_meta( $post_id, 'exclude_block_flat_pm', true );
			$text = ( $text ) ? $text : 'yes';
			echo '<div class="flat_pm_column_score" data-enabled="' . esc_attr( $text ) . '" data-post-id="' . esc_attr( $post_id ) . '" title="' . esc_attr__( 'Click to switch', 'flatpm_l10n' ) . '"></div>';
		}
	}
}

if( !function_exists( 'flat_pm_custom_orderby' ) ){
	function flat_pm_custom_orderby( $query ) {
		if ( ! is_admin() )
			return;

		$orderby = $query->get( 'orderby');

		if ( 'flat_pm_column' == $orderby ) {
			$query->set( 'meta_key', 'exclude_block_flat_pm' );
			$query->set( 'orderby', 'meta_value' );
		}
	}
}

if( !function_exists( 'flat_pm_set_custom_sortable_columns' ) ){
	function flat_pm_set_custom_sortable_columns( $columns ) {
		$columns['flat_pm_column'] = 'flat_pm_column';

		return $columns;
	}
}

if( !function_exists( 'wp_doing_ajax' ) ){
	function wp_doing_ajax() {
		return apply_filters( 'wp_doing_ajax', defined( 'DOING_AJAX' ) && DOING_AJAX );
	}
}

if( !function_exists( 'flat_pm_get_pro_text' ) ){
	function flat_pm_get_pro_text() {
		if( ! flat_do_some() ){
			return __( '<p style="margin:0">You have a free version, <a href="https://mehanoid.pro/flat-pm/kupit-flatpm/" target="_blank" class=" tooltipped" data-position ="bottom" data-tooltip="GEO, ISP, Folders and more">buy a PRO</a>?</p>', 'flatpm_l10n' );
		}else{
			return __( '<p style="margin:0 0 0 3px">You have a PRO version. You are awesome!</p>', 'flatpm_l10n' );
		}
	}
}

if( !function_exists( 'flat_pm_get_pro_tooltip' ) ){
	function flat_pm_get_pro_tooltip() {
		return __( 'data-position="top" data-tooltip="Available in PRO version"', 'flatpm_l10n' );
	}
}

if( !function_exists( 'flat_pm_get_posts_by_title' ) ){
	function flat_pm_get_posts_by_title( $post_title, $post_type = 'page' ) {
		global $wpdb;

		if( is_array( $post_type ) ){
			$post_type           = esc_sql( $post_type );
			$post_type_in_string = "'" . implode( "','", $post_type ) . "'";
			$sql                 = $wpdb->prepare(
				"SELECT ID FROM $wpdb->posts WHERE post_title LIKE %s AND post_type IN ($post_type_in_string)",
				'%' . $wpdb->esc_like( $post_title ) . '%'
			);
		}else{
			$sql = $wpdb->prepare(
				"SELECT ID FROM $wpdb->posts WHERE post_title LIKE %s AND post_type = %s",
				'%' . $wpdb->esc_like( $post_title ) . '%',
				$post_type
			);
		}

		$page = $wpdb->get_results( $sql );

		if( $page ){
			return $page;
		}

		return null;
	}
}


if( !function_exists( 'flat_pm_edit_term_hook' ) ){
	function flat_pm_edit_term_hook() {
		delete_transient( 'tax_transient' );
	}
}


if( !function_exists( 'flat_pm_recursive_base64_decode' ) ){
	function flat_pm_recursive_base64_decode() {
		
	}
}


if( !function_exists( 'flat_pm_is_need_to_migrate' ) ){
	function flat_pm_is_need_to_migrate() {
		$deprecated_settings = array(
			'flat_plugin_options_me',
			'flat_plugin_settings_me',
			'flat_plugin_header_footer_me',
			'flat_plugin_video_me',
			'flat_pm_cross_color',
			'flat_pm_cross_background',
			'flat_pm_cross_text_color',
			'flat_pm_cross_offset',
			'flat_pm_cross_width',
			'flat_pm_cross_height',
			'flat_pm_cross_weight',
		);

		// checking for deprecated settings

		foreach( $deprecated_settings as $key ){
			if( !empty( get_option( $key ) ) ){
				return true;
			}
		} unset( $key );

		// checking for deprecated blocks

		$blocks_args = array(
			'posts_per_page' => -1,
			'post_type'      => 'flat_pm_block',
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'meta_query'     => array(
				array(
					'key'     => 'flat_pm_block_enabled',
					'compare' => 'EXISTS'
				)
			)
		);

		$deprecated_blocks_query = new WP_Query;
		$deprecated_blocks = $deprecated_blocks_query->query( $blocks_args );

		if( !empty( $deprecated_blocks ) ){
			return true;
		}

		// checking for deprecated folders

		$folders_args = array(
			'taxonomy'   => 'flat_pm_block_folders',
			'hide_empty' => false,
			'orderby'    => 'none',
			'meta_query'     => array(
				array(
					'key'     => 'flat_pm_folder_enabled',
					'compare' => 'EXISTS'
				)
			)
		);

		$deprecated_folders = get_terms( $folders_args );

		if( !empty( $deprecated_folders ) && !is_wp_error( $deprecated_folders ) ){
			return true;
		}

		return false;
	}
}


if( flat_pm_is_need_to_migrate() ){
	add_action( 'admin_notices', function(){
		global $pagenow;

		if( get_current_screen()->base != 'flat-pm_page_fpm_migration' ){
			echo '
			<div id="message" class="notice notice-error is-dismissible">
				<p><b>' . __( 'Flat PM:', 'flatpm_l10n' ) . '</b></p>
				<p>
					' . __( 'You have outdated data.', 'flatpm_l10n' ) . '
					' . __( 'Probably you used the plugin before version 3.0.0', 'flatpm_l10n' ) . '<br>
					' . __( 'The old settings are not supported by the new version, so you need to start the data migration process!', 'flatpm_l10n' ) . '
				</p>
				<p><a href="' . esc_attr( get_site_url() ) . '/wp-admin/admin.php?page=fpm_migration">
					' . __( 'Please start the migration process immediately!', 'flatpm_l10n' ) . '
				</a></p>
			</div>';
		}
	} );
}


if( !function_exists( 'wp_sanitize_script_attributes' ) ){
	function wp_sanitize_script_attributes( $attributes ) {
		$html5_script_support = ! is_admin() && ! current_theme_supports( 'html5', 'script' );
		$attributes_string    = '';

		foreach ( $attributes as $attribute_name => $attribute_value ) {
			if ( is_bool( $attribute_value ) ) {
				if ( $attribute_value ) {
					$attributes_string .= $html5_script_support ? sprintf( ' %1$s="%2$s"', esc_attr( $attribute_name ), esc_attr( $attribute_name ) ) : ' ' . esc_attr( $attribute_name );
				}
			} else {
				$attributes_string .= sprintf( ' %1$s="%2$s"', esc_attr( $attribute_name ), esc_attr( $attribute_value ) );
			}
		}

		return $attributes_string;
	}
}


if( !function_exists( 'wp_get_inline_script_tag' ) ){
	function wp_get_inline_script_tag( $javascript, $attributes = array() ) {
		if ( ! isset( $attributes['type'] ) && ! is_admin() && ! current_theme_supports( 'html5', 'script' ) ) {
			$attributes['type'] = 'text/javascript';
		}

		$attributes = apply_filters( 'wp_inline_script_attributes', $attributes, $javascript );

		$javascript = "\n" . trim( $javascript, "\n\r " ) . "\n";

		return sprintf( "<script%s>%s</script>\n", wp_sanitize_script_attributes( $attributes ), $javascript );
	}
}


// !--sub_functions


add_action( 'add_meta_boxes', 'add_custom_box_flat_pm' );
add_action( 'save_post', 'save_postdata_flat_pm' );
add_action( 'init', 'register_post_types_flat_pm' );
add_action( 'saved_term', 'flat_pm_edit_term_hook', 10, 3 );
add_action( 'delete_term', 'flat_pm_edit_term_hook', 10, 3 );

add_action( 'admin_init', function(){
	$post_types = array_diff( get_post_types( array( 'public' => true ), 'names', 'and' ), array( 'flat_pm_block', 'attachment' ) );

	foreach ( $post_types as $type ) {
		add_filter( 'manage_' . $type . '_posts_columns', 'flat_pm_set_custom_edit_columns', FLATPM_INT_MAX );
		add_action( 'manage_' . $type . '_posts_custom_column' , 'flat_pm_custom_column', 10, 2 );
		add_filter( 'manage_edit-' . $type . '_sortable_columns', 'flat_pm_set_custom_sortable_columns' );
	}

	add_action( 'pre_get_posts', 'flat_pm_custom_orderby' );
	add_action( 'admin_head', 'flat_pm_admin_head_column_style' );
} );


add_shortcode( 'flat_pm', function( $args ){
	return '<span style="display:none" class="fpm-short-' . $args['id'] . '"></span>';
} );
?>