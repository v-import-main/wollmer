<?php

if (!class_exists('WC_Payment_Gateway')) {
    return;
}

use YooKassa\Client;
use YooKassa\Common\Exceptions\ApiException;
use YooKassa\Model\ConfirmationType;
use YooKassa\Model\CurrencyCode;
use YooKassa\Model\MonetaryAmount;
use YooKassa\Model\Payment;
use YooKassa\Model\PaymentMethodType;
use YooKassa\Model\PaymentStatus;
use YooKassa\Model\Receipt;
use YooKassa\Model\Receipt\PaymentMode;
use YooKassa\Model\Receipt\PaymentSubject;
use YooKassa\Request\Payments\CreatePaymentRequest;
use YooKassa\Request\Payments\CreatePaymentRequestBuilder;
use YooKassa\Request\Payments\CreatePaymentRequestSerializer;
use YooKassa\Request\Payments\CreatePaymentResponse;
use YooKassa\Request\Payments\PaymentResponse;

class YooKassaGateway extends WC_Payment_Gateway
{
    /**
     * @var string
     */
    const RETURN_URI_PATTERN = "yookassa/returnUrl?yookassa-order-id=%s";
    const RETURN_SIMPLE_PATTERN = "?yookassa=returnUrl&yookassa-order-id=%s";

    const MINIMUM_SUBSCRIBE_AMOUNT = 1;

    const YM_LANG_RU = 'ru_RU';
    const YM_LANG_EN = 'en_US';
    const YM_LANG_DE = 'de_DE';

    public $paymentMethod;

    public $confirmationType = ConfirmationType::REDIRECT;

    /**
     * @var string default description for payment method (if title  empty)
     */
    public $defaultDescription = '';

    /**
     * @var string default title for payment method (if description empty)
     */
    public $defaultTitle = '';

    /**
     * @var Client
     */
    private $apiClient;

    /**
     * @var string gateway description (admin panel)
     */
    public $method_description;

    /**
     * @var string gateway title (admin panel)
     */
    public $method_title;

    /**
     * @var string path to payment icon
     */
    public $icon;

    /**
     * @var bool
     */
    protected $savePaymentMethod = false;

    /**
     * @var bool
     */
    protected $subscribe = false;

    /**
     * @var float
     */
    protected $amount = 0.0;

    protected $enableRecurrentPayment;

    private $recurentPaymentMethodId;

    private $cache;

    public function __construct()
    {
        $this->cache = new YooKassaFileCache(60*60*6);
        $this->has_fields = false;
        $this->init_form_fields();
        $this->init_settings();
        $this->title       = $this->settings['title'];
        $this->description = $this->settings['description'];
        $this->supports    = array(
            'products',
        );

        if (version_compare(WOOCOMMERCE_VERSION, '2.0.0', '>=')) {
            add_action(
                'woocommerce_update_options_payment_gateways_'.$this->id,
                array(
                    $this,
                    'process_admin_options',
                )
            );
        } else {
            add_action('woocommerce_update_options_payment_gateways', array($this, 'process_admin_options'));
        }
        add_action('woocommerce_receipt_'.$this->id, array($this, 'receipt_page'));

        if (class_exists('WC_Subscriptions_Order')) {
            add_action('woocommerce_scheduled_subscription_payment_' . $this->id, array($this, 'scheduled_subscription_payment'), 10, 2);
            add_action('woocommerce_subscription_cancelled_' . $this->id, array($this, 'subscription_canceled'), 10, 2);
            add_action('woocommerce_subscription_expired_' . $this->id, array($this, 'subscription_expired'), 10, 2);
        }

    }

