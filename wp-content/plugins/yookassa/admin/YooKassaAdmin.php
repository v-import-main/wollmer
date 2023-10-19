<?php

use YooKassa\Model\CurrencyCode;
use YooKassa\Model\PaymentData\B2b\Sberbank\VatDataRate;
use YooKassa\Model\PaymentData\B2b\Sberbank\VatDataType;
use YooKassa\Model\Receipt\PaymentMode;
use YooKassa\Model\Receipt\PaymentSubject;

/**
 * The admin-specific functionality of the plugin.
 */
class YooKassaAdmin
{
    const CREDENTIAL_SUCCESS          = 0;
    const CREDENTIAL_AUTHORIZED_ERROR = 1;
    const CREDENTIAL_OTHER_ERROR      = 2;

    const OAUTH_CMS_URL = 'https://yookassa.ru/integration/oauth-cms';

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Задержка перед повторным показом блока NPS (в днях)
     * @var int
     */
    private $npsRetryAfterDays = 90;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;

        add_action( 'wp_ajax_yookassa_get_tab', array( $this, 'get_tab_content' ) );
        add_action( 'wp_ajax_yookassa_save_settings', array( $this, 'save_settings' ) );
        add_action( 'wp_ajax_yookassa_get_oauth_token', array( $this, 'get_oauth_token' ) );
        add_action( 'wp_ajax_yookassa_get_oauth_url', array( $this, 'get_oauth_url' ) );
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_register_style(
            'bootstrap',
            YooKassa::$pluginUrl . 'assets/css/bootstrap.min.css',
            array(),
            '4.5.3',
            'all'
        );
        wp_enqueue_style( 'bootstrap' );

        wp_register_style(
            $this->plugin_name . '-admin',
            YooKassa::$pluginUrl . 'assets/css/yookassa-admin.css',
            array('bootstrap'),
            $this->version,
            'all'
        );
        wp_enqueue_style( $this->plugin_name . '-admin' );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_register_script(
            'bootstrap',
            YooKassa::$pluginUrl . 'assets/js/bootstrap.bundle.min.js',
            array('jquery'),
            '4.5.3',
            false
        );
        wp_enqueue_script( 'bootstrap' );

