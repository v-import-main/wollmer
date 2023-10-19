<?php
global $product;
$product_id = $product->get_ID();
if (is_front_page()) {
  $args = array(
    'hide_empty' => true
  );
  $review_categories = get_terms('category_reviews_tax', $args);
}
$args = array(
  'post_type'       => 'reviews',
  'posts_per_page'  => -1,
);

if(is_product()){
  $tags = [];
  foreach(get_the_terms( $product->get_id(), 'product_tag' ) as $term){
    $tags[] = $term->term_id;
  }
  
  $args['tax_query'] = [
    [
      'taxonomy'    => 'product_tag',
      'field'       => 'term_id',
      'terms'       => $tags,
    ]
  ];
}
$loop = new WP_Query($args);
if( !$loop->have_posts() ) return;
?>
<section id="section-reels" class="product-page-headline">
  <h2>Отзывы владельцев</h2>
  <?php if (is_front_page()) { ?>
    <div class="reels-cat-list">
    <?php
    foreach ($review_categories as $review_category) {
      get_template_part('template-parts/item', 'review-cat', ['review_category' => $review_category]);
    }
    ?>
  </div>
  <?php } ?>
  <div class="reels-items-list">
    <div class="reels-wrapper">
      <?php
      while ($loop->have_posts()) : $loop->the_post();
        global $post;
        get_template_part('template-parts/item', 'review', ['post_id' => $post->ID]);
      endwhile;

      wp_reset_query();
      ?>
    </div>
  </div>
</section>