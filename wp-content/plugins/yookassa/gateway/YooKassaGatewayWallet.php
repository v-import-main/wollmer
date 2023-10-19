<?php
use YooKassa\Model\PaymentMethodType;

if (!class_exists('YooKassaGateway')) {
    return;
}

class YooKassaGatewayWallet extends YooKassaGateway
{
    public $paymentMethod = PaymentMethodType::YOO_MONEY;

    public $id = 'yookassa_wallet';

    public function __construct()
    {
        parent::__construct();

        $this->icon                   = YooKassa::$pluginUrl . '/assets/images/pc.png';
        $this->method_description     = __('Оплата кошельком ЮMoney', 'yookassa');
        $this->method_title           = __('Кошелек ЮMoney', 'yookassa');

        $this->defaultTitle           = __('Кошелек ЮMoney', 'yookassa');
        $this->defaultDescription     = __('Оплата кошельком ЮMoney', 'yookassa');

        $this->title                  = $this->getTitle();
        $this->description            = $this->getDescription();

        $this->enableRecurrentPayment = $this->get_option('save_payment_method') == 'yes';
        $this->supports               = array_merge($this->supports, array(
            'subscriptions',
            'tokenization',
            'subscription_cancellation',
            'subscription_suspension',
            'subscription_reactivation',
            'subscription_date_changes',
        ));
        $this->has_fields             = true;
    }

    public function init_form_fields()
    {
        parent::init_form_fields();
        $this->form_fields['save_payment_method'] = array(
            'title'   => __('Сохранять платежный метод', 'yookassa'),
            'type'    => 'checkbox',
            'label'   => __('Покупатели могут сохранять кошелёк для повторной оплаты', 'yookassa'),
            'default' => 'no',
        );
    }

    public function is_available()
    {
        if (is_add_payment_method_page() && !$this->enableRecurrentPayment) {
            return false;
        }

        return parent::is_available();
    }

    public function payment_fields()
    {
        parent::payment_fields();
        $displayTokenization = $this->supports('tokenization') && is_checkout() && $this->enableRecurrentPayment;
        if ($displayTokenization) {
            $this->saved_payment_methods();
            $this->save_payment_method_checkbox();
        }
    }
}