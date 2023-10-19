<?php
// global $product;
$product = wc_get_product(get_the_ID());
$price = ($product->get_type() === 'woosb' || $product->get_type() === 'bundle') ? $product->get_bundle_price() : $product->get_price();
?>
<div id="product-bar" <?= carbon_get_post_meta($product->get_id(),'square') ? '' : 'class="product-square"'; ?>>
  <div class="container product_bar_container 2222">
    <p class="name"><?= $product->get_name(); ?></p>
    <p class="price"><?= $price; ?> ₽ </p>
    <?php if ($product->get_stock_status() === 'onbackorder') { ?>
      <!-- <a href="#top-product" class="btn">Оформить предзаказ</a> -->
      <button data-fancybox="backordermodal_bar" data-src="#backordermodal" class="btn">Оформить предзаказ</button>
      <?php } else if ($product->get_stock_status() === 'outofstock') { ?>
        <style>
            #product-bar {
                display: none !important;
            }
        </style>
      <?php } else { ?>
        <!-- <a class="btn hidden md:block" href="#top-product">В корзину</a>
        <a class="btn block md:hidden" href="#top-product">Добавить в корзину</a> -->
        <button type="submit" name="add-to-cart" value="<?= get_the_ID(); ?>" class="btn single_add_to_cart_button 1111">Добавить в корзину</button>
    <?php } ?>
  </div>
</div>