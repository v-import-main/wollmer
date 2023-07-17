<?php

//deregister unnessosary scripts
function my_dequeue_scripts()
{
  wp_dequeue_script('jquery-ui-core');
  wp_dequeue_script('jquery-ui-sortable');
  wp_dequeue_script('jquery');
  wp_dequeue_script('jquery-core');
  wp_dequeue_script('jquery-migrate');
}
//remove smthng
add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'wp_shortlink_wp_head');

remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// remove hAtom micromarkup
function remove_hentry($classes)
{
  $classes = array_diff($classes, array('hentry'));
  return $classes;
}
add_filter('post_class', 'remove_hentry');
// remove Emojii
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
add_filter('tiny_mce_plugins', 'disable_wp_emojis_in_tinymce');
function disable_wp_emojis_in_tinymce($plugins)
{
  if (is_array($plugins)) {
    return array_diff($plugins, array('wpemoji'));
  } else {
    return array();
  }
}

function get_items_arr($type) {
  $args = [
    'posts_per_page' => -1,
    'post_type' => $type,
  ];
  $tabs = get_posts($args);

  $tabs_list = ['0' => 'Не выбрано'];
  foreach ($tabs as $tab) {
    $tabs_list[$tab->ID] = $tab->post_title;
  }
  return $tabs_list;
}

function get_terms_arr($type) {
	//видимо, категории оформляются после карбонов, тк список при обычном гет_термс - пустой

	global $wpdb;
	$tabs_list = ['0' => 'Не выбрано'];
	$results = $wpdb->get_results("SELECT * from wp_term_taxonomy WHERE taxonomy = 'product_cat'");
	foreach($results as $result) {
		$cat_name = $wpdb->get_results("SELECT * from wp_terms WHERE term_id = '$result->term_taxonomy_id'")[0]->name;
		$tabs_list[$result->term_taxonomy_id] = $cat_name;

	}
	return $tabs_list;
}

/**
 * Theme setup.
 */
function tailpress_setup() {
	add_theme_support( 'title-tag' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'tailpress' ),
			'sidebar' => __( 'Sidebar Nav', 'tailpress' ),
			'footer_cats' => __( 'Footer cats', 'tailpress' ),
		)
	);

	add_theme_support(
		'woocommerce',
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/editor-style.css' );
}

add_action( 'after_setup_theme', 'tailpress_setup' );

/**
 * Enqueue theme assets.
 */
function tailpress_enqueue_scripts() {
	$theme = wp_get_theme();
	wp_enqueue_script('jquery', false, array(), $theme->get( 'Version' ), true);
	wp_enqueue_script('jquery-core', false, array('jquery'), $theme->get( 'Version' ), true);
	wp_enqueue_script('jquery-migrate', false, array('jquery-core'), $theme->get( 'Version' ), true);
	
	wp_enqueue_script( 'functions', tailpress_asset( 'js/functions.js' ), array('jquery-migrate'), $theme->get( 'Version' ), true );

	if(is_front_page()){
		// wp_enqueue_script( 'tailpress', tailpress_asset( 'js/index.js' ), array( 'jquery-migrate' ), $theme->get( 'Version' ), true );
		// wp_enqueue_script( 'index', tailpress_asset( 'js/frontpage_custom_script.js' ), array('functions'), $theme->get( 'Version' ), true );
	} else {
		wp_enqueue_script( 'tailpress', tailpress_asset( 'js/app.js' ), array('jquery-migrate'), $theme->get( 'Version' ), true );
		wp_enqueue_script( 'ajax_add_to_cart', tailpress_asset( 'js/ajax-add-to-cart.js' ), array('tailpress'), $theme->get( 'Version' ), true );
		wp_enqueue_style( 'tailpress', tailpress_asset( 'css/app.css' ), array(), $theme->get( 'Version' ) );
	}

	wp_enqueue_script( 'tailpress', tailpress_asset( 'js/app.js' ), array('jquery-migrate'), $theme->get( 'Version' ), true );
	wp_enqueue_script( 'ajax_add_to_cart', tailpress_asset( 'js/ajax-add-to-cart.js' ), array('tailpress'), $theme->get( 'Version' ), true );
}

