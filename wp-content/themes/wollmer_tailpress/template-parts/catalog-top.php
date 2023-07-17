<?php

if( get_queried_object()->name === 'product' ) return;
$post_thumbnail_img = wp_get_attachment_url(carbon_get_term_meta(get_queried_object()->term_id,'cat_image'));
if(!$post_thumbnail_img) return;
$mob_post_thumbnail_img = carbon_get_term_meta(get_queried_object()->term_id,'cat_mob_image') ? wp_get_attachment_url(carbon_get_term_meta(get_queried_object()->term_id,'cat_mob_image')) : $post_thumbnail_img;
?>

<section id="catalog-top" class="top-section">
  <div class="main-image">
    <picture>
      <source media="(min-width:640px)" srcset="<?= $post_thumbnail_img; ?>">
      <img src="<?= $mob_post_thumbnail_img; ?>" alt="<?= get_queried_object()->name; ?>">
    </picture>
    <p><?= get_queried_object()->name; ?></p>
  </div>
</section>