<?php


if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Woodev_Payment_Gateway_Helper' ) ) :

class Woodev_Payment_Gateway_Helper {
	
	public static function get_payment_gateway_configuration_url( $gateway_class_name ) {
		return admin_url( 'admin.php?page=wc-settings&tab=checkout&section=' . strtolower( $gateway_class_name ) );
	}
	
	public static function is_payment_gateway_configuration_page( $gateway_class_name ) {

		return 'wc-settings' == Woodev_Helper::get_request( 'page' ) &&
			'checkout' == Woodev_Helper::get_request( 'tab' ) &&
			strtolower( $gateway_class_name ) == Woodev_Helper::get_request( 'section' );
	}
	
	public static function luhn_check( $account_number ) {

		for ( $sum = 0, $i = 0, $ix = strlen( $account_number ); $i < $ix - 1; $i++) {

			$weight = substr( $account_number, $ix - ( $i + 2 ), 1 ) * ( 2 - ( $i % 2 ) );
			$sum += $weight < 10 ? $weight : $weight - 9;

		}

		return substr( $account_number, $ix - 1 ) == ( ( 10 - $sum % 10 ) % 10 );
	}
	
	public static function card_type_from_account_number( $account_number ) {

		$types = array(
			'visa'     => '/^4/',
			'mc'       => '/^5[1-5]/',
			'amex'     => '/^3[47]/',
			'discover' => '/^(6011|65|64[4-9]|622)/',
			'diners'   => '/^(36|38|30[0-5])/',
			'jcb'      => '/^35/',
			'maestro'  => '/^(5018|5020|5038|6304|6759|676[1-3])/',
			'laser'    => '/^(6706|6771|6709)/',
		);

		foreach ( $types as $type => $pattern ) {
			if ( 1 === preg_match( $pattern, $account_number ) ) {
				return $type;
			}
		}

		return null;
	}
	
	public static function payment_type_to_name( $payment_type ) {

		$name = '';
		$type = strtolower( $payment_type );
		
		switch ( $type ) {

			case 'mc':         $name = 'MasterCard';          break;
			case 'amex':       $name = 'American Express';    break;
			case 'disc':       $name = 'Discover';            break;
			case 'jcb':        $name = 'JCB';                 break;
			case 'cartebleue': $name = 'CarteBleue';          break;
			case 'paypal':     $name = 'PayPal';              break;
			case 'checking':   $name = 'Checking Account';    break;
			case 'savings':    $name = 'Savings Account';     break;
			case 'card':       $name = 'Credit / Debit Card'; break;
			case 'bank':       $name = 'Bank Account';        break;
			case '':           $name = 'Account';             break;
		}
		
		if ( ! $name ) {
			$name = ucwords( str_replace( '-', ' ', $type ) );
		}

		return apply_filters( 'wc_payment_gateway_payment_type_to_name', $name, $type );
	}
	
	public static function get_order_line_items( $order ) {

		$line_items = array();

		foreach ( $order->get_items() as $id => $item ) {

			$line_item = new stdClass();

			$product = $order->get_product_from_item( $item );

			$item_desc = array();
				
			if ( is_callable( array( $product, 'get_sku' ) ) && $product->get_sku() ) {
				$item_desc[] = sprintf( 'SKU: %s', $product->get_sku() );
			}
				
			$item_meta = new WC_Order_Item_Meta( $item );

			$item_meta = $item_meta->get_formatted();

			if ( ! empty( $item_meta ) ) {

				foreach ( $item_meta as $meta ) {
					$item_desc[] = sprintf( '%s: %s', $meta['label'], $meta['value'] );
				}
			}

			$item_desc = implode( ', ', $item_desc );

			$line_item->id          = $id;
			$line_item->name        = htmlentities( $item['name'], ENT_QUOTES, 'UTF-8', false );
			$line_item->description = htmlentities( $item_desc, ENT_QUOTES, 'UTF-8', false );
			$line_item->quantity    = $item['qty'];
			$line_item->item_total  = isset( $item['recurring_line_total'] ) ? $item['recurring_line_total'] : $order->get_item_total( $item );
			$line_item->line_total  = $order->get_line_total( $item );
			$line_item->meta        = $item_meta;
			$line_item->product     = is_object( $product ) ? $product : null;
			$line_item->item        = $item;

			$line_items[] = $line_item;
		}

		return $line_items;
	}
}

endif;