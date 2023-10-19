<?php
/**
 * Plugin Name: Купи в кредит от Тинькофф
 * Plugin URI: https://woodev.ru/downloads/tinkoff-kupi-v-kredit
 * Description: Добавляет платёжный шлюз "Купить в кредит" для отправки заявки на расчёт и одобрение покупки заказа в кредит через банк Тинькоф.
 * Version: 1.2.2
 * Requires at least: 4.6
 * Tested up to: 5.4.1
 * Author: WooDev
 * WC tested up to: 4.7.1
 * WC requires at least: 3.0
 * Author URI: https://woodev.ru/vendor/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WC_TINKOFF_KVK_GATEWAY_VERSION', '1.2.2' );
define( 'WC_TINKOFF_KVK_GATEWAY_FILE', __FILE__ );

if ( ! class_exists( 'Woodev_Plugin_Bootstrap' ) ) {
	require_once( plugin_dir_path( WC_TINKOFF_KVK_GATEWAY_FILE ) . 'woodev/bootstrap.php' );
}

Woodev_Plugin_Bootstrap::instance()->register_plugin( '1.1.3', 'Купи в кредит от Тинькофф', WC_TINKOFF_KVK_GATEWAY_FILE, 'init_woocommerce_gateway_tinkoff_kredit', array(
	'is_payment_gateway' 	=> true,
	'minimum_wc_version'	=> '3.6',
	'minimum_wp_version'	=> '4.6',
	//'backwards_compatible' 	=> '1.1.3',
) );


function init_woocommerce_gateway_tinkoff_kredit() {
	
	class Woodev_TCB extends Woodev_Payment_Gateway_Plugin {
		
		protected static $instance;
		
		protected $product;
		
		const PLUGIN_ID = 'wc_tinkoff_kvk';
		
		const GATEWAY_CLASS_NAME = 'WC_Gateway_Tinkoff_KVK';
		
		const GATEWAY_ID = 'wc_tinkoff_kvk';
		
		public function __construct() {
			
			parent::__construct( 
				self::PLUGIN_ID,
				WC_TINKOFF_KVK_GATEWAY_VERSION,
				array(
					'gateways' => array(
						self::GATEWAY_ID => self::GATEWAY_CLASS_NAME
					),
					'currencies' => array( 'EUR', 'RUB', 'USD' )
				)
			);
			
			$this->product = $this->load_class( '/includes/product.php', 'WC_Gateway_Tinkoff_KVK_Product' );
			
			add_action( 'woodev_plugins_loaded', array( $this, 'includes' ) );
			
			add_action( 'woocommerce_order_details_after_order_table', array( $this, 'order_table_receipt_data' ) );
			add_action( 'woocommerce_email_after_order_table',         array( $this, 'email_order_table_receipt_data' ), 10, 3 );
		}
		
		public function includes() {
			require_once( $this->get_plugin_path() . '/includes/class-gateway.php' );
		}
		
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
		
		private function get_order_fields() {
			return apply_filters( 'wc_tinkoff_order_fields_for_display_data', array(
				'status_message'	=> 'Статус заявки',
				'first_payment'		=> 'Первый платёж',
				'credit_amount'		=> 'Сумма кредита/займа',
				'credit_product'	=> 'Тип кредита',
				'credit_term'		=> 'Общий срок кредита (мес.)',
				'monthly_payment'	=> 'Ежемесячный платёж',
				'signing_type'		=> 'Тип подписания кредита'
			) );
		}
		
		private function get_order_fields_formated( $order ) {
			
			$fields = array();
			
			foreach( ( array ) $this->get_order_fields() as $key => $value ) {
				if( ! $result = $this->get_gateway( self::GATEWAY_ID )->get_order_meta( $order, $key ) ) {
					continue;
				}
				
				switch( $key ) {
					case 'first_payment' :
					case 'credit_amount' :
					case 'monthly_payment' :
						$result = wc_price( floatval( $result ) );
						break;
					case 'credit_product' :
						$result = $result === 'credit' ? 'Кредит' : 'Рассрочка';
						break;
					case 'signing_type' :
						$result = $result === 'sms' ? 'По СМС' : 'Личная встреча';
						break;
				}
				
				$fields[ $key ] = array(
					'label'	=> $value,
					'value'	=> $result
				);
			}
			
			return $fields;
		}
		
		public function order_table_receipt_data( $order ) {
			
			if ( self::GATEWAY_ID !== $order->get_payment_method() ) {
				return;
			}
			
			if ( ! $order || ! is_user_logged_in() ) {
				return;
			}
			
			$table_rows = '';
			
			foreach( ( array ) $this->get_order_fields_formated( $order ) as $key => $value ) {
				$table_rows .= sprintf( '<tr class="woocommerce-table__line-item order_item"><td class="woocommerce-table__%s">%s</td><td>%s</td></tr>', $key, $value['label'], $value['value'] );
			}
			
			if( ! empty( $table_rows ) ) {
				echo '<h2 class="woocommerce-order-details__title">Информация о кредите</h2>';
				echo '<table class="woocommerce-table shop_table credit_details">';
					echo '<tbody>';
					echo $table_rows;
					echo '</tbody>';
				echo '</table>';
			}
		}
		
		public function email_order_table_receipt_data( $order, $sent_to_admin, $plain_text = false ) {
			
			if ( self::GATEWAY_ID !== $order->get_payment_method() ) {
				return;
			}
			
			if ( ! $order || $sent_to_admin ) {
				return;
			}
			
			$data_line = '';
			
			foreach( ( array ) $this->get_order_fields_formated( $order ) as $value ) {
				if( ! $plain_text ) {
					$data_line .= sprintf( '<p>%s - %s</p>', $value['label'], $value['value'] );
				} else {
					$data_line .= sprintf( '%s: %s', $value['label'], $value['value'] ) . PHP_EOL;
				}
			}
			
			if( ! empty( $data_line ) ) {
				if( ! $plain_text ) {
					echo '<h2>Информация о кредите</h2>';
				} else {
					echo 'Информация о кредите' . PHP_EOL;
				}
				
				echo $data_line;
			}
		}
		
		public function get_plugin_name() {
			return 'Купи в кредит от Тинькофф';
		}
		
		public function get_download_id() {
			return 1849;
		}
		
		protected function get_file() {
			return WC_TINKOFF_KVK_GATEWAY_FILE;
		}
		
		public function get_sales_page_url() {
			return 'https://woodev.ru/downloads/tinkoff-kupi-v-kredit';
		}
			
		public function get_support_url() {
			$args = array(
				'wpf4766_3'	=> urlencode( 'Проблемы с плагином' ),
				'wpf4766_5'	=> $this->get_download_id(),
				'wpf4766_7'	=> site_url(),
				'utm_source' => str_replace( '.', '_', wp_parse_url( home_url(), PHP_URL_HOST ) ),
				'utm_medium' => 'organic'
			);
			return add_query_arg( $args, 'https://woodev.ru/support/' );
		}

		public function get_settings_link( $gateway_id = null ) {

			return sprintf( '<a href="%s">Настроить метод оплаты</a>', $this->get_settings_url( $gateway_id ) );
		}
		
		protected function install() {
			/*
			* Если при установки плагина опции уже существуют то запускаем обновление без передачи установленной версии (null)
			*/
			if ( $this->get_gateway_settings( self::GATEWAY_ID ) ) {
				$this->upgrade( null );
			}
		}
		
		protected function upgrade( $installed_version ) {
			if ( null === $installed_version ) {
				/*
				* Если при установки плагина не была передана версия ранее установленой версии то выполяем какие либо действия.
				* Например обновляем ранее установленные значения настроек.
				*/
				
				$settings = $this->get_gateway_settings( self::GATEWAY_ID );
				
			}
			
			if ( version_compare( $installed_version, '1.2.0', '<' ) ) {
				/*
				* Если версия плагина меньше чем 1.2.0 то то выполяем какие либо действия.
				*/
				
				$settings = $this->get_gateway_settings( self::GATEWAY_ID );
				
				//update_option( $this->get_gateway_settings_name( self::GATEWAY_ID ), $settings );
			}
		}
	}
	
	function wc_tinkoff_kredit() {
		return Woodev_TCB::instance();
	}
	
	wc_tinkoff_kredit();
}