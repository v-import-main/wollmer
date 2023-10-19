<?php
/**
 * The installments functionality of the plugin.
 */
class YooKassaInstallments
{
    const MIN_AMOUNT = 3000;

    /**
     * @var string $plugin_name
     */
    private $plugin_name;

    /**
     * @param string $plugin_name
     */
    public function __construct($plugin_name)
    {
        $this->plugin_name = $plugin_name;
    }

    /**
     * @return void
     */
    public function showInfo()
    {
        $this->enqueue_styles();
        $this->enqueue_scripts();

        /** @var WC_Product $product */
        global $product;

        $showInfoInKassaMode = (get_option('yookassa_pay_mode') === '1') && (get_option('yookassa_epl_installments') === '1');

        $options              = (array)get_option('woocommerce_yookassa_installments_settings');
        $installments_enabled = (!empty($options['enabled']) && $options['enabled'] === 'yes');
        $showInfoInShopMode   = (get_option('yookassa_pay_mode') === '0') && $installments_enabled;

        if (!$showInfoInKassaMode && !$showInfoInShopMode) {
            return;
        }

        if (get_option('yookassa_add_installments_block') !== '1') {
            return;
        };

        $shopId   = get_option('yookassa_shop_id');
        $price    = $product->get_price();
        $language = mb_substr(get_bloginfo('language'), 0, 2);

        echo <<<HTML
<div class="installments-info"></div>
<script>
    jQuery(document).ready(function(){
        const yookassaCreditUI = CheckoutCreditUI({
            shopId: $shopId,
            sum: $price,
            language: '$language'
        });
        yookassaCreditUI({
            type: 'info',
            domSelector: '.installments-info'
        });
    });
</script>
HTML;
    }

    /**
     * @return void
     */
    public function showExtraCheckoutInfo()
    {
        global $woocommerce;
        $sum = (float)$woocommerce->cart->total;

        $shopId = get_option('yookassa_shop_id');

        $extraLabel = __('Заплатить по частям', 'yookassa');
        $extraInfo = __(' (%s ₽ в месяц)', 'yookassa');

        if (get_option('yookassa_epl_installments') == '1') {
            echo <<<END
<script>
        jQuery.get("https://yoomoney.ru/credit/order/ajax/credit-pre-schedule?shopId={$shopId}&sum={$sum}", 
        function (data) {
            const yookassa_installments_amount_text = "{$extraLabel} {$extraInfo}";
            if (yookassa_installments_amount_text && data && data.amount) {
                const label = jQuery('label[for=payment_method_yookassa_installments]');
                const img = label.find('img');
                label.text(yookassa_installments_amount_text.replace('%s', data.amount)).append(img);
            }
        });
</script>
END;
        }
    }

    /**
     * Register the stylesheets
     */
    private function enqueue_styles()
    {
        wp_enqueue_style(
            $this->plugin_name,
            YooKassa::$pluginUrl.'/assets/css/yookassa.css'
        );
    }

    /**
     * Register the JavaScript
     */
    private function enqueue_scripts()
    {
        global $wp;
        $product_page = (!empty($wp->query_vars['post_type']) && $wp->query_vars['post_type'] == 'product');
        if ((!$product_page && get_option('yookassa_epl_installments') == '1') ||
            ($product_page && get_option('yookassa_add_installments_block') == '1')) {
            wp_enqueue_script(
                $this->plugin_name,
                'https://static.yoomoney.ru/checkout-credit-ui/v1/index.js'
            );
        }
    }

}
