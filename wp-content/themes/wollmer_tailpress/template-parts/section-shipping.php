<div class="fields-group section-payments">
  <p class="fields-group-headline">Способ доставки</p>
  <div class="fields-wrapper">
    <?php
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
       
      <input value="<?= $key; ?>" <?= 'flat_rate:'.$key === $chosen_shipping_method ? 'checked' : '';?> type="radio" name="shipping_method_vis" id="vis_0_flat_rate<?= $key; ?>">
      <label for="vis_0_flat_rate<?= $key; ?>" class="woocommerce-input-wrapper <?= $gateway->chosen; ?>">
        <div><?= $method->get_title(); ?></div>
        <div class="smaller"><?= $method->get_instance_option( 'description' ); ?></div>
    </label>
    </div>
    <?php } ?>
  </div>
</div>