<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>

	<?php if ( WC()->cart->needs_payment() ) : ?>
			<?php

			if ( ! empty( $available_gateways ) ) {

				foreach ( $available_gateways as $key=>$gateway ) {?>

                    <div class="form-row checkbox">
                        <input value="<?= $key; ?>" <?= $gateway->chosen == 1 ? 'checked' : '';?> type="radio" name="payment_method_vis" id="vis_<?= $key; ?>">
                        <label for="vis_<?= $key; ?>" class="woocommerce-input-wrapper <?= $gateway->chosen; ?>">
                            <div><?= $gateway->title;?></div>
                            <div class="smaller"><?= $gateway->description; ?></div>
                        </label>
                    </div>

				<?php }

			} else {
				echo '<li>';
				wc_print_notice( apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ), 'notice' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
				echo '</li>';
			}
			?>
	<?php endif; ?>
<?php
if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