    /**
     * Init settings for gateways.
     */
    public function init_settings()
    {
        parent::init_settings();

        $paymentSubjectEnum = array(
            PaymentSubject::COMMODITY             => 'Товар ('.PaymentSubject::COMMODITY.')',
            PaymentSubject::EXCISE                => 'Подакцизный товар ('.PaymentSubject::EXCISE.')',
            PaymentSubject::JOB                   => 'Работа ('.PaymentSubject::JOB.')',
            PaymentSubject::SERVICE               => 'Услуга ('.PaymentSubject::SERVICE.')',
            PaymentSubject::GAMBLING_BET          => 'Ставка в азартной игре ('.PaymentSubject::GAMBLING_BET.')',
            PaymentSubject::GAMBLING_PRIZE        => 'Выигрыш в азартной игре ('.PaymentSubject::GAMBLING_PRIZE.')',
            PaymentSubject::LOTTERY               => 'Лотерейный билет ('.PaymentSubject::LOTTERY.')',
            PaymentSubject::LOTTERY_PRIZE         => 'Выигрыш в лотерею ('.PaymentSubject::LOTTERY_PRIZE.')',
            PaymentSubject::INTELLECTUAL_ACTIVITY => 'Результаты интеллектуальной деятельности ('.PaymentSubject::INTELLECTUAL_ACTIVITY.')',
            PaymentSubject::PAYMENT               => 'Платеж ('.PaymentSubject::PAYMENT.')',
            PaymentSubject::AGENT_COMMISSION      => 'Агентское вознаграждение ('.PaymentSubject::AGENT_COMMISSION.')',
            PaymentSubject::COMPOSITE             => 'Несколько вариантов ('.PaymentSubject::COMPOSITE.')',
            PaymentSubject::ANOTHER               => 'Другое ('.PaymentSubject::ANOTHER.')',
        );

        $paymentModeEnum = array(
            PaymentMode::FULL_PREPAYMENT    => 'Полная предоплата ('.PaymentMode::FULL_PREPAYMENT.')',
            PaymentMode::PARTIAL_PREPAYMENT => 'Частичная предоплата ('.PaymentMode::PARTIAL_PREPAYMENT.')',
            PaymentMode::ADVANCE            => 'Аванс ('.PaymentMode::ADVANCE.')',
            PaymentMode::FULL_PAYMENT       => 'Полный расчет ('.PaymentMode::FULL_PAYMENT.')',
            PaymentMode::PARTIAL_PAYMENT    => 'Частичный расчет и кредит ('.PaymentMode::PARTIAL_PAYMENT.')',
            PaymentMode::CREDIT             => 'Кредит ('.PaymentMode::CREDIT.')',
            PaymentMode::CREDIT_PAYMENT     => 'Выплата по кредиту ('.PaymentMode::CREDIT_PAYMENT.')',
        );

        $this->addReceiptAttribute('yookassa_payment_subject', __('Признак предмета расчета', 'yookassa'), $paymentSubjectEnum);
        $this->addReceiptAttribute('yookassa_payment_mode', __('Признак способа расчёта', 'yookassa'), $paymentModeEnum);
    }

    public function init_form_fields()
    {
        $this->form_fields = array(
            'enabled'     => array(
                'title'   => __('Включить/Выключить', 'yookassa'),
                'type'    => 'checkbox',
                'label'   => $this->method_description,
                'default' => 'no',
            ),
            'title'       => array(
                'title'       => __('Заголовок', 'yookassa'),
                'type'        => 'text',
                'description' => __('Название, которое пользователь видит во время оплаты', 'yookassa'),
                'default'     => $this->defaultTitle,
            ),
            'description' => array(
                'title'       => __('Описание', 'yookassa'),
                'type'        => 'textarea',
                'description' => __('Описание, которое пользователь видит во время оплаты', 'yookassa'),
                'default'     => $this->defaultDescription,
            ),
        );
    }

    public function admin_options()
    {
        echo '<h5>'.__(
                'Для работы с модулем необходимо <a href="https://yoomoney.ru/joinups/">подключить магазин к ЮKassa</a>. После подключения вы получите параметры для приема платежей (идентификатор магазина — shopId  и секретный ключ).',
                'yookassa'
            ).'</h5>';
        echo '<table class="form-table">';
        $this->generate_settings_html();
        echo '</table>';
    }

    /**
     *  There are no payment fields, but we want to show the description if set.
     */
    public function payment_fields()
    {
        if ($this->description) {
            echo wpautop(wptexturize($this->description));
        }
    }

    public function processReturnUrl($orderId)
    {
        YooKassaLogger::info(
            'Return process init.'
        );
        global $woocommerce;
        $order_id = wc_get_order_id_by_order_key(wc_clean(wp_unslash($orderId)));
        $order    = wc_get_order($order_id);
        if ( class_exists('sitepress') ) {
            do_action( 'wpml_switch_language', get_post_meta($order_id, 'wpml_language')[0] );
        }
        $apiClient = $this->getApiClient();
        $paymentId = $order->get_transaction_id();
        YooKassaLogger::info(
            sprintf(__('Пользователь вернулся с формы оплаты. Id заказа - %1$s. Идентификатор платежа - %2$s.',
                'yookassa'), $order_id, $paymentId)
        );
        try {
            $payment = $apiClient->getPaymentInfo($paymentId);
            if ($this->isPaymentSuccess($payment)) {
                $woocommerce->cart->empty_cart();
                wp_redirect($this->get_success_fail_url('yookassa_success', $order));
            } else {
                wp_redirect($this->get_success_fail_url('yookassa_fail', $order));
            }
        } catch (ApiException $e) {
            YooKassaLogger::error('Api error: '.$e->getMessage());
        }
    }

