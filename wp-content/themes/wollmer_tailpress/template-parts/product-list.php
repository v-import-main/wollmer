<div class="product-list">
  <?php
  $args = array(
    'post_type'       => 'product',
    'posts_per_page'  => 8,
    'tax_query'       => array(
      array(
        'taxonomy' => 'product_cat',
        'field'    => 'term_id', // Or 'name' or 'term_id'
        'terms'    => array('168'),
        'operator' => 'NOT IN', // Excluded
      )
    )
  );

  $loop = new WP_Query($args);
  while ($loop->have_posts()) : $loop->the_post();
    global $product;
    get_template_part('template-parts/item', 'product', ['product' => $product]);
  endwhile;

  wp_reset_query();
  ?>

</div>