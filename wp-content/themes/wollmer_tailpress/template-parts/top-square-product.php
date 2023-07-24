<style>
    .single.single-product .site-content .product {
        flex-direction: row!important;
        flex-wrap: wrap;
    }
</style>
<?php
$gall = count($args['product']->get_gallery_image_ids()) > 1;
?>
<section id="top-product" class="product-square<?= $gall ? ' with-gall' : '';?>">
  <?php if($gall) { ?>
  <div class="top-image-wrapper carousel" id="productMainCarousel">
    <?php foreach($args['product']->get_gallery_image_ids() as $image_id) { ?>
      <div class="f-carousel__slide carousel__slide" data-thumb-src="<?= wp_get_attachment_image_src($image_id,'full')[0]; ?>">
        <div class="picture">
          <img src="<?= wp_get_attachment_image_src($image_id,'full')[0]; ?>" alt="<?= $args['product']->get_title(); ?>">
        </div>
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

