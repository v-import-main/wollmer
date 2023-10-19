<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Order_Compatibility' ) ) :

class Woodev_Order_Compatibility extends Woodev_Data_Compatibility {

	public static function get_date_created( WC_Order $order, $context = 'edit' ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order::get_date_created()' );

		return self::get_date_prop( $order, 'created', $context );
	}
	
	public static function get_date_modified( WC_Order $order, $context = 'edit' ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order::get_date_modified()' );

		return self::get_date_prop( $order, 'modified', $context );
	}
	
	public static function get_date_paid( WC_Order $order, $context = 'edit' ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order::get_date_paid()' );

		return self::get_date_prop( $order, 'paid', $context );
	}
	
	public static function get_date_completed( WC_Order $order, $context = 'edit' ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order::get_date_completed()' );

		return self::get_date_prop( $order, 'completed', $context );
	}
	
	public static function get_date_prop( WC_Order $order, $type, $context = 'edit' ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order' );

		$prop = "date_{$type}";
		$date = is_callable( array( $order, "get_{$prop}" ) ) ? $order->{"get_{$prop}"}( $context ) : null;

		return $date;
	}
	
	public static function get_prop( $object, $prop, $context = 'edit', $compat_props = array() ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order::get_prop()' );

		return parent::get_prop( $object, $prop, $context, self::$compat_props );
	}
	
	public static function set_props( $object, $props, $compat_props = array() ) {

		return parent::set_props( $object, $props, self::$compat_props );
	}
	
	public static function add_coupon( WC_Order $order, $code = array(), $discount = 0, $discount_tax = 0 ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order::add_item()' );

		$item = new WC_Order_Item_Coupon();

		$item->set_props( array(
			'code'         => $code,
			'discount'     => $discount,
			'discount_tax' => $discount_tax,
			'order_id'     => $order->get_id()
		) );

		$item->save();

		$order->add_item( $item );

		return $item->get_id();
	}
	
	public static function add_fee( WC_Order $order, $fee ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order::add_item()' );

		$item = new WC_Order_Item_Fee();

		$item->set_props( array(
			'name'      => $fee->name,
			'tax_class' => $fee->taxable ? $fee->tax_class : 0,
			'total'     => $fee->amount,
			'total_tax' => $fee->tax,
			'taxes'     => array(
				'total' => $fee->tax_data
			),
			'order_id'  => $order->get_id()
		) );

		$item->save();

		$order->add_item( $item );

		return $item->get_id();
	}
	
	public static function add_shipping( WC_Order $order, $shipping_rate ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order::add_item()' );

		$item = new WC_Order_Item_Shipping();

		$item->set_props( array(
			'method_title' => $shipping_rate->label,
			'method_id'    => $shipping_rate->id,
			'total'        => wc_format_decimal( $shipping_rate->cost ),
			'taxes'        => $shipping_rate->taxes,
			'order_id'     => $order->get_id()
		) );

		foreach ( $shipping_rate->get_meta_data() as $key => $value ) {
			$item->add_meta_data( $key, $value, true );
			$item->save_meta_data();
		}

		$item->save();

		$order->add_item( $item );

		return $item->get_id();
	}
	
	public static function add_tax( WC_Order $order, $tax_rate_id, $tax_amount = 0, $shipping_tax_amount = 0 ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order::add_item()' );

		$item = new WC_Order_Item_Tax();

		$item->set_props( array(
			'rate_id'            => $tax_rate_id,
			'tax_total'          => $tax_amount,
			'shipping_tax_total' => $shipping_tax_amount
		) );

		$item->set_rate( $tax_rate_id );
		$item->set_order_id( $order->get_id() );
		$item->save();

		$order->add_item( $item );

		return $item->get_id();
	}
	
	public static function update_coupon( WC_Order $order, $item, $args ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order_Item_Coupon' );

		if ( is_numeric( $item ) ) {
			$item = $order->get_item( $item );
		}

		if ( ! is_object( $item ) || ! $item->is_type( 'coupon' ) ) {
			return false;
		}

		if ( ! $order->get_id() ) {
			$order->save();
		}

		$item->set_order_id( $order->get_id() );
		$item->set_props( $args );
		$item->save();

		return $item->get_id();
	}
	
	public static function update_fee( WC_Order $order, $item, $args ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order_Item_Fee' );

		if ( is_numeric( $item ) ) {
			$item = $order->get_item( $item );
		}

		if ( ! is_object( $item ) || ! $item->is_type( 'fee' ) ) {
			return false;
		}

		if ( ! $order->get_id() ) {
			$order->save();
		}

		$item->set_order_id( $order->get_id() );
		$item->set_props( $args );
		$item->save();

		return $item->get_id();
	}
	
	public static function reduce_stock_levels( WC_Order $order ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_reduce_stock_levels()' );

		wc_reduce_stock_levels( $order->get_id() );
	}
	
	public static function update_total_sales_counts( WC_Order $order ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_update_total_sales_counts()' );

		wc_update_total_sales_counts( $order->get_id() );
	}
	
	public static function has_shipping_address( WC_Order $order ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Order::has_shipping_address()' );

		return $order->has_shipping_address();
	}
	
	public static function get_item_formatted_meta_data( $item, $hide_prefix = '_', $include_all = false ) {

		if ( $item instanceof WC_Order_Item && Woodev_Plugin_Compatibility::is_wc_version_gte( '3.1' ) ) {

			$meta_data = $item->get_formatted_meta_data( $hide_prefix, $include_all );
			$item_meta = array();

			foreach ( $meta_data as $meta ) {

				$item_meta[] = array(
					'label' => $meta->display_key,
					'value' => $meta->value,
				);
			}

		} else {

			$item_meta = new WC_Order_Item_Meta( $item );
			$item_meta = $item_meta->get_formatted( $hide_prefix );
		}

		return $item_meta;
	}
	
	public static function get_edit_order_url( WC_Order $order ) {

		if ( Woodev_Plugin_Compatibility::is_wc_version_gte( '3.3' ) ) {
			$order_url = $order->get_edit_order_url();
		} else {
			$order_url = apply_filters( 'woocommerce_get_edit_order_url', get_admin_url( null, 'post.php?post=' . self::get_prop( $order, 'id' ) . '&action=edit' ), $order );
		}

		return $order_url;
	}

}

endif;