add_action( 'wp_enqueue_scripts', 'tailpress_enqueue_scripts' );

/**
 * Get asset path.
 *
 * @param string  $path Path to asset.
 *
 * @return string
 */
function tailpress_asset( $path ) {
	if ( wp_get_environment_type() === 'production' ) {
		return get_stylesheet_directory_uri() . '/' . $path;
	}

	return add_query_arg( 'time', time(),  get_stylesheet_directory_uri() . '/' . $path );
}

/**
 * Adds option 'li_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The curren item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tailpress_nav_menu_add_li_class( $classes, $item, $args, $depth ) {
	if ( isset( $args->li_class ) ) {
		$classes[] = $args->li_class;
	}

	if ( isset( $args->{"li_class_$depth"} ) ) {
		$classes[] = $args->{"li_class_$depth"};
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'tailpress_nav_menu_add_li_class', 10, 4 );

/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The curren item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tailpress_nav_menu_add_submenu_class( $classes, $args, $depth ) {
	if ( isset( $args->submenu_class ) ) {
		$classes[] = $args->submenu_class;
	}

	if ( isset( $args->{"submenu_class_$depth"} ) ) {
		$classes[] = $args->{"submenu_class_$depth"};
	}

	return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'tailpress_nav_menu_add_submenu_class', 10, 3 );



// start
require_once __DIR__ . '/theme-helpers/cpt.php';
require_once __DIR__ . '/theme-helpers/taxonomy.php';
add_action('init', 'add_new_taxonomies', 0);
add_action('init', 'true_register_post_type_init');

add_action('after_setup_theme', 'crb_load');
function crb_load()
{
  require_once('vendor/autoload.php');
  \Carbon_Fields\Carbon_Fields::boot();
}

add_action('carbon_fields_register_fields', 'crb_register_custom_fields');
function crb_register_custom_fields()
{
  include_once __DIR__ . '/theme-helpers/custom-fields/base.php';
	include_once __DIR__ . '/theme-helpers/blocks/block-items.php';
	include_once __DIR__ . '/theme-helpers/blocks/block-reels.php';
	include_once __DIR__ . '/theme-helpers/blocks/block-news.php';
	include_once __DIR__ . '/theme-helpers/blocks/block-cats.php';
	include_once __DIR__ . '/theme-helpers/blocks/block-banner.php';
}

// include parts
require_once __DIR__ . '/data.php';

require_once __DIR__ . '/theme-helpers/funs/woo.php';

require_once __DIR__ . '/theme-helpers/funs/filtering.php';

require_once __DIR__ . '/theme-helpers/funs/sms.php';

require_once __DIR__ . '/theme-helpers/funs/optimizations.php';

require_once __DIR__ . '/theme-helpers/funs/search_suggestions.php';

add_filter('run_wptexturize', '__return_false');


register_block_style(
  'core/button',
  [
	'name' => 'btn',
    'label' => 'Желтая кнопка',
	'is_default'   => true,
  ]
);

function wpdocs_enqueue_custom_admin_style() {
	wp_register_style( 'custom_wp_admin_css', get_stylesheet_directory_uri() . '/template-parts/blocks/admin.css', false, uniqid() );
	wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'wpdocs_enqueue_custom_admin_style' );




function get_search_count(){
	global $wp_query;
	$count = $wp_query->found_posts;
	return $count . ' товаров';
}

function get_yt_code($yt_code) {
  preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
	if($matches[0] !== ''){
		$yt_code = $matches[0];
	} else {
		preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtube.com/)[^&\n]+#", $yt_code, $matches);
		if($matches[0] !== ''){
			$yt_code = $matches[0];
		} else {
			$yt_code = '....';
		}
	}
	return $yt_code;
}


add_filter('render_block', 'h2_anchore_2', 10, 3);

function h2_anchore_2($block_content, $block)
{
	if (is_admin()) return $block_content;
	if ("core/heading" !== $block['blockName']) return $block_content;
	// if (2 !== $block['attrs']['level']) return $block_content;
	// if (!$block['attrs']['toc']) return $block_content;

	$slug = cyr_to_lat_mini(mb_strimwidth(trim(strip_tags($block_content)), 0, 50, ''));
	return str_replace('h2', 'h2 id="' . $slug . '"', $block_content);
}


function cyr_to_lat_mini($content)
{
	$cyr = ['Љ', 'Њ', 'Џ', 'џ', 'ш', 'ђ', 'ч', 'ћ', 'ж', 'љ', 'њ', 'Ш', 'Ђ', 'Ч', 'Ћ', 'Ж', 'Ц', 'ц', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', ' '];
	$lat = ['l', 'n', 'd', 'd', 's', 'd', 'c', 'c', 'z', 'l', 'n', 's', 'd', 'c', 'c', 'z', 'c', 'c', 'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sht', 'a', 'i', 'y', 'e', 'yu', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'Io', 'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sht', 'A', 'I', 'Y', 'e', 'Yu', 'Ya', '-'];
	$content = str_replace($cyr, $lat, $content);
	return $content;
}



function get_care($product) {
	$cross_sells = $product->get_cross_sell_ids();
	if(!$cross_sells) return false;

	$cares = get_posts([
    'post_type' => 'product',
		'numberposts' => -1,
		'fields' => 'ids',
		'tax_query' => [
			[
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => 'wollmer-care',
				'operator' => 'IN'
			]
		]
	]);
	$match = array_intersect($cares, $cross_sells);
	if(!$match) return false;

	return get_post($match[array_key_first($match)])->ID;
}




function shailan_change_post_count( $query ) {
  global $wp_the_query;
    if ( ( ! is_admin() ) 
        && ( $query === $wp_the_query ) 
        && ( $query->is_search() ) ) {
      $query->set( 'posts_per_page', -1 ); // For search pages
    }
  return $query;
} add_action( 'pre_get_posts', 'shailan_change_post_count' );






add_action('wp_ajax_backorder', 'backorder');
add_action('wp_ajax_nopriv_backorder', 'backorder');
function backorder(){
	$data = $_POST['data'];

	$headers = array('Content-Type: text/html; charset=UTF-8');

	$p_name = wc_get_product( $data[0]['value'] )->get_name();

	date_default_timezone_set('Europe/Moscow');
	$theme = 'Поступил новый предзаказ ('.date("d-m H:i").'): '.$p_name;

	$message = '<p>Товар: '.$p_name;
	$message .= '<br>Цена: '.$data[1]['value'];
	$message .= '<br>URL: https://shop.wollmer.ru/'.$data[2]['value'];
	$message .= '<br>Имя: '.$data[3]['value'];
	$message .= '<br>Телефон: '.$data[4]['value'].'</p>';
	
	wp_mail(['grigiriy.malyshev@gmail.com','info@wollmer.ru','trusovandrey1@gmail.com'], $theme, $message, $headers );
	
	// create_order_from_oneclick( $data[0]['value'], $data[1]['value'], $data[2]['value'] );

	echo 'success!';
	wp_die();
}

add_action('wp_ajax_show_other_complects', 'show_other_complects');
add_action('wp_ajax_nopriv_show_other_complects', 'show_other_complects');
function show_other_complects() {
	$accs = explode(';',$_POST['accs']);
	foreach($accs as $product_id) {
		if(wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' )) {
			$product = wc_get_product( $product_id );
			get_template_part('template-parts/item', 'product',['product' => $product,'slider' => false]);
		}
	}
	wp_die();
}

add_action('wp_ajax_oneclickcorder', 'oneclickcorder');
add_action('wp_ajax_nopriv_oneclickcorder', 'oneclickcorder');
function oneclickcorder(){
	$data = $_POST['data'];

	$headers = array('Content-Type: text/html; charset=UTF-8');
	$p_name = wc_get_product( $data[0]['value'] )->get_name();

	$message = 'Товар: '.$p_name;
	$message .= '<br>Имя: '.$data[1]['value'];
	$message .= '<br>Телефон: '.$data[2]['value'];
	wp_mail( get_option('admin_email'), 'Новый заказ в 1 клик', '<p>'.$message.'</p>', $headers);

	create_order_from_oneclick( $data[0]['value'], $data[1]['value'], $data[2]['value'] );

	echo 'success!';
	wp_die();
}


function create_order_from_oneclick( $product_id, $name, $phone ) {
	$order = wc_create_order();

	$order->add_product( wc_get_product( $product_id ));

	$address = array(
		'first_name' => $name,
		'phone'      => $phone,
	);
	
	$order->set_address( $address, 'billing' );
	$order->set_address( $address, 'shipping' );

	$order->calculate_totals();
}




add_filter('render_block', 'custom_fonts', 10, 3);

function custom_fonts($block_content, $block)
{
	if (is_admin()) return $block_content;
	if ("core/heading" !== $block['blockName'] && "core/paragraph" !== $block['blockName']) return $block_content;
	if (!$block['attrs']['font']) return $block_content;

	$theme = wp_get_theme();
	wp_enqueue_style( 'custom_fonts', tailpress_asset( 'resources/fonts/custom_fonts.css' ), array(), $theme->get( 'Version' ) );
	return $block_content;
}



function edit_shop_query( $query )
{
	if ( is_shop() && !is_admin() ) {
		$taxquery = array(
			array(
			'taxonomy' => 'section_shop_tax',
			'field' => 'slug',
			'terms' => ['home','kitchen'],
			)
		);
	
		$query->set( 'tax_query', $taxquery );
		$query->set( 'posts_per_page', -1 );
	}
}
add_action('pre_get_posts', 'edit_shop_query' );






function __search_by_title_only( $search, &$wp_query )
{
    global $wpdb;
    if(empty($search)) {
        return $search; // skip processing - no search term in query
    }
    $q = $wp_query->query_vars;
    $n = !empty($q['exact']) ? '' : '%';
    $search =
    $searchand = '';
    foreach ((array)$q['search_terms'] as $term) {
        $term = esc_sql($wpdb->esc_like($term));
        $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
        $searchand = ' AND ';
    }
    if (!empty($search)) {
        $search = " AND ({$search}) ";
        if (!is_user_logged_in())
            $search .= " AND ($wpdb->posts.post_password = '') ";
    }
    return $search;
}
add_filter('posts_search', '__search_by_title_only', 500, 2);


function mytheme_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'mytheme_custom_excerpt_length', 999 );



add_action( 'wp_head', 'sdek_script' );
function sdek_script() {
	if(is_checkout()){
  		echo '<script id="ISDEKscript" type="text/javascript" src="https://widget.cdek.ru/widget/widjet.js" charset="utf-8"></script>';
	}
}


add_action( 'woocommerce_thankyou', 'my_custom_thankyou_template', 10, 1 );
function my_custom_thankyou_template( $order_id ) {
    wc_get_template( 'thankyou.php', array( 'order_id' => $order_id ) );
}


add_filter( 'woocommerce_thankyou_order_details', '__return_false' );


register_block_style(
	'core/list',
	[
	  'name' => 'yellow',
	  'label' => __( 'Yellow', 'textdomain' )
	]
);
register_block_style(
	'core/list',
	[
	  'name' => 'brand',
	  'label' => __( 'Brand', 'textdomain' )
	]
  );