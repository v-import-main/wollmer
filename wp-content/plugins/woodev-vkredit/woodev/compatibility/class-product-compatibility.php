<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Product_Compatibility' ) ) :

class Woodev_Product_Compatibility extends Woodev_Data_Compatibility {
	
	public static function get_prop( $object, $prop, $context = 'edit', $compat_props = array() ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Product::get_prop()' );

		return parent::get_prop( $object, $prop, $context, self::$compat_props );
	}
	
	public static function set_props( $object, $props, $compat_props = array() ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Product::set_props()' );

		return parent::set_props( $object, $props, self::$compat_props );
	}
	
	public static function get_parent( WC_Product $product ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_get_product( WC_Product::get_parent_id() )' );

		return wc_get_product( $product->get_parent_id() );
	}
	
	public static function wc_update_product_stock( WC_Product $product, $amount = null, $mode = 'set' ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_update_product_stock()' );

		return wc_update_product_stock( $product, $amount, $mode );
	}
	
	public static function wc_get_price_html_from_text( WC_Product $product ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_get_price_html_from_text()' );

		return wc_get_price_html_from_text();
	}
	
	public static function wc_get_price_including_tax( WC_Product $product, $qty = 1, $price = '' ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_get_price_including_tax()' );

		return wc_get_price_including_tax( $product, array(
			'qty'   => $qty,
			'price' => $price
		) );
	}
	
	public static function wc_get_price_excluding_tax( WC_Product $product, $qty = 1, $price = '' ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_get_price_excluding_tax()' );

		return wc_get_price_excluding_tax( $product, array(
			'qty'   => $qty,
			'price' => $price
		) );
	}
	
	public static function wc_get_price_to_display( WC_Product $product, $price = '', $qty = 1 ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_get_price_to_display()' );

		return wc_get_price_to_display( $product, array(
			'qty'   => $qty,
			'price' => $price
		) );
	}
	
	public static function wc_get_product_category_list( WC_Product $product, $sep = ', ', $before = '', $after = '' ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_get_product_category_list()' );

		$id = $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id();

		return wc_get_product_category_list( $id, $sep, $before, $after );
	}
	
	public static function wc_get_rating_html( WC_Product $product, $rating = null ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_get_rating_html()' );

		return wc_get_rating_html( $rating );
	}

}

endif;
