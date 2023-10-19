<?php


class WC_Payment_Token_YooKassa extends WC_Payment_Token
{
    /** @protected string Token Type String */
    protected $type = 'YM';

    protected $extra_data = array(
        'last4' => '',
    );

    public function get_display_name($deprecated = '')
    {
        return __('Кошелек ЮMoney', 'woocommerce').' '.$this->get_last4();
    }

    protected function get_hook_prefix()
    {
        return 'woocommerce_payment_token_yookassa_get_';
    }

    /**
     * Validate eCheck payment tokens.
     *
     * These fields are required by all eCheck payment tokens:
     * last4  - string Last 4 digits of the check
     *
     * @since 2.6.0
     * @return boolean True if the passed data is valid
     */
    public function validate()
    {
        if (false === parent::validate()) {
            return false;
        }

        if (!$this->get_last4('edit')) {
            return false;
        }

        return true;
    }

    /**
     * Returns the last four digits.
     *
     * @since  2.6.0
     *
     * @param  string $context
     *
     * @return string Last 4 digits
     */
    public function get_last4($context = 'view')
    {
        return $this->get_prop('last4', $context);
    }

    /**
     * Set the last four digits.
     * @since 2.6.0
     *
     * @param string $last4
     */
    public function set_last4($last4)
    {
        $this->set_prop('last4', $last4);
    }
}
