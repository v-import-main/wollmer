<?php

use YooKassa\Client;
use YooKassa\Model\PaymentInterface;
use YooKassa\Model\PaymentMethodType;
use YooKassa\Model\PaymentStatus;
use YooKassa\Request\Payments\CreatePaymentRequestBuilder;
use YooKassa\Request\Payments\Payment\CreateCaptureRequest;
use YooKassa\Request\Payments\Payment\CreateCaptureRequestBuilder;

/**
 * The payment-facing functionality of the plugin.
 * @Todo rename class
 */
class YooKassaHandler
{
    const VAT_CODE_1 = 1;

    /**
     * @return bool
     */
    public static function isReceiptEnabled()
    {
        return get_option('yookassa_enable_receipt');
    }

    /**
     * @return bool
     */
    public static function isLegalEntity()
    {
        $taxRatesRelations = get_option('yookassa_tax_rate');
        $defaultTaxRate    = get_option('yookassa_default_tax_rate');

        return ($taxRatesRelations || $defaultTaxRate) && !self::isSelfEmployed();
    }

    /**
     * @return bool
     */
    public static function isSelfEmployed()
    {
        return (bool)get_option('yookassa_self_employed', '0');
    }

    /**
     * @param CreatePaymentRequestBuilder|CreateCaptureRequestBuilder $builder
     * @param WC_Order $order
     * @param bool $subscribe
     * @throws Exception
     */
    public static function setReceiptIfNeeded($builder, WC_Order $order, $subscribe = false)
    {
        if (!self::isReceiptEnabled()) {
            return;
        }

        if ($order->get_billing_email()) {
            $builder->setReceiptEmail($order->get_billing_email());
        }
        if ($order->get_billing_phone()) {
            $builder->setReceiptPhone(preg_replace('/[^\d]/', '', $order->get_billing_phone()));
        }

        $items = $order->get_items();

        /** @var WC_Order_Item_Product $item */
        foreach ($items as $item) {
            $amount = YooKassaOrderHelper::getAmountByCurrency($item->get_total() / $item->get_quantity() + $item->get_total_tax() / $item->get_quantity());
            if ($subscribe && $amount <= 0) {
                $amount = YooKassaGateway::MINIMUM_SUBSCRIBE_AMOUNT;
            }

            if (self::isSelfEmployed()) {
                $builder->addReceiptItem(
                    $item['name'],
                    $amount->getValue(),
                    $item->get_quantity(),
                    self::VAT_CODE_1
                );
            }

            if (self::isLegalEntity()) {
                $builder->addReceiptItem(
                    $item['name'],
                    $amount->getValue(),
                    $item->get_quantity(),
                    self::getYmTaxRate($item->get_taxes()),
                    self::getPaymentMode($item),
                    self::getPaymentSubject($item)
                );
            }
        }

        $orderData = $order->get_data();
        $shipping = $orderData['shipping_lines'];

        if (count($shipping)) {
            $shippingData = array_shift($shipping);
            if (self::isSelfEmployed() && $shippingData['total'] > 0) {
                $builder->addReceiptShipping(
                    __('Доставка', 'yookassa'),
                    $shippingData['total'],
                    self::VAT_CODE_1
                );
            }

            if (self::isLegalEntity()) {
                $amount = YooKassaOrderHelper::getAmountByCurrency($shippingData['total'] + $shippingData['total_tax']);
                $taxes = $shippingData->get_taxes();
                $builder->addReceiptShipping(
                    __('Доставка', 'yookassa'),
                    $amount->getValue(),
                    self::getYmTaxRate($taxes),
                    self::getShippingPaymentMode(),
                    self::getShippingPaymentSubject()
                );
            }
        }

        if (self::isLegalEntity()) {
            $defaultTaxSystemCode = get_option('yookassa_default_tax_system_code');
            if (!empty($defaultTaxSystemCode)) {
                $builder->setTaxSystemCode($defaultTaxSystemCode);
            }
        }
    }

    /**
     * @param WC_Order $order
     * @param PaymentInterface $payment
     */
    public static function updateOrderStatus(WC_Order $order, PaymentInterface $payment)
    {
        switch ($payment->getStatus()) {
            case PaymentStatus::SUCCEEDED:
                self::completeOrder($order, $payment);
                break;
            case PaymentStatus::CANCELED:
                self::cancelOrder($order, $payment);
                break;
            case PaymentStatus::WAITING_FOR_CAPTURE:
                self::holdOrder($order, $payment);
                break;
            case PaymentStatus::PENDING:
                self::pendingOrder($order, $payment);
                break;
        }
        YooKassaHandler::logOrderStatus($order->get_status());
    }

