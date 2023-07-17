<?php

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make(__('Reels List'))
  ->add_fields([
    Field::make('text', 'headline', 'Заголовок'),
  ])
  ->set_render_callback(function ($fields, $attributes, $inner_blocks) { 
?>

<section id="section-reels">
  <h2><?= $fields['headline']; ?></h2>
  <div class="reels-cat-list">
    <?php
    $args = array(
      'hide_empty' => true
    );
    $review_categories = get_terms('category_reviews_tax', $args);

    foreach ($review_categories as $review_category) {
      get_template_part('template-parts/item', 'review-cat', ['review_category' => $review_category,'count' => count($review_categories)]);
    }
    ?>
  </div>
  <div class="reels-items-list">
    <div class="reels-wrapper">
      <?php
    $args = array(
      'post_type'       => 'reviews',
      'posts_per_page'  => -1,
      'tax_query'  => [
        [
          'taxonomy' => 'category_reviews_tax',
          'field'    => 'term_id',
          'terms'    => $review_categories[0]->term_id
          ]
      ]
    );
    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
      global $post;
      get_template_part('template-parts/item', 'review', ['post_id' => $post->ID]);
    endwhile;
    wp_reset_query();
    ?>
    </div>
  </div>
</section>
<?php
}) ?>