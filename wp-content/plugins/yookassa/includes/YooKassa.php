<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * payment-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */
class YooKassa
{

    public static $pluginUrl;

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      YooKassaLoader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the payment-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {

        $this->plugin_name = 'yookassa';
        $this->version     = '2.5.2';
        self::$pluginUrl   = plugin_dir_url(dirname(__FILE__));

        $this->loadDependencies();
        $this->setLocale();
        $this->defineAdminHooks();
        $this->definePaymentHooks();
        $this->defineShopHooks();
        $this->defineChangeOrderStatuses();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - YooKassaLoader. Orchestrates the hooks of the plugin.
     * - YooKassai18n. Defines internationalization functionality.
     * - YooKassaAdmin. Defines all hooks for the admin area.
     * - YooKassaPublic. Defines all hooks for the payment side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function loadDependencies()
    {

        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/lib/autoload.php';

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/YooKassaLoader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/YooKassaI18N.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/YooKassaAdmin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/YooKassaTransactionsListTable.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/YooKassaPaymentChargeDispatcher.php';

        /**
         * The class responsible for defining all actions that occur in the payment-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/YooKassaPayment.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/YooKassaHandler.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/YooKassaInstallments.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/YooKassaOrderHelper.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/YooKassaSecondReceipt.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/YooKassaLogger.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/WC_Payment_Token_YooKassa.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/YooKassaFileCache.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/YooKassaCBRAgent.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/YooKassaClientFactory.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/YookassaWebhookSubscriber.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/PaymentsTableModel.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/CaptureNotificationChecker.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/SucceededNotificationChecker.php';

        $this->loader = new YooKassaLoader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the YooKassai18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function setLocale()
    {

        $plugin_i18n = new YooKassaI18N();

        $this->loader->addAction('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function defineAdminHooks()
    {
        $plugin_admin = new YooKassaAdmin($this->getPluginName(), $this->getVersion());

        $this->loader->addAction('admin_menu', $plugin_admin, 'addMenu');
        $this->loader->addAction('admin_init', $plugin_admin, 'registerSettings');
        $this->loader->addAction('wp_ajax_vote_nps', $plugin_admin, 'voteNps');
    }

    /**
     * Register all of the hooks related to the payment-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function definePaymentHooks()
    {
        $paymentKernel = new YooKassaPayment($this->getPluginName(), $this->getVersion());

        $this->loader->addAction('plugins_loaded', $paymentKernel, 'loadGateways');
        $this->loader->addAction('parse_request', $paymentKernel, 'processCallback');

        $this->loader->addFilter('woocommerce_payment_gateways', $paymentKernel, 'addGateways');

        $this->loader->addAction('woocommerce_order_status_on-hold_to_processing', $paymentKernel, 'changeOrderStatusToProcessing');
        $this->loader->addAction('woocommerce_order_status_on-hold_to_cancelled', $paymentKernel, 'changeOrderStatusToCancelled');
        $this->loader->addFilter('woocommerce_payment_methods_list_item', $paymentKernel, 'getAccountSavedPaymentMethodsListItem', 10, 2);

        $this->loader->addAction('wp_ajax_nopriv_yookassa_check_payment', $paymentKernel, 'checkPaymentStatus');
    }

    /**
     * Register all of the hooks related to the shop-facing functionality
     * of the plugin.
     *
     * @since    1.1.4
     * @access   private
     */
    private function defineShopHooks()
    {
        $installments = new YooKassaInstallments($this->getPluginName());

        $this->loader->addAction('woocommerce_single_product_summary', $installments, 'showInfo', 15);
        $this->loader->addAction('woocommerce_after_checkout_form', $installments, 'showExtraCheckoutInfo');
        $this->loader->addAction('woocommerce_cart_totals_after_order_total', $installments, 'showExtraCheckoutInfo');
        $this->loader->addAction('woocommerce_review_order_after_order_total', $installments, 'showExtraCheckoutInfo');
    }

    /**
     * Register all of the hooks related to the changes of order statuses
     *
     * @since    1.0.0
     * @access   private
     */
    private function defineChangeOrderStatuses()
    {
        $secondReceipt = new YooKassaSecondReceipt($this->getPluginName(), $this->getVersion());

        $this->loader->addAction('woocommerce_order_status_processing', $secondReceipt, 'changeOrderStatusToProcessing');
        $this->loader->addAction('woocommerce_order_status_completed', $secondReceipt, 'changeOrderStatusToCompleted');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function getPluginName()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    YooKassaLoader  Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function getVersion()
    {
        return $this->version;
    }

}
