<?php
function true_register_post_type_init()
{

  $labels = array(
    'name' => 'Wollmer News',
    'singular_name' => 'Wollmer News',
    'add_new' => 'Добавить видео Wollmer News',
    'edit_item' => 'Редактировать видео Wollmer News',
    'new_item' => 'Новое видео Wollmer News',
    'all_items' => 'Все Wollmer News',
    'view_item' => 'Просмотр Wollmer News на сайте',
    'search_items' => 'Искать Wollmer News',
    'not_found' => 'Wollmer News не найдено.',
    'menu_name' => 'Wollmer News'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_ui' => true,
    'has_archive' => false,
    'show_in_rest' => true,
    'menu_position' => 50,
    'menu_icon' => 'dashicons-video-alt3',
    'taxonomies' => ['category_videos_tax','product_tag'],
    'supports' => array(
      'title',
      // 'page-attributes',
      'editor',
      'thumbnail',
    )
  );
  register_post_type('wollmer_news', $args);

  $labels = array(
    'name' => 'Reels',
    'singular_name' => 'Reels',
    'add_new' => 'Добавить reels',
    'add_new_item' => 'Добавить новый reels',
    'edit_item' => 'Редактировать reels',
    'new_item' => 'Новый reels',
    'all_items' => 'Все reels',
    'view_item' => 'Просмотр reels на сайте',
    'search_items' => 'Искать reels',
    'not_found' => 'Reels не найдено.',
    'menu_name' => 'Reels'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_ui' => true,
    'has_archive' => false,
    'show_in_rest' => true,
    'menu_position' => 50,
    'menu_icon' => 'dashicons-admin-comments',
    'taxonomies' => ['category_reviews_tax','product_tag'],
    'supports' => array(
      'title',
      'editor',
    )
  );
  register_post_type('reviews', $args);

  $labels = array(
    'name' => 'Сквозные блоки',
    'singular_name' => 'Сквозной блок',
    'add_new' => 'Добавить сквозной блок',
    'edit_item' => 'Редактировать сквозной блок',
    'new_item' => 'Новый сквозной блок',
    'all_items' => 'Все сквозные блоки',
    'view_item' => 'Просмотр сквозного блока',
    'search_items' => 'Искать сквозной блок',
    'not_found' => 'Сквозных блоков не найдено.',
    'menu_name' => 'Сквозные блоки'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_ui' => true,
    'has_archive' => false,
    'show_in_rest' => true,
    'menu_position' => 90,
    'menu_icon' => 'dashicons-embed-photo',
    // 'taxonomies' => ['category_videos_tax','product_tag'],
    'supports' => array(
      'title',
      // 'page-attributes',
      'editor',
      'thumbnail',
    )
  );
  register_post_type('crossblocks', $args);
} //function close    
