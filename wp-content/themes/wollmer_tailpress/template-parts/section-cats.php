<section id="section-cats">
  <?php
  $cat_args = array(
    'hide_empty' => false,
    'include'    => [190,191,192,193,186,198,195,199]
  );
  
  $product_categories = get_terms( 'product_cat', $cat_args );
  set_query_var('product_categories',$product_categories);
  foreach($product_categories as $product_category) {
    get_template_part( 'template-parts/item', 'category',['product_category' => $product_category]);
  }
  ?>
</section>