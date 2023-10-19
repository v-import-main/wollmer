<?php
/**
 * Plugin Name: Wollmer Gutenberg Blocks
 * Author: Grigiriy from Webique
 * Version: 1.0.0
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
  exit;
}

function wollmer_extentions() {
  // $config = plugin_dir_url(__FILE__) . '/build/index.asset.php';

  wp_enqueue_script(
    'wollmer_extentions',
    plugin_dir_url(__FILE__) . '/build/index.js',
    array('wp-element','wp-editor'),
    rand(1,9999)
  );
}
   
add_action('enqueue_block_editor_assets', 'wollmer_extentions');
