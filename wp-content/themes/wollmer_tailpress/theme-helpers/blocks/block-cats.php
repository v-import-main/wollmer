<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make(__('Categories List'))
->add_fields([Field::make('multiselect', 'items', 'Категории')
->add_options(get_terms_arr('product_category')),
])
->set_render_callback(function ($fields, $attributes, $inner_blocks) {
  ?>
  <section id="section-cats">
  <?php
  $cat_args = array(
    'hide_empty' => false,
    'include'    => $fields['items']
  );
  
  $product_categories = get_terms( 'product_cat', $cat_args );
  set_query_var('product_categories',$product_categories);
  foreach($product_categories as $product_category) {
    get_template_part( 'template-parts/item', 'category',['product_category' => $product_category]);
  }
  ?>
</section>
<?php
  }) ?>