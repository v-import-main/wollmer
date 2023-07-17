<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make(__('Banner'))
  ->add_fields([
    Field::make('image', 'bg_img_desk', 'Фон десктоп'),
    Field::make('image', 'bg_img_mob', 'Фон мобил'),
    Field::make('complex', 'icons', 'Иконки')
    ->add_fields([
      Field::make('image', 'icon', 'Иконка'),
      Field::make('textarea', 'text', 'Подпись'),
    ])
  ])
  ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
?>
  <section id="front-top" class="top-section">
    <div class="main-image">
      <?php
      $image_src   = wp_get_attachment_image_src($fields['bg_img_desk'], 'full')[0];
      $image_src_mob   = wp_get_attachment_image_src($fields['bg_img_mob'], 'full')[0];
      $ext         = pathinfo($image_src, PATHINFO_EXTENSION);
      $mime_type   = wp_get_image_mime($image_src);

      if ($mime_type && ($mime_type === 'image/png' || $mime_type === 'image/jpeg')) {
        $webp_src = $image_src.'.webp';
        $webp_src_mob = $image_src_mob.'.webp';
      } else {
        $webp_src = $image_src;
        $webp_src_mob = $image_src_mob;
      }
?>

      <picture>
      <?php if($webp_src !== $image_src){?>
        <source srcset="<?= $webp_src_mob; ?>" type="image/webp" media="(max-width: 567px)">
        <source srcset="<?= $webp_src; ?>" type="image/webp" media="(min-width: 568px)">
      <?php } ?>
        <source srcset="<?= $image_src_mob; ?>" type="image/<?= $ext; ?>" media="(max-width: 567px)">
        <source srcset="<?= $image_src; ?>" type="image/<?= $ext; ?>" media="(min-width: 568px)">
        <img width="100%" height="100%" src="<?= $webp_src_mob; ?>" alt="">
      </picture>


      <div class="main-image-icons">
        <?php foreach($fields['icons'] as $icon){ ?>
        <div class="main-image-icon">
          <img loading="lazy" width="56px" height="60px" src="<?= wp_get_attachment_image_src($icon['icon'], 'full')[0]; ?>" alt="">
          <?= wpautop($icon['text']); ?>
        </div>
        <?php } ?>
      </div>
    </div>
  </section>
<?php
  })
?>