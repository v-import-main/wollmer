<?php
function custom_image_srcset($sources, $size_array, $image_src, $image_meta, $attachment_id) {
    $ext = pathinfo($image_src, PATHINFO_EXTENSION);

    // Add the default source
    $sources[0]['type'] = 'image/' . $ext;

    // Add a webp source if supported by the browser
    if (function_exists('wp_get_image_mime')) {
        $mime_type = wp_get_image_mime($image_src);
        if ($mime_type && ($mime_type === 'image/png' || $mime_type === 'image/jpeg')) {
            $webp_src = str_replace('.' . $ext, '.webp', $image_src);
            $sources[] = array(
                'srcset' => esc_url($webp_src) . ' 1x, ' . esc_url($webp_src) . ' 2x',
                'type' => 'image/webp'
            );
        }
    }
    
    return $sources;
}

add_filter('wp_calculate_image_srcset', 'custom_image_srcset', 10, 5);