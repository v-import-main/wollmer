<div class="fields-group">
    <p class="fields-group-headline">Регион доставки</p>
	<!-- <p style="font-size:11px;">Выберите регион, чтобы увидеть доступные способы доставки</p> -->
    <div class="woocommerce-billing-fields__field-wrapper">
        <?php
        global $fields;
        global $checkoutOut;
        foreach ( $fields as $key => $field ) {
            if ($key == "billing_state") {
                woocommerce_form_field($key, $field, $checkoutOut->get_value($key));

            }
        }
        ?>
    </div>
</div>

<div class="fields-group section-payments">
  <p class="fields-group-headline">Способ доставки</p>

  <div class="fields-wrapper js-update-shipment">
    <?php /*
    $WC_Shipping_Zones = new WC_Shipping_Zones();
    $shipping_zones = $WC_Shipping_Zones->get_zones();
    $shipping_methods = array();
    foreach($shipping_zones as $shipping_zone){
        $shipping_methods = $shipping_zone['shipping_methods'];
    }
    $chosen_shipping_method = WC()->session->get( 'chosen_shipping_methods' )[0];
    foreach ( $shipping_methods as $key=>$method ) {
        if (!$method->is_enabled()) continue;
    ?>

    <div class="form-row checkbox_ship">

      <input class="radio_option" value="<?= $key; ?>" <?= 'flat_rate:'.$key === $chosen_shipping_method ? 'checked' : '';?> type="radio" name="shipping_method_vis" id="vis_0_flat_rate<?= $key; ?>">
      <label for="vis_0_flat_rate<?= $key; ?>" class="woocommerce-input-wrapper <?= $gateway->chosen; ?>">
        <div><?= $method->get_title(); ?></div>
        <div class="smaller"><?= $method->get_instance_option( 'description' ); ?></div>
    </label>
    </div>
    <?php } */?>
  <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

      <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

      <?php wc_cart_totals_shipping_html(); ?>

      <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

  <?php endif; ?>

  </div>
</div>

