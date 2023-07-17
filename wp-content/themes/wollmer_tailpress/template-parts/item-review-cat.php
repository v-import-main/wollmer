<?php
$review_category = $args['review_category'];
$count = $args['count'];
$image_src = carbon_get_term_meta($review_category->term_id,'preview') !== '' ?
  wp_get_attachment_url(carbon_get_term_meta($review_category->term_id,'preview')) :
  '/wp-content/uploads/2022/06/frame-1236.png';

$ext         = pathinfo($image_src, PATHINFO_EXTENSION);
$mime_type   = wp_get_image_mime($image_src);
if ($mime_type && ($mime_type === 'image/png' || $mime_type === 'image/jpeg')) {
  $webp_src = $image_src.'.webp';
}
?>
<div class="item-reels-cat carousel__slide f-carousel__slide <?= $count !== 6 ?: 'six';?>" data-review-cat="<?= $review_category->term_id; ?>">
  <picture>
    <?php if(!!$webp_src){ ?>
      <source srcset="<?= $webp_src; ?>" type="image/webp">
    <?php } ?>
    <img width="64px" height="64px" src="<?= $image_src;?> " alt="<?= $review_category->name; ?>">
  </picture>
  <p><?= $review_category->name; ?></p>
</div>