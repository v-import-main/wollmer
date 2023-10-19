<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.3.0
 */

defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';
?>
<? /*
<tr class="woocommerce-shipping-totals shipping">

	<th><?php echo wp_kses_post( $package_name ); ?></th>

	<td data-title="<?php echo esc_attr( $package_name ); ?>">
  */ ?>
		<?php if ( $available_methods ) : ?>

				<?php foreach ( $available_methods as $key => $method ) : ?>
                <?
                $chosen_shipping_method = WC()->session->get( 'chosen_shipping_methods' )[0]
                ?>
                <?if ($chosen_shipping_method == $key) {?>
                <?= $method->label; ?>: <?= $method->cost; ?>  ₽
                <? } ?>
				<?php endforeach; ?>

			<?php if ( is_cart() ) : ?>
				<p class="woocommerce-shipping-destination">
					<?php
					if ( $formatted_destination ) {
						// Translators: $s shipping destination.
						printf( esc_html__( 'Shipping to %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' );
						$calculator_text = esc_html__( 'Change address', 'woocommerce' );
					} else {
						echo wp_kses_post( apply_filters( 'woocommerce_shipping_estimate_html', __( 'Shipping options will be updated during checkout.', 'woocommerce' ) ) );
					}
					?>
				</p>
			<?php endif; ?>
			<?php
		elseif ( ! $has_calculated_shipping || ! $formatted_destination ) :
			if ( is_cart() && 'no' === get_option( 'woocommerce_enable_shipping_calc' ) ) {
				echo wp_kses_post( apply_filters( 'woocommerce_shipping_not_enabled_on_cart_html', __( 'Shipping costs are calculated during checkout.', 'woocommerce' ) ) );
			} else {
				echo wp_kses_post( apply_filters( 'woocommerce_shipping_may_be_available_html', __( 'Enter your address to view shipping options.', 'woocommerce' ) ) );
			}
		elseif ( ! is_cart() ) :
			echo wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) );
		else :
			echo wp_kses_post(
				/**
				 * Provides a means of overriding the default 'no shipping available' HTML string.
				 *
				 * @since 3.0.0
				 *
				 * @param string $html                  HTML message.
				 * @param string $formatted_destination The formatted shipping destination.
				 */
				apply_filters(
					'woocommerce_cart_no_shipping_available_html',
					// Translators: $s shipping destination.
					sprintf( esc_html__( 'No shipping options were found for %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ),
					$formatted_destination
				)
			);
			$calculator_text = esc_html__( 'Enter a different address', 'woocommerce' );
		endif;
		?>

		<?php if ( $show_package_details ) : ?>
			<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
		<?php endif; ?>

		<?php if ( $show_shipping_calculator ) : ?>
			<?php woocommerce_shipping_calculator( $calculator_text ); ?>
		<?php endif; ?>
<? /*
	</td>
</tr>
 */ ?>
