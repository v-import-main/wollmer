<?php
use YooKassa\Model\PaymentMethodType;

if ( ! class_exists('YooKassaGateway')) {
    return;
}


class YooKassaGatewayCash extends YooKassaGateway
{
    public $paymentMethod = PaymentMethodType::CASH;

    public $id = 'yookassa_cash';
    /**
     * Gateway title.
     * @var string
     */
    public $method_title;

    public $defaultTitle;

    /**
     * Gateway description.
     * @var string
     */
    public $method_description = '';

    public function __construct()
    {
        parent::__construct();

        $this->icon = YooKassa::$pluginUrl.'/assets/images/gp.png';

        $this->method_description = __('Наличные', 'yookassa');
        $this->method_title       = __('Наличные', 'yookassa');

        $this->defaultTitle       = __('Наличные', 'yookassa');
        $this->defaultDescription = __('Наличные', 'yookassa');

        $this->title              = $this->getTitle();
        $this->description        = $this->getDescription();

    }
}