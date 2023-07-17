<?php

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make(__('Wollmer News List'))
  ->add_fields([
    Field::make('text', 'headline', 'Заголовок')
  ])
  ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
?>

  <section id="section-news">
    <h2><?= $fields['headline']; ?></h2>
    <div class="news-cat-list">
      <?php
      $args = array(
        'hide_empty' => true
      );
      $video_categories = get_terms('category_videos_tax', $args);

      foreach ($video_categories as $key=>$video_category) {
        get_template_part('template-parts/item', 'news-cat', ['video_category' => $video_category,'key' => $key]);
      }
      ?>
    </div>
    <div class="news-list">
      <?php
      $args = array(
        'post_type'       => 'wollmer_news',
        'posts_per_page'  => 6,
        'tax_query'    => [
          [
            'taxonomy' => 'category_videos_tax',
            'field'    => 'term_id', // Or 'name' or 'term_id'
            'terms'    => [$video_categories[0]->term_id],
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
      ?>
    </div>
  </section>
<?php
  }) ?>