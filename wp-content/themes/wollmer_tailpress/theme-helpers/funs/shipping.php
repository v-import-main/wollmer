<?php
add_action( 'init', 'smdfw_init', 100 );
function smdfw_init() {
    $shipping_methods = WC()->shipping->get_shipping_methods();
    foreach ( $shipping_methods as $id => $shipping_method ) {
        add_filter( "woocommerce_shipping_instance_form_fields_$id", 'smdfw_add_form_fields' );
    }
}


function smdfw_add_form_fields( $fields ) {
    $new_fields = array(
        'description' => array(
            'title'   => __( 'Description', 'smdfw' ),
            'type'    => 'textarea',
            'default' => null,
        ),
    );
    $keys  = array_keys( $fields );
    $index = array_search( 'title', $keys, true );
    $pos   = false === $index ? count( $fields ) : $index + 1;
    return array_merge( array_slice( $fields, 0, $pos ), $new_fields, array_slice( $fields, $pos ) );
}

/**
 * Load description as metadata
 */
add_filter( 'woocommerce_shipping_method_add_rate_args', 'smdfw_add_rate_description_arg', 10, 2 );
function smdfw_add_rate_description_arg( $args, $method ) {
    $args['meta_data']['description'] = htmlentities( $method->get_option( 'description' ) );
    return $args;
}







// add_action( 'woocommerce_shipping_init', 'fake_cdek_add_shipping_method' );

// function fake_cdek_add_shipping_method() {
//   if ( ! class_exists( 'WC_Fake_CDEK' ) ) {

//     class WC_Fake_CDEK extends WC_Shipping_Method {
//       /**
//        * Конструктор класса
//        */
//       public function __construct() {
//         $this->id = 'fake_cdek';
//         $this->title = 'Fake CDEK';
//         $this->method_title = 'Fake CDEK';
//         $this->method_description = 'Какое-то описание способа доставки';
//         $this->supports = array(
//           'shipping-zones',
//           'instance-settings',
//           'instance-settings_modal',
//         );
//         $this->init();
//       }



//       /**
//        * Инициализируем настройки
//       */
//       function init() {
//         // API настроек
//         $this->form_fields = array(
//           'enabled' => array(
//             'title'       => 'Включен/Выключен',
//             'label'       => 'Включить Fake CDEK',
//             'type'        => 'checkbox',
//             'description' => '',
//             'default'     => 'no'
//           )
//         );
//         $this->init_settings(); // This is part of the settings API. Loads settings you previously init.

//         $this->enabled = $this->get_option( 'enabled' );



//         // Сохраняем настройки
//         add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
//       }
//       /**
//        * Расчёт стоимости доставки
//        */
//       public function calculate_shipping( $package = array() ) {

//         $this->add_rate(
//           array(
//             'label'    => 'Доставка до ПВЗ', // можем использовать $this->get_title()
//             'cost'     => '400', // стоимость в текущей валюте магазина
//             'calc_tax' => 'per_order' // может быть per_item и per_order
//           )
//         );

//       }
//     }
//   }
// }


// add_filter( 'woocommerce_shipping_methods', 'fake_cdek_add_shipping_class' );

// function fake_cdek_add_shipping_class( $methods ) {
//   $methods[ 'fake_cdek' ] = 'WC_Fake_CDEK';
// 	return $methods;
// }




// add_action( 'wp_ajax_update_shipping_price', 'update_shipping_price' );
// add_action( 'wp_ajax_nopriv_update_shipping_price', 'update_shipping_price' );
// function update_shipping_price() {
//   if ( ! defined( 'WOOCOMMERCE_CART' ) ) {
//     define( 'WOOCOMMERCE_CART', true );
//   }
//   WC()->session->set( 'shipping_for_package_0', array( 'total' => $_POST['shipping_option'] ) );

//   //rolled up
//   WC()->session->set( 'shipping_option', sanitize_text_field( $_POST['shipping_option'] ) );

//   // WC()->session->set( 'chosen_shipping_methods', array( 'fake_cdek' ) );
//   // WC()->session->set( 'chosen_shipping_methods', array( 'flat_rate:1' ) );

//   // WC()->checkout->set_chosen_shipping_methods( array( 'fake_cdek' ) );

//   WC()->cart->calculate_totals();
//   wp_send_json( array(
//     'result' => 'success',
//   ) );
// }

// //rolled up
// add_action( 'woocommerce_package_rates', 'update_shipping_price_based_on_option', 10, 2 );
// function update_shipping_price_based_on_option( $rates, $package ) {
//   $shipping_option = WC()->session->get( 'shipping_option' );
//   if ( ! $shipping_option ) {
//     return $rates;
//   }
//   $new_rates = array();
//   foreach ( $rates as $rate_key => $rate ) {
//     $new_rates[ $rate_key ] = $rate;
//     if (
//       // $rate->method_id == 'fake_cdek' || $rate->method_id == 'flat_rate:1' ||
//       // $rate_key == 'fake_cdek' || $rate_key == 'flat_rate:1'

//       //to roll up
//       $rate->method_id == 'flat_rate:2' ||
//       $rate_key == 'flat_rate:2'
//       ) {
//       $new_rates[ $rate_key ]->cost = $shipping_option;
//     }
//   }

//   return $new_rates;
// }



add_action( 'woocommerce_checkout_create_order', 'append_shipping_method_to_order_comment' );

function append_shipping_method_to_order_comment( $order ) {
    $chosen_shipping_method = $order->get_shipping_method();
    if ( $chosen_shipping_method ) {
        $order_comment = $order->get_customer_note();
        $order_comment .= "\n\nСпособ доставки: " . $chosen_shipping_method;
        $order->set_customer_note( $order_comment );
    }
}



add_action( 'woocommerce_after_checkout_billing_form', 'show_shipping_methods_form' );
function show_shipping_methods_form() {
    get_template_part('template-parts/section', 'shipping');
}