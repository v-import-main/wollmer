<?php
// global $product;
$product = wc_get_product(get_the_ID());
$image_src = !empty($product->get_image_id()) ? wp_get_attachment_image_url($product->get_image_id(), 'medium') : wc_placeholder_img_src();
?>
<div id="oneclickmodal" class="login-modal hidden">
  <form class="transition opacity-100">
  <p class="headline">Заказ в 1 клик</p>
    <div class="modal-form-wrapper">
      <div class="modal-product-wrapper">
        <div class="product-thumbnail">
          <img src="<?= $image_src; ?>" alt="<?= $product->get_name(); ?>">
        </div>
        <p class="subheadline"><?= $product->get_name(); ?></p>
      </div>
      <div class="modal-form-wrapper">
        <input id="oneclick_product" name="oneclick_product" type="hidden" value="<?= $product->get_id(); ?>">
        <div class="form-row">
          <div class="input-wrap">
            <label for="oneclick_name">Ваше имя<span title="Обязательно">*</span></label>
            <div class="woocommerce-input-wrapper">
              <input name="oneclick_name" id="oneclick_name" type="text" placeholder="Ваше имя" required>
            </div>
          </div>
          <div class="input-wrap">
            <label for="oneclick_phone">Телефон<span title="Обязательно">*</span></label>
            <div class="woocommerce-input-wrapper">
              <input name="oneclick_phone" id="oneclick_phone" type="text" class="input_sms_login" placeholder="79001002030" required>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="btn-wrapper">
      <input type="submit" class="order-btn" value="Заказать">
    </div>
    <div class="control-wrapper">
      <input id="terms_chkbx" type="checkbox" checked="">
      <label for="terms_chkbx">Согласен с <a href="/privacy-policy/" target="_blank">политикой обработки персональных данных</a></label>
    </div>
  </form>
</div>

<script>
  document.querySelector('#oneclickmodal form').addEventListener('submit', function(e) {
    e.preventDefault();
    jQuery.ajax({
      url: '/wp-admin/admin-ajax.php',
      type: 'POST',
      data: {
        dataType: 'json',
        action: 'oneclickcorder',
        data: $('#oneclickmodal form').serializeArray()
      },
      success: function(data) {
        console.log(data);
        document.querySelector('#oneclickmodal form input[type="submit"]').disabled = true;
        setTimeout(() => {
          document.querySelector('#oneclickmodal form input[type="submit"]').disabled = false;
        }, 5000);
        $('#oneclickmodal form').html('<p class="montserrat text-xl">Спасибо!</p><p class="text-lg montserrat">Ваш заказ принят.</p>')
      },
      error: function(errorThrown) {
        console.log(errorThrown);
      }
    });
  })
</script>