<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

    <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

    <?php wc_cart_totals_shipping_html(); ?>

    <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

<?php endif; ?>

