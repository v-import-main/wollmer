<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC_Gateway_Tinkoff_KVK_Product {
	
	public function __construct() {
		add_action( 'woocommerce_single_product_summary', array( $this, 'add_inform_text' ), 25 );
		//add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'add_button' ) );
	}
	
	public function add_inform_text() {
		
		global $product;
		
		$payment_method = new WC_Gateway_Tinkoff_KVK();
		$content = $payment_method->get_option( 'single_page_informer' );
		
		if( ! empty( $content ) ) {
			
			$loans_rate = apply_filters( 'wc_geteway_tinkoff_kvk_loans_rate', 19 );
			$content = str_replace( '%payment_amount%', floor( $product->get_price() / intval( $loans_rate ) ), $content );
		
			printf( '<div class="wc-geteway-tinkoff-kvk-product-info woocommerce-info">%s</div>', apply_filters( 'wc_geteway_tinkoff_kvk_product_info', $content, $product ) );
		}
	}
	
	public function add_button() {
		global $product;
		
		$product_price = $product->get_price();
		
		if( $product_price >= 3000 ) {
			printf( '<button type="submit" class="button" value="%s">В кредит от %s в месяц</button>', esc_attr( $product->get_id() ), wc_price( ( $product_price / 19 ), array( 'currency' => get_woocommerce_currency() ) ) );
		}
		
	}
}