<?php
$post_id = $args['post_id'];
$image_src = !empty(get_the_post_thumbnail_url($post_id)) ? get_the_post_thumbnail_url($post_id,'woocommerce_single') : wp_get_attachment_image_url(171,'full');
$video_src = carbon_get_post_meta($post_id,'video_url');
$caption = get_post($post_id)->post_content !== "" ? '<h3>'. get_the_title($post_id).'</h3>'.get_post($post_id)->post_content : '';

$ext         = pathinfo($image_src, PATHINFO_EXTENSION);
$mime_type   = wp_get_image_mime($image_src);
if ($mime_type && ($mime_type === 'image/png' || $mime_type === 'image/jpeg')) {
  $webp_src = $image_src.'.webp';
}
?>
<div class="item-news carousel__slide f-carousel__slide">
  <a
    data-caption='<?= $caption; ?>'
    href='<?= $video_src; ?>'
    data-fancybox="video_gallery"
  >
    <picture>
      <?php if(!!$webp_src){ ?>
      <source srcset="<?= $webp_src; ?>" type="image/webp">
      <?php } ?>
      <source srcset="<?= $image_src; ?>">
      <img width="100%" height="100%" loading="lazy" data-lazy-src="<?= $image_src . '" alt="' . get_the_title($post_id); ?>" />
    </picture>
    <div class="icon">
      <?= file_get_contents(tailpress_asset('resources/svg/play.svg')); ?>
    </div>
  </a>
</div>