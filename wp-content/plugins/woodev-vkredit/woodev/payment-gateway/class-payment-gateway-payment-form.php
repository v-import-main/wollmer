<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Woodev_Payment_Gateway_Payment_Form' ) ) :


class Woodev_Payment_Gateway_Payment_Form {
	
	protected $gateway;
	
	protected $tokens;
	
	protected $default_new_payment_method = true;
	
	public function __construct( $gateway ) {

		$this->gateway = $gateway;
		
		$this->add_hooks();
		
		$this->get_tokens();
	}
	
	protected function add_hooks() {

		$gateway_id = $this->get_gateway()->get_id();
		
		add_action( "wc_{$gateway_id}_payment_form_start", array( $this, 'render_payment_form_description' ), 15 );
		
		add_action( "wc_{$gateway_id}_payment_form_start", array( $this, 'render_saved_payment_methods' ), 20 );
		
		add_action( "wc_{$gateway_id}_payment_form_start", array( $this, 'render_sample_check' ), 25 );
		
		add_action( "wc_{$gateway_id}_payment_form_start", array( $this, 'render_fieldset_start' ), 30 );
		
		add_action( "wc_{$gateway_id}_payment_form",       array( $this, 'render_payment_fields' ), 0 );
		
		add_action( "wc_{$gateway_id}_payment_form_end",   array( $this, 'render_fieldset_end' ), 5 );
		
		add_action( "wc_{$gateway_id}_payment_form_end",   array( $this, 'render_js' ), 5 );
	}
	
	protected function get_tokens() {

		if ( ! empty( $this->tokens ) ) {
			return $this->tokens;
		}

		$tokens = array();

		if ( $this->tokenization_allowed() && is_user_logged_in() ) {

			foreach ( $this->get_gateway()->get_payment_tokens( get_current_user_id() ) as $token ) {
			
				if ( ( $this->get_gateway()->is_credit_card_gateway() && $token->is_check() ) || ( $this->get_gateway()->is_echeck_gateway() && $token->is_credit_card() ) ) {
					continue;
				}
				
				$tokens[ $token->get_token() ] = $token;
				
				if ( $token->is_default() ) {
					$this->default_new_payment_method = false;
				}
			}
		}

		return $this->tokens = $tokens;
	}
	
	public function get_gateway() {
		return $this->gateway;
	}
	
	public function has_tokens() {
		return ! empty( $this->tokens );
	}
	
	public function tokenization_allowed() {
	
		$tokenization_allowed = $this->get_gateway()->supports_tokenization() && $this->get_gateway()->tokenization_enabled();
		
		if ( $tokenization_allowed && is_checkout_pay_page() && ! is_user_logged_in() ) {
			$tokenization_allowed = false;
		}
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_tokenization_allowed', $tokenization_allowed, $this );
	}
	
	public function tokenization_forced() {

		$tokenization_forced = $this->get_gateway()->is_direct_gateway() && $this->get_gateway()->tokenization_forced();
		
		if ( $this->get_gateway()->is_direct_gateway() && $this->get_gateway()->supports_add_payment_method() && is_add_payment_method_page() ) {
			$tokenization_forced = true;
		}
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_tokenization_forced', $tokenization_forced, $this );
	}
	
	public function default_new_payment_method() {
		return $this->default_new_payment_method;
	}
	
	protected function get_payment_fields() {

		switch ( $this->get_gateway()->get_payment_type() ) {

			case 'credit-card':
				$fields = $this->get_credit_card_fields();
			break;

			case 'echeck':
				$fields = $this->get_echeck_fields();
			break;

			default:
				$fields = array();
			break;
		}
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_default_payment_form_fields', $fields, $this );
	}
	
