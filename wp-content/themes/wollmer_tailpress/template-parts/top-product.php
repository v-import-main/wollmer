<?php
$gall = count($args['product']->get_gallery_image_ids()) > 1;
?>
<section id="top-product" class="product-default <?= $gall ? 'with-gall' : '';?>">
  <?php if($gall) { ?>
  <div class="top-image-wrapper carousel" id="productMainCarousel">
    <?php foreach($args['product']->get_gallery_image_ids() as $image_id) { ?>
      <div class="f-carousel__slide carousel__slide">
        <div class="picture">
          <img src="<?= wp_get_attachment_image_src($image_id,'full')[0]; ?>" alt="<?= $args['product']->get_title(); ?>">
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="top-image-gallery carousel" id="productThumbCarousel">
    <?php foreach($args['product']->get_gallery_image_ids() as $image_id) { ?>
      <div class="f-carousel__slide carousel__slide">
        <img src="<?= wp_get_attachment_image_src($image_id,'medium')[0]; ?>" alt="<?= $args['product']->get_title(); ?>">
      </div>
    <?php } ?>
  </div>
  <?php } else { ?>
    <div class="top-image-wrapper">
      <div>
      <img src="<?= wp_get_attachment_image_src($args['product']->get_gallery_image_ids()[0],'full')[0]; ?>" alt="<?= $args['product']->get_title(); ?>">
      </div>
    </div>
  <?php } ?>
</section>