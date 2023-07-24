<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('term_meta', ' Дополнительно')
->show_on_taxonomy(['category_reviews_tax','section_shop_tax'])
->add_fields([
    Field::make('image', 'preview', 'Превью')
]);

Container::make('post_meta', ' Дополнительно')
    ->where('post_type', '=', 'product')
    ->add_fields([

        Field::make( 'html', 'crb_information_text_0' )
        ->set_html( '<h3>Тип первого экрана</h3>' ),
        Field::make('checkbox', 'square', 'Старая версия'),
        Field::make( 'html', 'crb_information_text_1' )
        ->set_html( '<h3>Блок Рилзов</h3>' ),
        Field::make('checkbox', 'reels', 'Показывать'),

        // Field::make('text', 'subtitle', 'Подзаголовок'),

        Field::make('image', 'scheme', 'Схема')
        ->set_width(40),
        Field::make('file', 'pdf', 'Инструкция (PDF)')
        ->set_width(40),
        Field::make('text', 'reviews_count', 'Количество отзывов')
        ->set_width(20),
        // Field::make('complex', 'videos', 'Видео')
        // ->add_fields([
        //     Field::make('image', 'video_preview', 'Превью')
        //     ->set_width(30),
        //     Field::make('text', 'video', 'Ссылка на видео')
        //     ->set_width(30),
        //     Field::make('text', 'video_title', 'Название видео')
        //     ->set_width(40),
        // ]),

        // Field::make( 'html', 'wrap_acc' )
        // ->set_html( '<br><p style="font-size:24px;font-width:bold;margin-top:14px">Блок Используй возможности по-максимуму</p>' ),
        // Field::make('complex', 'acc', 'Аксессуары')
        // ->add_fields([
        //     Field::make('image', 'image', 'Превью')
        //     ->set_width(30),
        //     Field::make('text', 'title', 'Заголовок')
        //     ->set_width(30),
        //     Field::make('text', 'text', 'Текст')
        //     ->set_width(40),
        // ]),

        Field::make( 'html', 'wrap_next' )
        ->set_html( '<br><p style="font-size:24px;font-width:bold;margin-top:14px">Блок Преимущества</p>' ),

        Field::make('image', 'complex_image', 'Изображение для сравнения'),
        Field::make('textarea', 'checkboxes', 'Общие элементы'),
        Field::make('textarea', 'checkboxes_plus', 'Есть в комплектации'),
        Field::make('textarea', 'checkboxes_minus', 'Нет в комплектации'),

        Field::make( 'html', 'wrap_link' )
        ->set_html( '<br><p style="font-size:24px;font-width:bold;margin-top:14px">Блок ссылок</p>' ),

        Field::make('checkbox', 'links_1_on', 'Показывать 1 ссылку')
            ->set_width(80),
        Field::make('checkbox', 'links_1_on_file', 'Ссылка на файл')
            ->set_width(20),

        Field::make('text', 'links_1_txt', 'Первая ссылка текст')
            ->set_width(40),
        Field::make('text', 'links_1', 'Первая ссылка')
        ->set_width(40),
        Field::make('file', 'links_1_file', '(PDF)')
            ->set_width(20) ->set_value_type('url'),

        Field::make('checkbox', 'links_2_on', 'Показывать 2 ссылку')
            ->set_width(80),
        Field::make('checkbox', 'links_2_on_file', 'Ссылка на файл')
            ->set_width(20),

        Field::make('text', 'links_2_txt', 'Вторая ссылка текст')
            ->set_width(40),
        Field::make('text', 'links_2', 'Вторая ссылка')
            ->set_width(40),
        Field::make('file', 'links_2_file', '(PDF)')
            ->set_width(20),

        Field::make('checkbox', 'links_3_on', 'Показывать 3 ссылку')
            ->set_width(80),
        Field::make('checkbox', 'links_3_on_file', 'Ссылка на файл')
            ->set_width(20),

        Field::make('text', 'links_3_txt', 'Третья ссылка текст')
            ->set_width(40),
        Field::make('text', 'links_3', 'Третья ссылка')
            ->set_width(40),
        Field::make('file', 'links_3_file', '(PDF)')
            ->set_width(20),

]);

