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
use YooKassa\Model\Notification\NotificationFactory;
use YooKassa\Model\NotificationEventType;
use YooKassa\Model\PaymentMethod\PaymentMethodBankCard;
use YooKassa\Model\PaymentMethod\PaymentMethodYooMoney;
use YooKassa\Model\PaymentMethodType;
use YooKassa\Model\PaymentStatus;
use YooKassa\Request\Payments\PaymentResponse;
use YooKassa\Request\Refunds\RefundResponse;
use Yoomoney\Includes\PaymentsTableModel;
use Yoomoney\Includes\CaptureNotificationChecker;
use Yoomoney\Includes\SucceededNotificationChecker;

/**
 * The payment-facing functionality of the plugin.
 */
class YooKassaPayment
{
    /** @var Client */
    private $apiClient;

    /** @var PaymentsTableModel */
    private $paymentsTableModel;

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
        $this->initRouter();
    }

    /**
     * @todo сделать нормальный роутер для ЧПУ
     */
    public function initRouter()
    {
        add_action( 'wp_loaded', function () {
            add_rewrite_endpoint('yookassa/returnUrl', EP_ALL);
        });

        add_filter('query_vars', function( $query_vars ) {
            if (in_array('yookassa/returnUrl', $query_vars)) {
                $query_vars[] = 'yookassa-order-id';
            }
            return $query_vars;
        });

        add_action('template_redirect', function() {
            $orderId = get_query_var('yookassa-order-id');
            if (!empty($orderId)) {
                $gateway = new YooKassaGateway();
                $gateway->processReturnUrl($orderId);
            }
        });
    }

    /**
     * @return PaymentsTableModel
     */
    public function getPaymentTableModel()
    {
        if (!$this->paymentsTableModel) {
            global $wpdb;
            $this->paymentsTableModel = new PaymentsTableModel($wpdb);
        }
        return $this->paymentsTableModel;
    }

    /**
     * @param $viewPath
     * @param $args
     *
     * @return false|string
     */
    private function render($viewPath, $args)
    {
        ob_start();
        extract($args);
        include (plugin_dir_path(__FILE__) . $viewPath);
//        ob_flush();
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }


    public function addGateways($methods)
    {
        global $woocommerce;
        $installmentsOn = !isset($woocommerce->cart)
                          || !isset($woocommerce->cart->total)
                          || $woocommerce->cart->total >= YooKassaInstallments::MIN_AMOUNT;

        $shopPassword = get_option('yookassa_shop_password');
        $prefix       = substr($shopPassword, 0, 4);
        $testMode  = $prefix == "test";

        if (get_option('yookassa_pay_mode') == '1') {
            $methods[] = 'YooKassaGatewayEPL';
            if ((get_option('yookassa_epl_installments') == '1') && $installmentsOn) {
                $methods[] = 'YooKassaGatewayInstallments';
            }
        } else {
            $methods[] = 'YooKassaWidgetGateway';
            if ($testMode) {
                $methods[] = 'YooKassaGatewayCard';
                $methods[] = 'YooKassaGatewayWallet';
            } else {
                if (get_option('yookassa_enable_sbbol') == '1') {
                    $methods[] = 'YooKassaGatewayB2BSberbank';
                }
                $methods[] = 'YooKassaGatewayCard';
                $methods[] = 'YooKassaGatewayQiwi';
                $methods[] = 'YooKassaGatewayCash';
                $methods[] = 'YooKassaGatewaySberbank';
                $methods[] = 'YooKassaGatewayWallet';
                $methods[] = 'YooKassaGatewayTinkoffBank';
                $methods[] = 'YooKassaGatewaySbp';
            }
            if ($installmentsOn) {
                $methods[] = 'YooKassaGatewayInstallments';
            }
        }

        return $methods;
    }

    public function loadGateways()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGateway.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGatewayCard.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGatewayAlfabank.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGatewayQiwi.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGatewayWebmoney.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGatewayCash.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGatewaySberbank.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGatewayWallet.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGatewayEPL.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGatewayInstallments.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGatewayB2bSberbank.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGatewayTinkoffBank.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaGatewaySbp.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YooKassaWidgetGateway.php';
    }

    public function processCallback()
    {
        if (
            $_SERVER['REQUEST_METHOD'] == "POST" &&
            isset($_REQUEST['yookassa'])
            && $_REQUEST['yookassa'] == 'callback'
        ) {

            YooKassaLogger::info('Notification init');
            $body           = @file_get_contents('php://input');
            $callbackParams = json_decode($body, true);
            YooKassaLogger::info('Notification body: '.$body);

            if (!json_last_error()) {
                try {
                    $this->processNotification($callbackParams);
                } catch (Exception $e) {
                    YooKassaLogger::error("Error while process notification: ".$e->getMessage());
                }
            } else {
                YooKassaLogger::info('Notification json error');
                header("HTTP/1.1 400 Bad Request");
                header("Status: 400 Bad Request");
            }
            exit();
        }
    }

    /**
     * @param $callbackParams
     *
     * @throws ApiException
     * @throws BadApiRequestException
     * @throws ForbiddenException
     * @throws InternalServerError
     * @throws NotFoundException
     * @throws ResponseProcessingException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws Exception
     */
    protected function processNotification($callbackParams)
    {
        YooKassaLogger::info('Process notification init');

        $paymentTableModel = $this->getPaymentTableModel();
        $captureNtfChecker = new CaptureNotificationChecker($paymentTableModel);
        $succeededNtfChecker = new SucceededNotificationChecker($paymentTableModel);

        $gateway = new YooKassaGateway();

        try {
            $fabric = new NotificationFactory();
            $notificationModel = $fabric->factory($callbackParams);
            // todo: refund.succeeded support
            if ($notificationModel->getEvent() == NotificationEventType::REFUND_SUCCEEDED) {
                /** @var RefundResponse $refund */
                $refund = $notificationModel->getObject();
                $order = YooKassaOrderHelper::getOrderIdByPayment($refund->getPaymentId());
                YooKassaLogger::info(sprintf(
                    'Refund %s %s for Order #%s (paymentId %s)',
                    $refund->getAmount()->getValue(),
                    $refund->getAmount()->getCurrency(),
                    $order ? $order->get_order_number() : '???',
                    $refund->getPaymentId()
                ));
                exit();
            }
        } catch (\Exception $e) {
            YooKassaLogger::error('Invalid notification object - '.$e->getMessage());
            header("HTTP/1.1 400 Bad Request");
            header("Status: 400 Bad Request");
            exit();
        }

        /** @var PaymentResponse $payment */
        $payment = $notificationModel->getObject();
        $order   = YooKassaOrderHelper::getOrderIdByPayment($payment->getId());
        if (!$order) {
            $paymentMethod = $payment->getPaymentMethod();
            $userId        = $payment->getMetadata()->offsetGet('wp_user_id');
            $token         = null;
            if (!empty($userId)) {
                $tokens = WC_Payment_Tokens::get_customer_tokens($userId);
                foreach ($tokens as $tokenObject) {
                    if ($tokenObject->get_token() == $paymentMethod->id) {
                        $token = $tokenObject;
                        break;
                    }
                }
            }

            if ($paymentMethod->getSaved()
                && $payment->getMetadata()->offsetExists('wp_user_id')
                && $payment->getStatus() === PaymentStatus::WAITING_FOR_CAPTURE) {
                YooKassaLogger::info('Token init');
                try {
                    $token = $this->prepareToken($paymentMethod, $payment);
                } catch (\Exception $e) {
                    YooKassaLogger::error('Token prepare failed '.$e->getMessage());
                }

                YooKassaLogger::info('Token before save');

                if ($token->save()) {
                    YooKassaLogger::info('Token saved id:'.$token->get_id());
                    $this->getApiClient()->cancelPayment($payment->getId());
                    exit();
                } else {
                    YooKassaLogger::info('Token validate failed');
                }
            }

            YooKassaLogger::error('Order not found for payment '.$payment->getId());
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            exit();
        }

        $payment = $this->getApiClient()->getPaymentInfo($payment->getId());

        if ($payment->getMetadata()->offsetExists('subscribe_trial')) {
            if($this->cancelPayment($payment) === false) {
                YooKassaLogger::error('Wrong payment status: '.$payment->getStatus());
                header("HTTP/1.1 402 Payment Required");
                header("Status: 402 Payment Required");
                exit();
            }
            YooKassaHandler::competeSubscribe($order, $payment);
            $saveMethod = $payment->getMetadata()->offsetGet('subscribe_payment_save_card');
            if ($saveMethod) {
                $token = $this->prepareToken($payment->getPaymentMethod(), $payment);
                if (!$token->save()) {
                    YooKassaLogger::info('Token validate failed');
                } else {
                    YooKassaLogger::info('Token saved id:'.$token->get_id());
                }
            }
            exit();
        }

        $updateData = array(
            'status' => $payment->getStatus(),
        );
        if ($paymentMethod = $payment->getPaymentMethod()) {
            $updateData['payment_method_id'] = $paymentMethod->getId();
        }

        if ($payment->getStatus() === PaymentStatus::SUCCEEDED) {
            if ($succeededNtfChecker->isHandled($notificationModel)) {
                return;
            }
            $updateData['paid'] = 'Y';
            $updateData['captured_at'] = date('Y-m-d H:i:s');
            $gateway->updatePaymentData($payment->getId(), $updateData);

            /** @var PaymentMethodYooMoney $paymentMethod */
            $paymentMethod = $payment->paymentMethod;
            $userId        = $payment->getMetadata()->offsetGet('wp_user_id');

            $isNeedSavedCard = $paymentMethod->getSaved() && !empty($userId);
            if ($payment->getMetadata()->offsetExists('subscribe_payment_save_card')) {
                $isNeedSavedCard = $paymentMethod->getSaved()
                    && !empty($userId)
                    && $payment->getMetadata()->offsetGet('subscribe_payment_save_card');
            }

            if ($isNeedSavedCard) {
                $token = $this->prepareToken($paymentMethod, $payment);
                if (!$token->save()) {
                    YooKassaLogger::info('Token validate failed');
                } else {
                    YooKassaLogger::info('Token saved id:'.$token->get_id());
                }
            } else {
                YooKassaLogger::info('Token not entered saved = ' . $paymentMethod->getSaved() . ' !empty($userId) = ' . $userId);
            }
            YooKassaLogger::info('Init complete order');
            YooKassaHandler::completeOrder($order, $payment);

            $order->set_transaction_id($payment->getId());
        } elseif ($payment->getStatus() === PaymentStatus::WAITING_FOR_CAPTURE) {
            if ($captureNtfChecker->isHandled($notificationModel)) {
                return;
            }
            YooKassaLogger::info('Init waiting for capture');

            $updateData['paid'] = 'Y';
            $gateway->updatePaymentData($payment->getId(), $updateData);

            $capturePaymentMethods = array(
                PaymentMethodType::BANK_CARD,
                PaymentMethodType::YOO_MONEY,
                PaymentMethodType::GOOGLE_PAY,
                PaymentMethodType::APPLE_PAY,
            );
            if (in_array($payment->getPaymentMethod()->getType(), $capturePaymentMethods)) {
                YooKassaHandler::holdOrder($order, $payment);
            } else {
                $updateData['captured_at'] = date('Y-m-d H:i:s');
                YooKassaHandler::capturePayment($this->getApiClient(), $order, $payment);
            }

            $order->set_transaction_id($payment->getId());
        } elseif ($payment->getStatus() === PaymentStatus::CANCELED) {
            $updateData['paid'] = 'N';
        } else {
            YooKassaLogger::error('Wrong payment status: '.$payment->getStatus());
            header("HTTP/1.1 402 Payment Required");
            header("Status: 402 Payment Required");
            $updateData['paid'] = 'N';
        }

        $gateway->updatePaymentData($payment->getId(), $updateData);

        exit();
    }

    public function validStatuses()
    {
        return array('processing', 'completed', 'on-hold', 'pending');
    }

    public function checkPaymentStatus()
    {
        $order_id  = sanitize_key($_GET['order-id']);
        YooKassaLogger::info('CheckPaymentStatus Init: ' . $order_id);

        $order     = wc_get_order($order_id);
        $paymentId = $order->get_transaction_id();

        if (!$this->isYooKassaOrder($order)) {
            YooKassaLogger::info('Payment method is not YooKassa!');
            wp_die();
        }

        try {
            $payment = $this->getApiClient()->getPaymentInfo($paymentId);
            $result = json_encode(array(
                'result' => 'success',
                'status' => $payment->getStatus(),
                'redirectUrl' => $order->get_checkout_payment_url()
            ));
            YooKassaLogger::info('CheckPaymentStatus: ' . $result);
            echo $result;
        } catch (Exception $e) {
            YooKassaLogger::error('CheckPaymentStatus Error: ' . $e->getMessage());
        }
        wp_die();
    }

    /**
     * @param int $order_id
     *
     * @throws Exception
     */
    public function changeOrderStatusToProcessing($order_id)
    {
        YooKassaLogger::info('Init changeOrderStatusToProcessing');
        if (!get_option('yookassa_enable_hold')) {
            return;
        }
        if (!$order_id) {
            return;
        }

        $order     = wc_get_order($order_id);
        $paymentId = $order->get_transaction_id();

        if (!$this->isYooKassaOrder($order)) {
            YooKassaLogger::info('Payment method is not YooKassa!');
            return;
        }

        try {
            $payment = $this->getApiClient()->getPaymentInfo($paymentId);

            $payment = YooKassaHandler::capturePayment($this->getApiClient(), $order, $payment);
            if ($payment->getStatus() === PaymentStatus::SUCCEEDED) {
                $order->payment_complete($payment->getId());
                $order->add_order_note(__('Вы подтвердили платёж в ЮKassa.', 'yookassa'));
            } elseif ($payment->getStatus() === PaymentStatus::CANCELED) {
                YooKassaHandler::cancelOrder($order, $payment);
                $order->add_order_note(__('Платёж не подтвердился. Попробуйте ещё раз.', 'yookassa'));
            } else {
                $order->update_status(YooKassaOrderHelper::WC_STATUS_ON_HOLD);
                $order->add_order_note(__('Платёж не подтвердился. Попробуйте ещё раз.', 'yookassa'));
            }
        } catch (Exception $e) {
            $order->update_status(YooKassaOrderHelper::WC_STATUS_ON_HOLD);
            $order->add_order_note(__('Платёж не подтвердился. Попробуйте ещё раз.', 'yookassa'));
            YooKassaLogger::error('Api error: '.$e->getMessage());
        }
    }

    /**
     * @param int $order_id
     *
     * @throws Exception
     */
    public function changeOrderStatusToCancelled($order_id)
    {
        YooKassaLogger::info('Init changeOrderStatusToCancelled');
        if (!get_option('yookassa_enable_hold')) {
            return;
        }
        if (!$order_id) {
            return;
        }

        $order     = wc_get_order($order_id);
        $paymentId = $order->get_transaction_id();

        if (!$this->isYooKassaOrder($order)) {
            YooKassaLogger::info('Payment method is not YooKassa!');
            return;
        }

        try {
            $payment = $this->getApiClient()->cancelPayment($paymentId);
            if ($payment->getStatus() === PaymentStatus::CANCELED) {
                $order->add_order_note(__('Вы отменили платёж в ЮKassa. Деньги вернутся клиенту.', 'yookassa'));
            } else {
                $order->update_status(YooKassaOrderHelper::WC_STATUS_ON_HOLD);
                $order->add_order_note(__('Платёж не отменился. Попробуйте ещё раз.', 'yookassa'));
            }
        } catch (Exception $e) {
            $order->update_status(YooKassaOrderHelper::WC_STATUS_ON_HOLD);
            $order->add_order_note(__('Платёж не отменился. Попробуйте ещё раз.', 'yookassa'));
            YooKassaLogger::error('Api error: '.$e->getMessage());
        }
    }

    public function getAccountSavedPaymentMethodsListItem($item, $payment_token)
    {
        if ('ym' === strtolower($payment_token->get_type())) {
            $item['method']['last4'] = $payment_token->get_last4();
            $item['method']['brand'] = esc_html__('Кошелек ЮMoney', 'yookassa');
        }

        return $item;
    }

    /**
     * @param $payment
     * @return bool
     */
    protected function cancelPayment($payment)
    {
        $apiClient = $this->getApiClient();
        if ($payment->getStatus() === PaymentStatus::WAITING_FOR_CAPTURE) {
            try {
                $response = $apiClient->cancelPayment($payment->getId());
            } catch (Exception $e) {
                YooKassaLogger::info($e->getMessage());
                return false;
            }

            if ($response->getStatus() === PaymentStatus::CANCELED) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Client
     */
    private function getApiClient()
    {
        return YooKassaClientFactory::getYooKassaClient();
    }

    /**
     * @param $paymentMethod
     * @param $payment
     *
     * @return WC_Payment_Token|WC_Payment_Token_CC
     */
    protected function prepareToken($paymentMethod, $payment)
    {

        if ($paymentMethod->getType() == PaymentMethodType::BANK_CARD) {

            $userId = $payment->getMetadata()->offsetGet('wp_user_id');
            $token  = null;
            if (!empty($userId)) {
                $tokens = WC_Payment_Tokens::get_customer_tokens($userId, 'yookassa_'.$paymentMethod->getType());
                foreach ($tokens as $token) {
                    if ($token->get_token() == $paymentMethod->id || $token->get_last4() == $paymentMethod->getLast4()) {
                        return $token;
                    }
                }
            }

            $token = new WC_Payment_Token_CC();

            /** @var PaymentMethodBankCard $paymentMethod */
            $token->set_card_type($paymentMethod->getCardType());
            $token->set_last4($paymentMethod->getLast4());
            $token->set_expiry_month($paymentMethod->getExpiryMonth());
            $token->set_expiry_year($paymentMethod->getExpiryYear());
            $token->set_gateway_id('yookassa_'.$paymentMethod->getType());
        } else {
            $accountLast4 = substr($paymentMethod->getAccountNumber(), -4);

            $userId = $payment->getMetadata()->offsetGet('wp_user_id');
            $token  = null;
            if (!empty($userId)) {
                $tokens = WC_Payment_Tokens::get_customer_tokens($userId, 'yookassa_wallet');
                foreach ($tokens as $token) {
                    if ($token->get_token() == $paymentMethod->id || $token->get_last4() == $accountLast4) {
                        return $token;
                    }
                }
            }

            $token = new WC_Payment_Token_YooKassa();
            $token->set_gateway_id('yookassa_wallet');
            /** @var PaymentMethodYooMoney $paymentMethod */
            $token->set_last4($accountLast4);
        }

        $token->set_token($paymentMethod->id);
        $token->set_user_id($payment->getMetadata()->offsetGet('wp_user_id'));

        return $token;
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
