<?php
global $product;
if (carbon_get_post_meta($product->get_id(),'acc')) { ?>
<section id="accessories">
  <h2>Используй возможности по максимуму</h2>
  <div class="acc-wrapper col-<?=count( carbon_get_post_meta($product->get_id(),'acc') );?>">
    <?php
    foreach( carbon_get_post_meta($product->get_id(),'acc') as $acc){ ?>
      <div class="acc-item" style="background-image:url(<?= wp_get_attachment_url($acc['image']); ?>)">
        <p class="acc-subtitle"><?= $acc['title']; ?></p>
        <p><?= $acc['text']; ?></p>
      </div>
    <?php } ?>
  </div>
</section>
<?php } ?>