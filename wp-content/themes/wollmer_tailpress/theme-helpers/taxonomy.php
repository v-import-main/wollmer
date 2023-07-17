<?php
function add_new_taxonomies()
{
    $labels = array(
        'name' => 'Категории Reels',
        'singular_name' => 'Категория Reels',
        'add_new' => 'Добавить категорию Reels',
        'add_new_item' => 'Добавить новую категорию Reels',
        'edit_item' => 'Редактировать категорию Reels',
        'new_item' => 'Новая категория Reels',
        'all_items' => 'Все категории Reels',
        'view_item' => 'Просмотр всех категорий Reels на сайте',
        'search_items' => 'Искать категории Reels',
        'not_found' => 'Категорий Reels не найдено.',
        'menu_name' => 'Категории Reels'
    );

    register_taxonomy(
        'category_reviews_tax',
        'reviews',
        array(
            'label' => 'Категории Reels',
            'hierarchical' => false,
            'show_in_rest' => true,
            'labels' => $labels,
        )
    );


    $labels = array(
        'name' => 'Категории Wollmer News',
        'singular_name' => 'Категория Wollmer News',
        'add_new' => 'Добавить категорию Wollmer News',
        'add_new_item' => 'Добавить новую категорию Wollmer News',
        'edit_item' => 'Редактировать категорию Wollmer News',
        'new_item' => 'Новая категория Wollmer News',
        'all_items' => 'Все категории Wollmer News',
        'view_item' => 'Просмотр всех категорий Wollmer News на сайте',
        'search_items' => 'Искать категории Wollmer News',
        'not_found' => 'Категорий Wollmer News не найдено.',
        'menu_name' => 'Категории Wollmer News'
    );

    register_taxonomy(
        'category_videos_tax',
        'reviews',
        array(
            'label' => 'Категории Wollmer News',
            'hierarchical' => false,
            'show_in_rest' => true,
            'labels' => $labels,
        )
    );


    $labels = array(
        'name' => 'Разделы Shop',
        'singular_name' => 'Категория раздела Shop',
        'add_new' => 'Добавить раздел Shop',
        'add_new_item' => 'Добавить новый раздел Shop',
        'edit_item' => 'Редактировать раздел Shop',
        'new_item' => 'Новый раздел Shop',
        'all_items' => 'Все разделы Shop',
        'view_item' => 'Просмотр всех разделов Shop на сайте',
        'search_items' => 'Искать раздел Shop',
        'not_found' => 'Раздел Shop не найден.',
        'menu_name' => 'Разделы Shop'
    );

    register_taxonomy(
        'section_shop_tax',
        'product',
        array(
            'label' => 'Раздел Shop',
            'hierarchical' => false,
            'show_in_rest' => true,
            'labels' => $labels,
        )
    );
}