	protected function get_credit_card_fields() {

		$defaults = $this->get_gateway()->get_payment_method_defaults();

		$fields = array(
			'card-number' => array(
				'type'              => 'text',
				'label'             => 'Номер карты',
				'id'                => 'wc-' . $this->get_gateway()->get_id_dasherized() . '-account-number',
				'name'              => 'wc-' . $this->get_gateway()->get_id_dasherized() . '-account-number',
				'placeholder'       => '•••• •••• •••• ••••',
				'required'          => true,
				'class'             => array( 'form-row-wide' ),
				'input_class'       => array( 'js-woodev-payment-gateway-credit-card-form-input js-woodev-payment-gateway-credit-card-form-account-number' ),
				'maxlength'         => 20,
				'custom_attributes' => array( 'autocomplete' => 'cc-number' ),
				'value'             => $defaults['account-number'],
			),
			'card-expiry' => array(
				'type'              => 'text',
				'label'             => 'Срок действия (месяц/год)',
				'id'                => 'wc-' . $this->get_gateway()->get_id_dasherized() . '-expiry',
				'name'              => 'wc-' . $this->get_gateway()->get_id_dasherized() . '-expiry',
				'placeholder'       => 'Месяц / Год',
				'required'          => true,
				'class'             => array( 'form-row-first' ),
				'input_class'       => array( 'js-woodev-payment-gateway-credit-card-form-input js-woodev-payment-gateway-credit-card-form-expiry' ),
				'custom_attributes' => array( 'autocomplete' => 'cc-exp' ),
				'value'             => $defaults['expiry'],
			),
		);

		if ( $this->get_gateway()->csc_enabled() ) {
			$fields['card-csc']    = array(
				'type'              => 'text',
				'label'             => 'Код защиты',
				'id'                => 'wc-' . $this->get_gateway()->get_id_dasherized() . '-csc',
				'name'              => 'wc-' . $this->get_gateway()->get_id_dasherized() . '-csc',
				'placeholder'       => 'CSC',
				'required'          => true,
				'class'             => array( 'form-row-last' ),
				'input_class'       => array( 'js-woodev-payment-gateway-credit-card-form-input js-woodev-payment-gateway-credit-card-form-csc' ),
				'maxlength'         => 20,
				'custom_attributes' => array( 'autocomplete' => 'off' ),
				'value'             => $defaults['csc'],
			);
		}
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_default_credit_card_fields', $fields, $this );
	}
	
	protected function get_echeck_fields() {

		$fields = array();
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_default_echeck_fields', $fields, $this );
	}
	
	public function get_payment_form_description_html() {

		$description = '';

		if ( $this->get_gateway()->get_description() ) {
			$description .= '<p>' . wp_kses_post( $this->get_gateway()->get_description() ) . '</p>';
		}

		if ( $this->get_gateway()->is_test_environment() ) {
			echo '<p>Включён режим тестирования.</p>';
		}
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_description', $description, $this );
	}
	
	protected function get_sample_check_html() {

		$image_url = WC_HTTPS::force_https_url( $this->get_gateway()->get_plugin()->get_payment_gateway_framework_assets_url() . '/images/sample-check.png' );

		$html = sprintf( '<div class="js-woodev-payment-gateway-echeck-form-sample-check" style="display: none;"><img width="541" height="270" src="%s" /></div>', esc_url( $image_url ) );
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_sample_check_html', $html, $this );
	}
	
	protected function get_saved_payment_methods_html() {

		$html = '<p class="form-row form-row-wide">';

		$html .= $this->get_manage_payment_methods_button_html();

		foreach ( $this->get_tokens() as $token ) {

			$html .= $this->get_saved_payment_method_html( $token );
		}

		$html .= $this->get_use_new_payment_method_input_html();

		$html .= '</p><div class="clear"></div>';
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_saved_payment_methods_html', $html, $this );
	}
	
