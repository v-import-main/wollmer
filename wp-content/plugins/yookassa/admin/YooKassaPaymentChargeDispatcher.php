<?php


use YooKassa\Client;
use YooKassa\Common\Exceptions\ApiException;

/**
 * Class YooKassaPaymentChargeDispatcher
 */
class YooKassaPaymentChargeDispatcher
{
    /**
     * @var Client
     */
    private $apiClient;

    /**
     * YooKassaPaymentChargeDispatcher constructor.
     */
    public function __construct()
    {
        $this->apiClient = $this->getApiClient();
    }

    /**
     * @param string $paymentId
     * @throws Exception
     */
    public function tryChargePayment($paymentId)
    {
        try {
            $order   = $this->getOrderIdByPayment($paymentId);
            $payment = $this->getApiClient()->getPaymentInfo($paymentId);
            YooKassaHandler::updateOrderStatus($order, $payment);
        } catch (ApiException $e) {
            YooKassaLogger::error('Api error: '.$e->getMessage());
        }
    }

    /**
     * @return Client
     */
    private function getApiClient()
    {
        return YooKassaClientFactory::getYooKassaClient();
    }

    /**
     * @param $id
     *
     * @return null|WC_Order
     */
    private function getOrderIdByPayment($id)
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
}