Container::make('post_meta', 'Информация')
    ->where('post_type', '=', 'reviews')
    ->add_fields([
        Field::make('image', 'image', 'Изображение (для превию или если нет видео)')
        ->set_width(30),
        Field::make('file', 'video_src', 'Файл видео')
        ->set_type( array( 'video' ) )
        ->set_width(30),
        Field::make('text', 'video_url', 'Код видео (ютуб итп)')
        ->set_width(40),
        Field::make('text', 'title', 'Заголовок'),
        Field::make('text', 'text', 'Текст'),
        Field::make('text', 'subtitle', 'Автор'),
]);

Container::make('term_meta', ' Дополнительно')
    ->where( 'term_taxonomy', '=', 'product_cat' )
    ->add_fields([
        Field::make( 'html', 'crb_information_text_1' )
            ->set_html( '<h3>Настройки для главной страницы</h3>' ),
        Field::make('text', 'short_name', 'Сокращенное название')
            ->set_width(50),
        Field::make('image', 'mob_image', 'Изображение для мобильного на главной')
            ->set_width(50),
        Field::make( 'html', 'crb_information_text_2' )
            ->set_html( '<h3>Настройки для страницы категории</h3>' ),
        Field::make('image', 'cat_image', 'Изображение для страницы категории')
            ->set_width(50),
        Field::make('image', 'cat_mob_image', 'Изображение для мобильного на категории')
            ->set_width(50),
    ]);

Container::make('post_meta', ' Дополнительно')
->where('post_type', '=', 'post')
->add_fields([
    Field::make('image', 'ban_image', 'Изображение баннер')
    ->set_width(50),
    Field::make('image', 'mob_ban_image', 'Изображение баннер (моб)')
    ->set_width(50),
]);

Container::make('post_meta', ' Сервисные центры')
->where('post_template', '=', 'page-service.php')
->add_fields([
    Field::make('complex', 'sc', '')
    ->add_fields([
        Field::make('text', 'id', 'ID')
        ->set_width(5),
        Field::make('text', 'area_id', 'Area ID')
        ->set_width(5),
        Field::make('text', 'city', 'Город')
        ->set_width(10),
        Field::make('text', 'name', 'Название СЦ')
        ->set_width(20),
        Field::make('text', 'address', 'Адрес')
        ->set_width(20),
        Field::make('text', 'schedule', 'График работы')
        ->set_width(10),
        Field::make('text', 'phone', 'Телефон')
        ->set_width(10),
        Field::make('text', 'latitude', 'Широта')
        ->set_width(10),
        Field::make('text', 'longitude', 'Долгота')
        ->set_width(10),
    ])
]);

Container::make('post_meta', ' Дополнительно')
    ->where('post_type', '=', 'wollmer_news')
    ->add_fields([
        Field::make('text', 'video', 'Код ютуб видео'),
        Field::make('text', 'video_url', 'Ссылка ютуб видео')
    ]);


Container::make('theme_options', 'Настройки темы')
    // ->add_tab('Служебная информация', [
    // ])
    ->add_tab('Контактные данные', [
        Field::make('textarea', 'head', 'Для кодов в хед'),
        Field::make('textarea', 'upperbody', 'Для кодов после открывающего боди'),
        Field::make('textarea', 'lowerbody', 'Для кодов перед закрывающим боди'),
        Field::make('text', 'phone', 'Телефон'),
        Field::make('text', 'email', 'e-mail'),
        Field::make('text', 'schedule', 'График колл-центра'),
        Field::make('text', 'vk', 'Вконтакте')
            ->set_width(80),
        Field::make('checkbox', 'vk_toggler', 'Показывать в худере/футере')
            ->set_width(20),
        Field::make('text', 'youtube', 'YouTube')
            ->set_width(80),
        Field::make('checkbox', 'youtube_toggler', 'Показывать в худере/футере')
            ->set_width(20),
        Field::make('text', 'whatsapp', 'Whatsapp')
            ->set_width(80),
        Field::make('checkbox', 'whatsapp_toggler', 'Показывать в худере/футере')
            ->set_width(20),
        Field::make('text', 'telegram', 'Telegram')
            ->set_width(80),
        Field::make('checkbox', 'telegram_toggler', 'Показывать в худере/футере')
            ->set_width(20),
        Field::make('text', 'facebook', 'Facebook')
            ->set_width(80),
        Field::make('checkbox', 'facebook_toggler', 'Показывать в худере/футере')
            ->set_width(20),
        Field::make('text', 'instagram', 'Instagram')
            ->set_width(80),
        Field::make('checkbox', 'instagram_toggler', 'Показывать в худере/футере')
            ->set_width(20),
    ]);
