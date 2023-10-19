<?php
use YooKassa\Model\ConfirmationType;
use YooKassa\Model\PaymentData\PaymentDataAlfabank;

if (!class_exists('YooKassaGateway')) {
    return;
}

class YooKassaGatewayAlfabank extends YooKassaGateway
{
    public $has_fields = true;

    public $confirmationType = ConfirmationType::EXTERNAL;

    public $id = 'yookassa_alfabank';

    public function __construct()
    {
        parent::__construct();

        $this->paymentMethod      = new PaymentDataAlfabank();
        $this->icon               = YooKassa::$pluginUrl.'/assets/images/ab.png';

        $this->method_description = __('Оплата через Альфа банк', 'yookassa');
        $this->method_title       = __('Альфа-Клик', 'yookassa');

        $this->defaultTitle       = __('Альфа-Клик', 'yookassa');
        $this->defaultDescription = __('Оплата через Альфа банк', 'yookassa');

        $this->title              = $this->getTitle();
        $this->description        = $this->getDescription();

        $this->has_fields         = true;
    }

    public function payment_fields()
    {
        parent::payment_fields();

        $phone_field = '<p class="form-row">
            <label for="login-'.$this->id.'"> ' . __('Укажите логин, и мы выставим счет в Альфа-Клике. После этого останется подтвердить платеж на сайте интернет-банка.', 'yookassa').'<span class="required">*</span></label>
            <input id="login-'.$this->id.'" name="login-'.$this->id.'" class="input-text" inputmode="numeric" autocomplete="off" autocorrect="no" autocapitalize="no" spellcheck="no" type="tel" maxlength="12"/>
        </p>';

        echo '<fieldset>'.$phone_field.'</fieldset>';
    }

    public function createPayment($order)
    {
        if (isset($_POST['login-yookassa_alfabank'])) {
            try {
                $this->paymentMethod->setLogin(sanitize_text_field($_POST['login-yookassa_alfabank']));
            } catch (Exception $e) {
                wc_add_notice(__('Поле логин заполнено неверно.', 'yookassa'), 'error');
            }
        }

        return parent::createPayment($order);
    }
}