<?php

use YooKassa\Client;
use YooKassa\Common\Exceptions\ApiException;
use YooKassa\Common\Exceptions\BadApiRequestException;
use YooKassa\Common\Exceptions\ForbiddenException;
use YooKassa\Common\Exceptions\InternalServerError;
use YooKassa\Common\Exceptions\NotFoundException;
use YooKassa\Common\Exceptions\ResponseProcessingException;
use YooKassa\Common\Exceptions\TooManyRequestsException;
use YooKassa\Common\Exceptions\UnauthorizedException;
use YooKassa\Model\Receipt\PaymentMode;
use YooKassa\Model\ReceiptCustomer;
use YooKassa\Model\ReceiptItem;
use YooKassa\Model\ReceiptType;
use YooKassa\Model\Settlement;
use YooKassa\Request\Receipts\CreatePostReceiptRequest;
use YooKassa\Request\Receipts\ReceiptResponseInterface;
use YooKassa\Request\Receipts\ReceiptResponseItemInterface;

/**
 * The second-receipt functionality of the plugin.
 */
class YooKassaSecondReceipt
{
    /**
     * @var Client
     */
    private $apiClient;

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    /**
     * @return Client
     * @throws Exception
     */
    private function getApiClient()
    {
        return YooKassaClientFactory::getYooKassaClient();
    }

    /**
     * @return array
     */
    public static function getValidPaymentMode()
    {
        return array(
            PaymentMode::FULL_PREPAYMENT,
//        пока не нужно, возможно в скором времени будем делать и для них.
//        PaymentMode::PARTIAL_PREPAYMENT,
//        PaymentMode::ADVANCE,
        );
    }

    /**
     * @param int $order_id
     *
     * @throws Exception
     */
    public function changeOrderStatusToProcessing($order_id)
    {
        $this->changeOrderStatus($order_id, 'ChangeOrderStatusToProcessing');
    }

    /**
     * @param int $order_id
     *
     * @throws Exception
     */
    public function changeOrderStatusToCompleted($order_id)
    {
        $this->changeOrderStatus($order_id, 'ChangeOrderStatusToCompleted');
    }

    /**
     * @param ReceiptResponseInterface $lastReceipt
     * @param string $paymentId
     * @param WC_Order $order
     *
     * @return CreatePostReceiptRequest|null
     */
    private function buildSecondReceipt($lastReceipt, $paymentId, $order)
    {
        if ($lastReceipt instanceof ReceiptResponseInterface) {
            if ($lastReceipt->getType() === "refund") {
                return null;
            }

            $resendItems = $this->getResendItems($lastReceipt->getItems());

            if (count($resendItems['items']) < 1) {
                YooKassaLogger::info('Second receipt is not required');
                return null;
            }

            try {
                $customer = $this->getReceiptCustomer($order);

                if (empty($customer)) {
                    YooKassaLogger::error('Need customer phone or email for second receipt');
                    return null;
                }

                $receiptBuilder = CreatePostReceiptRequest::builder();
                $receiptBuilder->setObjectId($paymentId)
                    ->setType(ReceiptType::PAYMENT)
                    ->setObjectType(ReceiptType::PAYMENT)
                    ->setItems($resendItems['items'])
                    ->setSettlements(
                        array(
                            new Settlement(
                                array(
                                    'type' => 'prepayment',
                                    'amount' => array(
                                        'value' => $resendItems['amount'],
                                        'currency' => 'RUB',
                                    ),
                                )
                            ),
                        )
                    )
                    ->setCustomer($customer)
                    ->setSend(true);

                return $receiptBuilder->build();
            } catch (Exception $e) {
                YooKassaLogger::error($e->getMessage() . '. Property name: '. $e->getProperty());
            }
        }

        return null;
    }

    /**
     * @param WC_Order $order
     * @return bool|ReceiptCustomer
     */
    private function getReceiptCustomer($order)
    {
        $customerData = array();

        if (!empty($order->get_billing_email())) {
            $customerData['email'] = $order->get_billing_email();
        }

        if (!empty($order->get_billing_phone())) {
            $customerData['phone'] = preg_replace('/[^\d]/', '', $order->get_billing_phone());
        }

        if (!empty($order->get_formatted_billing_full_name())) {
            $customerData['full_name'] = $order->get_formatted_billing_full_name();
        }

        return new ReceiptCustomer($customerData);
    }

    /**
     * @param ReceiptResponseInterface $response
     * @return float
     */
    private function getSettlementsAmountSum($response)
    {
        $amount = 0;

        foreach ($response->getSettlements() as $settlement) {
            $amount += $settlement->getAmount()->getIntegerValue();
        }

        return number_format($amount / 100.0, 2, '.', ' ');
    }

