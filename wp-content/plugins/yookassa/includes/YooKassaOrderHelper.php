<?php

use YooKassa\Model\CurrencyCode;
use YooKassa\Model\MonetaryAmount;

class YooKassaOrderHelper
{
    const WC_STATUS_COMPLETED = 'wc-completed';
    const WC_STATUS_PENDING = 'wc-pending';
    const WC_STATUS_CANCELLED = 'wc-cancelled';
    const WC_STATUS_ON_HOLD = 'wc-on-hold';
    const WC_STATUS_PROCESSING = 'wc-processing';

    /**
     * @param string $id
     * @return null|WC_Order
     */
    public static function getOrderIdByPayment($id)
    {
        global $wpdb;

        $query  = "
            SELECT *
            FROM {$wpdb->prefix}postmeta
            WHERE meta_value = %s AND meta_key = '_transaction_id'
        ";
        $sql    = $wpdb->prepare($query, $id);
        $result = $wpdb->get_row($sql);

        if ($result) {
            $orderId = $result->post_id;
            $order   = new WC_Order($orderId);

            return $order;
        } else {
            $query  = "
                SELECT *
                FROM {$wpdb->prefix}yookassa_payment
                WHERE payment_id = %s
            ";
            $sql    = $wpdb->prepare($query, $id);
            $result = $wpdb->get_row($sql);

            if ($result) {
                $orderId = $result->order_id;
                $order   = new WC_Order($orderId);

                return $order;
            }
        }

        return null;
    }

    /**
     * @param WC_Order $order
     * @return string
     */
    public static function getTotal(WC_Order $order)
    {
        return (version_compare(WOOCOMMERCE_VERSION, "3.0", ">="))
            ? $order_total = (string)$order->get_total()
            : $order_total = number_format($order->order_total, 2, '.', '');
    }

    public static function getAmountByCurrency($amount)
    {
        $kassaCurrency = get_option('yookassa_kassa_currency', CurrencyCode::RUB);
        if (get_option('yookassa_kassa_currency_convert') == 1) {
            $amount = self::convertFromCbrf($amount, $kassaCurrency);
        }

        return new MonetaryAmount($amount, $kassaCurrency);
    }

    /**
     * @param float $amount
     * @param string $currency
     * @return string
     * @throws Exception
     */
    public static function convertFromCbrf($amount, $currency)
    {
        $config_currency = get_woocommerce_currency();

        if ($config_currency == $currency) {
            return $amount;
        }

        $courses = self::getCbrfCourses();
        if ((!empty($courses[$currency]) || $currency === CurrencyCode::RUB)
            && (!empty($courses[$config_currency]) || $config_currency === CurrencyCode::RUB)) {
            $input  = $config_currency != CurrencyCode::RUB ? $courses[$config_currency] : 1.0;
            $output = $currency != CurrencyCode::RUB ? $courses[$currency] : 1.0;

            return number_format($amount * $input / $output, 2, '.', '');
        } else {
            YooKassaLogger::error('CBRF Error: Can\'t get currency list!');
            throw new Exception(__('Ошибка ЦБ РФ: не удается получить список валют!', 'yookassa'), 404);
        }
    }

    public static function getCbrfCourses()
    {
        $cache = new YooKassaFileCache(60*60*6);
        $courses = $cache->get('cbrf_courses');
        if (!$courses) {
            $cbrf = new YooKassaCBRAgent();
            $courses = $cbrf->getList();
            $cache->set('cbrf_courses', $courses);
            YooKassaLogger::info(sprintf("Get CBRF courses \n%s", print_r($courses, true)));
        }
        return $courses;
    }
}