    /**
     * @param Client $apiClient
     * @param WC_Order $order
     * @param PaymentInterface $payment
     *
     * @return PaymentInterface|\YooKassa\Request\Payments\Payment\CreateCaptureResponse
     * @throws Exception
     * @throws \YooKassa\Common\Exceptions\ApiException
     * @throws \YooKassa\Common\Exceptions\BadApiRequestException
     * @throws \YooKassa\Common\Exceptions\ForbiddenException
     * @throws \YooKassa\Common\Exceptions\InternalServerError
     * @throws \YooKassa\Common\Exceptions\NotFoundException
     * @throws \YooKassa\Common\Exceptions\ResponseProcessingException
     * @throws \YooKassa\Common\Exceptions\TooManyRequestsException
     * @throws \YooKassa\Common\Exceptions\UnauthorizedException
     */
    public static function capturePayment(Client $apiClient, WC_Order $order, PaymentInterface $payment)
    {
        $builder = CreateCaptureRequest::builder();
        $builder->setAmount(YooKassaOrderHelper::getTotal($order));
        self::setReceiptIfNeeded($builder, $order);
        $captureRequest = $builder->build();

        $payment = $apiClient->capturePayment($captureRequest, $payment->getId());

        return $payment;
    }

    /**
     * @param WC_Order $order
     * @param PaymentInterface $payment
     */
    public static function completeOrder(WC_Order $order, PaymentInterface $payment)
    {
        $message = '';
        if ($payment->getPaymentMethod()->getType() == PaymentMethodType::B2B_SBERBANK) {
            $payerBankDetails = $payment->getPaymentMethod()->getPayerBankDetails();

            $fields  = array(
                'fullName'   => 'Полное наименование организации',
                'shortName'  => 'Сокращенное наименование организации',
                'adress'     => 'Адрес организации',
                'inn'        => 'ИНН организации',
                'kpp'        => 'КПП организации',
                'bankName'   => 'Наименование банка организации',
                'bankBranch' => 'Отделение банка организации',
                'bankBik'    => 'БИК банка организации',
                'account'    => 'Номер счета организации',
            );
            $message = '';

            foreach ($fields as $field => $caption) {
                if (isset($requestData[$field])) {
                    $message .= $caption . ': ' . $payerBankDetails->offsetGet($field) . '\n';
                }
            }
        }
        YooKassaLogger::info(
            sprintf(__('Успешный платеж. Id заказа - %1$s. Данные платежа - %2$s.', 'yookassa'),
                $order->get_id(), json_encode($payment))
        );
        $order->payment_complete($payment->getId());
        $order->add_order_note(sprintf(
                __('Номер транзакции в ЮKassa: %1$s. Сумма: %2$s', 'yookassa' . $message
                ), $payment->getId(), $payment->getAmount()->getValue())
        );
    }

    /**
     * @param WC_Order $order
     * @param PaymentInterface $payment
     */
    public static function competeSubscribe(WC_Order $order, PaymentInterface $payment)
    {
        YooKassaLogger::info(
            sprintf(__('Успешная подписка. Id заказа - %1$s. Данные платежа - %2$s.', 'yookassa'),
                $order->get_id(), json_encode($payment))
        );
        $order->payment_complete($payment->getId());
    }

    /**
     * @param WC_Order $order
     * @param PaymentInterface $payment
     */
    public static function cancelOrder(WC_Order $order, PaymentInterface $payment)
    {
        YooKassaLogger::warning(
            sprintf(__('Неуспешный платеж. Id заказа - %1$s. Данные платежа - %2$s.', 'yookassa'),
                $order->get_id(), json_encode($payment))
        );
        $order->update_status(YooKassaOrderHelper::WC_STATUS_CANCELLED);
    }

    /**
     * @param WC_Order $order
     * @param PaymentInterface $payment
     */
    public static function pendingOrder(WC_Order $order, PaymentInterface $payment)
    {
        YooKassaLogger::warning(
            sprintf(__('Платеж в ожидании оплаты. Id заказа - %1$s. Данные платежа - %2$s.', 'yookassa'),
                $order->get_id(), json_encode($payment))
        );
        $order->update_status(YooKassaOrderHelper::WC_STATUS_PENDING);
    }

    /**
     * @param WC_Order $order
     * @param PaymentInterface $payment
     */
    public static function holdOrder(WC_Order $order, PaymentInterface $payment)
    {
        YooKassaLogger::warning(
            sprintf(__('Платеж ждет подтверждения. Id заказа - %1$s. Данные платежа - %2$s.', 'yookassa'),
                $order->get_id(), json_encode($payment))
        );
        $order->update_status(YooKassaOrderHelper::WC_STATUS_ON_HOLD);
        $order->add_order_note(sprintf(
                __('Поступил новый платёж. Он ожидает подтверждения до %1$s, после чего автоматически отменится',
                    'yookassa'
                ), $payment->getExpiresAt()->format('d.m.Y H:i'))
        );
    }

