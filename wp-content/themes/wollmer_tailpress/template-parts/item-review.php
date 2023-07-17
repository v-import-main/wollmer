<?php
  $post_id = $args['post_id'];

  $image_src = wp_get_attachment_image_src(carbon_get_post_meta($post_id, 'image'),'medium_large')[0];
  $image_src_thumb = wp_get_attachment_image_src(carbon_get_post_meta($post_id, 'image'),'woocommerce_thumbnail')[0];
  // $video_src = carbon_get_post_meta($post_id, 'video_src');
  $video_url = carbon_get_post_meta($post_id, 'video_url');
  // $caption = get_post($post_id)->post_content !== "" ? '<h3>'. get_the_title($post_id).'</h3>'.get_post($post_id)->post_content : '';
  $href = $image_src;
  $ext         = pathinfo($image_src, PATHINFO_EXTENSION);
  $mime_type   = wp_get_image_mime($image_src);
  $webp_src = $image_src;
  if ($mime_type && ($mime_type === 'image/png' || $mime_type === 'image/jpeg')) {
    // $webp_src = $image_src.'.webp';
    $webp_src = $image_src_thumb.'.webp';
  }
  if($video_url) {
    $href = $video_url;
  }
  // if($video_src) {
  //   $href = wp_get_attachment_url($video_src);
  // }
  $title = carbon_get_post_meta($post_id,'title');
  $subtitle = carbon_get_post_meta($post_id,'subtitle');
  $text = carbon_get_post_meta($post_id,'text');
?>
<div class="item-reels carousel__slide f-carousel__slide">
  <a
    data-caption='<?= $caption; ?>'
    href='<?= $href; ?>'
    data-fancybox="reviews_gallery">
    <picture>
      <?php if(!!$webp_src){ ?>
        <source srcset="<?= $webp_src; ?>" type="image/webp" >
      <?php } ?>
      <source srcset="<?= $image_src; ?>" type="image/<?= $ext; ?>">
      <img loading="lazy" data-lazy-src="<?= $image_src; ?>" alt="<?= get_the_title($post_id); ?>">
    </picture>
    <div class="caption">
      <?php if($title){ ?>
        <p class="title"><?= $title; ?></p>
      <?php }
      if($text){ ?>
      <p class="text"><?= $text; ?></p>
      <?php }
      if($subtitle){ ?>
      <p class="subtitle"><?= $subtitle; ?></p>
      <?php } ?>
    </div>
  </a>
</div>