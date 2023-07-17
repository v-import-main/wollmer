<?php
function custom_image_srcset($sources, $size_array, $image_src, $image_meta, $attachment_id) {
    $ext = pathinfo($image_src, PATHINFO_EXTENSION);

    // Add the default source
    $sources[0]['type'] = 'image/' . $ext;

    // Add a webp source if supported by the browser
    if (function_exists('wp_get_image_mime')) {
        $mime_type = wp_get_image_mime($image_src);
        if ($mime_type && ($mime_type === 'image/png' || $mime_type === 'image/jpeg')) {
            $webp_src = $image_src.'.webp';
            $sources[] = array(
                'srcset' => esc_url($webp_src) . ' 1x, ' . esc_url($webp_src) . ' 2x',
                'type' => 'image/webp'
            );
        }
    }

    return $sources;
}

add_filter('wp_calculate_image_srcset', 'custom_image_srcset', 10, 5);



function crunchify_remove_plugin_stylesheet() {
    wp_dequeue_style( 'wc-blocks-style' );
    wp_deregister_style( 'wc-blocks-style' );
    if(is_front_page()){
        wp_dequeue_script( 'woosb-frontend' );
        wp_deregister_script( 'woosb-frontend' );

        wp_dequeue_script( 'wc-cart-fragments' );
        wp_deregister_script( 'wc-cart-fragments' );

        wp_dequeue_script( 'wc-add-to-cart' );
        wp_deregister_script( 'wc-add-to-cart' );

        wp_dequeue_script( 'woocommerce-inline' );
        wp_deregister_script( 'woocommerce-inline' );

        wp_dequeue_script( 'jquery-blockui' );
        wp_deregister_script( 'jquery-blockui' );

        wp_dequeue_script( 'woocommerce' );
        wp_deregister_script( 'woocommerce' );
    }
    if(!is_checkout()){
        wp_dequeue_style( 'wc-pb-checkout-blocks' );
        wp_deregister_style( 'wc-pb-checkout-blocks' );
    }
    if(!is_single() && !is_page()){
        wp_dequeue_style( 'wp-block-library' );
        wp_deregister_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-columns' );
        wp_deregister_style( 'wp-block-columns' );
        wp_dequeue_style( 'wp-block-column' );
        wp_deregister_style( 'wp-block-column' );
        wp_dequeue_style( 'global-styles' );
        wp_deregister_style( 'global-styles' );
    }
}
add_action( 'wp_enqueue_scripts', 'crunchify_remove_plugin_stylesheet', 100 );

function mihdan_add_async_attribute( $tag, $handle ) {
    if(!is_admin()) {
        if(
            $handle !== 'jquery' &&
            $handle !== 'jquery-core' &&
            $handle !== 'jquery-migrate'){
            return str_replace( ' src', ' async="async" src', $tag );
        }
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'mihdan_add_async_attribute', 10, 2 );



// add_image_size( 'reels', 240, 340 );


// Remove X-Pingback
add_filter('wp_headers', 'jltwp_adminify_remove_pingback_head');
add_action('wp', 'jltwp_adminify_remove_pingback');
function jltwp_adminify_remove_pingback_head($headers)
{
    if (isset($headers['X-Pingback'])) {
        unset($headers['X-Pingback']);
    }
    return $headers;
}

function jltwp_adminify_remove_pingback()
{
    if (function_exists('header_remove')) {
        header_remove('X-Pingback');
        header_remove('X-Pingback');
    }
}