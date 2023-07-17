<?php
global $product;
$product_id = $product->get_ID();
if( count(carbon_get_post_meta($product_id,'videos')) < 1) return;
?>
<section id="video">
  <h2>Видео от наших партнеров</h2>
  <div class="video-wrapper">
    <div class="video-list">
      <?php
      foreach(carbon_get_post_meta($product_id,'videos') as $video){
        ?>
        <div class="video-list-item" data-yt="<?= get_yt_code($video['video']); ?>" data-preview="<?= wp_get_attachment_url($video['video_preview']); ?>">
          <?= $video['video_title']; ?>
        </div>
        <?php
      }
      ?>
    </div>
    <div id="video-player" class="video-player" data-yt="<?= get_yt_code(carbon_get_post_meta($product_id,'videos')[0]['video']); ?>">
      <picture>

        <img src="<?= wp_get_attachment_url(carbon_get_post_meta($product_id,'videos')[0]['video_preview']); ?>" alt="">
      </picture>
    </div>
  </div>

</section>

