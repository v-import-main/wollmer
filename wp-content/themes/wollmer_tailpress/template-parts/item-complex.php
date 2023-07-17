<?php
global $product;
$complex_product = wc_get_product($complect_id);
$var_name = ($complex_product->get_type() === 'woosb' || $complex_product->get_type() === 'bundle') ? get_post_meta( $complect_id, 'woosb_before_text', true ) : 'Basic';

$basic = explode(PHP_EOL,carbon_get_post_meta($complect_id,'checkboxes'));
$plus = carbon_get_post_meta($complect_id,'checkboxes_plus');
$minus = carbon_get_post_meta($complect_id,'checkboxes_minus');
?>
<div data-swiper-parallax-scale="1.1" class="swiper-slide item-complex order-<?= $complex_product->get_type() === 'woosb' ? 'last' : 'first'; ?>">
  <div class="complex-image">
    <img src="<?= wp_get_attachment_url(carbon_get_post_meta($complect_id, 'complex_image')); ?>" alt="">
  </div>
  <div class="complex-content">
    <div class="complex-head">
      <h3>Комплектация <?= $var_name; ?></h3>
      <div class="prices">

      <?php
      if ($complex_product->is_on_sale()) {
        $full_price = ($complex_product->get_type() === 'woosb' || $complex_product->get_type() === 'bundle') ? $complex_product->get_bundle_regular_price() : $complex_product->get_price();
        $sale_price = ($complex_product->get_type() === 'woosb' || $complex_product->get_type() === 'bundle') ? $complex_product->get_bundle_price() : $complex_product->get_sale_price();
      ?>
        <div class="prices">
          <div class="price price-new"><?= number_format($sale_price,0,'',' '); ?> ₽</div>
          <div class="price price-old"><?= number_format($full_price,0,'',' '); ?> ₽</div>
        </div>
      <?php } else { ?>
        <div class="price"><?= number_format($complex_product->get_regular_price(),0,'',' '); ?> ₽</div>
      <?php } ?>
      
      </div>
    </div>
    <div class="complex-body">
      <div class="complex-checkboxes">
        <ul>
        <?php foreach($basic as $point) { ?>
          <li><?= $point; ?></li>
        <?php } ?>
        </ul>
      </div>
      <?php if($plus !== ''){ ?>
      <div class="complex-checkboxes-diff style-custom">
        <ul>
          <?php foreach(explode(PHP_EOL,$plus) as $point) { ?>
            <li><?= $point; ?></li>
          <?php } ?>
        </ul>
      </div>
      <?php }
      if($minus !== ''){ ?>
      <div class="complex-checkboxes-diff style-base">
        <ul>
          <?php foreach(explode(PHP_EOL,$minus) as $point) { ?>
            <li><?= $point; ?></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
      <div class="btn-wrapper">
        <?php if ($complex_product->get_stock_status() === 'onbackorder') { ?>
          <button data-fancybox="backordermodal_3" data-src="#backordermodal" class="btn">Оформить предзаказ</button>
        <?php } else { ?>
          <div class="quantity hidden"></div>
          <a name="add-to-cart" data-id="<?= $complect_id; ?>" class="button" href="#addedmodal">Купить <?= $var_name; ?></a>
        <?php } ?>
      </div>

    </div>
  </div>
</div>