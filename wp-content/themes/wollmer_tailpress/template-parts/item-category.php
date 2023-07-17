<?php
$term = $args['product_category'];
$image_id    = get_term_meta($term->term_id, 'thumbnail_id', true);
$image_src   = wp_get_attachment_image_src($image_id, 'medium_large')[0];
$image_src_mob   = wp_get_attachment_image_src($image_id, 'medium')[0];
$spec_text   = carbon_get_term_meta($term->term_id, 'short_name') ? carbon_get_term_meta($term->term_id, 'short_name') : $term->name;
$ext         = pathinfo($image_src, PATHINFO_EXTENSION);
$mime_type   = wp_get_image_mime($image_src);
?>
<a class="item-category" href="/products/<?= $term->slug; ?>">
  <?php
  if ($mime_type && ($mime_type === 'image/png' || $mime_type === 'image/jpeg')) {
    $webp_src = $image_src.'.webp';
    $webp_src_mob = $image_src_mob.'.webp';
  } else {
    $webp_src = $image_src;
    $webp_src_mob = $image_src_mob;
  }
  ?>

  <picture>
    <?php if($webp_src !== $image_src) { ?>
      <source srcset="<?= $webp_src_mob; ?>" type="image/webp" media="(max-width: 767px)">
      <source srcset="<?= $webp_src; ?>" type="image/webp" media="(min-width: 768px)">
    <?php } ?>
    <source srcset="<?= $image_src_mob; ?>" type="image/<?= $ext; ?>" media="(max-width: 767px)">
    <source srcset="<?= $image_src; ?>" type="image/<?= $ext; ?>" media="(min-width: 768px)">

    <img  src="<?= $webp_src_mob; ?>" width="411" height="280"  alt="<?= $term->name; ?>">
  </picture>

  <p><?= $spec_text; ?></p>
</a>