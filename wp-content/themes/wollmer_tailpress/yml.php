<?php
/**
 * Template Name: YML
*/

$cats = [
    1=>[
        'url'=>'http://wollmer.cq77457.tmweb.ru/product-category/gotovaya-produkcziya/elektricheskaya-myasorubka/',
        'id'=>'9b4bad53-02ae-11ed-0a80-0fe900498171',
        'name'=>'Электрическая мясорубка'
    ],
    2=>[
        'url'=>'http://wollmer.cq77457.tmweb.ru/product-category/gotovaya-produkcziya/vertikalnyj-pylesos/',
        'id'=>'ae28c691-0f65-11ed-0a80-0d8300135272',
        'name'=>'Вертикальный пылесос'
    ],
    3=>[
        'url'=>'http://wollmer.cq77457.tmweb.ru/product-category/gotovaya-produkcziya/elektrogril/',
        'id'=>'9b5cb622-02ae-11ed-0a80-0fe900498178',
        'name'=>'Электрогриль'
    ],
    4=>[
        'url'=>'http://wollmer.cq77457.tmweb.ru/product-category/gotovaya-produkcziya/pogruzhnoj-blender/',
        'id'=>'9b698d1e-02ae-11ed-0a80-0fe90049817d',
        'name'=>'Погружные блендеры'
    ],
    5=>[
        'url'=>'http://wollmer.cq77457.tmweb.ru/product-category/gotovaya-produkcziya/planetarnyj-mikser/',
        'id'=>'9ae0dd6f-4bc7-11ed-0a80-03de0011b6e1',
        'name'=>'Планетарный миксер'
    ],
    6=>[
        'url'=>'http://wollmer.cq77457.tmweb.ru/product-category/gotovaya-produkcziya/robot-mojshhik-okon/',
        'id'=>'198',
        'name'=>'Робот-мойщик окон'
    ],
    7=>[
        'url'=>'http://wollmer.cq77457.tmweb.ru/product-category/gotovaya-produkcziya/aksessuary/',
        'id'=>'8719c01c-0f65-11ed-0a80-017700133d2e',
        'name'=>'Аксессуары'
    ],
];

$items = [
    ['WLM905XP','9b4bad53-02ae-11ed-0a80-0fe900498171'],
    ['WLM907SS','9b4bad53-02ae-11ed-0a80-0fe900498171'],
    ['WLM901','9b4bad53-02ae-11ed-0a80-0fe900498171'],
    ['WLD707S','ae28c691-0f65-11ed-0a80-0d8300135272'],
    ['WLD703C','ae28c691-0f65-11ed-0a80-0d8300135272'],
    ['WLS807N','9b5cb622-02ae-11ed-0a80-0fe900498178'],
    ['WLG522K','9b698d1e-02ae-11ed-0a80-0fe90049817d'],
    ['WLT1000','9ae0dd6f-4bc7-11ed-0a80-03de0011b6e1'],
    ['WLW600U','c4eea97d-0f65-11ed-0a80-0c4c00135e4f'],
    ['KWLMS905','8719c01c-0f65-11ed-0a80-017700133d2e'],
    ['KWLMJ905','8719c01c-0f65-11ed-0a80-017700133d2e'],
    ['KWLMJ907','8719c01c-0f65-11ed-0a80-017700133d2e'],
    ['KWLMS907','8719c01c-0f65-11ed-0a80-017700133d2e'],
    ['KWLDA705','8719c01c-0f65-11ed-0a80-017700133d2e'],
    ['KWLDA707','8719c01c-0f65-11ed-0a80-017700133d2e']
];


date_default_timezone_set('moscow/europe');
?>

<yml_catalog date="<?= date('Y-m-d H:i'); ?>">
    <shop> 
        <name>Wollmer</name>
        <company>Wollmer</company>
        <url>https://wollmer.ru</url>

        <categories>
            <?php foreach($cats as $cat) { ?>
            <category id="<?= $cat['id'];?>"><?= $cat['name'];?></category>
            <?php } ?>
        </categories>

        <offers>
        <?php foreach($items as $item){
            $product_id = wc_get_product_id_by_sku($item[0]);
            $product = wc_get_product($product_id);
        ?>

            <offer id="<?= $item[0]; ?>">
                <url>http://wollmer.cq77457.tmweb.ru/product/<?= $product->get_slug();?>/</url>
                <categoryId><?= $item[1];?></categoryId>
                <picture><?= !empty($product->get_image_id()) ? wp_get_attachment_image_url($product->get_image_id(), 'medium') : wc_placeholder_img_src(); ?></picture>
                <name><?= $product->get_name(); ?></name>
                <vendor>Wollmer</vendor>
            </offer>
            <?php } ?>
        </offers>
    </shop>
</yml_catalog>