    /**
     * @param Payment $payment
     * @return bool
     */
    private function isPaymentSuccess($payment)
    {
        if ($payment->getMetadata()->offsetExists('subscribe_trial')
            && in_array($payment->getStatus(), self::getValidForTrialStatuses())) {
            return true;
        } else if (in_array($payment->getStatus(), self::getValidPaidStatuses())) {
            return true;
        } else if ($payment->getStatus() === PaymentStatus::PENDING && $payment->getPaid()) {
            return true;
        }
        return false;
    }

    protected static function getValidPaidStatuses()
    {
        return array(
            PaymentStatus::SUCCEEDED,
            PaymentStatus::WAITING_FOR_CAPTURE,
        );
    }

    protected function getValidForTrialStatuses()
    {
        return array(
            PaymentStatus::CANCELED,
            PaymentStatus::WAITING_FOR_CAPTURE,
        );
    }

    /**
     * @param WC_Order $order
     *
     * @return mixed|WP_Error|CreatePaymentResponse
     *
     * @throws Exception
     */
    public function createPayment($order)
    {
        $builder        = $this->getBuilder($order);
        $paymentRequest = $builder->build();
        if (YooKassaHandler::isReceiptEnabled()) {
            $receipt = $paymentRequest->getReceipt();
            if ($receipt instanceof Receipt) {
                $receipt->normalize($paymentRequest->getAmount());
            }
        }
        $serializer     = new CreatePaymentRequestSerializer();
        $serializedData = $serializer->serialize($paymentRequest);
        YooKassaLogger::info('Create payment request: '.json_encode($serializedData));
        try {
            $response = $this->getApiClient()->createPayment($paymentRequest);
            YooKassaLogger::info('Create payment response: '.json_encode($response->toArray()));
            return $response;
        } catch (ApiException $e) {
            YooKassaLogger::error('Api error: '.$e->getMessage());
            return new WP_Error($e->getCode(), $e->getMessage());
        } catch (Exception $e) {
            YooKassaLogger::error('Create payment response: '.json_encode($e));
        }
    }

    public function subscription_canceled($subscription)
    {
        YooKassaLogger::info('Subscription id = ' . $subscription->get_id() . ' was canceled');
    }

    public function subscription_expired($subscription)
    {
        YooKassaLogger::info('Subscription id = ' . $subscription->get_id() . ' is expired');
    }

    /**
     * @param $amount
     * @param WC_Order $order
     * @return array|WP_Error|CreatePaymentResponse|null
     * @throws Exception
     */
    public function scheduled_subscription_payment($amount, $order)
    {
        $this->recurentPaymentMethodId = $order->get_meta('_yookassa_saved_payment_id');
        $this->amount = $amount;
        YooKassaLogger::info(
            sprintf('Start subscription payment, recurentId = %s and amount = %s', $this->recurentPaymentMethodId, $amount)
        );
        $this->process_payment($order->get_id());
    }