        wp_register_script(
            $this->plugin_name . '-admin',
            YooKassa::$pluginUrl . 'assets/js/yookassa-admin.js',
            array('jquery', 'bootstrap', 'clipboard'),
            $this->version,
            true
        );
        wp_enqueue_script( $this->plugin_name . '-admin' );
    }

    public function addMenu()
    {
        $hook = add_submenu_page(
            'woocommerce',
            __('Настройки ЮKassa', 'yookassa'),
            __('Настройки ЮKassa', 'yookassa'),
            'manage_options',
            'yoomoney_api_menu',
            array($this, 'renderAdminPage')
        );

        // make sure the style callback is used on our page only
        add_action(
            "admin_print_styles-$hook",
            array ( $this, 'enqueue_styles' )
        );
        add_action(
            "admin_print_scripts-$hook",
            array ( $this, 'enqueue_scripts' )
        );
    }

    public function registerSettings()
    {
        register_setting('woocommerce-yookassa', 'yookassa_shop_id');
        register_setting('woocommerce-yookassa', 'yookassa_shop_password');
        register_setting('woocommerce-yookassa', 'yookassa_pay_mode');
        register_setting('woocommerce-yookassa', 'yookassa_epl_installments');
        register_setting('woocommerce-yookassa', 'yookassa_add_installments_block');
        register_setting('woocommerce-yookassa', 'yookassa_success');
        register_setting('woocommerce-yookassa', 'yookassa_fail');
        register_setting('woocommerce-yookassa', 'yookassa_tax_rates_enum');
        register_setting('woocommerce-yookassa', 'yookassa_enable_hold');
        register_setting('woocommerce-yookassa', 'yookassa_description_template');
        register_setting('woocommerce-yookassa', 'yookassa_enable_receipt');
        register_setting('woocommerce-yookassa', 'yookassa_enable_second_receipt');
        register_setting('woocommerce-yookassa', 'yookassa_second_receipt_order_status');
        register_setting('woocommerce-yookassa', 'yookassa_debug_enabled');
        register_setting('woocommerce-yookassa', 'yookassa_default_tax_rate');
        register_setting('woocommerce-yookassa', 'yookassa_default_tax_system_code');
        register_setting('woocommerce-yookassa', 'yookassa_force_clear_cart');
        register_setting('woocommerce-yookassa', 'yookassa_tax_rate');
        register_setting('woocommerce-yookassa', 'yookassa_enable_sbbol');
        register_setting('woocommerce-yookassa', 'yookassa_sbbol_tax_rates_enum');
        register_setting('woocommerce-yookassa', 'yookassa_sbbol_default_tax_rate');
        register_setting('woocommerce-yookassa', 'yookassa_sbbol_tax_rate');
        register_setting('woocommerce-yookassa', 'yookassa_sbbol_purpose');
        register_setting('woocommerce-yookassa', 'yookassa_payment_subject_default');
        register_setting('woocommerce-yookassa', 'yookassa_payment_mode_default');
        register_setting('woocommerce-yookassa', 'yookassa_shipping_payment_subject_default');
        register_setting('woocommerce-yookassa', 'yookassa_shipping_payment_mode_default');
        register_setting('woocommerce-yookassa', 'yookassa_kassa_currency');
        register_setting('woocommerce-yookassa', 'yookassa_kassa_currency_convert');
        register_setting('woocommerce-yookassa', 'yookassa_test_shop');
        register_setting('woocommerce-yookassa', 'yookassa_access_token');
        register_setting('woocommerce-yookassa', 'yookassa_fiscalization_enabled');
        register_setting('woocommerce-yookassa', 'yookassa_save_card');
        register_setting('woocommerce-yookassa', 'yookassa_self_employed');

        update_option(
            'yookassa_sbbol_tax_rates_enum',
            array(
                VatDataType::UNTAXED => __('Без НДС', 'yookassa'),
                VatDataRate::RATE_7  => '7%',
                VatDataRate::RATE_10 => '10%',
                VatDataRate::RATE_18 => '18%',
                VatDataRate::RATE_20 => '20%',
            )
        );

        update_option(
            'yookassa_tax_rates_enum',
            array(
                1 => __('Не облагается', 'yookassa'),
                2 => '0%',
                3 => '10%',
                4 => '20%',
                5 => __('Расчетная ставка 10/110', 'yookassa'),
                6 => __('Расчетная ставка 20/120', 'yookassa'),
            )
        );

        update_option(
            'yookassa_tax_system_codes_enum',
            array(
                1 => __('Общая система налогообложения', 'yookassa'),
                2 => __('Упрощенная (УСН, доходы)', 'yookassa'),
                3 => __('Упрощенная (УСН, доходы минус расходы)', 'yookassa'),
                4 => __('Единый налог на вмененный доход (ЕНВД)', 'yookassa'),
                5 => __('Единый сельскохозяйственный налог (ЕСН)', 'yookassa'),
                6 => __('Патентная система налогообложения', 'yookassa'),
            )
        );
    }

    private function get_all_settings()
    {
        $wcTaxes                = $this->getAllTaxes();
        $wcCalcTaxes            = get_option('woocommerce_calc_taxes');
        $ymTaxRatesEnum         = get_option('yookassa_tax_rates_enum');
        $ymTaxSystemCodesEnum   = get_option('yookassa_tax_system_codes_enum');
        $pages                  = get_pages();
        $ymTaxes                = get_option('yookassa_tax_rate');
        $isHoldEnabled          = get_option('yookassa_enable_hold');
        $isSbBOLEnabled         = get_option('yookassa_enable_sbbol');
        $descriptionTemplate    = get_option('yookassa_description_template',
            __('Оплата заказа №%order_number%', 'yookassa'));
        $isReceiptEnabled       = get_option('yookassa_enable_receipt');
        $isSecondReceiptEnabled = get_option('yookassa_enable_second_receipt');
        $orderStatusReceipt     = get_option('yookassa_second_receipt_order_status', 'wc-completed');
        $isDebugEnabled         = (bool)get_option('yookassa_debug_enabled', '0');
        $forceClearCart         = (bool)get_option('yookassa_force_clear_cart', '0');
        $testMode               = $this->isTestMode();
        $active_tab             = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'yookassa-settings';

        $shopId                 = get_option('yookassa_shop_id');
        $password               = get_option('yookassa_shop_password');
        $npsVoteTime            = get_option('yookassa_nps_vote_time');
        $sbbolTemplate          = get_option('yookassa_sbbol_purpose', __('Оплата заказа №%order_number%', 'yookassa'));
        $payMode                = get_option('yookassa_pay_mode');

        $kassaCurrency          = get_option('yookassa_kassa_currency');
        $kassaCurrencyConvert   = get_option('yookassa_kassa_currency_convert');
        $isOauthTokenGotten     = (bool)get_option('yookassa_access_token', '0');
        $isTestShop             = (bool)get_option('yookassa_test_shop', '0');
        $isFiscalizationEnabled = (bool)get_option('yookassa_fiscalization_enabled', '0');
        $isSaveCard             = (bool)get_option('yookassa_save_card', '1');
        $isSelfEmployed         = (bool)get_option('yookassa_self_employed', '0');

        $validCredentials = null;


        if (!empty($shopId) && !empty($password) || $isOauthTokenGotten) {
            $validCredentials = $this->testConnection();
        }

        $isNeededShowNps = time() > (int)$npsVoteTime + $this->npsRetryAfterDays * 86400
            && substr($password, 0, 5) === 'live_'
            && get_locale() === 'ru_RU';

        $paymentSubjectEnum = array(
            PaymentSubject::COMMODITY             => __('Товар', 'yookassa') . ' ('.PaymentSubject::COMMODITY.')',
            PaymentSubject::EXCISE                => __('Подакцизный товар', 'yookassa') . ' ('.PaymentSubject::EXCISE.')',
            PaymentSubject::JOB                   => __('Работа', 'yookassa') . ' ('.PaymentSubject::JOB.')',
            PaymentSubject::SERVICE               => __('Услуга', 'yookassa') . ' ('.PaymentSubject::SERVICE.')',
            PaymentSubject::GAMBLING_BET          => __('Ставка в азартной игре', 'yookassa') . ' ('.PaymentSubject::GAMBLING_BET.')',
            PaymentSubject::GAMBLING_PRIZE        => __('Выигрыш в азартной игре', 'yookassa') . ' ('.PaymentSubject::GAMBLING_PRIZE.')',
            PaymentSubject::LOTTERY               => __('Лотерейный билет', 'yookassa') . ' ('.PaymentSubject::LOTTERY.')',
            PaymentSubject::LOTTERY_PRIZE         => __('Выигрыш в лотерею', 'yookassa') . ' ('.PaymentSubject::LOTTERY_PRIZE.')',
            PaymentSubject::INTELLECTUAL_ACTIVITY => __('Результаты интеллектуальной деятельности', 'yookassa') . ' ('.PaymentSubject::INTELLECTUAL_ACTIVITY.')',
            PaymentSubject::PAYMENT               => __('Платеж', 'yookassa') . ' ('.PaymentSubject::PAYMENT.')',
            PaymentSubject::AGENT_COMMISSION      => __('Агентское вознаграждение', 'yookassa') . ' ('.PaymentSubject::AGENT_COMMISSION.')',
            PaymentSubject::COMPOSITE             => __('Несколько вариантов', 'yookassa') . ' ('.PaymentSubject::COMPOSITE.')',
            PaymentSubject::ANOTHER               => __('Другое', 'yookassa') . ' ('.PaymentSubject::ANOTHER.')',
        );

        $paymentModeEnum = array(
            PaymentMode::FULL_PREPAYMENT    => __('Полная предоплата', 'yookassa') . ' ('.PaymentMode::FULL_PREPAYMENT.')',
            PaymentMode::PARTIAL_PREPAYMENT => __('Частичная предоплата', 'yookassa') . ' ('.PaymentMode::PARTIAL_PREPAYMENT.')',
            PaymentMode::ADVANCE            => __('Аванс', 'yookassa') . ' ('.PaymentMode::ADVANCE.')',
            PaymentMode::FULL_PAYMENT       => __('Полный расчет', 'yookassa') . ' ('.PaymentMode::FULL_PAYMENT.')',
            PaymentMode::PARTIAL_PAYMENT    => __('Частичный расчет и кредит', 'yookassa') . ' ('.PaymentMode::PARTIAL_PAYMENT.')',
            PaymentMode::CREDIT             => __('Кредит', 'yookassa') . ' ('.PaymentMode::CREDIT.')',
            PaymentMode::CREDIT_PAYMENT     => __('Выплата по кредиту', 'yookassa') . ' ('.PaymentMode::CREDIT_PAYMENT.')',
        );

        $wcOrderStatuses = wc_get_order_statuses();
        $wcOrderStatuses = array_filter($wcOrderStatuses, function ($k) {
            return in_array($k, self::getValidOrderStatuses());
        }, ARRAY_FILTER_USE_KEY);

        $kassaCurrencies = $this->createKassaCurrencyList();

        return array(
            'wcTaxes'                => $wcTaxes,
            'pages'                  => $pages,
            'wcCalcTaxes'            => $wcCalcTaxes,
            'ymTaxRatesEnum'         => $ymTaxRatesEnum,
            'ymTaxSystemCodesEnum'   => $ymTaxSystemCodesEnum,
            'ymTaxes'                => $ymTaxes,
            'isHoldEnabled'          => $isHoldEnabled,
            'isSbBOLEnabled'         => $isSbBOLEnabled,
            'descriptionTemplate'    => $descriptionTemplate,
            'isReceiptEnabled'       => $isReceiptEnabled,
            'isSecondReceiptEnabled' => $isSecondReceiptEnabled,
            'orderStatusReceipt'     => $orderStatusReceipt,
            'testMode'               => $testMode,
            'isDebugEnabled'         => $isDebugEnabled,
            'forceClearCart'         => $forceClearCart,
            'validCredentials'       => $validCredentials,
            'active_tab'             => $active_tab,
            'isNeededShowNps'        => $isNeededShowNps,
            'sbbolTemplate'          => $sbbolTemplate,
            'paymentModeEnum'        => $paymentModeEnum,
            'paymentSubjectEnum'     => $paymentSubjectEnum,
            'payMode'                => $payMode,
            'wcOrderStatuses'        => $wcOrderStatuses,
            'kassaCurrencies'        => $kassaCurrencies,
            'kassaCurrency'          => $kassaCurrency,
            'kassaCurrencyConvert'   => $kassaCurrencyConvert,
            'isOauthTokenGotten'     => $isOauthTokenGotten,
            'shopId'                 => $shopId,
            'password'               => $password,
            'isTestShop'             => $isTestShop,
            'isFiscalizationEnabled' => $isFiscalizationEnabled,
            'yookassaNonce'          => wp_create_nonce('yookassa-nonce'),
            'isSaveCard'             => $isSaveCard,
            'isSelfEmployed'         => $isSelfEmployed,
        );
    }

    public function renderAdminPage()
    {
        $this->render(
            'partials/admin-settings-view.php',
            $this->get_all_settings()
        );
    }

    /**
     * @return array
     */
    public static function getValidOrderStatuses()
    {
        return array('wc-processing', 'wc-completed');
    }

    /**
     * Get tab settings
     */
    public function get_tab_content ()
    {
        $file = 'partials/tabs/' . sanitize_key($_GET['tab']) . '.php';
        if (is_file(plugin_dir_path(__FILE__) . $file)) {
            $this->render($file, $this->get_all_settings());
        } else {
            echo 'Error! File "' . $file . '" not found';
        }
        wp_die();
    }

    /**
     * Делает запрос к OAuth приложению для получения ссылки на авторизацию
     *
     * @return void
     */
    public function get_oauth_url()
    {
        header('Content-Type: application/json');

        if (!is_ajax()) {
            echo json_encode(array('status' => 'error', 'error' => 'Unknown', 'code' => 'unknown'));
            wp_die();
        }

        $parameters = array(
            'state' => $this->getOauthState(),
            'cms' => 'woocommerce',
            'host' => $_SERVER['HTTP_HOST']
        );

        YooKassaLogger::info('Sending request for OAuth link. Request parameters: ' . json_encode($parameters));

        $data = wp_remote_post(self::OAUTH_CMS_URL . '/authorization', array(
            'headers'     => array('Content-Type' => 'application/json; charset=utf-8'),
            'body'        => json_encode($parameters),
            'method'      => 'POST',
            'data_format' => 'body',
        ));

        if (is_wp_error($data)) {
            $error = $data->get_error_message();
            YooKassaLogger::error('Got error while getting OAuth link. Error: ' . $error);
            echo json_encode(array('error' => 'Got error while getting OAuth link.'));
            wp_die('', '', array('response' => 502));
        }

        $body = $data['body'];

        $body = json_decode($body, true);

        if (!isset($body['oauth_url'])) {
            $error = empty($body['error']) ? 'OAuth URL not found' : $body['error'];
            YooKassaLogger::error('Got error while getting OAuth link. Response body: ' . json_encode($body));
            echo json_encode(array('error' => $error));
            wp_die('', '', array('response' => 502));
        }

        echo json_encode(array('oauth_url' => $body['oauth_url']));
        wp_die();
    }

    /**
     * Проверяет в БД state и возвращает его, если нету в БД, генерирует его
     *
     * @return string state - уникальный id для запросов в OAuth приложение
     */
    private function getOauthState()
    {
        $state = get_option('yookassa_oauth_state');

        if (!$state) {
            $state = substr(md5(time()), 0, 12);
            update_option('yookassa_oauth_state', $state);
        }

        return $state;
    }

    /**
     * Функция обработки ajax зпроса на получение OAuth токена через OAuth-приложение
     *
     * @return void
     */
    public function get_oauth_token()
    {
        header('Content-Type: application/json');

        if (!is_ajax()) {
            echo json_encode(array('status' => 'error', 'error' => 'Unknown', 'code' => 'unknown'));
            wp_die();
        }

        $state = $this->getOauthState();

        $parameters = array('state' => $state);

        YooKassaLogger::info('Sending request for OAuth token. Request parameters: ' . json_encode($parameters));

        $data = wp_remote_post(self::OAUTH_CMS_URL . '/get-token', array(
            'headers'     => array('Content-Type' => 'application/json; charset=utf-8'),
            'body'        => json_encode($parameters),
            'method'      => 'POST',
            'data_format' => 'body',
        ));

        if (is_wp_error($data)) {
            $error = $data->get_error_message();
            YooKassaLogger::error('Got error while getting OAuth token. Error: ' . $error);
            echo json_encode(array('error' => 'Got error while getting OAuth token.'));
            wp_die('', '', array('response' => 502));
        }

        if (wp_remote_retrieve_response_code($data) == 422) {
            $error = empty($body['error']) ? 'Access token not found' : $body['error'];
            YooKassaLogger::error('Error: ' . $error);
            echo json_encode(array('error' => 'Авторизация не пройдена'));
            wp_die('', '', array('response' => 502));
        }

        $body = $data['body'];

        $body = json_decode($body, true);

        if (!isset($body['access_token'])) {
            $error = empty($body['error']) ? 'Access token not found' : $body['error'];
            YooKassaLogger::error(
                'Got error while getting OAuth token. Key access_token not found. Response body: '
                . json_encode($body)
            );
            echo json_encode(array('error' => $error));
            wp_die('', '', array('response' => 502));
        }

        if (!isset($body['expires_in'])) {
            $error = empty($body['error']) ? 'Expires_in parameter not found' : $body['error'];
            YooKassaLogger::error(
                'Got error while getting OAuth token. Key expires_in not found. Response body: '
                . json_encode($body)
            );
            echo json_encode(array('error' => $error));
            wp_die('', '', array('response' => 502));
        }

        $token = get_option('yookassa_access_token');

        if ($token) {
            YooKassaLogger::info('Old token found. Trying to revoke.');
            $this->revokeOldToken($token, $state);
        }

        update_option('yookassa_access_token', $body['access_token']);
        update_option('yookassa_token_expires_in', $body['expires_in']);

        try {
            $client = YooKassaClientFactory::getYooKassaClient();
            YookassaWebhookSubscriber::subscribe($client);
            $this->saveShopInfoByOauth();
        } catch (Exception $e) {
            YooKassaLogger::error('Error occurred during creating webhooks: ' . $e->getMessage());
            echo json_encode(array('error' => $e->getMessage()));
            wp_die('', '', array('response' => 500));
        }

        echo json_encode(array('status' => 'success'));
        wp_die();
    }

    /**
     * Выполняет запрос в OAuth приложение на отзыв токена
     *
     * @param $token - OAuth токен, который нужно отозвать
     * @param $state - id модуля
     * @return void
     */
    private function revokeOldToken($token, $state)
    {
        $parameters = array(
            'state' => $state,
            'token' => $token,
            'cms' => 'woocommerce'
        );

        $data = wp_remote_post(self::OAUTH_CMS_URL . '/revoke-token', array(
            'headers'     => array('Content-Type' => 'application/json; charset=utf-8'),
            'body'        => json_encode($parameters),
            'method'      => 'POST',
            'data_format' => 'body',
        ));

        $body = $data['body'];
        $body = json_decode($body, true);

        if (!isset($body['success'])) {
            YooKassaLogger::error(
                'Got error while revoking OAuth token. Response body: '
                . json_encode($body)
            );
        }
    }

    /**
     * Получает информацию о магазине при загрузке страницы с настройками модуля
     *
     * @return void
     * @throws \Exception
     */
    private function saveShopInfoByOauth()
    {
        $apiClient = YooKassaClientFactory::getYooKassaClient();
        $shopInfo = $apiClient->me();

        if (!isset($shopInfo['account_id'], $shopInfo['test'], $shopInfo['fiscalization_enabled'])) {
            throw new \Exception('Failed to save shop info');
        }

        update_option('yookassa_shop_id', $shopInfo['account_id']);
        update_option('yookassa_test_shop', $shopInfo['test']);
        update_option('yookassa_fiscalization_enabled', $shopInfo['fiscalization_enabled']);
    }

    /**
     * Save settings
     */
    public function save_settings()
    {
        header('Content-Type: application/json');

        $this->isRequestSecure();

        if ($options = explode(',', wp_unslash($_POST['page_options']))) {
            $user_language_old = get_user_locale();
            // Save options
            array_map(function ($option) {
                $option = trim($option);
                if (isset($_POST[$option])) {
                    if (is_array($_POST[$option])) {
                        $value = $_POST[$option];
                        array_walk_recursive($value, function (&$item) {
                            $item = sanitize_textarea_field(wp_unslash(trim($item)));
                        });
                    } else {
                        $value = sanitize_textarea_field(wp_unslash(trim($_POST[$option])));
                    }
                } else {
                    $value = null;
                }
                update_option($option, $value);
            }, $options);

            unset($GLOBALS['locale']);
            $user_language_new = get_user_locale();
            if ($user_language_old !== $user_language_new) {
                load_default_textdomain($user_language_new);
            }
        } else {
            echo json_encode(array('status' => 'error', 'error' => 'Unknown', 'code' => 'unknown'));
            wp_die();
        }

        echo json_encode(array('status' => 'success'));
        wp_die();
    }

    public function voteNps()
    {
        update_option('yookassa_nps_vote_time', time());
    }

    public function getAllTaxes()
    {
        global $wpdb;

        $query = "
            SELECT *
            FROM {$wpdb->prefix}woocommerce_tax_rates
            WHERE 1 = 1
        ";

        $order_by = ' ORDER BY tax_rate_order';

        $result = $wpdb->get_results($query.$order_by);

        return $result;
    }

    private function isRequestSecure()
    {
        if (!is_ajax()) {
            echo json_encode(array('status' => 'error', 'error' => 'Unknown', 'code' => 'unknown'));
            wp_die();
        }

        if( !current_user_can('manage_woocommerce') && !current_user_can('administrator') ) {
            wp_die('Forbidden', 'Forbidden', 403);
        }

        if (!isset($_POST['form_nonce']) || !wp_verify_nonce($_POST['form_nonce'],'yookassa-nonce')) {
            wp_die('Bad request', 'Bad request', 400);
        }
    }

    private function render($viewPath, $args)
    {
        extract($args);

        include(plugin_dir_path(__FILE__) . $viewPath);
    }

    private function isTestMode()
    {
        $shopPassword = get_option('yookassa_shop_password');
        $prefix       = substr($shopPassword, 0, 4);

        return $prefix == "test";
    }

    private function testConnection()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'includes/lib/autoload.php';

        try {
            $apiClient = YooKassaClientFactory::getYooKassaClient();
            $apiClient->getPaymentInfo('00000000-0000-0000-0000-000000000001');
        } catch (\YooKassa\Common\Exceptions\NotFoundException $e) {
            return self::CREDENTIAL_SUCCESS;
        } catch (\YooKassa\Common\Exceptions\UnauthorizedException $e) {
            return self::CREDENTIAL_AUTHORIZED_ERROR;
        } catch (\Exception $e) {
            return self::CREDENTIAL_OTHER_ERROR;
        }

        return self::CREDENTIAL_SUCCESS;
    }

    /**
     * @return array
     */
    private function createKassaCurrencyList()
    {
        $allCurrencies = get_woocommerce_currencies();
        $currentCurrency = get_woocommerce_currency();
        $kassa_currencies = CurrencyCode::getEnabledValues();

        $available_currencies = array(CurrencyCode::RUB);
        if (in_array($currentCurrency, $kassa_currencies)) {
            $available_currencies[] = $currentCurrency;
        }

        $return_currencies = array();
        foreach (array_unique($available_currencies) as $code) {
            $return_currencies[$code] = $allCurrencies[$code];
        }
        return $return_currencies;
    }
}
