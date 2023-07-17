<?php

add_action('wp_ajax_search_suggest', 'search_suggest');
add_action('wp_ajax_nopriv_search_suggest', 'search_suggest');

function search_suggest() {
    $s = $_POST['s'];

    $res = get_posts([
        'post_type'=>'product',
        'numberposts'=>4,
        's'=>$s,
        'orderby' => 'meta_value_num',
        'meta_key' => '_price',
        'order' => 'DESC'
    ]);

    foreach($res as $key=>$el){

        if($key === 3 ){
            ?>
            <a href="/?s=<?= $s;?>" class="suggest-btn btn">Смотреть все результаты</a>
            <?php
            break;
        }
        $product = get_product($el->ID);

        $image_src = is_object($product) && !empty($product->get_image_id()) ? wp_get_attachment_image_url($product->get_image_id(), 'woocommerce_gallery_thumbnail') : wc_placeholder_img_src();
        
        
        if( $product->is_type( 'bundle' ) || $product->is_type( 'woosb' ) ){
            $sale_price = $product->get_bundle_price();
            $base_price = $product->get_bundle_regular_price();
        } else {
            $base_price = $product->get_price();
            $sale_price = $product->get_sale_price();
        };

    ?>
    <a class="suggest-item" href="<?= get_permalink($product->get_id()); ?>">
        <img src="<?= $image_src; ?>" alt="">
        <div>
            <p class="product-name"><?= $product->get_name(); ?></p>
            <?php
              if ($product->is_on_sale()) { ?>
                <div class="sale-price-wrapper">
                  <div class="sale-price"><?= $sale_price; ?> ₽</div>
                  <div class="orig-price"><?= $base_price; ?> ₽</div>
                </div>
              <?php } else { ?>
                <div class="regular-price"><?= $base_price; ?> ₽</div>
              <?php } ?>
        </div>
    </a>
    <?php
    }
    wp_die();
}

?>