    /**
     * Process the payment and return the result
     *
     * @param $order_id
     *
     * @return array
     * @throws WC_Data_Exception
     * @throws Exception
     */
    public function process_payment($order_id)
    {
        global $woocommerce;

        $order = new WC_Order($order_id);

        if (YooKassaHandler::isReceiptEnabled() && YooKassaHandler::isSelfEmployed()) {
            try {
                YooKassaHandler::checkConditionForSelfEmployed($order);
            } catch (Exception $e) {
                YooKassaLogger::warning(sprintf(__('Не удалось создать платеж. Для заказа %1$s', 'yookassa'), $order_id) . ' ' . strip_tags($e->getMessage()));
                wc_add_notice($e->getMessage(), 'error');
                return array('result' => 'fail', 'redirect' => '');
            }
        }

        if (class_exists('WC_Subscriptions_Cart')
            && WC_Subscriptions_Cart::cart_contains_subscription()) {
            $this->subscribe = true;
        }

        $this->savePaymentMethod = $this->saveNewPaymentMethod() || $this->subscribe;
        if (isset($_POST["wc-{$this->id}-payment-token"]) && 'new' !== $_POST["wc-{$this->id}-payment-token"]) {
            $token_id = wc_clean($_POST["wc-{$this->id}-payment-token"]);
            $token    = WC_Payment_Tokens::get($token_id);
            if ($token->get_user_id() !== get_current_user_id()) {
                //@TODO Optionally display a notice with `wc_add_notice`
                return;
            }

            $this->recurentPaymentMethodId = $token->get_token();
        }
        $result = $this->createPayment($order);
        if ($result) {
            if (is_wp_error($result)) {
                wc_add_notice(__('Платеж не прошел. Попробуйте еще или выберите другой способ оплаты',
                    'yookassa'), 'error');

                return array('result' => 'fail', 'redirect' => $order->get_view_order_url());
            } else {
                $order->set_transaction_id($result->getId());
                $this->savePaymentData($result, $order);

                if ($this->subscribe) {
                    $subscriptions = wcs_get_subscriptions_for_order($order);
                    foreach ($subscriptions as $subscription) {
                        update_post_meta( $subscription->get_id(), '_yookassa_saved_payment_id', $result->getId());
                        YooKassaLogger::info(
                            'Subscription id = '. $subscription->get_id() . 'succeeded created. Token = '. $result->getId()
                        );
                    }
                }

                if ($result->status == PaymentStatus::PENDING) {
                    $order->update_status('wc-pending');
                    if (get_option('yookassa_force_clear_cart') == '1') {
                        $woocommerce->cart->empty_cart();
                    }
                    if ($result->confirmation->type == ConfirmationType::EXTERNAL) {
                        return array('result' => 'success', 'redirect' => $order->get_checkout_order_received_url());
                    } elseif ($result->confirmation->type == ConfirmationType::REDIRECT) {
                        return array('result' => 'success', 'redirect' => $result->confirmation->confirmationUrl);
                    }
                } elseif ($result->status == PaymentStatus::WAITING_FOR_CAPTURE) {
                    return array('result' => 'success', 'redirect' => $order->get_checkout_order_received_url());
                } elseif ($result->status == PaymentStatus::SUCCEEDED) {
                    if ($this->recurentPaymentMethodId) {
                        $order->update_status('wc-success');
                    }

                    return array(
                        'result'   => 'success',
                        'redirect' => $this->get_success_fail_url('yookassa_success', $order),
                    );
                } else {
                    YooKassaLogger::warning(sprintf(__('Не удалось создать платеж. Для заказа %1$s',
                        'yookassa'), $order_id));
                    wc_add_notice(__('Платеж не прошел. Попробуйте еще или выберите другой способ оплаты',
                        'yookassa'), 'error');
                    $order->update_status('wc-cancelled');

                    return array('result' => 'fail', 'redirect' => '');
                }
            }
        } else {
            YooKassaLogger::warning(sprintf(__('Не удалось создать платеж. Для заказа %1$s', 'yookassa'),
                $order_id));
            wc_add_notice(__('Платеж не прошел. Попробуйте еще или выберите другой способ оплаты', 'yookassa'),
                'error');

            return array('result' => 'fail', 'redirect' => '');
        }
    }

    public function showMessage($content)
    {
        return '<div class="box '.$this->msg['class'].'-box">'.$this->msg['message'].'</div>'.$content;
    }

    // get all pages
    public function get_pages($title = false, $indent = true)
    {
        $wp_pages  = get_pages('sort_column=menu_order');
        $page_list = array();
        if ($title) {
            $page_list[] = $title;
        }
        foreach ($wp_pages as $page) {
            $prefix = '';
            // show indented child pages?
            if ($indent) {
                $has_parent = $page->post_parent;
                while ($has_parent) {
                    $prefix     .= ' - ';
                    $next_page  = get_page($has_parent);
                    $has_parent = $next_page->post_parent;
                }
            }
            // add to page list array array
            $page_list[$page->ID] = $prefix.$page->post_title;
        }

        return $page_list;
    }

    /**
     * @param $name
     * @param WC_Order $order
     *
     * @return string
     */
    protected function get_success_fail_url($name, $order)
    {
        switch (get_option($name)) {
            case "wc_success":
                return $order->get_checkout_order_received_url();
                break;
            case "wc_checkout":
                return $order->get_view_order_url();
                break;
            case "wc_payment":
                return $order->get_checkout_payment_url();
                break;
            default:
                return get_page_link(get_option($name));
                break;
        }
    }

