<?php
// global $product;
$product = wc_get_product(get_the_id());
$image_src = !empty($product->get_image_id()) ? wp_get_attachment_image_url($product->get_image_id(), 'medium') : wc_placeholder_img_src();
?>
<div id="addedmodal" class="login-modal hidden">
  <form class="transition opacity-100">

    <?php
      // global $woocommerce;
      // foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
      //   echo $cart_item_key;
      //   echo $cart_item['product_id'];
      // }
    ?>

    <div class="mb-5">
      <p class="headline">Товар добавлен в корзину</p>
    </div>
    <div class="modal-product-wrapper">
      <div class="flex">
        <div class="product-thumbnail">
          <img src="<?= $image_src; ?>" alt="<?= $product->get_name(); ?>">
        </div>
        <p class="subheadline"><?= $product->get_name(); ?> <span></span></p>
      </div>
      <td class="product-quantity hidden" data-title="Количество">
        <div class="quantity" style="display:none!important">
          <button type="button" onclick="modal_minus()" class="minus modal_minus">
            <svg width="47" height="38" viewBox="0 0 47 38" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.9144 18.8118H30.0863C30.1829 18.8118 30.2312 18.8601 30.2312 18.9567V20.0434C30.2312 20.14 30.1829 20.1883 30.0863 20.1883H17.9144C17.8178 20.1883 17.7695 20.14 17.7695 20.0434V18.9567C17.7695 18.8601 17.8178 18.8118 17.9144 18.8118Z"></path>
            </svg>
          </button>
          <input type="number" class="input-text qty text" step="1" min="0" max="<?= $product->get_stock_quantity(); ?>" value="1" title="Кол-во" size="4" placeholder="" inputmode="numeric" autocomplete="off">
          <button type="button" onclick="modal_plus()" class="plus modal_plus">
            <svg width="47" height="38" viewBox="0 0 47 38" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M23.4574 12.9794H24.5442C24.6408 12.9794 24.6891 13.0277 24.6891 13.1243V25.8757C24.6891 25.9723 24.6408 26.0206 24.5442 26.0206H23.4574C23.3608 26.0206 23.3125 25.9723 23.3125 25.8757V13.1243C23.3125 13.0277 23.3608 12.9794 23.4574 12.9794Z"></path>
              <path d="M17.9144 18.8117H30.0863C30.1829 18.8117 30.2312 18.86 30.2312 18.9566V20.0434C30.2312 20.14 30.1829 20.1883 30.0863 20.1883H17.9144C17.8178 20.1883 17.7695 20.14 17.7695 20.0434V18.9566C17.7695 18.86 17.8178 18.8117 17.9144 18.8117Z"></path>
            </svg>
          </button>
        </div>
      </td>
    </div>
    <div class="modal-price-wrapper">
      <?php
      $_product = $product;
      // if ($product->is_type('variable')) {
      //   $_product = wc_get_product($product->get_children()[0]);
      // };

      
      if($_product->get_type() === 'woosb' || $_product->get_type() === 'bundle'){
        $sale_price = $_product->get_bundle_price();
        $reg_price = $_product->get_bundle_regular_price();
      } else {
        $sale_price = $_product->get_sale_price();
        $reg_price = $_product->get_regular_price();
      }

      if ($_product->is_on_sale()) { ?>
        <div class="sale-price-wrapper">
          <div class="prefix-price">Цена:</div>
          <div class="sale-price"><?= $sale_price; ?> ₽</div>
          <div class="orig-price"><?= $reg_price; ?> ₽</div>
        </div>
      <?php } else { ?>
        <div class="prefix-price">Цена:</div>
        <div class="regular-price"><?= $reg_price; ?> ₽</div>
      <?php } ?>
    </div>

    <div class="modal-form-wrapper">
      <div class="btn-wrapper">
        <!-- <button class="modal_submit order-btn" onclick="modal_submit()">Оформить заказ</button> -->
        <a class="modal_submit order-btn" href="/cart/">Оформить заказ</a>
        <button type="button" class="order-btn scnd-btn is-close" data-fancybox-close>Продолжить покупки</button>
      </div>
    </div>
  </form>
</div>