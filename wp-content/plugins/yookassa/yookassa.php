<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             2.0.0
 * @package           YooKassa
 *
 * @wordpress-plugin
 * Plugin Name:       ЮKassa для WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/yookassa/
 * Description:       Платежный модуль для работы с сервисом ЮKassa через плагин WooCommerce
 * Version:           2.5.2
 * Author:            YooMoney
 * Author URI:        http://yookassa.ru
 * License URI:       https://yoomoney.ru/doc.xml?id=527132
 * Text Domain:       yookassa
 * Domain Path:       /languages
 *
 * WC requires at least: 3.7.0
 * WC tested up to: 7.4.1
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

function yookassa_plugin_activate()
{
    if (!yookassa_check_woocommerce_plugin_status()) {
        deactivate_plugins(__FILE__);
        $error_message = __("Плагин ЮKassa для WooCommerce требует, чтобы плагин <a href=\"https://wordpress.org/extend/plugins/woocommerce/\" target=\"_blank\">WooCommerce</a> был активен!", 'yookassa');
        wp_die($error_message);
    }
    require_once plugin_dir_path(__FILE__) . 'includes/YooKassaActivator.php';
    YooKassaActivator::activate();
}

function yookassa_plugin_deactivate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/YooKassaDeactivator.php';
    YooKassaDeactivator::deactivate();
}

/**
 * @return bool
 */
function yookassa_check_woocommerce_plugin_status()
{
    if (defined("RUNNING_CUSTOM_WOOCOMMERCE") && RUNNING_CUSTOM_WOOCOMMERCE === true) {
        return true;
    }
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        return true;
    }
    if (!is_multisite()) return false;
    $plugins = get_site_option('active_sitewide_plugins');
    return isset($plugins['woocommerce/woocommerce.php']);
}

register_activation_hook(__FILE__, 'yookassa_plugin_activate');
register_deactivation_hook(__FILE__, 'yookassa_plugin_deactivate');

if (yookassa_check_woocommerce_plugin_status()) {
    require plugin_dir_path(__FILE__) . 'includes/YooKassa.php';

    $plugin = new YooKassa();

    define('YOOKASSA_VERSION', $plugin->getVersion());

    $plugin->run();
}