    /**
     * @return Client
     */
    public function getApiClient()
    {
        return YooKassaClientFactory::getYooKassaClient();
    }

    /**
     * @param WC_Order $order
     *
     * @param $save
     *
     * @return CreatePaymentRequestBuilder
     * @throws Exception
     */
    protected function getBuilder($order)
    {
        $paymentMethodsForHold = array(
            '',
            PaymentMethodType::BANK_CARD,
            PaymentMethodType::YOO_MONEY,
            PaymentMethodType::GOOGLE_PAY,
            PaymentMethodType::APPLE_PAY,
        );
        $enableHold = get_option('yookassa_enable_hold')
                      && in_array($this->paymentMethod, $paymentMethodsForHold);

        $amount = ($this->amount <= 0) ? YooKassaOrderHelper::getTotal($order) : $this->amount;

        $metadata = $this->createMetadata();
        if ($this->subscribe && $amount <= 0) {
            $enableHold = true;
            $amount = self::MINIMUM_SUBSCRIBE_AMOUNT;
            $metadata['subscribe_trial'] = true;
        }

        $builder = CreatePaymentRequest::builder()
                   ->setAmount(YooKassaOrderHelper::getAmountByCurrency($amount))
                   ->setCapture(!$enableHold)
                   ->setDescription($this->createDescription($order))
                   ->setSavePaymentMethod($this->savePaymentMethod)
                   ->setMetadata($metadata);

        if ($this->recurentPaymentMethodId) {
            $builder->setPaymentMethodId($this->recurentPaymentMethodId);
        } else {
            $builder->setPaymentMethodData($this->paymentMethod)
                    ->setConfirmation(
                        array(
                            'type'      => $this->confirmationType,
                            'returnUrl' => get_site_url(null, sprintf(self::getReturnUrlPattern(), $order->get_order_key())),
                        )
                    );
        }
        YooKassaLogger::info('Return url: '.$order->get_checkout_payment_url(true));
        YooKassaHandler::setReceiptIfNeeded($builder, $order, $this->subscribe);

        return $builder;
    }

    /**
     * @return array
     */
    protected function createMetadata()
    {
        $metadata = array(
            'cms_name'       => 'yoo_woocommerce',
            'module_version' => YOOKASSA_VERSION,
            'wp_user_id'     => get_current_user_id(),
        );

        if ($this->subscribe) {
            $metadata['subscribe_payment_save_card'] = $this->saveNewPaymentMethod();
        }

        if (isset($_COOKIE['p4s_push_subscriber_id'])) {
            $metadata['subscriber_id'] = sanitize_text_field($_COOKIE['p4s_push_subscriber_id']);
        }

        return $metadata;
    }

    /**
     * @param WC_Order $order
     *
     * @return string
     */
    public function createDescription($order)
    {
        $template = get_option('yookassa_description_template', __('Оплата заказа №%order_number%', 'yookassa'));

        return $this->parseTemplateString($order, $template);
    }

    /**
     * @param WC_Order $order
     * @param string $template
     * @return string
     */
    public function parseTemplateString($order, $template)
    {
        $replace  = array();
        $patterns = explode('%', $template);
        foreach ($patterns as $pattern) {
            $value  = null;
            $method = 'get_'.$pattern;
            if (method_exists($order, $method)) {
                $value = $order->{$method}();
            }
            if (!is_null($value) && is_scalar($value)) {
                $replace['%'.$pattern.'%'] = $value;
            }
        }
        $description = strtr($template, $replace);

        return mb_substr($description, 0, Payment::MAX_LENGTH_DESCRIPTION);
    }

    /**
     * @param string $attributeName
     * @param string $rawName
     * @param array $terms
     */
    public function addReceiptAttribute($attributeName, $rawName, $terms)
    {
        $isAttributeCreated = wc_attribute_taxonomy_id_by_name($attributeName);
        if (!$isAttributeCreated) {

            $args = array(
                'name' => $rawName,
                'slug' => $attributeName,
            );
            wc_create_attribute($args);

            $taxonomy_name = wc_attribute_taxonomy_name($attributeName);
            register_taxonomy(
                $taxonomy_name,
                apply_filters('woocommerce_taxonomy_objects_'.$taxonomy_name, array('product')),
                apply_filters('woocommerce_taxonomy_args_'.$taxonomy_name, array(
                    'labels'       => array(
                        'name' => $rawName,
                    ),
                    'hierarchical' => true,
                    'show_ui'      => false,
                    'query_var'    => true,
                    'rewrite'      => false,
                ))
            );
            foreach ($terms as $term => $description) {
                $insert_result = wp_insert_term($term, $taxonomy_name, array(
                    'description' => $description,
                    'parent'      => 0,
                    'slug'        => $term,
                ));
            }
        }
    }