    /**
     * @param ReceiptResponseItemInterface[] $items
     *
     * @return array
     */
    private function getResendItems($items)
    {
        $result = array(
            'items'  => array(),
            'amount' => 0,
        );

        foreach ($items as $item) {
            if ( $this->isNeedResendItem($item->getPaymentMode()) ) {
                $item->setPaymentMode(PaymentMode::FULL_PAYMENT);
                $result['items'][] = new ReceiptItem($item->jsonSerialize());
                $result['amount'] += $item->getAmount() / 100.0;
            }
        }

        return $result;
    }


    /**
     * @param string $status
     * @return bool
     */
    private function isNeedSecondReceipt($status)
    {
        $status = $this->convertToWCStatus($status);
        YooKassaLogger::info('New status of order is ' . $status . '. We need is ' . $this->getSecondReceiptStatus() . '!');

        if (!$this->isSendReceiptEnable()) {
            return false;
        } elseif (!$this->isSecondReceiptEnable()) {
            return false;
        } elseif ($this->getSecondReceiptStatus() != $status) {
            return false;
        }

        return true;
    }

    /**
     * @param string $paymentMode
     *
     * @return bool
     */
    private function isNeedResendItem($paymentMode)
    {
        return in_array($paymentMode, self::getValidPaymentMode());
    }

    /**
     * @param $paymentId
     * @return mixed|ReceiptResponseInterface
     * @throws ApiException
     * @throws BadApiRequestException
     * @throws ForbiddenException
     * @throws InternalServerError
     * @throws NotFoundException
     * @throws ResponseProcessingException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     */
    private function getLastReceipt($paymentId)
    {
        $receipts = $this->getApiClient()->getReceipts(array('payment_id' => $paymentId))->getItems();

        return array_pop($receipts);
    }

    /**
     * @return bool
     */
    private function isSendReceiptEnable()
    {
        return (bool) get_option('yookassa_enable_receipt');
    }

    /**
     * @return bool
     */
    private function isSecondReceiptEnable()
    {
        return (bool) get_option('yookassa_enable_second_receipt');
    }

    /**
     * @return string
     */
    private function getSecondReceiptStatus()
    {
        return get_option('yookassa_second_receipt_order_status');
    }

    /**
     * Добавляет префикс 'wc-' для текущего статуса, если его нет
     *
     * @param string $status
     * @return string
     */
    private function convertToWCStatus($status)
    {
        return 'wc-' . ('wc-' === substr($status, 0, 3) ? substr($status, 3) : $status);
    }

    /**
     * @param int $order_id
     * @param string $type
     */
    private function changeOrderStatus($order_id, $type)
    {
        if (YooKassaHandler::isSelfEmployed()) {
            return;
        }

        YooKassaLogger::info('Init YooKassaSecondReceipt::' . $type);

        if (!$order_id) {
            YooKassaLogger::info('Order ID is empty!');
            return;
        }

        $order = wc_get_order($order_id);
        $paymentId = $order->get_transaction_id();

        if (!$this->isYooKassaOrder($order)) {
            YooKassaLogger::info('Payment method is not YooKassa!');
            return;
        }

        if (!$this->isNeedSecondReceipt($order->get_status())) {
            YooKassaLogger::info('Second receipt is not need!');
            return;
        }

        YooKassaLogger::info($type . ' PaymentId: ' . $paymentId);

        try {

            if ($lastReceipt = $this->getLastReceipt($paymentId)) {
                YooKassaLogger::info($type . ' LastReceipt:' . PHP_EOL . json_encode($lastReceipt->jsonSerialize()));
            } else {
                YooKassaLogger::info($type . ' LastReceipt is empty!');
                return;
            }

            if ($receiptRequest = $this->buildSecondReceipt($lastReceipt, $paymentId, $order)) {

                YooKassaLogger::info("Second receipt request data: " . PHP_EOL . json_encode($receiptRequest->jsonSerialize()));

                try {
                    $response = $this->getApiClient()->createReceipt($receiptRequest);
                } catch (Exception $e) {
                    YooKassaLogger::error('Request second receipt error: ' . $e->getMessage());
                    return;
                }

                $amount = $this->getSettlementsAmountSum($response);
                $comment = sprintf(__('Отправлен второй чек. Сумма %s рублей.', 'yookassa'), $amount);
                $order->add_order_note($comment, 0, false);
                YooKassaLogger::info('Request second receipt result: ' . PHP_EOL . json_encode($response->jsonSerialize()));
            }
        } catch (Exception $e) {
            YooKassaLogger::info($type . ' Error: ' . $e->getMessage());
            return;
        }
    }

    /**
     * @param WC_Order $order
     * @return bool
     */
    private function isYooKassaOrder(WC_Order $order)
    {
        $wcPaymentMethod = $order->get_payment_method();
        YooKassaLogger::info('Check PaymentMethod: ' . $wcPaymentMethod);

        return (strpos($wcPaymentMethod, 'yookassa_') !== false);
    }
}
