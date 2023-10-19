<?php
// global $product;
$product = wc_get_product(get_the_ID());
$image_src = !empty($product->get_image_id()) ? wp_get_attachment_image_url($product->get_image_id(), 'medium') : wc_placeholder_img_src();
?>
<div id="backordermodal" class="login-modal" style="display:none" >
  <form class="transition opacity-100">
    <p class="headline">Предзаказ</p>
    <div class="modal-product-wrapper">
      <div class="product-thumbnail">
        <img src="<?= $image_src; ?>" alt="<?= $product->get_name(); ?>">
      </div>
      <p class="subheadline"><?= $product->get_name(); ?></p>
    </div>
    <div class="modal-price-wrapper">
      <?php
      if ($product->is_on_sale()) {
        $full_price = ($product->get_type() === 'woosb' || $product->get_type() === 'bundle') ? $product->get_bundle_regular_price() : $product->get_price();
        $sale_price = ($product->get_type() === 'woosb' || $product->get_type() === 'bundle') ? $product->get_bundle_price() : $product->get_sale_price();
      ?>
        <div class="sale-price-wrapper">
          <div class="prefix-price">Цена:</div>
          <div class="sale-price"><?= $sale_price; ?> ₽</div>
          <div class="orig-price"><?= $full_price; ?> ₽</div>
        </div>
      <?php } else { ?>
        <div class="prefix-price">Цена:</div>
        <div class="regular-price"><?= $product->get_regular_price(); ?> ₽</div>
      <?php } ?>
    </div>

    <div class="modal-form-wrapper">
      <input id="backorder_product" name="backorder_product" type="hidden" value="<?= $product->get_id(); ?>">
      <input id="backorder_price" name="backorder_price" type="hidden" value="<?= $sale_price; ?>">
      <input id="backorder_url" name="backorder_url" type="hidden" value="<?= $_SERVER['REQUEST_URI']; ?>">
      <div class="form-row">
        <div class="input-wrap">
          <label for="backorder_name">Имя и фамилия<span title="Обязательно">*</span></label>
          <div class="woocommerce-input-wrapper" id="input-wrapper-name">
            <input type="text" name="backorder_name" id="backorder_name" class="1112" min="1" required placeholder="Владимир Иванов">
          </div>
        </div>
        <div class="input-wrap">
          <label for="backorder_phone">Мобильный телефон<span title="Обязательно">*</span></label>
          <div class="woocommerce-input-wrapper" id="input-wrapper-phone">
            <input type="text" name="backorder_phone" id="backorder_phone" required placeholder="+7 (921) 123-45-67">
          </div>
        </div>
      </div>
      <div class="btn-wrapper">
        <input type="submit" value="Оформить предзаказ" class="order-btn">
      </div>
      <div class="control-wrapper">
        <input id="terms_chkbx" type="checkbox" checked="">
        <label for="terms_chkbx">Согласен с <a href="/privacy-policy/" target="_blank">политикой обработки персональных данных</a></label>
      </div>
    </div>
  </form>
</div>

<script>
  document.querySelector('#backordermodal form').addEventListener('submit', function(e) {
    e.preventDefault();
    document.querySelector('#backordermodal form input[type="submit"]').disabled = true;
        setTimeout(() => {
          document.querySelector('#backordermodal form input[type="submit"]').disabled = false;
        }, 5000);   
    jQuery.ajax({
      url: '/wp-admin/admin-ajax.php',
      type: 'POST',
      data: {
        dataType: 'json',
        action: 'backorder',
        data: $('#backordermodal form').serializeArray()
      },
      success: function() {     
        $('#backordermodal form').html('<p class="montserrat text-xl">Спасибо!</p><p class="text-lg montserrat">Ваш заказ принят.</p>')
      },
      error: function(errorThrown) {
        console.log(errorThrown);
      }
    });
  })

</script>

<script>

    function initSuggestions() {
        $(document).ready(function() {
            var token = '65d58e1f71cb0d914d348a1e59a2ae774c380e44'

            $("#backorder_name").suggestions({
                token: token,
                type: "NAME",
                params: {
                    parts: ["NAME", "SURNAME"]
                },
            });
        });
    }


    jQuery('#backorder_phone').on('keypress',function(e){
        setTimeout(() => {
            console.log('phone:',e.currentTarget.value);
            if(e.currentTarget.value[4] !== '9'){
                e.currentTarget.value = '+7 ('
            }
        }, 100);
    })

    initSuggestions("#backorder_name");

    $('input:text').change(function() {
        if ($(this).is(":invalid")) {
            $(this).closest('.woocommerce-input-wrapper').addClass("error");
        } else {
            $(this).closest('.woocommerce-input-wrapper').removeClass("error");
        }
    });
</script>

<style>
    .login-modal .modal-form-wrapper .form-row .woocommerce-input-wrapper {
        position: relative;
    }
    .login-modal .modal-form-wrapper .form-row .woocommerce-input-wrapper:focus-within {
        border-color: #facc15;
    }
    .login-modal .modal-form-wrapper .form-row .woocommerce-input-wrapper.error {
        border-color: red;
    }

    .woocommerce-input-wrapper.error::before {
        content: '';
        position: absolute;
        /* background: #facc15; */
        background: red;
        color: #fff;
        border-radius: 0.5rem;
        /* border-radius: 0 0 0.5rem 0.5rem; */
        padding: 0.2rem 0.4rem;
        top: 62px;
        /* bottom: -34px;*/
        left: 4px;
        font-size: 12px;
        max-width: calc(100% - 8px);
        width: fit-content;
        left: 0;
        right: 0;
        margin: auto;
        text-align: center;
    }

    .woocommerce-input-wrapper.error::after {
        content:" ";
        position: absolute; bottom: -10px; left: 50%;
        margin-left: -5px;
        width: 0;
        border-bottom: 5px solid red;
        border-right: 5px solid transparent;
        border-left: 5px solid transparent;
        font-size: 0;
        line-height: 0;
    }
    #input-wrapper-name.error::before {
        content: 'Введите имя и фамилию';
    }
    #input-wrapper-phone.error::before  {
        content: 'Введите номер мобильного телефона';
    }
</style>