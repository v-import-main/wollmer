<?php

if ( ! class_exists('YooKassaGateway')) {
    return;
}

class YooKassaGatewayEPL extends YooKassaGateway
{
    public $paymentMethod = '';

    public $id = 'yookassa_epl';

    /**
     * YooKassaGatewayEPL constructor.
     * @TODO вынести функцию перевода в методы getTitle и getDescription. в способах оставить голое название
     */
    public function __construct()
    {
        parent::__construct();

        $this->icon = YooKassa::$pluginUrl.'/assets/images/kassa.png';

        $this->method_title       = __('ЮKassa (банковские карты, электронные деньги и другое)', 'yookassa');
        $this->method_description = __('ЮKassa (банковские карты, электронные деньги и другое)', 'yookassa');

        $this->defaultTitle       = __('ЮKassa (банковские карты, электронные деньги и другое)', 'yookassa');
        $this->defaultDescription = __('ЮKassa (банковские карты, электронные деньги и другое)', 'yookassa');

        $this->title              = $this->getTitle();
        $this->description        = $this->getDescription();
    }
}