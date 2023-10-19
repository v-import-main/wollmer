<?php
use YooKassa\Model\PaymentMethodType;

if ( ! class_exists('YooKassaGateway')) {
    return;
}


class YooKassaGatewayTinkoffBank extends YooKassaGateway
{
    public $paymentMethod = PaymentMethodType::TINKOFF_BANK;

    public $id = 'yookassa_tinkoff';

    public function __construct()
    {
        parent::__construct();

        $this->icon = YooKassa::$pluginUrl.'/assets/images/tks.png';

        $this->method_description = __('Интернет-банк Тинькофф', 'yookassa');
        $this->method_title       = __('Интернет-банк Тинькофф', 'yookassa');

        $this->defaultTitle       = __('Интернет-банк Тинькофф', 'yookassa');
        $this->defaultDescription = __('Интернет-банк Тинькофф', 'yookassa');

        $this->title              = $this->getTitle();
        $this->description        = $this->getDescription();
    }
}