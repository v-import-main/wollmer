<?php
use YooKassa\Model\PaymentMethodType;

if ( ! class_exists('YooKassaGateway')) {
    return;
}

class YooKassaGatewaySberbank extends YooKassaGateway
{
    public $paymentMethod = PaymentMethodType::SBERBANK;

    public $id = 'yookassa_sberbank';

    public function __construct()
    {
        parent::__construct();

        $this->icon = YooKassa::$pluginUrl.'/assets/images/sb.png';

        $this->method_description = __('Оплата через Сбербанк', 'yookassa');
        $this->method_title       = __('SberPay', 'yookassa');

        $this->defaultTitle       = __('Оплата через Сбербанк', 'yookassa');
        $this->defaultDescription = __('SberPay', 'yookassa');

        $this->title              = $this->getTitle();
        $this->description        = $this->getDescription();
    }
}