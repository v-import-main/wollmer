<?php
use YooKassa\Common\Exceptions\ApiException;
use YooKassa\Model\CurrencyCode;
use YooKassa\Model\MonetaryAmount;
use YooKassa\Model\PaymentData\B2b\Sberbank\VatData;
use YooKassa\Model\PaymentData\B2b\Sberbank\VatDataType;
use YooKassa\Model\PaymentData\PaymentDataB2bSberbank;
use YooKassa\Model\PaymentMethodType;
use YooKassa\Request\Payments\CreatePaymentRequest;
use YooKassa\Request\Payments\CreatePaymentRequestSerializer;

if (!class_exists('YooKassaGateway')) {
    return;
}

class YooKassaGatewayB2BSberbank extends YooKassaGateway
{
    public $paymentMethod = PaymentMethodType::B2B_SBERBANK;

    public $id = 'yookassa_b2b_sberbank';

    public function __construct()
    {
        parent::__construct();

        $this->icon               = YooKassa::$pluginUrl.'/assets/images/sb.png';

        $this->method_description = __('Сбербанк Бизнес Онлайн', 'yookassa');
        $this->method_title       = __('Сбербанк Бизнес Онлайн', 'yookassa');

        $this->defaultTitle       = __('Сбербанк Бизнес Онлайн', 'yookassa');
        $this->defaultDescription = __('Сбербанк Бизнес Онлайн', 'yookassa');

        $this->title       = $this->getTitle();
        $this->description = $this->getDescription();
    }

    /**
     * @param WC_Order $order
     *
     * @return mixed|WP_Error
     * @throws Exception
     */
    public function createPayment($order)
    {
        $builder = $this->getBuilder($order);

        $paymentRequest = $builder->build();

        $serializer     = new CreatePaymentRequestSerializer();
        $serializedData = $serializer->serialize($paymentRequest);
        YooKassaLogger::info('Create payment request: '.json_encode($serializedData));
        try {
            $response = $this->getApiClient()->createPayment($paymentRequest);

            return $response;
        } catch (ApiException $e) {
            YooKassaLogger::error('Api error: '.$e->getMessage());

            return new WP_Error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param WC_Order $order
     *
     * @param $save
     *
     * @return \YooKassa\Request\Payments\CreatePaymentRequestBuilder
     * @throws Exception
     */
    protected function getBuilder($order)
    {
        $paymentData = new PaymentDataB2bSberbank();
        $order_total = YooKassaOrderHelper::getTotal($order);
        $data        = $order->get_data();
        $items       = $order->get_items();
        $shipping    = $data['shipping_lines'];
        $hasShipping = (bool)count($shipping);
        $sbbolTaxes  = array();

        foreach ($items as $item) {
            $taxes        = $item->get_taxes();
            $sbbolTaxes[] = $this->getSbbolTaxRate($taxes);
        }

        if ($hasShipping) {
            $shippingData = array_shift($shipping);
            $taxes        = $shippingData->get_taxes();
            $sbbolTaxes[] = $this->getSbbolTaxRate($taxes);
        }

        $sbbolTaxes = array_unique($sbbolTaxes);

        if (count($sbbolTaxes) !== 1) {
            throw new Exception('У вас в корзине товары, для которых действуют разные ставки НДС — их нельзя оплатить одновременно. Можно разбить покупку на несколько этапов: сначала оплатить товары с одной ставкой НДС, потом — с другой.');
        }

        $vatType = reset($sbbolTaxes);

        if ($vatType !== VatDataType::UNTAXED) {
            YooKassaLogger::log('info', 'Vat rate : '.$vatType);
            $vatRate = $vatType;
            $vatSum  = $order_total * $vatRate / 100;
            $vatData = new VatData(
                VatDataType::CALCULATED,
                $vatRate,
                ['value' => round($vatSum, 2), 'currency' => CurrencyCode::RUB]
            );
        } else {
            $vatData = new VatData(VatDataType::UNTAXED);
        }
        $paymentData->setVatData($vatData);

        $paymentData->setPaymentPurpose($this->createPurposeDescription($order));

        $amount = YooKassaOrderHelper::getTotal($order);

        $builder = CreatePaymentRequest::builder()
                   ->setAmount(YooKassaOrderHelper::getAmountByCurrency($amount))
                   ->setPaymentMethodData($paymentData)
                   ->setCapture(true)
                   ->setDescription($this->createDescription($order))
                   ->setConfirmation(array(
                       'type'      => $this->confirmationType,
                       'returnUrl' => get_site_url(null, sprintf(self::getReturnUrlPattern(), $order->get_order_key())),
                   ))
                   ->setMetadata($this->createMetadata());
        YooKassaLogger::info('Return url: '.$order->get_checkout_payment_url(true));

        return $builder;
    }

    private function getSbbolTaxRate($taxes)
    {
        $taxRatesRelations = get_option('yookassa_sbbol_tax_rate');
        $defaultTaxRate    = get_option('yookassa_sbbol_default_tax_rate');

        if ($taxRatesRelations) {
            $taxesSubtotal = $taxes['total'];

            if ($taxesSubtotal) {
                $wcTaxIds = array_keys($taxesSubtotal);
                $wcTaxId  = $wcTaxIds[0];
                if (isset($taxRatesRelations[$wcTaxId])) {
                    return $taxRatesRelations[$wcTaxId];
                }
            }
        }

        return $defaultTaxRate;
    }

    /**
     * @param WC_Order $order
     *
     * @return string
     */
    public function createPurposeDescription($order)
    {
        $template = get_option('yookassa_sbbol_purpose', __('Оплата заказа №%order_number%', 'yookassa'));

        return $this->parseTemplateString($order, $template);
    }
}