	protected function get_manage_payment_methods_button_html() {

		$html = sprintf( '<a class="button" style="float:right;" href="%s">%s</a>',
			esc_url( wc_get_page_permalink( 'myaccount' ) . '#wc-' . $this->get_gateway()->get_plugin()->get_id_dasherized() . '-my-payment-methods' ),
			wp_kses_post( apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_manage_payment_methods_text', 'Управление методами оплаты' ) )
		);
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_manage_payment_methods_button_html', $html, $this );
	}
	
	protected function get_saved_payment_method_html( $token ) {
		
		$html = sprintf( '<input type="radio" id="wc-%1$s-payment-token-%2$s" name="wc-%1$s-payment-token" class="js-woodev-payment-gateway-payment-token js-wc-%1$s-payment-token" style="width:auto;" value="%2$s" %3$s/>',
			esc_attr( $this->get_gateway()->get_id_dasherized() ),
			esc_attr( $token->get_token() ),
			checked( $token->is_default(), true, false )
		);
		
		$html .= sprintf( '<label class="woodev-payment-gateway-payment-form-saved-payment-method" for="wc-%s-payment-token-%s">', esc_attr( $this->get_gateway()->get_id_dasherized() ), esc_attr( $token->get_token() ) );
		$html .= $this->get_saved_payment_method_title( $token );
		$html .= '</label><br />';
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_payment_method_html', $html, $token, $this );
	}
	
	protected function get_saved_payment_method_title( $token ) {

		$image_url = $token->get_image_url();
		$last_four = $token->get_last_four();
		$type      = $token->get_type_full();

		if ( $image_url ) {
			$title = sprintf( '<img src="%1$s" alt="%2$s" title="%2$s" width="30" height="20" />%3$s', esc_url( $image_url ), $type, $type );
		} else {
			$title = $type;
		}
		
		if ( $last_four ) {
			$title .= '&nbsp;' . sprintf( 'заканчивается на %s', $last_four );
		}
		
		if ( $token->get_exp_month() && $token->get_exp_year() ) {
			$title .= ' ' . sprintf( '(дата окончания %s)', $token->get_exp_date() );
		}
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_payment_method_title', $title, $token, $this );
	}
	
	protected function get_use_new_payment_method_input_html() {
	
		$html = sprintf( '<input type="radio" id="wc-%1$s-use-new-payment-method" name="wc-%1$s-payment-token" class="js-woodev-payment-token js-wc-%1$s-payment-token" style="width:auto;" value="" %2$s />',
			esc_attr( $this->get_gateway()->get_id_dasherized() ),
			checked( $this->default_new_payment_method(), true, false )
		);
		
		$html .= sprintf( '<label style="display:inline;" for="wc-%s-use-new-payment-method">%s</label>',
			esc_attr( $this->get_gateway()->get_id_dasherized() ),
			$this->get_gateway()->is_credit_card_gateway() ? 'Использовать новую карту' : 'Использовать новые банковские реквизиты'
		);
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_new_payment_method_input_html', $html, $this );
	}
	
	protected function get_save_payment_method_checkbox_html() {

		$html = '';

		if ( $this->tokenization_allowed() || $this->tokenization_forced() ) {

			if ( $this->tokenization_forced() ) {

				$html .= sprintf( '<input name="wc-%1$s-tokenize-payment-method" id="wc-%1$s-tokenize-payment-method" type="hidden" value="true" />', $this->get_gateway()->get_id_dasherized() );

			} else {

				$html .= '<p class="form-row">';
				$html .= sprintf( '<input name="wc-%1$s-tokenize-payment-method" id="wc-%1$s-tokenize-payment-method" class="js-woodev-tokenize-payment method js-wc-%1$s-tokenize-payment-method" type="checkbox" value="true" style="width:auto;" />', $this->get_gateway()->get_id_dasherized() );
				$html .= sprintf( '<label for="wc-%s-tokenize-payment-method" style="display:inline;">%s</label>', $this->get_gateway()->get_id_dasherized(), apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_tokenize_payment_method_text', 'Безопастно сохранить аккаунт' ) );
				$html .= '</p><div class="clear"></div>';
			}
		}
		
		return apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_save_payment_method_checkbox_html', $html, $this );
	}
	
	public function render() {
		
		do_action( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_start', $this );
		
		do_action( 'wc_' . $this->get_gateway()->get_id() . '_payment_form', $this );
		
		do_action( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_end', $this );
	}
	
	public function render_payment_form_description() {
		echo $this->get_payment_form_description_html();
	}
	
	public function render_saved_payment_methods() {

		$is_add_new_payment_method_page = $this->get_gateway()->supports_add_payment_method() && is_add_payment_method_page();
		
		if ( $this->has_tokens() && ! $is_add_new_payment_method_page ) {
			echo $this->get_saved_payment_methods_html();
		}
	}
	
	public function render_sample_check() {

		if ( $this->get_gateway()->is_echeck_gateway() ) {
			echo $this->get_sample_check_html();
		}
	}
	
	public function render_fieldset_start() {

		printf( '<fieldset id="wc-%s-%s-form">', esc_attr( $this->get_gateway()->get_id_dasherized() ), esc_attr( $this->get_gateway()->get_payment_type() ) );

		printf( '<div class="wc-%1$s-new-payment-method-form js-wc-%1$s-new-payment-method-form">', esc_attr( $this->get_gateway()->get_id_dasherized() ) );
	}
	
	public function render_payment_fields() {
		foreach ( $this->get_payment_fields() as $field ) {
			woocommerce_form_field( $field['name'], $field, $field['value'] );
		}
	}
	
	public function render_fieldset_end() {
		
		echo '<div class="clear"></div>';

		echo $this->get_save_payment_method_checkbox_html() . '</div>';

		echo '</fieldset>';
	}
	
	public function render_js() {
		
		$args = apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_js_args', array(
			'plugin_id'     => $this->get_gateway()->get_plugin()->get_id(),
			'id'            => $this->get_gateway()->get_id(),
			'id_dasherized' => $this->get_gateway()->get_id_dasherized(),
			'type'          => $this->get_gateway()->get_payment_type(),
			'csc_required'  => $this->get_gateway()->csc_enabled(),
		), $this );

		wc_enqueue_js( sprintf( 'window.wc_%s_payment_form_handler = new Woodev_Payment_Form_Handler( %s );', esc_js( $this->get_gateway()->get_id() ), json_encode( $args ) ) );
	}


}

endif;