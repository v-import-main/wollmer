<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Woodev_Payment_Gateway' ) ) :

abstract class Woodev_Abstract_Shipping_Method extends WC_Shipping_Method {
	
	const DEBUG_MODE_LOG = 'log';

	const DEBUG_MODE_CHECKOUT = 'checkout';

	const DEBUG_MODE_BOTH = 'both';

	const DEBUG_MODE_OFF = 'off';
	
	const FEATURE_SHIPPING_ZONES = 'shipping-zones';
	
	const FEATURE_INSTANCE_SETTINGS = 'instance-settings';
	
	const FEATURE_INSTANCE_SETTINGS_MODAL = 'instance-settings-modal';
	
	const FEATURE_SETTINGS = 'settings';
	
	private $debug_mode;
	
	private $currencies;
	
	public $localized_script_handle;
	
	public function __construct( $instance_id  = 0 ) {
		
		$this->instance_id        = absint( $instance_id );
		
		$this->init_form_fields();
		
		add_action( 'woocommerce_update_options_shipping_' . $this->get_id(), array( $this, 'process_admin_options' ) );
		
		if ( ! has_action( 'woodev_' . $this->get_id() . '_api_request_performed' ) ) {
			add_action( 'woodev_' . $this->get_id() . '_api_request_performed', array( $this, 'log_api_request' ), 10, 2 );
		}
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}
	
	public function enqueue_scripts() {
		
		if ( ! $this->is_enabled() || ( $this->localized_script_handle && wp_script_is( $this->localized_script_handle, 'enqueued' ) ) ) {
			return false;
		}
		
		if ( $this->localized_script_handle ) {

			$params = apply_filters( 'woodev_' . $this->get_plugin()->get_id() . '_js_localize_script_params', $this->get_js_localize_script_params() );

			wp_localize_script( $this->localized_script_handle, $this->get_plugin()->get_id() . '_params', $params );
		}
		
		return true;
	}
	
	protected function get_js_localize_script_params() {
		return array(
			'ajax_url'	=> WC()->ajax_url()
		);
	}
	
	public function get_id() {
		return $this->id;
	}
	
	public function init_form_fields() {
	
		$this->form_fields = $this->get_form_fields();
		
		$this->form_fields['debug_mode'] = array(
			'title'   => 'Режим отладки',
			'type'    => 'select',
			'desc'    => sprintf( 'Показать отчёты об ошибках и запросы/ответы API на странице оформления заказа и/или сохранить их в <a href="%s">лог</a>', Woodev_Helper::get_wc_log_file_url( $this->get_id() ) ),
			'default' => self::DEBUG_MODE_OFF,
			'options' => array(
				self::DEBUG_MODE_OFF      => 'Выкл',
				self::DEBUG_MODE_CHECKOUT => 'Показывать на странице оформления заказа',
				self::DEBUG_MODE_LOG      => 'Записывать в лог',
				self::DEBUG_MODE_BOTH     => 'Оба варианта (и показывать и записывать)'
			),
		);
		
		$this->instance_form_fields = $this->get_instance_form_fields();
	}
	
	public function get_instance_form_fields() {
		return array(
			'enabled' => array(
				'title'   => 'Вкл/Выкл',
				'type'    => 'checkbox',
				'label'   => 'Включить этот метод доставки',
				'default' => 'yes',
			),
			'title' => array(
				'title'       => 'Заголовок',
				'type'        => 'text',
				'description' => 'Этот заголовок будет отображатся на странице оформления заказа.',
				'desc_tip'    => true,
				'default'     => ! empty( $this->method_title ) ? $this->method_title : '',
			),
		);
	}
	
	public function get_form_fields() {
		return array();
	}
	
	public function is_available( $package ) {
		
		$available = parent::is_available( $package );
		
		if ( ! $this->is_configured() ) {
			$available = false;
		}
		
		if ( ! $this->currency_is_accepted() ) {
			$available = false;
		}
		
		return apply_filters( 'woocommerce_shipping_' . $this->get_id() . '_is_available', $available, $package, $this );
	}
	
	protected function is_configured() {
		return true;
	}
	
	public function currency_is_accepted( $currency = null ) {
	
		if ( ! $this->currencies ) {
			return true;
		}
		
		if ( is_null( $currency ) ) {
			$currency = get_woocommerce_currency();
		}

		return in_array( $currency, $this->currencies );
	}
	
	public function is_method_chosen() {
		return in_array( $this->get_id(), wc_get_chosen_shipping_method_ids() );
	}
	
	public function log_api_request( $request, $response ) {

		$this->add_debug_message( $this->get_plugin()->get_api_log_message( $request ), 'message' );
		
		if ( ! empty( $response ) ) {
			$this->add_debug_message( $this->get_plugin()->get_api_log_message( $response ), 'message' );
		}
	}
	
	protected function add_debug_message( $message, $type = 'message' ) {

		if ( $this->debug_off() || ! $message ) {
			return;
		}
		
		if ( $this->debug_log() ) {
			$this->get_plugin()->log( $message, $this->get_id() );
		}
		
		if ( $this->debug_checkout() && ( ! is_admin() || defined( 'DOING_AJAX' ) ) ) {

			if ( 'message' === $type ) {
				Woodev_Helper::wc_add_notice( str_replace( "\n", "<br/>", htmlspecialchars( $message ) ), 'notice' );
			} else {
				Woodev_Helper::wc_add_notice( str_replace( "\n", "<br/>", htmlspecialchars( $message ) ), 'error' );
			}
		}
	}
	
	public function set_supports( $features ) {
		$this->supports = $features;
	}
	
	public function get_api() {
		return $this->get_plugin()->get_api();
	}
	
	public function debug_off() {
		return self::DEBUG_MODE_OFF === $this->debug_mode;
	}
	
	public function debug_log() {
		return self::DEBUG_MODE_LOG === $this->debug_mode || self::DEBUG_MODE_BOTH === $this->debug_mode;
	}
	
	public function debug_checkout() {
		return self::DEBUG_MODE_CHECKOUT === $this->debug_mode || self::DEBUG_MODE_BOTH === $this->debug_mode;
	}
	
	abstract public function get_plugin();
	
}

endif;

?>