    /**
     * @param string $status
     */
    public static function logOrderStatus($status)
    {
        YooKassaLogger::info(sprintf(__('Статус заказа. %1$s', 'yookassa'), $status));
    }

    /**
     * @param WC_Order $order
     * @return void
     * @throws Exception
     */
    public static function checkConditionForSelfEmployed(WC_Order $order)
    {
        $items = (int)$order->get_shipping_total() > 0 ? $order->get_items(['line_item', 'shipping']) : $order->get_items(['line_item']);
        if (count($items) > 6) {
            throw new Exception(
                __('<b>Нельзя добавить больше 6 разных позиций </b><br>Такое ограничение для владельца магазина. Уберите лишние позиции из корзины — остальные можно добавить в другом заказе.', 'yookassa')
            );
        }

        foreach ($items as $item) {
            if (!is_int($item->get_quantity())) {
                throw new Exception(
                    __('<b>Нельзя добавить позицию с дробным количеством </b><br>Только с целым. Свяжитесь с магазином, чтобы исправили значение и помогли сделать заказ.', 'yookassa')
                );
            }

            if ((int)$item->get_total() <= 0) {
                throw new Exception(
                    __('<b>Не получается создать чек </b><br>Цена позиции должна быть больше 0 ₽. Уберите позицию из корзины и попробуйте ещё раз.', 'yookassa')
                );
            }
        }
    }

    /**
     * @param $taxes
     *
     * @return int
     */
    private static function getYmTaxRate($taxes)
    {
        $taxRatesRelations = get_option('yookassa_tax_rate');
        $defaultTaxRate    = (int)get_option('yookassa_default_tax_rate');

        if ($taxRatesRelations) {
            $taxesSubtotal = $taxes['total'];
            if ($taxesSubtotal) {
                $wcTaxIds = array_keys($taxesSubtotal);
                $wcTaxId = $wcTaxIds[0];
                if (isset($taxRatesRelations[$wcTaxId])) {
                    return (int)$taxRatesRelations[$wcTaxId];
                }
            }
        }

        return $defaultTaxRate;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private static function getShippingPaymentMode()
    {
        $paymentModeValue = get_option('yookassa_shipping_payment_mode_default');
        self::checkValidModeOrSubject($paymentModeValue, true);
        return $paymentModeValue;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private static function getShippingPaymentSubject()
    {
        $paymentSubjectValue = get_option('yookassa_shipping_payment_subject_default');
        self::checkValidModeOrSubject($paymentSubjectValue, true);
        return $paymentSubjectValue;
    }

    /**
     * @param WC_Order_Item_Product $item
     * @return mixed
     * @throws Exception
     */
    private static function getPaymentMode($item)
    {
        if ($product = $item->get_product()) {
            $paymentModeValue = $product->get_attribute('pa_yookassa_payment_mode');
        }

        if (empty($paymentModeValue)) {
            $paymentModeValue = get_option('yookassa_payment_mode_default');
        }
        self::checkValidModeOrSubject($paymentModeValue);

        return $paymentModeValue;
    }

    /**
     * @param WC_Order_Item_Product $item
     * @return mixed
     * @throws Exception
     */
    private static function getPaymentSubject($item)
    {
        if ($product = $item->get_product()) {
            $paymentSubjectValue = $product->get_attribute('pa_yookassa_payment_subject');
        }

        if (empty($paymentSubjectValue)) {
            $paymentSubjectValue = get_option('yookassa_payment_subject_default');
        }
        self::checkValidModeOrSubject($paymentSubjectValue);

        return $paymentSubjectValue;
    }

    /**
     * @param $value
     * @param bool $isShipping
     * @throws Exception
     */
    private static function checkValidModeOrSubject($value, $isShipping = false)
    {
        if (!empty($value)) {
            return;
        }

        $errorMessage = 'Оплата временно не работает — ошибка на сайте. Пожалуйста, сообщите в техподдержку: «Не установлены признаки предмета или способа расчёта»';
        if ($isShipping) {
            $errorMessage = 'Оплата временно не работает — ошибка на сайте. Пожалуйста, сообщите в техподдержку: «Не установлены признаки предмета или способа расчёта для доставки»';
        }

        throw new Exception(
            __($errorMessage, 'yookassa')
        );
    }

}
