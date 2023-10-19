<?php
use YooKassa\Model\PaymentMethodType;

if ( ! class_exists('YooKassaGateway')) {
    return;
}


class YooKassaGatewayWebmoney extends YooKassaGateway
{
    public $paymentMethod = PaymentMethodType::WEBMONEY;

    public $id = 'yookassa_webmoney';

    public function __construct()
    {
        parent::__construct();

        $this->icon = YooKassa::$pluginUrl.'/assets/images/wm.png';

        $this->method_description = __('Webmoney', 'yookassa');
        $this->method_title       = __('Webmoney', 'yookassa');

        $this->defaultTitle       = __('Webmoney', 'yookassa');
        $this->defaultDescription = __('Webmoney', 'yookassa');

        $this->title              = $this->getTitle();
        $this->description        = $this->getDescription();
    }
}