    /**
     * @return bool
     */
    private function saveNewPaymentMethod()
    {
        $savePaymentMethod = is_checkout() && !empty($_POST["wc-{$this->id}-new-payment-method"]);

        return $savePaymentMethod;
    }

    /**
     * @inheritdoc
     */
    public function add_payment_method()
    {
        try {
            $builder = CreatePaymentRequest::builder()
                       ->setAmount('2.00')
                       ->setCapture(false)
                       ->setSavePaymentMethod(true)
                       ->setPaymentMethodData($this->paymentMethod)
                       ->setConfirmation(
                           array(
                               'type'      => ConfirmationType::REDIRECT,
                               'returnUrl' => wc_get_endpoint_url('payment-methods'),
                           )
                       )
                       ->setMetadata(array(
                           'cms_name'       => 'yoo_woocommerce',
                           'module_version' => YOOKASSA_VERSION,
                           'wp_user_id'     => get_current_user_id(),
                       ));
            if (YooKassaHandler::isReceiptEnabled()) {
                $user = wp_get_current_user();
                $builder->setReceiptEmail($user->user_email);
                $builder->addReceiptItem(__('Тестовое списание для привязки карты, средства будут возвращены.', 'yookassa'), '2.00', 1, get_option('yookassa_default_tax_rate'));
            }

            $paymentRequest = $builder->build();

            $response = $this->getApiClient()->createPayment($paymentRequest);

        } catch (ApiException $e) {
            return array(
                'result'   => 'failure',
                'redirect' => wc_get_endpoint_url('payment-methods'),
            );
        }

        return array(
            'result'   => 'success',
            'redirect' => $response->confirmation->confirmationUrl,
        );
    }

    protected function getTitle()
    {
        $title = $this->title ? $this->title : $this->defaultTitle;
        return __($title, 'yookassa');
    }

    protected function getDescription()
    {
        $description = $this->description ? $this->description : $this->defaultDescription;
        return __($description, 'yookassa');
    }

    /**
     * Save payment data into database
     *
     * @param PaymentResponse $paymentResponse
     * @param WC_Order $order
     * @return mixed
     */
    public function savePaymentData($paymentResponse, $order)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'yookassa_payment';

        $paymentMethod = $paymentResponse->getPaymentMethod();
        $saveData = array(
            'payment_id' => $paymentResponse->getId(),
            'order_id' => $order->get_id(),
            'status' => $paymentResponse->getStatus(),
            'amount' => $paymentResponse->getAmount()->getValue(),
            'currency' => $paymentResponse->getAmount()->getCurrency(),
            'payment_method_id' => !empty($paymentMethod) ? $paymentMethod->getId() : null,
            'paid' => 'N',
        );

        $result = $wpdb->insert(
            $table_name,
            $saveData
        );

        if (!$result) {
            YooKassaLogger::error('Не удалось сохранить данные платежа '.$paymentResponse->getId().' в базе данных!'.print_r($saveData, true));
        }

        return $result;
    }

    /**
     * Update payment data into database
     *
     * @param string $paymentId
     * @param array $data
     * @return null|bool
     */
    public function updatePaymentData($paymentId, $data=array())
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'yookassa_payment';
        if (!empty($data)) {
            $result = $wpdb->update(
                $table_name,
                array_merge(
                    $data,
                    array('updated_at' => date('Y-m-d H:i:s'))
                ),
                array(
                    'payment_id' => $paymentId,
                )
            );
        } else {
            $result = null;
        }

        if (!$result) {
            YooKassaLogger::error('Не удалось обновить данные платежа '.$paymentId.' в базе данных!');
        }

        return $result;
    }

    /**
     * @return string
     */
    public static function getReturnUrlPattern()
    {
        global $wp_rewrite;

        return empty($wp_rewrite->permalink_structure) ? self::RETURN_SIMPLE_PATTERN : self::RETURN_URI_PATTERN;
    }
}
