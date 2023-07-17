<?php
$post = $args['post'];
$image_src = !empty(get_the_post_thumbnail_url($post->ID)) ? get_the_post_thumbnail_url($post->ID) : wp_get_attachment_image_url(171,'full');
$video_src = carbon_get_post_meta($post->ID,'video_url');
?>
<div class="item-video">
  <a href="<?= $video_src; ?>"
  data-fancybox="video_gallery"
  data-caption='<?php if(get_the_content($post->ID)!== ""){ ?><h3><?= get_the_title($post->ID); ?></h3><?= get_the_content($post->ID); }?>'
    <picture>
      <img src="<?= $image_src . '" alt="' . get_the_title(); ?>" />
    </picture>
  </a>
  <div class="icon">
    <?= file_get_contents(tailpress_asset('resources/svg/play.svg')); ?>
  </div>
</div>