<?php

require_once plugin_dir_path(__FILE__) . 'YooKassaInstaller.php';

/**
 * Fired during plugin deactivation
 */
class YooKassaDeactivator extends YooKassaInstaller
{
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate()
    {
        delete_option('woocommerce_yookassa_qiwi_settings');
        delete_option('woocommerce_yookassa_bank_card_settings');
        delete_option('woocommerce_yookassa_epl_settings');
        delete_option('woocommerce_yookassa_sberbank_settings');
        delete_option('woocommerce_yookassa_wallet_settings');
        delete_option('woocommerce_yookassa_cash_settings');
        delete_option('woocommerce_yookassa_webmoney_settings');
        delete_option('woocommerce_yookassa_alfabank_settings');
        delete_option('woocommerce_yookassa_installments_settings');

        self::log('info', 'YooKassa plugin deactivate!');
    }

}
