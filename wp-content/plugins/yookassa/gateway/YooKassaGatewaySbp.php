<?php
use YooKassa\Model\PaymentMethodType;

if ( ! class_exists('YooKassaGateway')) {
    return;
}


class YooKassaGatewaySbp extends YooKassaGateway
{
    public $paymentMethod = PaymentMethodType::SBP;

    public $id = 'yookassa_sbp';

    public function __construct()
    {
        parent::__construct();

        $this->icon = YooKassa::$pluginUrl.'/assets/images/sbp.png';

        $this->method_title       = __('СБП', 'yookassa');
        $this->method_description = __('Система быстрых платежей ЦБ РФ для мгновенного перевода денег в другие банки', 'yookassa');

        $this->defaultTitle       = __('СБП', 'yookassa');
        $this->defaultDescription = __('Система быстрых платежей ЦБ РФ для мгновенного перевода денег в другие банки', 'yookassa');

        $this->title              = $this->getTitle();
        $this->description        = $this->getDescription();
    }
}
