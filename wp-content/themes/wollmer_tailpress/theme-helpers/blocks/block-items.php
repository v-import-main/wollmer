<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make(__('Product List'))
  ->add_fields([
    Field::make('text', 'headline', 'Заголовок'),
    Field::make('text', 'btn_link', 'Ссылка'),
    Field::make('text', 'btn_text', 'Текст на кнопке'),
    Field::make('multiselect', 'items', 'Товары')
      ->set_options(get_items_arr('product')),
  ])
  ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
?>
  <section id="section-product" class="section-product">
    <div class="headline">
      <h2>Популярные товары</h2>
      <?php if(!!$fields['btn_link']){ ?>
      <a class="btn" href="<?= $fields['btn_link']; ?>"><?= $fields['btn_text']; ?></a>
      <?php } ?>
    </div>
    <div class="product-list home_prods">
      <?php
      foreach ($fields['items'] as $item) {
        $_product = wc_get_product($item);
        if(!is_object($_product)) continue;
        get_template_part('template-parts/item', 'product', ['product' => $_product]);
      } ?>
    </div>
    <div class="botline">
      <?php if(!!$fields['btn_link']){ ?>
      <a class="btn" href="<?= $fields['btn_link']; ?>"><?= $fields['btn_text']; ?></a>
      <?php } ?>
    </div>
  </section>
<?php
  }) ?>