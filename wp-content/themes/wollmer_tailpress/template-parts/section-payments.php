<div class="fields-group section-payments">
  <p class="fields-group-headline">Способ оплаты</p>
  <div class="fields-wrapper js-update-payment">
    <?php
    $WC_Payment_Gateways = new WC_Payment_Gateways();
    $gateways = $WC_Payment_Gateways->get_available_payment_gateways();

    foreach($gateways as $key=>$gateway){ ?>

    <div class="form-row checkbox">
      <input value="<?= $key; ?>" <?= $key === 'cheque' ? 'checked' : '';?> type="radio" name="payment_method_vis" id="vis_<?= $key; ?>">
      <label for="vis_<?= $key; ?>" class="woocommerce-input-wrapper <?= $gateway->chosen; ?>">
        <div><?= $gateway->title;?></div>
        <div class="smaller"><?= $gateway->description; ?></div>
    </label>
    </div>

    <?php } ?>
  </div>
</div>