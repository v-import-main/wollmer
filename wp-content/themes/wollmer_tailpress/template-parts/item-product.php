<?php

if( (is_archive() && !is_shop()) || is_search()){
  global $product;
} else {
  $product = $args['product'];
  $slider = isset($args['slider']) ? $args['slider'] : '';
}

if(is_archive() && $product->get_type() != 'simple') return;

$image_src       = is_object($product) && !empty($product->get_image_id()) ? wp_get_attachment_image_url($product->get_image_id(), 'medium') : wc_placeholder_img_src();
$image_src_mob   = is_object($product) && !empty($product->get_image_id()) ? wp_get_attachment_image_url($product->get_image_id(), 'woocommerce_gallery_thumbnail') : wc_placeholder_img_src();
$ext             = pathinfo($image_src, PATHINFO_EXTENSION);
$mime_type       = wp_get_image_mime($image_src);
$classlist       = 'item-product';

if(!is_search() && !is_archive() && !is_shop() && $slider !== false){
  $classlist .= ' carousel__slide f-carousel__slide';
}
if(is_search()){
  if($product->get_type() === 'bundle' || $product->get_price()<0) {
    $style = 'style="order:'.round($product->get_price()).'"';
  }
}
?>
<a class="<?= $classlist; ?>" <?= $style ;?> href="<?= get_permalink($product->get_id()); ?>">
  <div class="image-wrap">
    <picture>
      <?php
        if ( is_front_page() && $mime_type && ($mime_type === 'image/png' || $mime_type === 'image/jpeg')) {
          $webp_src = $image_src.'.webp';
          $webp_src_mob = $image_src_mob.'.webp';
        } else {
          $webp_src = $image_src;
          $webp_src_mob = $image_src_mob;
        }
      ?>
      <?php if($webp_src !== $image_src){ ?>
      <source srcset="<?= $webp_src; ?>" type="image/webp" >
      <?php } ?>
      <source srcset="<?= $image_src; ?>" type="image/<?= $ext; ?>">
      <img class="mb-2" loading="lazy" data-lazy-src="<?= $webp_src_mob; ?>" alt="<?= $product->get_name(); ?>">
    </picture>

    <button class="btn">Подробнее</button>
  </div>
  <?php
  $_product = get_product($product->get_id());
  $base_price = $product->get_regular_price();
  if( $_product->is_type( 'bundle' ) || $_product->is_type( 'woosb' ) ){
    $sale_price = $_product->get_bundle_price();
  } else {
    $sale_price = $product->get_sale_price();
  };
  
  if ($product->is_on_sale()) { ?>
    <div class="sale-price-wrapper">
      <div class="sale-price"><?= $sale_price; ?> ₽</div>
      <div class="orig-price"><?= $base_price; ?> ₽</div>
    </div>
  <?php } else { ?>
    <div class="regular-price"><?= $base_price; ?> ₽</div>
  <?php } ?>
  <p class="product-name"><?= $product->get_name(); ?></p>
</a>