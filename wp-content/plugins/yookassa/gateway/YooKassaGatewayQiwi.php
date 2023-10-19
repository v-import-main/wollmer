<?php

use YooKassa\Common\Exceptions\InvalidPropertyValueException;
use YooKassa\Model\ConfirmationType;
use YooKassa\Model\PaymentData\PaymentDataQiwi;

if (!class_exists('YooKassaGateway')) {
    return;
}

class YooKassaGatewayQiwi extends YooKassaGateway
{
    public $confirmationType = ConfirmationType::REDIRECT;

    public $id = 'yookassa_qiwi';

    public function __construct()
    {
        parent::__construct();

        $this->paymentMethod      = new PaymentDataQiwi();
        $this->icon               = YooKassa::$pluginUrl.'/assets/images/qw.png';

        $this->method_description = __('QIWI Wallet', 'yookassa');
        $this->method_title       = __('QIWI Wallet', 'yookassa');

        $this->defaultTitle       = __('QIWI Wallet', 'yookassa');
        $this->defaultDescription = __('QIWI Wallet', 'yookassa');

        $this->title              = $this->getTitle();
        $this->description        = $this->getDescription();
        $this->has_fields         = true;
    }

    public function payment_fields()
    {
        parent::payment_fields();
        $phone_field = '<p class="form-row">
            <label for="phone-'.$this->id.'">'.__('Телефон, который привязан к Qiwi Wallet', 'yookassa').'<span class="required">*</span></label>
            <input id="phone-'.$this->id.'" name="phone-'.$this->id.'"class="input-text" maxlength="18"/>
        </p>';

        echo '<fieldset>'.$phone_field.'</fieldset>';
    }

    public function createPayment($order)
    {
        if (isset($_POST['phone-yookassa_qiwi'])) {
            $phone = preg_replace('/[^\d]/', '', $_POST['phone-yookassa_qiwi']);
            try {
                $this->paymentMethod->setPhone($phone);
            } catch (Exception $e) {
                wc_add_notice(__('Поле телефон заполнено неверно.', 'yookassa'), 'error');
            }
        }

        return parent::createPayment($order);
    }
}