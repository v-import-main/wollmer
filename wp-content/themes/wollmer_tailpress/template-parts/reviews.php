<section class="reviews">
  <h2>Отзывы</h2>
  <div class="review-cat-list">
    <?php
    $args = array(
      'meta_key'   => 'order',
      'orderby'    => 'meta_value_num',
      'hide_empty' => true,
    );
    $review_categories = get_terms('category_reviews_tax', $review_categories);
    foreach ($product_categories as $product_category) {
      get_template_part('template-parts/item', 'review-cat', ['review_categories' => $review_categories]);
    }
    ?>
  </div>

  <div class="review-items-list">
    <?php
    $args = array(
      'post_type'       => 'reviews',
      'posts_per_page'  => -1,
    );

    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
      global $post;
      get_template_part('template-parts/item', 'review', ['post' => $post]);
    endwhile;

    wp_reset_query();
    ?>
  </div>
</section>