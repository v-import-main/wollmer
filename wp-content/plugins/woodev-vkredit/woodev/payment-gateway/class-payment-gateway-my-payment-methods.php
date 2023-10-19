<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Woodev_Payment_Gateway_My_Payment_Methods' ) ) :


class Woodev_Payment_Gateway_My_Payment_Methods {

	protected $plugin;

	protected $tokens;
	
	protected $credit_card_tokens;
	
	protected $echeck_tokens;
	
	protected $has_tokens;
	
	public function __construct( $plugin ) {

		$this->plugin = $plugin;
		
		$this->load_tokens();

		$this->has_tokens = ! empty( $this->tokens );
		
		add_action( 'woocommerce_after_my_account', array( $this, 'render' ) );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue_styles_scripts' ) );
		
		$this->handle_payment_method_actions();
	}
	
	public function maybe_enqueue_styles_scripts() {

		wp_enqueue_style( 'dashicons' );
		
		if ( $this->has_tokens ) {
			wc_enqueue_js( '
			$( ".woodev-payment-gateway-payment-method-actions .delete-payment-method" ).on( "click", function( e ) {
				if ( ! confirm( "Вы уверены что хотите удалить этот метод оплаты?" ) ) {
					e.preventDefault();
				}
			} );
		' );
		}
	}
	
	protected function load_tokens() {

		if ( ! empty( $this->tokens ) ) {
			return $this->tokens;
		}

		$this->credit_card_tokens = $this->echeck_tokens = array();

		foreach ( $this->get_plugin()->get_gateways() as $gateway ) {

			if ( ! $gateway->is_available() || ! $gateway->tokenization_enabled() ) {
				continue;
			}

			foreach ( $gateway->get_payment_tokens( get_current_user_id() ) as $token ) {
			
				if ( isset( $this->credit_card_tokens[ $token->get_token() ] ) ||  isset( $this->echeck_tokens[ $token->get_token() ] ) ) {
					continue;
				}

				if ( $token->is_credit_card() ) {

					$this->credit_card_tokens[ $token->get_token() ] = $token;

				} elseif ( $token->is_check() ) {

					$this->echeck_tokens[ $token->get_token() ] = $token;
				}
			}
		}

		return $this->tokens = array_merge( $this->credit_card_tokens, $this->echeck_tokens );
	}
	
	public function render() {

		if ( $this->has_tokens ) {

			echo $this->get_table_title_html();

			do_action( 'wc_' . $this->get_plugin()->get_id() . '_before_my_payment_method_table', $this );

			echo $this->get_table_html();

			do_action( 'wc_' . $this->get_plugin()->get_id() . '_after_my_payment_method_table', $this );

		} else {

			echo $this->get_table_title_html();

			echo $this->get_no_payment_methods_html();
		}
	}
	
	protected function get_no_payment_methods_html() {

		$html = '<p>' . apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_no_payment_methods_text', 'У вас нету сохраненных методов оплаты.', $this ) . '</p>';

		return apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_my_payment_methods_no_payment_methods_html', $html, $this );
	}
	
	protected function get_table_title_html() {

		$title = apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_my_payment_methods_table_title', 'Мои методы оплаты', $this );

		$html = '<div class="woodev-payment-gateway-my-payment-methods-table-title">';

		$html .= sprintf( '<h2 id="wc-%s-my-payment-methods">%s</h2>', $this->get_plugin()->get_id_dasherized(), esc_html( $title ) );

		if ( $this->supports_add_payment_method() ) {
			$html .= sprintf( '<a class="button woodev-payment-gateway-my-payment-methods-add-payment-method-button dashicons-before dashicons-plus-alt" href="%s">%s</a>', esc_url( wc_get_endpoint_url( 'add-payment-method' ) ), 'Добавить новый метод оплаты' );
		}

		$html .= '</div>';

		return apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_my_payment_methods_table_title_html', $html, $this );
	}
	
	public function get_table_html() {

		$html = sprintf( '<table class="shop_table shop_table_responsive woodev-payment-gateway-my-payment-methods-table wc-%s-my-payment-methods">', sanitize_html_class( $this->get_plugin()->get_id_dasherized() ) );

		$html .= $this->get_table_head_html();

		$html .= $this->get_table_body_html();

		$html .= '</table>';

		return apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_my_payment_methods_table_html', $html, $this );
	}
	
	protected function get_table_head_html() {

		$html = '<thead><tr>';

		foreach ( $this->get_table_headers() as $key => $title ) {

			$html .= sprintf( '<th class="woodev-payment-gateway-my-payment-method-table-header wc-%s-payment-method-%s"><span class="nobr">%s</span></th>', sanitize_html_class( $this->get_plugin()->get_id_dasherized() ), sanitize_html_class( $key ), esc_html( $title ) );
		}

		$html .= '</tr></thead>';

		return apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_my_payment_methods_table_head_html', $html, $this );
	}
	
	protected function get_table_headers() {

		$headers = array(
			'title'   => 'Метод',
			'expiry'  => 'Истекает',
			'actions' => '&nbsp;'
		);

		return apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_my_payment_methods_table_headers', $headers, $this );
	}
	
	protected function get_table_body_html() {

		$html = '<tbody>';

		if ( $this->credit_card_tokens && $this->echeck_tokens ) {

			$html .= sprintf( '<tr class="woodev-payment-gateway-my-payment-methods-type-divider wc-%s-my-payment-methods-type-divider"><td colspan="%d">%s</td><tr>',
				sanitize_html_class( $this->get_plugin()->get_id_dasherized() ), count( $this->get_table_headers() ), 'Банковские карты'
			);

			$html .= $this->get_table_body_row_html( $this->credit_card_tokens );

			$html .= sprintf( '<tr class="woodev-payment-gateway-my-payment-methods-type-divider wc-%s-my-payment-methods-type-divider"><td colspan="%d">%s</td><tr>',
				sanitize_html_class( $this->get_plugin()->get_id_dasherized() ), count( $this->get_table_headers() ), 'Банковский аккаунт'
			);

			$html .= $this->get_table_body_row_html( $this->echeck_tokens );

		} else {

			$html .= $this->get_table_body_row_html( $this->tokens );
		}

		$html .= '</tbody>';

		return apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_my_payment_methods_table_body_html', $html, $this );
	}
	
	protected function get_table_body_row_html( $tokens ) {

		$html = '';
		
		$headers = $this->get_table_headers();

		foreach ( $this->get_table_body_row_data( $tokens ) as $method ) {

			$html .= sprintf( '<tr class="woodev-payment-gateway-my-payment-methods-method wc-%s-my-payment-methods-method">', sanitize_html_class( $this->get_plugin()->get_id_dasherized() ) );

			foreach ( $method as $attribute => $value ) {

				$html .= sprintf( '<td class="woodev-payment-gateway-payment-method-%1$s wc-%2$s-payment-method-%1$s" data-title="%4$s">%3$s</td>', sanitize_html_class( $attribute ), $this->get_plugin()->get_id_dasherized(), $value, esc_attr( isset( $headers[ $attribute ] ) ? $headers[ $attribute ] : '' ) );
			}

			$html .= '</tr>';
		}

		return apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_my_payment_methods_table_row_html', $html, $tokens, $this );
	}
	
	protected function get_table_body_row_data( $tokens ) {

		$methods = array();

		foreach ( $tokens as $token ) {

			$actions = array();

			foreach ( $this->get_payment_method_actions( $token ) as $action ) {

				$actions[] = sprintf( '<a href="%s" class="button %s">%s</a>', esc_url( $action['url'] ), implode( ' ', array_map( 'sanitize_html_class', (array) $action['class'] ) ), esc_html( $action['name'] ) );
			}

			$methods[] = array(
				'title'   => $this->get_payment_method_title( $token ),
				'expiry'  => $token->get_exp_month() && $token->get_exp_year() ? $token->get_exp_date() : 'Н/А',
				'actions' => implode( '', $actions ),
			);
		}

		return apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_my_payment_methods_table_body_row_data', $methods, $this->tokens, $this );
	}
	
	protected function get_payment_method_actions( $token ) {

		$actions = array();
		
		if ( ! $token->is_default() ) {

			$actions[] = array(
				'url'   => wp_nonce_url( add_query_arg( array(
					'wc-' . $this->get_plugin()->get_id_dasherized() . '-token'  => $token->get_token(),
					'wc-' . $this->get_plugin()->get_id_dasherized() . '-action' => 'make-default'
				) ), 'wc-' . $this->get_plugin()->get_id_dasherized() . '-token-action' ),
				'class' => array( 'make-payment-method-default' ),
				'name'  => 'По-умолчанию'
			);
		}
		
		$actions[] = array(
			'url'   => wp_nonce_url( add_query_arg( array(
				'wc-' . $this->get_plugin()->get_id_dasherized() . '-token'  => $token->get_token(),
				'wc-' . $this->get_plugin()->get_id_dasherized() . '-action' => 'delete'
			) ), 'wc-' . $this->get_plugin()->get_id_dasherized() . '-token-action' ),
			'class' => array( 'delete-payment-method' ),
			'name'  => 'Удалить',
		);
		
		return apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_my_payment_methods_table_method_actions', $actions, $token, $this );
	}
	
	protected function get_payment_method_title( $token ) {

		$image_url = $token->get_image_url();
		$last_four = $token->get_last_four();
		$type      = $token->get_type_full();

		if ( $image_url ) {
			$title = sprintf( '<img src="%1$s" alt="%2$s" title="%2$s" width="40" height="25" />%3$s', esc_url( $image_url ), $type, $type );
		} else {
			$title = $type;
		}

		if ( $last_four ) {

			$title .= '&nbsp;' . sprintf( 'заканчивается на %s', $last_four );
		}
		
		if ( $token->is_default() ) {
			$title .= ' (по-умолчанию)';
		}

		return apply_filters( 'wc_' . $this->get_plugin()->get_id() . '_my_payment_methods_table_method_title', $title, $token, $this );
	}
	
	public function handle_payment_method_actions() {

		if ( ! $this->has_tokens ) {
			return;
		}

		$token  = isset( $_GET[ 'wc-' . $this->get_plugin()->get_id_dasherized() . '-token' ] )  ? trim( $_GET[ 'wc-' . $this->get_plugin()->get_id_dasherized() . '-token' ] ) : '';
		$action = isset( $_GET[ 'wc-' . $this->get_plugin()->get_id_dasherized() . '-action' ] ) ? $_GET[ 'wc-' . $this->get_plugin()->get_id_dasherized() . '-action' ] : '';
		
		if ( $token && $action && ! empty( $_GET['_wpnonce'] ) && is_user_logged_in() ) {
		
			if ( false === wp_verify_nonce( $_GET['_wpnonce'], 'wc-' . $this->get_plugin()->get_id_dasherized() . '-token-action' ) ) {

				Woodev_Helper::wc_add_notice( 'К сожалению, вы слишком долго, пожалуйста, попробуйте еще раз.', 'error' );

				$this->redirect_to_my_account();
			}
			
			$user_id = get_current_user_id();

			$gateway = $this->get_plugin()->get_gateway_from_token( $user_id, $token );
			
			if ( ! is_object( $gateway ) ) {

				Woodev_Helper::wc_add_notice( 'Произошла ошибка в вашем запросе, пожалуйста, попробуйте еще раз.', 'error' );

				$this->redirect_to_my_account();
			}

			switch ( $action ) {
			
				case 'delete':

					if ( ! $gateway->remove_payment_token( $user_id, $token ) ) {
						Woodev_Helper::wc_add_notice( 'Ошибка при удалении способа оплаты', 'error' );
					} else {
						Woodev_Helper::wc_add_notice( 'Способ оплаты удален.' );
					}

				break;
				
				case 'make-default':
					$gateway->set_default_payment_token( $user_id, $token );
					Woodev_Helper::wc_add_notice( 'Способ оплаты по умолчанию обновлен.' );
				break;
				
				default:
					do_action( 'wc_' . $this->get_plugin()->get_id() . '_my_payment_methods_action_' . sanitize_title( $action ), $this );
				break;
			}

			$this->redirect_to_my_account();
		}
	}
	
	protected function redirect_to_my_account() {

		wp_redirect( wc_get_page_permalink( 'myaccount' ) );
		exit;
	}
	
	public function get_plugin() {
		return $this->plugin;
	}
	
	protected function supports_add_payment_method() {

		foreach ( $this->get_plugin()->get_gateways() as $gateway ) {

			if ( $gateway->is_direct_gateway() && $gateway->supports_add_payment_method() ) {
				return true;
			}
		}

		return false;
	}


}

endif;