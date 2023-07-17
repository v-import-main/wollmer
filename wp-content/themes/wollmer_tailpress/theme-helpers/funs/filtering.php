<?php

add_action('wp_ajax_get_selected_cat_reviews', 'get_selected_cat_reviews');
add_action('wp_ajax_nopriv_get_selected_cat_reviews', 'get_selected_cat_reviews');

add_action('wp_ajax_get_selected_cat_videos', 'get_selected_cat_videos');
add_action('wp_ajax_nopriv_get_selected_cat_videos', 'get_selected_cat_videos');

function get_selected_cat_reviews()
{
  $term_id = $_POST['term_id'];

  $args = array(
    'post_type'       => 'reviews',
    'posts_per_page'  => -1,
    'tax_query'       => [
      [
        'taxonomy'    => 'category_reviews_tax',
        'field'       => 'term_id', // Or 'name' or 'term_id'
        'terms'       => [$term_id],
        'operator'    => 'IN', // Excluded
      ]
    ]
  );
  $loop = new WP_Query($args);
  echo '<div class="reels-wrapper">';
  while ($loop->have_posts()) : $loop->the_post();
    global $post;
    get_template_part('template-parts/item', 'review', ['post_id' => $post->ID]);
  endwhile;
  echo '</div>';
  wp_reset_query();

  wp_die();
}


function get_selected_cat_videos()
{
  $term_id = $_POST['term_id'];
  $args = array(
    'post_type'      => 'wollmer_news',
    'posts_per_page' => 6,
      'tax_query'    => [
      [
        'taxonomy' => 'category_videos_tax',
        'field'    => 'term_id', // Or 'name' or 'term_id'
        'terms'    => [$term_id],
        'operator' => 'IN', // Excluded
      ]
    ]
  );
  $loop = new WP_Query($args);
  while ($loop->have_posts()) : $loop->the_post();
  global $post;
    get_template_part('template-parts/item', 'news', ['post_id' => $post->ID]);
  endwhile;
  wp_reset_query();

  wp_die();
}