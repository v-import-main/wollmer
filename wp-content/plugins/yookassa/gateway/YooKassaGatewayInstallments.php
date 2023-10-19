<?php
use YooKassa\Model\PaymentMethodType;

if ( ! class_exists('YooKassaGateway')) {
    return;
}

class YooKassaGatewayInstallments extends YooKassaGateway
{
    public $paymentMethod = PaymentMethodType::INSTALLMENTS;

    public $id = 'yookassa_installments';

    public function __construct()
    {
        parent::__construct();

        $this->icon = YooKassa::$pluginUrl.'/assets/images/installments.png';

        $this->method_description = __('Заплатить по частям', 'yookassa');
        $this->method_title       = __('Заплатить по частям', 'yookassa');

        $this->defaultTitle       = __('Заплатить по частям', 'yookassa');
        $this->defaultDescription = __('Заплатить по частям', 'yookassa');

        $this->title              = $this->getTitle();
        $this->description        = $this->getDescription();
    }
}