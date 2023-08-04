<?php
require_once __DIR__ . '/shipping.php';


// remove default styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// remove breadcrumbs
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

// remove sidebar
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// ENABLE GUTENBERG FOR PRODUCTS
// enable gutenberg for woocommerce
function activate_gutenberg_product($can_edit, $post_type)
{
    if ($post_type == 'product') {
        $can_edit = true;
    }
    return $can_edit;
}
add_filter('use_block_editor_for_post_type', 'activate_gutenberg_product', 10, 2);
// enable taxonomy fields for woocommerce with gutenberg on
function enable_taxonomy_rest($args)
{
    $args['show_in_rest'] = true;
    return $args;
}
add_filter('woocommerce_taxonomy_args_product_cat', 'enable_taxonomy_rest');
add_filter('woocommerce_taxonomy_args_product_tag', 'enable_taxonomy_rest');


function woocommerce_button_proceed_to_checkout() {
    $checkout_url = WC()->cart->get_checkout_url();
    ?>
    <p>Доступные способы доставки можно выбрать при оформлении заказа</p>
    <a href="<?php echo $checkout_url; ?>" class="checkout-button button alt wc-forward">Перейти к оформлению</a>
    <?php
}


// REMOVE THE PRODUCT DESCRIPTION TITLE
add_filter('woocommerce_product_description_heading', '__return_null');






// BACKORDER
// add_filter('woocommerce_product_meta_start', 'no_stock_preorder');
// function no_stock_preorder()
// {
//   global $product;
//   if ($product->get_stock_status() === 'onbackorder') {
//     echo '<div class="backorder-wrapper">';
//     echo '<p>Товара сейчас нет в наличии, но вы можете сделать предзаказ</p>';
//     echo '<button data-fancybox="backordermodal" data-src="#backordermodal" class="backorder-btn">Предзаказ</button>';
//     get_template_part('template-parts/modal','backorder',['product' => $product]);
//     echo '</div>';

//     echo '</div>';
//   }
// }

add_action('woocommerce_single_product_summary', 'check_if_backordered', 1);
function check_if_backordered()
{
    global $product;
    if ($product->is_on_backorder()) {
        // remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    }
}



/**
 * Новый таб для продуктов
 */
add_filter( 'woocommerce_product_tabs', 'rmn_woo_custom_tabs' );
function rmn_woo_custom_tabs($tabs) {

    if(!has_term(['aksessuary','wollmer-care','zapchasti'],'product_cat',get_the_ID())){
        $tabs['description']['title'] = 'Описание';
        $tabs['description']['callback'] = 'description_tab';

        $tabs['additional_information']['title'] = 'Характеристики';
        $tabs['additional_information']['callback'] = 'additional_tab';


        if(1>2){ //Отключено 24-03

            $tabs['review_tab'] = array(
                'title'    => 'Отзывы', // Тут можно присвоить простую строку.
                'priority' => 31,                               // Определяет положение таба относительно других.
                'callback' => 'review_tab'          // Функция для содержимого вкладки.
            );

            $tabs['complex_tab'] = array(
                'title'    => 'Комплектации', // Тут можно присвоить простую строку.
                'priority' => 30,                               // Определяет положение таба относительно других.
                'callback' => 'complex_tab'          // Функция для содержимого вкладки.
            );
        }
        return $tabs;
    } else {
        return description_tab();
    }
}

function additional_tab(){
    get_template_part('template-parts/section', 'chars');
}

function description_tab() {
    // get_template_part('template-parts/section', 'credit');
    wc_get_template( 'single-product/tabs/description.php' );
    // get_template_part('template-parts/section', 'accessories');
    // get_template_part('template-parts/section', 'advantages');
    // get_template_part('template-parts/section', 'video');
    if(carbon_get_post_meta(get_the_ID(),'reels') != ''){
        get_template_part('template-parts/section', 'reels');
    }
    get_template_part('template-parts/section', 'database');
    if(!has_term(['aksessuary','wollmer-care','zapchasti'],'product_cat',get_the_ID())){
        echo '<div class="char_headline headline"><h2>Характеристики</h2></div>';
        get_template_part('template-parts/section', 'chars');
    }
}
function review_tab() {
    // get_template_part('template-parts/section', 'reels');
    // get_template_part('template-parts/section', 'mneniyapro');
}
function complex_tab() {
    get_template_part('template-parts/section', 'complex');
}





// gutenberg
// add_filter( 'woocommerce_blocks_product_grid_item_html', 'ssu_custom_render_product_block', 10, 3);

function ssu_custom_render_product_block($html, $data, $post)
{
    $productID = url_to_postid($data->permalink);
    $product = wc_get_product($productID);
    get_template_part('template-parts/item', 'product', ['product' => $product]);
}


// CFS
add_action('woocommerce_after_single_product', 'after_single_product_section', 2);
function after_single_product_section()
{
    get_template_part('template-parts/section', 'related');
}
add_action('woocommerce_after_single_product_summary', 'woocommerce_after_single_product_summary_section', 2);
function woocommerce_after_single_product_summary_section()
{
    // get_template_part('template-parts/section', 'credit');
}

// remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 1);



function remove_loop_button()
{
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
}
add_action('init', 'remove_loop_button');


add_action('woocommerce_before_shop_loop_item_title', 'wc_cp_image_wrapper_open', 5);
function wc_cp_image_wrapper_open()
{

    if (is_product()) {
        echo '<div class="image-wrap">';
        echo '<picture>';
    }
}


add_action('woocommerce_shop_loop_item_title', 'wc_cp_image_wrapper_close', 5);
function wc_cp_image_wrapper_close()
{
    if (is_product()) {
        echo '</picture>';
        echo '<button class="btn">Подробнее</button>';
        echo '</div>';
    }
}

// add_filter('woocommerce_product_upsells_products_heading', function () {
//   return 'Покупают вместе';
// });

add_filter('woocommerce_sale_flash', 'hide_sale_flash');
function hide_sale_flash()
{
    return false;
}



remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
add_action('woocommerce_before_single_product_summary', 'show_custom_product_images_layout', 20);

function show_custom_product_images_layout()
{
    global $product;
    if(carbon_get_post_meta($product->get_id(),'square') == 1){
        get_template_part('template-parts/top', 'product', ['product' => $product]);
    } else {
        get_template_part('template-parts/top-square', 'product', ['product' => $product]);
    }

    echo '<div class="colorizer">';
}


function my_text_strings( $translated_text, $text, $domain ) {
    switch ( strtolower( $translated_text ) ) {
        case 'View Cart' :
            $translated_text = 'Перейти в корзину';
            break;
        case 'Просмотр корзины' :
            $translated_text = 'Перейти в корзину';
            break;
        case '[Убрать]' :
            $translated_text = "";
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'my_text_strings', 20, 3 );

add_filter('woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text');
function woo_custom_cart_button_text()
{
    return __('Добавить в корзину', 'woocommerce');
}

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
add_action('woocommerce_single_product_summary', 'woocommerce_my_single_title', 5);

if (!function_exists('woocommerce_my_single_title')) {
    function woocommerce_my_single_title()
    {
        $data_price = wc_get_product(get_the_ID())->get_type() === 'bundle' || wc_get_product(get_the_ID())->get_type() === 'woosb' ? wc_get_product(get_the_ID())->get_bundle_price() : wc_get_product(get_the_ID())->get_price();
        ?>
        <div class="rating-top <?= carbon_get_post_meta(get_the_ID(), 'reviews_count') === '321' ? 'invisible' : '123';?>">
            <div class="rating-top-stars"></div>
            <div class="rating-top-count">Отзывы: <?= carbon_get_post_meta(get_the_ID(), 'reviews_count'); ?></div>
        </div>
        <div class="links-block">


            <?php
            if( have_rows('block_links') ):
//                echo '<h2>Тест</h2>';
                echo '<ul>';
                while( have_rows('block_links') ): the_row();

                    $title = get_sub_field('link_title');
                    $link = get_sub_field('link');
                    $file = get_sub_field('link_file');
                    $linkfileon = get_sub_field('link_file_on');
                    if ($linkfileon == 'yes'){
                        echo '<li><a href="' .$file. '" target="_blank">
                        ' .$title. '
                        <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12L11 1M11 1V9.51613M11 1H2.72414" stroke="black"/>
                        </svg>
                        </a></li>';
                    } else {
                        echo '<li><a href="' .$link. '" target="_blank">
                        ' .$title. '
                        <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12L11 1M11 1V9.51613M11 1H2.72414" stroke="black"/>
                        </svg>
                        </a></li>';
                    }
                endwhile;
                echo '</ul>';
            endif;
            ?>

        </div>



        <h1 data-price="<?= $data_price; ?>"><?= get_the_title(); ?></h1>
        <!--        <div class="subtitle">--><?php //= get_post(get_the_ID())->post_excerpt ?><!--</div>-->
        <?php
        global $product;
        $upsells = $product->get_upsells();
        if(count($upsells)){

            $var_name = ($product->get_type() === 'woosb' || $product->get_type() === 'bundle') ? get_post_meta( $product->get_id(), '_custom_complex_name', true ) : 'Basic1';?>
            <div class="buttons-wrapper">
                <p class="subtitle">Комплектация:</p>
                <div class="variation-radios">
                    <div class="radio-wrapper" style="order:<?= ($product->get_type() === 'woosb' || $product->get_type() === 'bundle') ? $product->get_bundle_price() : $product->get_price(); ?>">
                        <a class="label active" href="javascript:void(0)">
                            <span class="var_name"><?= $var_name; ?></span>:<span class="var_price"><?= ($product->get_type() === 'woosb' || $product->get_type() === 'bundle') ? $product->get_bundle_price() : $product->get_price(); ?> ₽</span>
                        </a>
                    </div>
                    <?php foreach($upsells as $upsell_id) {
                        $upsell = wc_get_product($upsell_id);
                        $var_name = ($upsell->get_type() === 'woosb' || $upsell->get_type() === 'bundle') ? get_post_meta( $upsell_id, '_custom_complex_name', true ) : 'Basic2';
                        ?>
                        <div class="radio-wrapper" style="order:<?= ($upsell->get_type() === 'woosb' || $upsell->get_type() === 'bundle') ? $upsell->get_bundle_price() : $upsell->get_price(); ?>">
                            <a class="label" href="<?= $upsell->get_permalink();?>">
                                <span class="var_name"><?= $var_name; ?></span>:<span class="var_price"><?= ($upsell->get_type() === 'woosb' || $upsell->get_type() === 'bundle') ? $upsell->get_bundle_price() : $upsell->get_price(); ?> ₽</span>
                            </a>
                        </div>
                    <?php } ?>
                </div>

            </div>
            <div class="subtitle"><?= get_post(get_the_ID())->post_excerpt ?></div>
            <?php
        }
    }
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

function woocommerce_template_single_add_to_cart()
{
    global $product;
    echo '<div class="pricing-wrap">';
    woocommerce_template_single_price();
    echo '<div class="buttons-wrapper">';
    if (!$product->is_on_backorder()) {
        do_action('woocommerce_' . $product->get_type() . '_add_to_cart');
        echo '<button data-fancybox="oneclickmodal" data-src="#oneclickmodal" class="one-click-btn">Заказ в один клик</button>';
    } else {
        echo '<div class="backorder-wrapper">';
        echo '<p>Товара сейчас нет в наличии, но вы можете сделать предзаказ</p>';
        echo '<button data-fancybox="backordermodal" data-src="#backordermodal" class="backorder-btn">Оформить предзаказ</button>';
        get_template_part('template-parts/modal','backorder',['product' => $product]);
        echo '</div>';

        // echo '</div>';
    }
    get_template_part('template-parts/modal','oneclick');
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

add_action('woocommerce_after_cart_item_name', 'extand_product_name_col', 25, 2);

function extand_product_name_col($cart_item, $cart_item_key)
{

    $product_id = $cart_item['data']->get_ID();
    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        'woocommerce_cart_item_remove_link',
        sprintf(
            '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">' . file_get_contents(tailpress_asset('resources/svg/cart_cross.svg')) . ' Удалить</a>',
            esc_url(wc_get_cart_remove_url($cart_item_key)),
            esc_html__('Remove this item', 'woocommerce'),
            esc_attr($product_id),
            esc_attr($cart_item['data']->get_sku())
        ),
        $cart_item_key
    );
}


add_action('woocommerce_before_quantity_input_field', 'truemisha_quantity_minus', 25);
add_action('woocommerce_after_quantity_input_field', 'truemisha_quantity_plus', 25);

function truemisha_quantity_plus()
{
    echo '<button type="button" class="plus">' . file_get_contents(tailpress_asset('resources/svg/plus.svg')) . '</button>';
}

function truemisha_quantity_minus()
{
    echo '<button type="button" class="minus">' . file_get_contents(tailpress_asset('resources/svg/minus.svg')) . '</button>';
}


add_filter('woocommerce_cart_item_price', 'bbloomer_change_cart_table_price_display', 30, 3);

function bbloomer_change_cart_table_price_display($price, $values, $cart_item_key)
{
    $slashed_price = $values['data']->get_price_html();
    $is_on_sale = $values['data']->is_on_sale();
    if ($is_on_sale) {
        $price = $slashed_price;
    }
    return $price;
}


add_filter('woocommerce_product_cross_sells_products_heading', 'bbloomer_translate_may_also_like');

function bbloomer_translate_may_also_like()
{
    return 'Аксессуары';
}
add_filter('woocommerce_cross_sells_total', 'bbloomer_change_cross_sells_product_no');

function bbloomer_change_cross_sells_product_no($columns)
{
    return 4;
}
add_filter('woocommerce_cross_sells_columns', 'bbloomer_change_cross_sells_columns');

function bbloomer_change_cross_sells_columns($columns)
{
    return 4;
}



add_action('woocommerce_after_shop_loop_item_title', 'wp_kama_woocommerce_single_product_summary_action');
function wp_kama_woocommerce_single_product_summary_action()
{
    if (is_cart()) {
        global $product;
        echo '<a class="addtocart add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $product->get_ID() . '&quantity=1">Добавить</a>';
    }
}
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

add_filter('woocommerce_before_shop_loop_item', 'woocommerce_before_shop_loop_item_action');
function woocommerce_before_shop_loop_item_action()
{
    if (is_single()) {
        global $product;
        echo '<a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="' . $product->get_permalink() . '">';
    }
}

add_filter('woocommerce_after_shop_loop_item', 'woocommerce_after_shop_loop_item_action');
function woocommerce_after_shop_loop_item_action()
{
    if (is_single()) {
        echo '</a>';
    }
}

add_filter('woocommerce_before_cart_totals', 'woocommerce_before_cart_totals_action');
function woocommerce_before_cart_totals_action()
{
    echo '</div></div></div><div class="cart_totals_wrapper"><div class="cart_totals">';
}

add_filter('woocommerce_after_cart_totals', 'woocommerce_after_cart_totals_action');
function woocommerce_after_cart_totals_action()
{
    if (wc_coupons_enabled()) {
        echo '<form class="woocommerce-coupon-form" action="' . esc_url(wc_get_cart_url()) . '" method="post">';
        echo '<div class="coupon under-proceed">';
        echo '<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="Промокод" />';
        echo '<button type="submit" class="button" name="apply_coupon" value="' . esc_attr('Apply coupon', 'woocommerce') . '">Применить</button>';
        echo '</div>';
        echo '</form>';
        echo '</div>';
        // get_template_part('template-parts/section','credit');
        echo '</div>';
    }
}


add_filter('woocommerce_proceed_to_checkout', 'woocommerce_proceed_to_checkout_action');
add_filter('woocommerce_review_order_after_submit', 'woocommerce_proceed_to_checkout_action');
function woocommerce_proceed_to_checkout_action()
{
    echo '<div class="control-wrapper">';
    echo '<input id="terms_chkbx" type="checkbox" checked>';
    echo '<label for="terms_chkbx">Согласен с <a href="/privacy-policy/" target="_blank">политикой обработки персональных данных</a></label>';
    echo '</div>';
}


add_filter('gettext', 'my_translate_text');
add_filter('ngettext', 'my_translate_text');
function my_translate_text($translated) {
    $translated = str_ireplace('Подытог', 'Товары', $translated);
    $translated = str_ireplace('Купон', 'Промокод', $translated);
    return $translated;
}


/**
 * Remove all checkout fields
 **/
add_action('woocommerce_checkout_fields', 'fdev_remove_all_checkout_fields', 10, 1);

function fdev_remove_all_checkout_fields($checkout_fields){
    unset($checkout_fields['billing']['billing_last_name']);
    unset($checkout_fields['billing']['billing_company']);
    unset($checkout_fields['billing']['billing_address_2']);
    unset($checkout_fields['billing']['billing_postcode']);
    // unset($checkout_fields['billing']['billing_country']);
    unset($checkout_fields['billing']['billing_state']);
    unset($checkout_fields['billing']['billing_street']);
    unset($checkout_fields['billing']['billing_kv']);
//    unset($checkout_fields['billing']['billing_city']);

    unset($checkout_fields['shipping']['shipping_first_name']);
    unset($checkout_fields['shipping']['shipping_last_name']);
    unset($checkout_fields['shipping']['shipping_company']);
    unset($checkout_fields['shipping']['shipping_address_1']);
    unset($checkout_fields['shipping']['shipping_address_2']);
    unset($checkout_fields['shipping']['shipping_city']);
    unset($checkout_fields['shipping']['shipping_postcode']);
    unset($checkout_fields['shipping']['shipping_country']);
    unset($checkout_fields['shipping']['shipping_state']);
    unset($checkout_fields['shipping']['shipping_street']);
    unset($checkout_fields['shipping']['shipping_kv']);


    $checkout_fields[ 'order' ][ 'order_comments' ][ 'label' ] = 'Комментарий к заказу';
    $checkout_fields[ 'order' ][ 'order_comments' ][ 'placeholder' ] = 'Если есть уточнения по заказу, напишите их тут';
    $checkout_fields[ 'order' ][ 'order_comments' ][ 'rows' ] = 5;

    $checkout_fields[ 'order' ][ 'billing_state' ] = $checkout_fields[ 'billing' ][ 'billing_address_1' ];
    $checkout_fields[ 'order' ][ 'billing_city' ] = $checkout_fields[ 'billing' ][ 'billing_address_1' ];
    $checkout_fields[ 'order' ][ 'billing_address_1' ] = $checkout_fields[ 'billing' ][ 'billing_address_1' ];
    $checkout_fields[ 'order' ][ 'billing_street' ] = $checkout_fields[ 'billing' ][ 'billing_address_1' ];
    $checkout_fields[ 'order' ][ 'billing_kv' ] = $checkout_fields[ 'billing' ][ 'billing_address_1' ];

    // unset($checkout_fields[ 'billing '][ 'billing_country' ]);
    $checkout_fields[ 'billing' ][ 'billing_country' ][ 'default' ] = 'RU';
    // $checkout_fields[ 'shipping' ][ 'shipping_country' ][ 'default' ] = 'RU';

    $checkout_fields[ 'order' ][ 'billing_address_1' ][ 'placeholder' ] = 'Номер дома, название улицы, квартира';
    $checkout_fields[ 'order' ][ 'billing_address_1' ][ 'autocomplete' ] = 'off';

    $checkout_fields[ 'order' ][ 'billing_state' ][ 'label' ] = 'Регион, область';
    $checkout_fields[ 'order' ][ 'billing_state' ][ 'placeholder' ] = 'Укажите ваш регион или область';
    $checkout_fields[ 'order' ][ 'billing_state' ][ 'autocomplete' ] = 'address-level1';

    $checkout_fields[ 'order' ][ 'billing_city' ][ 'label' ] = 'Город';
    $checkout_fields[ 'order' ][ 'billing_city' ][ 'placeholder' ] = 'Укажите ваш город';
    $checkout_fields[ 'order' ][ 'billing_city' ][ 'autocomplete' ] = 'address-level2';


    $checkout_fields[ 'order' ][ 'billing_street' ][ 'label' ] = 'Улица, дом';
    $checkout_fields[ 'order' ][ 'billing_street' ][ 'placeholder' ] = 'Улица и номер дома';
//    $checkout_fields[ 'order' ][ 'billing_street' ][ 'autocomplete' ] = 'street-address';
    $checkout_fields[ 'order' ][ 'billing_street' ][ 'autocomplete' ] = 'off';

    $checkout_fields[ 'order' ][ 'billing_kv' ][ 'label' ] = 'Квартира';
    $checkout_fields[ 'order' ][ 'billing_kv' ][ 'placeholder' ] = 'Номер квартиры';
    $checkout_fields[ 'order' ][ 'billing_kv' ][ 'autocomplete' ] = 'flate-address';

    $checkout_fields[ 'order' ][ 'billing_state' ][ 'priority' ] = 1;
    $checkout_fields[ 'order' ][ 'billing_city' ][ 'priority' ] = 1;
    $checkout_fields[ 'order' ][ 'billing_address_1' ][ 'priority' ] = 4;
    $checkout_fields[ 'order' ][ 'billing_street' ][ 'priority' ] = 2;
    $checkout_fields[ 'order' ][ 'billing_kv' ][ 'priority' ] = 3;

    unset( $checkout_fields[ 'billing' ][ 'billing_address_1' ] );
    unset( $checkout_fields[ 'billing' ][ 'billing_city' ] );
    unset( $checkout_fields[ 'billing' ][ 'billing_state' ] );
    unset( $checkout_fields[ 'billing' ][ 'billing_street' ] );
    unset( $checkout_fields[ 'billing' ][ 'billing_kv' ] );

    $checkout_fields[ 'billing' ][ 'billing_first_name' ][ 'label' ] = 'Имя и фамилия';
    $checkout_fields[ 'billing' ][ 'billing_first_name' ][ 'priority' ] = 1;
    $checkout_fields[ 'billing' ][ 'billing_first_name' ][ 'placeholder' ] = 'Владимир Иванов';
    $checkout_fields[ 'billing' ][ 'billing_phone' ][ 'priority' ] = 2;
    $checkout_fields[ 'billing' ][ 'billing_phone' ][ 'label' ] = 'Мобильный телефон';
    $checkout_fields[ 'billing' ][ 'billing_phone' ][ 'placeholder' ] = '+7 (921) 123-45-67';
    $checkout_fields[ 'billing' ][ 'billing_phone' ][ 'autocomplete' ] = 'off';
    $checkout_fields[ 'billing' ][ 'billing_email' ][ 'priority' ] = 3;
    $checkout_fields[ 'billing' ][ 'billing_email' ][ 'label' ] = 'Электронная почта';
    $checkout_fields[ 'billing' ][ 'billing_email' ][ 'placeholder' ] = 'order@wollmer.ru';
    $checkout_fields[ 'billing' ][ 'billing_email' ][ 'autocomplete' ] = 'off';

    $checkout_fields[ 'order' ][ 'billing_state' ][ 'required' ] = false;
    $checkout_fields[ 'order' ][ 'billing_street' ][ 'required' ] = false;
    $checkout_fields[ 'order' ][ 'billing_kv' ][ 'required' ] = false;
    $checkout_fields[ 'order' ][ 'billing_city' ][ 'required' ] = false;
    $checkout_fields[ 'order' ][ 'billing_address_1' ][ 'required' ] = false;

    return $checkout_fields;

}



function change_woocommerce_field_markup($field, $key, $args, $value) {

    // echo ' = '.$key.' = ';

    $field = str_replace('woocommerce-additional-fields__field-wrapper', 'fields-group', $field);

    $stat = WC()->session->get( 'chosen_shipping_methods' )[0] !== 'flat_rate:2' ? 'cur' : 'pvz';

     $stat_cur = WC()->session->get( 'chosen_shipping_methods' )[0] !== 'flat_rate:2' ? '' : 'selected';
     $stat_pvz = WC()->session->get( 'chosen_shipping_methods' )[0] !== 'flat_rate:1' ? '' : 'selected';

    $stat_cur = $stat === 'pvz' ? '' : 'selected';
    $stat_pvz = $stat === 'cur' ? '' : 'selected';



//     echo '$stat_cur:'.$stat_cur.' $stat_pvz:'.$stat_pvz.' $stat:'.$stat;

     $display_cur = $stat_cur !== '' ? '' : 'style="display:none1"';
     $display_pvz = $stat_pvz !== '' ? '' : 'style="display:none1"';

    $display_cur = $stat === 'cur' ? '' : 'style="display:none2"';
    $display_pvz = $stat === 'pvz' ? '' : 'style="display:none2"';


    if( $key === 'billing_first_name' ) {
        $field_pref = '<div class="fields-group">';
        $field_pref .= '<p class="fields-group-headline">Покупатель</p>';
        $field_pref .= '<div class="fields-wrapper">';
        $field = $field_pref.$field;

    } else if ( $key === 'billing_email' ){
        $field = str_replace('type="email"', 'type="text"', $field);
        $field = $field.'</div></div>';

    } else if( $key === 'order_comments' ) {
        // wp_die();
        $field = '
    <div class="fields-group fields-shipping" id="delivery">
      <div class="tabs fields-wrapper">
        <div '.$display_cur.' id="curier">
        <p class="fields-group-headline delivery-field">Адрес</p>
          '.$field;
    } else if ( $key === 'billing_address_1' ){
        $field = $field.'
        </div>
      </div>
    </div>';
    } else if( $key === 'order_comments___BACK' ) {
        $field = '
    <div class="fields-group fields-shipping" id="delivery">
      <p class="fields-group-headline">Способ получения 1</p>
      <div class="tabs_toggler">
        <a class="tag '.$stat_cur.'" onclick="toggle_ship(this,`curier`)">Курьером</a>
        <a class="tag '.$stat_pvz.'" onclick="toggle_ship(this,`cdek`)">Пункт выдачи</a>
      </div>

      <div class="tabs fields-wrapper 22222">
        <div '.$display_cur.' id="curier">
        <p class="fields-group-headline">Адрес 2</p>
          '.$field;
    } else if ( $key === 'billing_address_1___BACK' ){

        $field = $field.'
    </div>
    <div '.$display_pvz.' id="cdek">
      <div>
			<script type="text/javascript">
				var ourWidjet = new ISDEKWidjet ({
					defaultCity: "auto",
          mode: "pvz",
					cityFrom: "Санкт-Петербург",
					country: "Россия",
          apikey: "927a70a9-1768-4f55-bd6a-c2255bf68c98",
					link: "forpvz",
					path: "https://widget.cdek.ru/widget/scripts/",

          hidedress: true,
          hidecash: true,
          hidedelt: true,
				});

        ourWidjet.binders.add(choosePVZ, "onChoose");

        function choosePVZ(wat) {
            console.log(wat);
            // jQuery("#shipping_method").find("label").html(`Пункт выдачи: <span class="woocommerce-Price-amount amount"><bdi>`+wat.price+`&nbsp;<span class="woocommerce-Price-currencySymbol">₽</span></bdi></span>`);
            jQuery("#billing_city").val(wat.cityName);
            jQuery("#billing_address_1").val("СДЭК, ПВЗ "+wat.id+", "+wat.PVZ.Address);
            jQuery(".CDEK-widget__sidebar-burger").click();
            jQuery("#forpvz").next("p").text("СДЭК, ПВЗ "+wat.id+", "+wat.PVZ.Address);
            jQuery("#shipping_option").val(wat.price);

            jQuery.ajax({
              type: "POST",
              url: wc_checkout_params.ajax_url,
              data: {
                action: "update_shipping_price",
                security: wc_checkout_params.update_order_review_nonce,
                package_hash: "<package_hash_value>",
                shipping_option: wat.price,
              },
              success: function( response ) {
                jQuery("#shipping_method_0_flat_rate2").click();
                jQuery("body").trigger("update_checkout");
                console.log("UPD shipping_option:","'.WC()->session->get( 'shipping_option' ).'");
                console.log("UPD chosen_shipping_methods[0]:","'.WC()->session->get( 'chosen_shipping_methods' )[0].'");
              },
            });
        }
        console.log("shipping_option:","'.WC()->session->get( 'shipping_option' ).'");
        console.log("chosen_shipping_methods[0]:","'.WC()->session->get( 'chosen_shipping_methods' )[0].'");
			</script>
      <input id="shipping_option" name="shipping_option" type="hidden" value="400">
			<div id="forpvz" style="width:100%; height:400px;"></div>
      <p style="padding-top:12px"></p>
      </div>
    </div>
  </div>
</div>
<script src="https://api-maps.yandex.ru/2.1/?apikey=927a70a9-1768-4f55-bd6a-c2255bf68c98&lang=ru_RU" type="text/javascript"></script>
<script>
let map = document.getElementById("map");
let zoom = map.getAttribute("data-zoom");
let long = map.getAttribute("data-long");
let lat = map.getAttribute("data-lat");
function init() {
  var suggestView1 = new ymaps.SuggestView("billing_city", {provider: provider, results: 3});
  var myMap = new ymaps.Map("map", {
    center: [lat, long],
    zoom: zoom
  });
}
ymaps.ready(init);

var arr =   [
  "Москва",
  "Абрамцево, Московская обл.",
  "Алабино, Московская обл.",
  "Апрелевка, Московская обл.",
  "Архангельское, Московская обл.",
  "Ашитково, Московская обл.",
  "Байконур, Московская обл.",
  "Бакшеево, Московская обл.",
  "Балашиха, Московская обл.",
  "Барыбино, Московская обл.",
  "Белоомут, Московская обл.",
  "Белые Столбы, Московская обл.",
  "Бородино, Московская обл.",
  "Бронницы, Московская обл.",
  "Быково, Московская обл.",
  "Валуево, Московская обл.",
  "Вербилки, Московская обл.",
  "Верея, Московская обл.",
  "Видное, Московская обл.",
  "Внуково, Московская обл.",
  "Вождь Пролетариата, Московская обл.",
  "Волоколамск, Московская обл.",
  "Вороново, Московская обл.",
  "Воскресенск, Московская обл.",
  "Восточный, Московская обл.",
  "Востряково, Московская обл.",
  "Высоковск, Московская обл.",
  "Голицино, Московская обл.",
  "Деденево, Московская обл.",
  "Дедовск, Московская обл.",
  "Джержинский, Московская обл.",
  "Дмитров, Московская обл.",
  "Долгопрудный, Московская обл.",
  "Домодедово, Московская обл.",
  "Дорохово, Московская обл.",
  "Дрезна, Московская обл.",
  "Дубки, Московская обл.",
  "Дубна, Московская обл.",
  "Егорьевск, Московская обл.",
  "Железнодорожный, Московская обл.",
  "Жилево, Московская обл.",
  "Жуковский, Московская обл.",
  "Загорск, Московская обл.",
  "Загорянский, Московская обл.",
  "Запрудная, Московская обл.",
  "Зарайск, Московская обл.",
  "Звенигород, Московская обл.",
  "Зеленоград, Московская обл.",
  "Ивантеевка, Московская обл.",
  "Икша, Московская обл.",
  "Ильинский, Московская обл.",
  "Истра, Московская обл.",
  "Калининград, Московская обл.",
  "Кашира, Московская обл.",
  "Керва, Московская обл.",
  "Климовск, Московская обл.",
  "Клин, Московская обл.",
  "Клязьма, Московская обл.",
  "Кожино, Московская обл.",
  "Кокошкино, Московская обл.",
  "Коломна, Московская обл.",
  "Колюбакино, Московская обл.",
  "Королев, Московская обл.",
  "Косино, Московская обл.",
  "Котельники, Московская обл.",
  "Красково, Московская обл.",
  "Красноармейск, Московская обл.",
  "Красногорск, Московская обл.",
  "Краснозаводск, Московская обл.",
  "Краснознаменск, Московская обл.",
  "Красный Ткач, Московская обл.",
  "Крюково, Московская обл.",
  "Кубинка, Московская обл.",
  "Купавна, Московская обл.",
  "Куровское, Московская обл.",
  "Лесной Городок, Московская обл.",
  "Ликино-Дулево, Московская обл.",
  "Лобня, Московская обл.",
  "Лопатинский, Московская обл.",
  "Лосино-Петровский, Московская обл.",
  "Лотошино, Московская обл.",
  "Лукино, Московская обл.",
  "Луховицы, Московская обл.",
  "Лыткарино, Московская обл.",
  "Львовский, Московская обл.",
  "Люберцы, Московская обл.",
  "Малаховка, Московская обл.",
  "Михайловское, Московская обл.",
  "Михнево, Московская обл.",
  "Можайск, Московская обл.",
  "Монино, Московская обл.",
  "Муханово, Московская обл.",
  "Мытищи, Московская обл.",
  "Нарофоминск, Московская обл.",
  "Нахабино, Московская обл.",
  "Некрасовка, Московская обл.",
  "Немчиновка, Московская обл.",
  "Новобратцевский, Московская обл.",
  "Новоподрезково, Московская обл.",
  "Ногинск, Московская обл.",
  "Обухово, Московская обл.",
  "Одинцово, Московская обл.",
  "Ожерелье, Московская обл.",
  "Озеры, Московская обл.",
  "Октябрьский, Московская обл.",
  "Опалиха, Московская обл.",
  "Орехово-Зуево, Московская обл.",
  "Павловский Посад, Московская обл.",
  "Первомайский, Московская обл.",
  "Пески, Московская обл.",
  "Пироговский, Московская обл.",
  "Подольск, Московская обл.",
  "Полушкино, Московская обл.",
  "Правдинский, Московская обл.",
  "Привокзальный, Московская обл.",
  "Пролетарский, Московская обл.",
  "Протвино, Московская обл.",
  "Пушкино, Московская обл.",
  "Пущино, Московская обл.",
  "Радовицкий, Московская обл.",
  "Раменское, Московская обл.",
  "Реутов, Московская обл.",
  "Решетниково, Московская обл.",
  "Родники, Московская обл.",
  "Рошаль, Московская обл.",
  "Рублево, Московская обл.",
  "Руза, Московская обл.",
  "Салтыковка, Московская обл.",
  "Северный, Московская обл.",
  "Сергиев Посад, Московская обл.",
  "Серебряные Пруды, Московская обл.",
  "Серпухов, Московская обл.",
  "Солнечногорск, Московская обл.",
  "Солнцево, Московская обл.",
  "Софрино, Московская обл.",
  "Старая Купавна, Московская обл.",
  "Старбеево, Московская обл.",
  "Ступино, Московская обл.",
  "Сходня, Московская обл.",
  "Талдом, Московская обл.",
  "Текстильщик, Московская обл.",
  "Темпы, Московская обл.",
  "Тишково, Московская обл.",
  "Томилино, Московская обл.",
  "Троицк, Московская обл.",
  "Туголесский Бор, Московская обл.",
  "Тучково, Московская обл.",
  "Уваровка, Московская обл.",
  "Удельная, Московская обл.",
  "Успенское, Московская обл.",
  "Фирсановка, Московская обл.",
  "Фосфоритный, Московская обл.",
  "Фрязино, Московская обл.",
  "Фряново, Московская обл.",
  "Химки, Московская обл.",
  "Хорлово, Московская обл.",
  "Хотьково, Московская обл.",
  "Черкизово, Московская обл.",
  "Черноголовка, Московская обл.",
  "Черусти, Московская обл.",
  "Чехов, Московская обл.",
  "Шарапово, Московская обл.",
  "Шатура, Московская обл.",
  "Шатурторф, Московская обл.",
  "Шаховская, Московская обл.",
  "Шереметьевский, Московская обл.",
  "Щелково, Московская обл.",
  "Щербинка, Московская обл.",
  "Электрогорск, Московская обл.",
  "Электросталь, Московская обл.",
  "Электроугли, Московская обл.",
  "Яхрома, Московская обл.",
  "Санкт-Петербург",
  "Александровская, Ленинградская область",
  "Бокситогорск, Ленинградская область",
  "Большая Ижора, Ленинградская область",
  "Будогощь, Ленинградская область",
  "Вознесенье, Ленинградская область",
  "Волосово, Ленинградская область",
  "Волхов, Ленинградская область",
  "Всеволожск, Ленинградская область",
  "Выборг, Ленинградская область",
  "Вырица, Ленинградская область",
  "Высоцк, Ленинградская область",
  "Гатчина, Ленинградская область",
  "Дружная Горка, Ленинградская область",
  "Дубровка, Ленинградская область",
  "Ефимовский, Ленинградская область",
  "Зеленогорск, Ленинградская область",
  "Ивангород, Ленинградская область",
  "Каменногорск, Ленинградская область",
  "Кикерино, Ленинградская область",
  "Кингисепп, Ленинградская область",
  "Кириши, Ленинградская область",
  "Кировск, Ленинградская область",
  "Кобринское, Ленинградская область",
  "Колпино, Ленинградская область",
  "Коммунар, Ленинградская область",
  "Кронштадт, Ленинградская область",
  "Лисий Нос, Ленинградская область",
  "Лодейное Поле, Ленинградская область",
  "Ломоносов, Ленинградская область",
  "Луга, Ленинградская область",
  "Павловск, Ленинградская область",
  "Парголово, Ленинградская область",
  "Петродворец, Ленинградская область",
  "Пикалёво, Ленинградская область",
  "Подпорожье, Ленинградская область",
  "Приозерск, Ленинградская область",
  "Пушкин, Ленинградская область",
  "Сестрорецк, Ленинградская область",
  "Сланцы, Ленинградская область",
  "Сосновый Бор, Ленинградская область",
  "Тихвин, Ленинградская область",
  "Тосно, Ленинградская область",
  "Шлиссельбург, Ленинградская область",
  "Адыгейск, Адыгея",
  "Майкоп, Адыгея",
  "Акташ, Алтайский край",
  "Акутиха, Алтайский край",
  "Алейск, Алтайский край",
  "Алтайский, Алтайский край",
  "Баево, Алтайский край",
  "Барнаул, Алтайский край",
  "Белово, Алтайский край",
  "Белокуриха, Алтайский край",
  "Белоярск, Алтайский край",
  "Бийск, Алтайский край",
  "Благовещенск, Алтайский край",
  "Боровлянка, Алтайский край",
  "Бурла, Алтайский край",
  "Бурсоль, Алтайский край",
  "Волчиха, Алтайский край",
  "Горно-Алтайск, Алтайский край",
  "Горняк, Алтайский край",
  "Ельцовка, Алтайский край",
  "Залесово, Алтайский край",
  "Заринск, Алтайский край",
  "Заток, Алтайский край",
  "Змеиногорск, Алтайский край",
  "Камень-на-Оби, Алтайский край",
  "Ключи, Алтайский край",
  "Кош-Агач, Алтайский край",
  "Красногорское, Алтайский край",
  "Краснощеково, Алтайский край",
  "Кулунда, Алтайский край",
  "Кытманово, Алтайский край",
  "Мамонтово, Алтайский край",
  "Новичиха, Алтайский край",
  "Новоалтайск, Алтайский край",
  "Онгудай, Алтайский край",
  "Павловск, Алтайский край",
  "Петропавловское, Алтайский край",
  "Поспелиха, Алтайский край",
  "Ребриха, Алтайский край",
  "Родино, Алтайский край",
  "Рубцовск, Алтайский край",
  "Славгород, Алтайский край",
  "Смоленское, Алтайский край",
  "Солонешное, Алтайский край",
  "Солтон, Алтайский край",
  "Староаллейское, Алтайский край",
  "Табуны, Алтайский край",
  "Тальменка, Алтайский край",
  "Топчиха, Алтайский край",
  "Троицкое, Алтайский край",
  "Турочак, Алтайский край",
  "Тюменцево, Алтайский край",
  "Угловское, Алтайский край",
  "Усть-Калманка, Алтайский край",
  "Усть-Кан, Алтайский край",
  "Усть-Кокса, Алтайский край",
  "Усть-Улаган, Алтайский край",
  "Усть-Чарышская Пристань, Алтайский край",
  "Хабары, Алтайский край",
  "Целинное, Алтайский край",
  "Чарышское, Алтайский край",
  "Шебалино, Алтайский край",
  "Шелаболиха, Алтайский край",
  "Шипуново, Алтайский край",
  "Айгунь, Амурская обл.",
  "Архара, Амурская обл.",
  "Белогорск, Амурская обл.",
  "Благовещенск (Амурская обл.), Амурская обл.",
  "Бурея, Амурская обл.",
  "Возжаевка, Амурская обл.",
  "Екатеринославка, Амурская обл.",
  "Ерофей Павлович, Амурская обл.",
  "Завитинск, Амурская обл.",
  "Зея, Амурская обл.",
  "Златоустовск, Амурская обл.",
  "Ивановка, Амурская обл.",
  "Коболдо, Амурская обл.",
  "Магдагачи, Амурская обл.",
  "Новобурейский, Амурская обл.",
  "Поярково, Амурская обл.",
  "Райчихинск, Амурская обл.",
  "Ромны, Амурская обл.",
  "Свободный, Амурская обл.",
  "Серышево, Амурская обл.",
  "Сковородино, Амурская обл.",
  "Стойба, Амурская обл.",
  "Тамбовка, Амурская обл.",
  "Тында, Амурская обл.",
  "Шимановск, Амурская обл.",
  "Экимчан, Амурская обл.",
  "Ядрино, Амурская обл.",
  "Амдерма, Архангельская обл.",
  "Архангельск, Архангельская обл.",
  "Березник, Архангельская обл.",
  "Вельск, Архангельская обл.",
  "Верхняя Тойма, Архангельская обл.",
  "Волошка, Архангельская обл.",
  "Вычегодский, Архангельская обл.",
  "Емца, Архангельская обл.",
  "Илеза, Архангельская обл.",
  "Ильинско-Подомское, Архангельская обл.",
  "Каргополь, Архангельская обл.",
  "Карпогоры, Архангельская обл.",
  "Кодино, Архангельская обл.",
  "Коноша, Архангельская обл.",
  "Коряжма, Архангельская обл.",
  "Котлас, Архангельская обл.",
  "Красноборск, Архангельская обл.",
  "Лешуконское, Архангельская обл.",
  "Мезень, Архангельская обл.",
  "Мирный, Архангельская обл.",
  "Нарьян-Мар, Архангельская обл.",
  "Новодвинск, Архангельская обл.",
  "Няндома, Архангельская обл.",
  "Онега, Архангельская обл.",
  "Пинега, Архангельская обл.",
  "Плесецк, Архангельская обл.",
  "Северодвинск, Архангельская обл.",
  "Сольвычегодск, Архангельская обл.",
  "Холмогоры, Архангельская обл.",
  "Шенкурск, Архангельская обл.",
  "Яренск, Архангельская обл.",
  "Астрахань, Астраханская обл.",
  "Ахтубинск, Астраханская обл.",
  "Верхний Баскунчак, Астраханская обл.",
  "Володарский, Астраханская обл.",
  "Енотаевка, Астраханская обл.",
  "Икряное, Астраханская обл.",
  "Камызяк, Астраханская обл.",
  "Капустин Яр, Астраханская обл.",
  "Красный Яр, Астраханская обл.",
  "Лиман, Астраханская обл.",
  "Началово, Астраханская обл.",
  "Харабали, Астраханская обл.",
  "Черный Яр, Астраханская обл.",
  "Аксаково, Башкортостан(Башкирия)",
  "Амзя, Башкортостан(Башкирия)",
  "Аскино, Башкортостан(Башкирия)",
  "Баймак, Башкортостан(Башкирия)",
  "Бакалы, Башкортостан(Башкирия)",
  "Белебей, Башкортостан(Башкирия)",
  "Белорецк, Башкортостан(Башкирия)",
  "Бижбуляк, Башкортостан(Башкирия)",
  "Бирск, Башкортостан(Башкирия)",
  "Благовещенск, Башкортостан(Башкирия)",
  "Большеустьикинское, Башкортостан(Башкирия)",
  "Бураево, Башкортостан(Башкирия)",
  "Верхнеяркеево, Башкортостан(Башкирия)",
  "Верхние Киги, Башкортостан(Башкирия)",
  "Верхние Татышлы, Башкортостан(Башкирия)",
  "Верхний Авзян, Башкортостан(Башкирия)",
  "Давлеканово, Башкортостан(Башкирия)",
  "Дуван, Башкортостан(Башкирия)",
  "Дюртюли, Башкортостан(Башкирия)",
  "Ермекеево, Башкортостан(Башкирия)",
  "Ермолаево, Башкортостан(Башкирия)",
  "Зилаир, Башкортостан(Башкирия)",
  "Зирган, Башкортостан(Башкирия)",
  "Иглино, Башкортостан(Башкирия)",
  "Инзер, Башкортостан(Башкирия)",
  "Исянгулово, Башкортостан(Башкирия)",
  "Ишимбай, Башкортостан(Башкирия)",
  "Кананикольское, Башкортостан(Башкирия)",
  "Кандры, Башкортостан(Башкирия)",
  "Караидель, Башкортостан(Башкирия)",
  "Караидельский, Башкортостан(Башкирия)",
  "Киргиз-Мияки, Башкортостан(Башкирия)",
  "Красноусольский, Башкортостан(Башкирия)",
  "Кумертау, Башкортостан(Башкирия)",
  "Кушнаренково, Башкортостан(Башкирия)",
  "Малояз, Башкортостан(Башкирия)",
  "Мелеуз, Башкортостан(Башкирия)",
  "Месягутово, Башкортостан(Башкирия)",
  "Мраково, Башкортостан(Башкирия)",
  "Нефтекамск, Башкортостан(Башкирия)",
  "Октябрьский, Башкортостан(Башкирия)",
  "Раевский, Башкортостан(Башкирия)",
  "Салават, Башкортостан(Башкирия)",
  "Сибай, Башкортостан(Башкирия)",
  "Старобалтачево, Башкортостан(Башкирия)",
  "Старосубхангулово, Башкортостан(Башкирия)",
  "Стерлибашево, Башкортостан(Башкирия)",
  "Стерлитамак, Башкортостан(Башкирия)",
  "Туймазы, Башкортостан(Башкирия)",
  "Уфа, Башкортостан(Башкирия)",
  "Учалы, Башкортостан(Башкирия)",
  "Федоровка, Башкортостан(Башкирия)",
  "Чекмагуш, Башкортостан(Башкирия)",
  "Чишмы, Башкортостан(Башкирия)",
  "Шаран, Башкортостан(Башкирия)",
  "Янаул, Башкортостан(Башкирия)",
  "Алексеевка, Белгородская обл.",
  "Белгород, Белгородская обл.",
  "Борисовка, Белгородская обл.",
  "Валуйки, Белгородская обл.",
  "Вейделевка, Белгородская обл.",
  "Волоконовка, Белгородская обл.",
  "Грайворон, Белгородская обл.",
  "Губкин, Белгородская обл.",
  "Ивня, Белгородская обл.",
  "Короча, Белгородская обл.",
  "Красногвардейское, Белгородская обл.",
  "Новый Оскол, Белгородская обл.",
  "Ракитное, Белгородская обл.",
  "Ровеньки, Белгородская обл.",
  "Старый Оскол, Белгородская обл.",
  "Строитель, Белгородская обл.",
  "Чернянка, Белгородская обл.",
  "Шебекино, Белгородская обл.",
  "Алтухово, Брянская обл.",
  "Белая Березка, Брянская обл.",
  "Белые Берега, Брянская обл.",
  "Большое Полпино, Брянская обл.",
  "Брянск, Брянская обл.",
  "Бытошь, Брянская обл.",
  "Выгоничи, Брянская обл.",
  "Вышков, Брянская обл.",
  "Гордеевка, Брянская обл.",
  "Дубровка, Брянская обл.",
  "Дятьково, Брянская обл.",
  "Жирятино, Брянская обл.",
  "Жуковка, Брянская обл.",
  "Злынка, Брянская обл.",
  "Ивот, Брянская обл.",
  "Карачев, Брянская обл.",
  "Клетня, Брянская обл.",
  "Климово, Брянская обл.",
  "Клинцы, Брянская обл.",
  "Кокаревка, Брянская обл.",
  "Комаричи, Брянская обл.",
  "Красная Гора, Брянская обл.",
  "Локоть, Брянская обл.",
  "Мглин, Брянская обл.",
  "Навля, Брянская обл.",
  "Новозыбков, Брянская обл.",
  "Погар, Брянская обл.",
  "Почеп, Брянская обл.",
  "Ржаница, Брянская обл.",
  "Рогнедино, Брянская обл.",
  "Севск, Брянская обл.",
  "Стародуб, Брянская обл.",
  "Суземка, Брянская обл.",
  "Сураж, Брянская обл.",
  "Трубчевск, Брянская обл.",
  "Унеча, Брянская обл.",
  "Бабушкин, Бурятия",
  "Багдарин, Бурятия",
  "Баргузин, Бурятия",
  "Баянгол, Бурятия",
  "Бичура, Бурятия",
  "Выдрино, Бурятия",
  "Гусиное Озеро, Бурятия",
  "Гусиноозерск, Бурятия",
  "Заиграево, Бурятия",
  "Закаменск, Бурятия",
  "Иволгинск, Бурятия",
  "Илька, Бурятия",
  "Кабанск, Бурятия",
  "Каменск, Бурятия",
  "Кижинга, Бурятия",
  "Курумкан, Бурятия",
  "Кырен, Бурятия",
  "Кяхта, Бурятия",
  "Монды, Бурятия",
  "Мухоршибирь, Бурятия",
  "Нижнеангарск, Бурятия",
  "Орлик, Бурятия",
  "Петропавловка, Бурятия",
  "Романовка, Бурятия",
  "Северобайкальск, Бурятия",
  "Селенгинск, Бурятия",
  "Сосново-Озерское, Бурятия",
  "Таксимо, Бурятия",
  "Турунтаево, Бурятия",
  "Улан-Удэ, Бурятия",
  "Хоринск, Бурятия",
  "Александров, Владимирская обл.",
  "Андреево, Владимирская обл.",
  "Анопино, Владимирская обл.",
  "Бавлены, Владимирская обл.",
  "Балакирево, Владимирская обл.",
  "Боголюбово, Владимирская обл.",
  "Великодворский, Владимирская обл.",
  "Вербовский, Владимирская обл.",
  "Владимир, Владимирская обл.",
  "Вязники, Владимирская обл.",
  "Городищи, Владимирская обл.",
  "Гороховец, Владимирская обл.",
  "Гусевский, Владимирская обл.",
  "Гусь Хрустальный, Владимирская обл.",
  "Золотково, Владимирская обл.",
  "Иванищи, Владимирская обл.",
  "Камешково, Владимирская обл.",
  "Карабаново, Владимирская обл.",
  "Киржач, Владимирская обл.",
  "Ковров, Владимирская обл.",
  "Кольчугино, Владимирская обл.",
  "Красная Горбатка, Владимирская обл.",
  "Меленки, Владимирская обл.",
  "Муром, Владимирская обл.",
  "Петушки, Владимирская обл.",
  "Покров, Владимирская обл.",
  "Собинка, Владимирская обл.",
  "Судогда, Владимирская обл.",
  "Суздаль, Владимирская обл.",
  "Юрьев-Польский, Владимирская обл.",
  "Алексеевская, Волгоградская обл.",
  "Алущевск, Волгоградская обл.",
  "Быково, Волгоградская обл.",
  "Волгоград, Волгоградская обл.",
  "Волжский, Волгоградская обл.",
  "Городище, Волгоградская обл.",
  "Дубовка, Волгоградская обл.",
  "Елань, Волгоградская обл.",
  "Жирновск, Волгоградская обл.",
  "Иловля, Волгоградская обл.",
  "Калач-на-Дону, Волгоградская обл.",
  "Камышин, Волгоградская обл.",
  "Кириллов, Волгоградская обл.",
  "Клетский, Волгоградская обл.",
  "Котельниково, Волгоградская обл.",
  "Котово, Волгоградская обл.",
  "Кумылженская, Волгоградская обл.",
  "Ленинск, Волгоградская обл.",
  "Михайловка, Волгоградская обл.",
  "Нехаевский, Волгоградская обл.",
  "Николаевск, Волгоградская обл.",
  "Новоаннинский, Волгоградская обл.",
  "Новониколаевский, Волгоградская обл.",
  "Ольховка, Волгоградская обл.",
  "Палласовка, Волгоградская обл.",
  "Рудня, Волгоградская обл.",
  "Светлый Яр, Волгоградская обл.",
  "Серафимович, Волгоградская обл.",
  "Средняя Ахтуба, Волгоградская обл.",
  "Сталинград, Волгоградская обл.",
  "Старая Полтавка, Волгоградская обл.",
  "Суровикино, Волгоградская обл.",
  "Урюпинск, Волгоградская обл.",
  "Фролово, Волгоградская обл.",
  "Чернышковский, Волгоградская обл.",
  "Бабаево, Вологодская обл.",
  "Белозерск, Вологодская обл.",
  "Великий Устюг, Вологодская обл.",
  "Верховажье, Вологодская обл.",
  "Вожега, Вологодская обл.",
  "Вологда, Вологодская обл.",
  "Вохтога, Вологодская обл.",
  "Вытегра, Вологодская обл.",
  "Грязовец, Вологодская обл.",
  "Кадников, Вологодская обл.",
  "Кадуй, Вологодская обл.",
  "Кичменгский Городок, Вологодская обл.",
  "Липин Бор, Вологодская обл.",
  "Никольск, Вологодская обл.",
  "Нюксеница, Вологодская обл.",
  "Сокол, Вологодская обл.",
  "Сямжа, Вологодская обл.",
  "Тарногский Городок, Вологодская обл.",
  "Тотьма, Вологодская обл.",
  "Устюжна, Вологодская обл.",
  "Харовск, Вологодская обл.",
  "Чагода, Вологодская обл.",
  "Череповец, Вологодская обл.",
  "Шексна, Вологодская обл.",
  "Шуйское, Вологодская обл.",
  "Анна, Воронежская обл.",
  "Бобров, Воронежская обл.",
  "Богучар, Воронежская обл.",
  "Борисоглебск, Воронежская обл.",
  "Бутурлиновка, Воронежская обл.",
  "Верхний Мамон, Воронежская обл.",
  "Верхняя Хава, Воронежская обл.",
  "Воробьевка, Воронежская обл.",
  "Воронеж, Воронежская обл.",
  "Грибановский, Воронежская обл.",
  "Давыдовка, Воронежская обл.",
  "Елань-Коленовский, Воронежская обл.",
  "Калач, Воронежская обл.",
  "Кантемировка, Воронежская обл.",
  "Лиски, Воронежская обл.",
  "Нижнедевицк, Воронежская обл.",
  "Новая Усмань, Воронежская обл.",
  "Новохоперск, Воронежская обл.",
  "Ольховатка, Воронежская обл.",
  "Острогожск, Воронежская обл.",
  "Павловск, Воронежская обл.",
  "Панино, Воронежская обл.",
  "Петропавловка, Воронежская обл.",
  "Поворино, Воронежская обл.",
  "Подгоренский, Воронежская обл.",
  "Рамонь, Воронежская обл.",
  "Репьевка, Воронежская обл.",
  "Россошь, Воронежская обл.",
  "Семилуки, Воронежская обл.",
  "Таловая, Воронежская обл.",
  "Терновка, Воронежская обл.",
  "Хохольский, Воронежская обл.",
  "Эртиль, Воронежская обл.",
  "нововоронеж, Воронежская обл.",
  "Агвали, Дагестан",
  "Акуша, Дагестан",
  "Ахты, Дагестан",
  "Ачису, Дагестан",
  "Бабаюрт, Дагестан",
  "Бежта, Дагестан",
  "Ботлих, Дагестан",
  "Буйнакск, Дагестан",
  "Вачи, Дагестан",
  "Гергебиль, Дагестан",
  "Гуниб, Дагестан",
  "Дагестанские Огни, Дагестан",
  "Дербент, Дагестан",
  "Дылым, Дагестан",
  "Ершовка, Дагестан",
  "Избербаш, Дагестан",
  "Карабудахкент, Дагестан",
  "Карата, Дагестан",
  "Каспийск, Дагестан",
  "Касумкент, Дагестан",
  "Кизилюрт, Дагестан",
  "Кизляр, Дагестан",
  "Кочубей, Дагестан",
  "Кумух, Дагестан",
  "Курах, Дагестан",
  "Магарамкент, Дагестан",
  "Маджалис, Дагестан",
  "Махачкала, Дагестан",
  "Мехельта, Дагестан",
  "Новолакское, Дагестан",
  "Рутул, Дагестан",
  "Советское, Дагестан",
  "Тарумовка, Дагестан",
  "Терекли-Мектеб, Дагестан",
  "Тлярата, Дагестан",
  "Тпиг, Дагестан",
  "Уркарах, Дагестан",
  "Хасавюрт, Дагестан",
  "Хив, Дагестан",
  "Хунзах, Дагестан",
  "Цуриб, Дагестан",
  "Южно-Сухокумск, Дагестан",
  "Биробиджан, Еврейская обл.",
  "Архиповка, Ивановская обл.",
  "Верхний Ландех, Ивановская обл.",
  "Вичуга, Ивановская обл.",
  "Гаврилов Посад, Ивановская обл.",
  "Долматовский, Ивановская обл.",
  "Дуляпино, Ивановская обл.",
  "Заволжск, Ивановская обл.",
  "Заречный, Ивановская обл.",
  "Иваново, Ивановская обл.",
  "Иваньковский, Ивановская обл.",
  "Ильинское-Хованское, Ивановская обл.",
  "Каминский, Ивановская обл.",
  "Кинешма, Ивановская обл.",
  "Комсомольск, Ивановская обл.",
  "Кохма, Ивановская обл.",
  "Лух, Ивановская обл.",
  "Палех, Ивановская обл.",
  "Пестяки, Ивановская обл.",
  "Приволжск, Ивановская обл.",
  "Пучеж, Ивановская обл.",
  "Родники, Ивановская обл.",
  "Савино, Ивановская обл.",
  "Сокольское, Ивановская обл.",
  "Тейково, Ивановская обл.",
  "Фурманов, Ивановская обл.",
  "Шуя, Ивановская обл.",
  "Южа, Ивановская обл.",
  "Юрьевец, Ивановская обл.",
  "Алексеевск, Иркутская обл.",
  "Алзамай, Иркутская обл.",
  "Алыгжер, Иркутская обл.",
  "Ангарск, Иркутская обл.",
  "Артемовский, Иркутская обл.",
  "Атагай, Иркутская обл.",
  "Байкал, Иркутская обл.",
  "Байкальск, Иркутская обл.",
  "Балаганск, Иркутская обл.",
  "Баяндай, Иркутская обл.",
  "Бирюсинск, Иркутская обл.",
  "Бодайбо, Иркутская обл.",
  "Большая Речка, Иркутская обл.",
  "Большой Луг, Иркутская обл.",
  "Бохан, Иркутская обл.",
  "Братск, Иркутская обл.",
  "Видим, Иркутская обл.",
  "Витимский, Иркутская обл.",
  "Вихоревка, Иркутская обл.",
  "Еланцы, Иркутская обл.",
  "Ербогачен, Иркутская обл.",
  "Железногорск-Илимский, Иркутская обл.",
  "Жигалово, Иркутская обл.",
  "Забитуй, Иркутская обл.",
  "Залари, Иркутская обл.",
  "Звездный, Иркутская обл.",
  "Зима, Иркутская обл.",
  "Иркутск, Иркутская обл.",
  "Казачинское, Иркутская обл.",
  "Качуг, Иркутская обл.",
  "Квиток, Иркутская обл.",
  "Киренск, Иркутская обл.",
  "Куйтун, Иркутская обл.",
  "Култук, Иркутская обл.",
  "Кутулик, Иркутская обл.",
  "Мама, Иркутская обл.",
  "Нижнеудинск, Иркутская обл.",
  "Оса, Иркутская обл.",
  "Саянск, Иркутская обл.",
  "Слюдянка, Иркутская обл.",
  "Тайшет, Иркутская обл.",
  "Тулун, Иркутская обл.",
  "Усолье-Сибирское, Иркутская обл.",
  "Усть-Илимск, Иркутская обл.",
  "Усть-Кут, Иркутская обл.",
  "Усть-Ордынский, Иркутская обл.",
  "Усть-Уда, Иркутская обл.",
  "Черемхово, Иркутская обл.",
  "Чунский, Иркутская обл.",
  "Шелехов, Иркутская обл.",
  "Баксан, Кабардино-Балкария",
  "Майский, Кабардино-Балкария",
  "Нальчик, Кабардино-Балкария",
  "Нарткала, Кабардино-Балкария",
  "Прохладный, Кабардино-Балкария",
  "Советское, Кабардино-Балкария",
  "Терек, Кабардино-Балкария",
  "Тырныауз, Кабардино-Балкария",
  "Чегем-Первый, Кабардино-Балкария",
  "Багратионовск, Калининградская обл.",
  "Балтийск, Калининградская обл.",
  "Гвардейск, Калининградская обл.",
  "Гурьевск, Калининградская обл.",
  "Гусев, Калининградская обл.",
  "Железнодорожный, Калининградская обл.",
  "Зеленоградск, Калининградская обл.",
  "Знаменск, Калининградская обл.",
  "Кёнигсберг, Калининградская обл.",
  "Калининград, Калининградская обл.",
  "Кенисберг, Калининградская обл.",
  "Краснознаменск, Калининградская обл.",
  "Мамоново, Калининградская обл.",
  "Неман, Калининградская обл.",
  "Нестеров, Калининградская обл.",
  "Озерск, Калининградская обл.",
  "Полесск, Калининградская обл.",
  "Правдинск, Калининградская обл.",
  "Светлогорск, Калининградская обл.",
  "Светлый, Калининградская обл.",
  "Славск, Калининградская обл.",
  "Советск, Калининградская обл.",
  "Черняховск, Калининградская обл.",
  "Аршань, Калмыкия",
  "Каспийский, Калмыкия",
  "Комсомольский, Калмыкия",
  "Малые Дербеты, Калмыкия",
  "Приютное, Калмыкия",
  "Советское, Калмыкия",
  "Троицкое, Калмыкия",
  "Утта, Калмыкия",
  "Цаган-Аман, Калмыкия",
  "Элиста, Калмыкия",
  "Юста, Калмыкия",
  "Яшалта, Калмыкия",
  "Яшкуль, Калмыкия",
  "Бабынино, Калужская обл.",
  "Балабаново, Калужская обл.",
  "Барятино, Калужская обл.",
  "Белоусово, Калужская обл.",
  "Бетлица, Калужская обл.",
  "Боровск, Калужская обл.",
  "Дугна, Калужская обл.",
  "Дудоровский, Калужская обл.",
  "Думиничи, Калужская обл.",
  "Еленский, Калужская обл.",
  "Жиздра, Калужская обл.",
  "Износки, Калужская обл.",
  "Калуга, Калужская обл.",
  "Киров, Калужская обл.",
  "Козельск, Калужская обл.",
  "Кондрово, Калужская обл.",
  "Людиново, Калужская обл.",
  "Малоярославец, Калужская обл.",
  "Медынь, Калужская обл.",
  "Мещовск, Калужская обл.",
  "Мосальск, Калужская обл.",
  "Обнинск, Калужская обл.",
  "Перемышль, Калужская обл.",
  "Спас-Деменск, Калужская обл.",
  "Сухиничи, Калужская обл.",
  "Таруса, Калужская обл.",
  "Ульяново, Калужская обл.",
  "Ферзиково, Калужская обл.",
  "Хвастовичи, Калужская обл.",
  "Юхнов, Калужская обл.",
  "Атласово, Камчатская обл.",
  "Аянка, Камчатская обл.",
  "Большерецк, Камчатская обл.",
  "Вилючинск, Камчатская обл.",
  "Елизово, Камчатская обл.",
  "Ильпырский, Камчатская обл.",
  "Каменское, Камчатская обл.",
  "Кировский, Камчатская обл.",
  "Ключи, Камчатская обл.",
  "Крапивная, Камчатская обл.",
  "Мильково, Камчатская обл.",
  "Никольское, Камчатская обл.",
  "Озерновский, Камчатская обл.",
  "Оссора, Камчатская обл.",
  "Палана, Камчатская обл.",
  "Парень, Камчатская обл.",
  "Пахачи, Камчатская обл.",
  "Петропавловск-Камчатский, Камчатская обл.",
  "Тигиль, Камчатская обл.",
  "Тиличики, Камчатская обл.",
  "Усть-Большерецк, Камчатская обл.",
  "Усть-Камчатск, Камчатская обл.",
  "Амбарный, Карелия",
  "Беломорск, Карелия",
  "Валаам, Карелия",
  "Вирандозеро, Карелия",
  "Гирвас, Карелия",
  "Деревянка, Карелия",
  "Идель, Карелия",
  "Ильинский, Карелия",
  "Импалахти, Карелия",
  "Калевала, Карелия",
  "Кемь, Карелия",
  "Кестеньга, Карелия",
  "Кондопога, Карелия",
  "Костомукша, Карелия",
  "Лахденпохья, Карелия",
  "Лоухи, Карелия",
  "Медвежьегорск, Карелия",
  "Муезерский, Карелия",
  "Олонец, Карелия",
  "Петрозаводск, Карелия",
  "Питкяранта, Карелия",
  "Повенец, Карелия",
  "Пряжа, Карелия",
  "Пудож, Карелия",
  "Сегежа, Карелия",
  "Сортавала, Карелия",
  "Софпорог, Карелия",
  "Суоярви, Карелия",
  "Анжеро-Судженск, Кемеровская обл.",
  "Барзас, Кемеровская обл.",
  "Белово, Кемеровская обл.",
  "Белогорск, Кемеровская обл.",
  "Березовский, Кемеровская обл.",
  "Грамотеино, Кемеровская обл.",
  "Гурьевск, Кемеровская обл.",
  "Ижморский, Кемеровская обл.",
  "Итатский, Кемеровская обл.",
  "Калтан, Кемеровская обл.",
  "Кедровка, Кемеровская обл.",
  "Кемерово, Кемеровская обл.",
  "Киселевск, Кемеровская обл.",
  "Крапивинский, Кемеровская обл.",
  "Ленинск-Кузнецкий, Кемеровская обл.",
  "Мариинск, Кемеровская обл.",
  "Междуреченск, Кемеровская обл.",
  "Мыски, Кемеровская обл.",
  "Новокузнецк, Кемеровская обл.",
  "Осинники, Кемеровская обл.",
  "Прокопьевск, Кемеровская обл.",
  "Промышленная, Кемеровская обл.",
  "Тайга, Кемеровская обл.",
  "Таштагол, Кемеровская обл.",
  "Тисуль, Кемеровская обл.",
  "Топки, Кемеровская обл.",
  "Тяжинский, Кемеровская обл.",
  "Юрга, Кемеровская обл.",
  "Яшкино, Кемеровская обл.",
  "Яя, Кемеровская обл.",
  "Арбаж, Кировская обл.",
  "Аркуль, Кировская обл.",
  "Белая Холуница, Кировская обл.",
  "Богородское, Кировская обл.",
  "Боровой, Кировская обл.",
  "Верхошижемье, Кировская обл.",
  "Вятские Поляны, Кировская обл.",
  "Зуевка, Кировская обл.",
  "Каринторф, Кировская обл.",
  "Кикнур, Кировская обл.",
  "Кильмезь, Кировская обл.",
  "Киров, Кировская обл.",
  "Кирово-Чепецк, Кировская обл.",
  "Кирс, Кировская обл.",
  "Кобра, Кировская обл.",
  "Котельнич, Кировская обл.",
  "Кумены, Кировская обл.",
  "Ленинское, Кировская обл.",
  "Луза, Кировская обл.",
  "Малмыж, Кировская обл.",
  "Мураши, Кировская обл.",
  "Нагорск, Кировская обл.",
  "Нема, Кировская обл.",
  "Нововятск, Кировская обл.",
  "Нолинск, Кировская обл.",
  "Омутнинск, Кировская обл.",
  "Опарино, Кировская обл.",
  "Оричи, Кировская обл.",
  "Пижанка, Кировская обл.",
  "Подосиновец, Кировская обл.",
  "Санчурск, Кировская обл.",
  "Свеча, Кировская обл.",
  "Слободской, Кировская обл.",
  "Советск, Кировская обл.",
  "Суна, Кировская обл.",
  "Тужа, Кировская обл.",
  "Уни, Кировская обл.",
  "Уржум, Кировская обл.",
  "Фаленки, Кировская обл.",
  "Халтурин, Кировская обл.",
  "Юрья, Кировская обл.",
  "Яранск, Кировская обл.",
  "Абезь, Коми",
  "Айкино, Коми",
  "Верхняя Инта, Коми",
  "Визинга, Коми",
  "Водный, Коми",
  "Вожаель, Коми",
  "Воркута, Коми",
  "Вуктыл, Коми",
  "Гешарт, Коми",
  "Елецкий, Коми",
  "Емва, Коми",
  "Заполярный, Коми",
  "Ижма, Коми",
  "Инта, Коми",
  "Ираель, Коми",
  "Каджером, Коми",
  "Кажым, Коми",
  "Кожым, Коми",
  "Койгородок, Коми",
  "Корткерос, Коми",
  "Кослан, Коми",
  "Объячево, Коми",
  "Печора, Коми",
  "Сосногорск, Коми",
  "Сыктывкар, Коми",
  "Троицко-Печерск, Коми",
  "Усинск, Коми",
  "Усогорск, Коми",
  "Усть-Кулом, Коми",
  "Усть-Цильма, Коми",
  "Ухта, Коми",
  "Антропово, Костромская обл.",
  "Боговарово, Костромская обл.",
  "Буй, Костромская обл.",
  "Волгореченск, Костромская обл.",
  "Галич, Костромская обл.",
  "Горчуха, Костромская обл.",
  "Зебляки, Костромская обл.",
  "Кадый, Костромская обл.",
  "Кологрив, Костромская обл.",
  "Кострома, Костромская обл.",
  "Красное-на-Волге, Костромская обл.",
  "Макарьев, Костромская обл.",
  "Мантурово, Костромская обл.",
  "Нерехта, Костромская обл.",
  "Нея, Костромская обл.",
  "Островское, Костромская обл.",
  "Павино, Костромская обл.",
  "Парфентьево, Костромская обл.",
  "Поназырево, Костромская обл.",
  "Солигалич, Костромская обл.",
  "Судиславль, Костромская обл.",
  "Сусанино, Костромская обл.",
  "Чухлома, Костромская обл.",
  "Шарья, Костромская обл.",
  "Шемятино, Костромская обл.",
  "Абинск, Краснодарский край",
  "Абрау-Дюрсо, Краснодарский край",
  "Анапа, Краснодарский край",
  "Апшеронск, Краснодарский край",
  "Армавир, Краснодарский край",
  "Архипо-Осиповка, Краснодарский край",
  "Афипский, Краснодарский край",
  "Ахтырский, Краснодарский край",
  "Ачуево, Краснодарский край",
  "Белореченск, Краснодарский край",
  "Верхнебаканский, Краснодарский край",
  "Выселки, Краснодарский край",
  "Геленджик, Краснодарский край",
  "Гиагинская, Краснодарский край",
  "Горячий Ключ, Краснодарский край",
  "Джубга, Краснодарский край",
  "Динская, Краснодарский край",
  "Ейск, Краснодарский край",
  "Ильский, Краснодарский край",
  "Кабардинка, Краснодарский край",
  "Калинино, Краснодарский край",
  "Калининская, Краснодарский край",
  "Каменномостский, Краснодарский край",
  "Каневская, Краснодарский край",
  "Кореновск, Краснодарский край",
  "Красноармейская, Краснодарский край",
  "Краснодар, Краснодарский край",
  "Кропоткин, Краснодарский край",
  "Крыловская, Краснодарский край",
  "Крымск, Краснодарский край",
  "Курганинск, Краснодарский край",
  "Кущевская, Краснодарский край",
  "Лабинск, Краснодарский край",
  "Лениградская, Краснодарский край",
  "Майкоп, Краснодарский край",
  "Мостовской, Краснодарский край",
  "Новороссийск, Краснодарский край",
  "Отрадная, Краснодарский край",
  "Павловская, Краснодарский край",
  "Приморско-Ахтарск, Краснодарский край",
  "Северская, Краснодарский край",
  "Славянск-на-Кубани, Краснодарский край",
  "Сочи, Краснодарский край",
  "Староминская, Краснодарский край",
  "Старощербиновская, Краснодарский край",
  "Тбилисская, Краснодарский край",
  "Темрюк, Краснодарский край",
  "Тимашевск, Краснодарский край",
  "Тихорецк, Краснодарский край",
  "Туапсе, Краснодарский край",
  "Тульский, Краснодарский край",
  "Усть-Лабинск, Краснодарский край",
  "Шовгеновский, Краснодарский край",
  " Железногорск, Красноярский край",
  "Абаза, Красноярский край",
  "Абакан, Красноярский край",
  "Абан, Красноярский край",
  "Агинское, Красноярский край",
  "Артемовск, Красноярский край",
  "Аскиз, Красноярский край",
  "Ачинск, Красноярский край",
  "Байкит, Красноярский край",
  "Балахта, Красноярский край",
  "Балыкса, Красноярский край",
  "Белый Яр, Красноярский край",
  "Бельтырский, Красноярский край",
  "Бея, Красноярский край",
  "Бискамжа, Красноярский край",
  "Боготол, Красноярский край",
  "Боград, Красноярский край",
  "Богучаны, Красноярский край",
  "Большая Мурта, Красноярский край",
  "Большой Улуй, Красноярский край",
  "Бородино, Красноярский край",
  "Ванавара, Красноярский край",
  "Верхнеимбатск, Красноярский край",
  "Горячегорск, Красноярский край",
  "Дзержинское, Красноярский край",
  "Дивногорск, Красноярский край",
  "Диксон, Красноярский край",
  "Дудинка, Красноярский край",
  "Емельяново, Красноярский край",
  "Енисейск, Красноярский край",
  "Ермаковское, Красноярский край",
  "Заозерный, Красноярский край",
  "Зеленогорск, Красноярский край",
  "Игарка, Красноярский край",
  "Идринское, Красноярский край",
  "Иланский, Красноярский край",
  "Ирбейское, Красноярский край",
  "Казачинское, Красноярский край",
  "Канск, Красноярский край",
  "Каратузское, Красноярский край",
  "Караул, Красноярский край",
  "Кежма, Красноярский край",
  "Кодинск, Красноярский край",
  "Козулька, Красноярский край",
  "Копьево, Красноярский край",
  "Краснотуранск, Красноярский край",
  "Красноярск, Красноярский край",
  "Курагино, Красноярский край",
  "Лесосибирск, Красноярский край",
  "Минусинск, Красноярский край",
  "Мотыгино, Красноярский край",
  "Назарово, Красноярский край",
  "Нижний Ингаш, Красноярский край",
  "Новоселово, Красноярский край",
  "Норильск, Красноярский край",
  "Партизанское, Красноярский край",
  "Пировское, Красноярский край",
  "Саяногорск, Красноярский край",
  "Северо-Енисейский, Красноярский край",
  "Сосновоборск, Красноярский край",
  "Тасеево, Красноярский край",
  "Таштып, Красноярский край",
  "Тура, Красноярский край",
  "Туруханск, Красноярский край",
  "Тюхтет, Красноярский край",
  "Ужур, Красноярский край",
  "Усть-Авам, Красноярский край",
  "Уяр, Красноярский край",
  "Хатанга, Красноярский край",
  "Черемушки, Красноярский край",
  "Черногорск, Красноярский край",
  "Шалинское, Красноярский край",
  "Шарыпово, Красноярский край",
  "Шира, Красноярский край",
  "Шушенское, Красноярский край",
  "Варгаши, Курганская обл.",
  "Глядянское, Курганская обл.",
  "Далматово, Курганская обл.",
  "Каргаполье, Курганская обл.",
  "Катайск, Курганская обл.",
  "Кетово, Курганская обл.",
  "Курган, Курганская обл.",
  "Куртамыш, Курганская обл.",
  "Лебяжье, Курганская обл.",
  "Макушино, Курганская обл.",
  "Мишкино, Курганская обл.",
  "Мокроусово, Курганская обл.",
  "Петухово, Курганская обл.",
  "Половинное, Курганская обл.",
  "Сафакулево, Курганская обл.",
  "Целинное, Курганская обл.",
  "Шадринск, Курганская обл.",
  "Шатрово, Курганская обл.",
  "Шумиха, Курганская обл.",
  "Щучье, Курганская обл.",
  "Юргамыш, Курганская обл.",
  "Альменево, Курская обл.",
  "Белая, Курская обл.",
  "Большое Солдатское, Курская обл.",
  "Глушково, Курская обл.",
  "Горшечное, Курская обл.",
  "Дмитриев-Льговский, Курская обл.",
  "Железногорск, Курская обл.",
  "Золотухино, Курская обл.",
  "Касторное, Курская обл.",
  "Конышевка, Курская обл.",
  "Коренево, Курская обл.",
  "Курск, Курская обл.",
  "Курчатов, Курская обл.",
  "Кшенский, Курская обл.",
  "Льгов, Курская обл.",
  "Мантурово, Курская обл.",
  "Медвенка, Курская обл.",
  "Обоянь, Курская обл.",
  "Поныри, Курская обл.",
  "Пристень, Курская обл.",
  "Прямицыно, Курская обл.",
  "Рыльск, Курская обл.",
  "Суджа, Курская обл.",
  "Тим, Курская обл.",
  "Фатеж, Курская обл.",
  "Хомутовка, Курская обл.",
  "Черемисиново, Курская обл.",
  "Щигры, Курская обл.",
  "Грязи, Липецкая обл.",
  "Данхов, Липецкая обл.",
  "Доброе, Липецкая обл.",
  "Долгоруково, Липецкая обл.",
  "Елец, Липецкая обл.",
  "Задонск, Липецкая обл.",
  "Измалково, Липецкая обл.",
  "Казинка, Липецкая обл.",
  "Лебедянь, Липецкая обл.",
  "Лев Толстой, Липецкая обл.",
  "Липецк, Липецкая обл.",
  "Тербуны, Липецкая обл.",
  "Усмань, Липецкая обл.",
  "Хлевное, Липецкая обл.",
  "Чаплыгин, Липецкая обл.",
  "Анадырь, Магаданская обл.",
  "Атка, Магаданская обл.",
  "Балыгычан, Магаданская обл.",
  "Беринговский, Магаданская обл.",
  "Билибино, Магаданская обл.",
  "Большевик, Магаданская обл.",
  "Ванкарем, Магаданская обл.",
  "Иульитин, Магаданская обл.",
  "Кадыкчан, Магаданская обл.",
  "Лаврентия, Магаданская обл.",
  "Магадан, Магаданская обл.",
  "Мыс Шмидта, Магаданская обл.",
  "Ола, Магаданская обл.",
  "Омонск, Магаданская обл.",
  "Омсукчан, Магаданская обл.",
  "Палатка, Магаданская обл.",
  "Певек, Магаданская обл.",
  "Провидения, Магаданская обл.",
  "Сеймчан, Магаданская обл.",
  "Синегорье, Магаданская обл.",
  "Сусуман, Магаданская обл.",
  "Усть-Белая, Магаданская обл.",
  "Усть-Омчуг, Магаданская обл.",
  "Эвенск, Магаданская обл.",
  "Эгвекинот, Магаданская обл.",
  "Ягодное, Магаданская обл.",
  "Волжск, Марий Эл",
  "Дубовский, Марий Эл",
  "Звенигово, Марий Эл",
  "Йошкар-Ола, Марий Эл",
  "Килемары, Марий Эл",
  "Козьмодемьянск, Марий Эл",
  "Куженер, Марий Эл",
  "Мари-Турек, Марий Эл",
  "Медведево, Марий Эл",
  "Морки, Марий Эл",
  "Новый Торьял, Марий Эл",
  "Оршанка, Марий Эл",
  "Параньга, Марий Эл",
  "Сернур, Марий Эл",
  "Советский, Марий Эл",
  "Юрино, Марий Эл",
  "Ардатов, Мордовия",
  "Атюрьево, Мордовия",
  "Атяшево, Мордовия",
  "Большие Березники, Мордовия",
  "Большое Игнатово, Мордовия",
  "Выша, Мордовия",
  "Ельники, Мордовия",
  "Зубова Поляна, Мордовия",
  "Инсар, Мордовия",
  "Кадошкино, Мордовия",
  "Кемля, Мордовия",
  "Ковылкино, Мордовия",
  "Комсомольский, Мордовия",
  "Кочкурово, Мордовия",
  "Краснослободск, Мордовия",
  "Лямбирь, Мордовия",
  "Ромоданово, Мордовия",
  "Рузаевка, Мордовия",
  "Саранск, Мордовия",
  "Старое Шайгово, Мордовия",
  "Темников, Мордовия",
  "Теньгушево, Мордовия",
  "Торбеево, Мордовия",
  "Чамзинка, Мордовия",
  "Апатиты, Мурманская обл.",
  "Африканда, Мурманская обл.",
  "Верхнетуломский, Мурманская обл.",
  "Заозерск, Мурманская обл.",
  "Заполярный, Мурманская обл.",
  "Зареченск, Мурманская обл.",
  "Зашеек, Мурманская обл.",
  "Зеленоборский, Мурманская обл.",
  "Кандалакша, Мурманская обл.",
  "Кильдинстрой, Мурманская обл.",
  "Кировск, Мурманская обл.",
  "Ковдор, Мурманская обл.",
  "Кола, Мурманская обл.",
  "Конда, Мурманская обл.",
  "Мончегорск, Мурманская обл.",
  "Мурманск, Мурманская обл.",
  "Мурмаши, Мурманская обл.",
  "Никель, Мурманская обл.",
  "Оленегорск, Мурманская обл.",
  "Полярные Зори, Мурманская обл.",
  "Полярный, Мурманская обл.",
  "Североморск, Мурманская обл.",
  "Снежногорск, Мурманская обл.",
  "Умба, Мурманская обл.",
  "Ардатов, Нижегородская (Горьковская)",
  "Арзамас, Нижегородская (Горьковская)",
  "Арья, Нижегородская (Горьковская)",
  "Балахна, Нижегородская (Горьковская)",
  "Богородск, Нижегородская (Горьковская)",
  "Большереченск, Нижегородская (Горьковская)",
  "Большое Болдино, Нижегородская (Горьковская)",
  "Большое Козино, Нижегородская (Горьковская)",
  "Большое Мурашкино, Нижегородская (Горьковская)",
  "Большое Пикино, Нижегородская (Горьковская)",
  "Бор, Нижегородская (Горьковская)",
  "Бутурлино, Нижегородская (Горьковская)",
  "Вад, Нижегородская (Горьковская)",
  "Варнавино, Нижегородская (Горьковская)",
  "Васильсурск, Нижегородская (Горьковская)",
  "Вахтан, Нижегородская (Горьковская)",
  "Вача, Нижегородская (Горьковская)",
  "Велетьма, Нижегородская (Горьковская)",
  "Ветлуга, Нижегородская (Горьковская)",
  "Виля, Нижегородская (Горьковская)",
  "Вознесенское, Нижегородская (Горьковская)",
  "Володарск, Нижегородская (Горьковская)",
  "Воротынец, Нижегородская (Горьковская)",
  "Ворсма, Нижегородская (Горьковская)",
  "Воскресенское, Нижегородская (Горьковская)",
  "Выездное, Нижегородская (Горьковская)",
  "Выкса, Нижегородская (Горьковская)",
  "Гагино, Нижегородская (Горьковская)",
  "Гидроторф, Нижегородская (Горьковская)",
  "Горбатов, Нижегородская (Горьковская)",
  "Горбатовка, Нижегородская (Горьковская)",
  "Городец, Нижегородская (Горьковская)",
  "Горький, Нижегородская (Горьковская)",
  "Дальнее Константиново, Нижегородская (Горьковская)",
  "Дзержинск, Нижегородская (Горьковская)",
  "Дивеево, Нижегородская (Горьковская)",
  "Досчатое, Нижегородская (Горьковская)",
  "Заволжье, Нижегородская (Горьковская)",
  "Катунки, Нижегородская (Горьковская)",
  "Керженец, Нижегородская (Горьковская)",
  "Княгинино, Нижегородская (Горьковская)",
  "Ковернино, Нижегородская (Горьковская)",
  "Красные Баки, Нижегородская (Горьковская)",
  "Кстово, Нижегородская (Горьковская)",
  "Кулебаки, Нижегородская (Горьковская)",
  "Лукоянов, Нижегородская (Горьковская)",
  "Лысково, Нижегородская (Горьковская)",
  "Навашино, Нижегородская (Горьковская)",
  "Нижний Новгород, Нижегородская (Горьковская)",
  "Павлово, Нижегородская (Горьковская)",
  "Первомайск, Нижегородская (Горьковская)",
  "Перевоз, Нижегородская (Горьковская)",
  "Пильна, Нижегородская (Горьковская)",
  "Починки, Нижегородская (Горьковская)",
  "Саров, Нижегородская (Горьковская)",
  "Сергач, Нижегородская (Горьковская)",
  "Сеченово, Нижегородская (Горьковская)",
  "Сосновское, Нижегородская (Горьковская)",
  "Спасское, Нижегородская (Горьковская)",
  "Тонкино, Нижегородская (Горьковская)",
  "Тоншаево, Нижегородская (Горьковская)",
  "Уразовка, Нижегородская (Горьковская)",
  "Урень, Нижегородская (Горьковская)",
  "Чкаловск, Нижегородская (Горьковская)",
  "Шаранга, Нижегородская (Горьковская)",
  "Шатки, Нижегородская (Горьковская)",
  "Шахунья, Нижегородская (Горьковская)",
  "Анциферово, Новгородская обл.",
  "Батецкий, Новгородская обл.",
  "Большая Вишера, Новгородская обл.",
  "Боровичи, Новгородская обл.",
  "Валдай, Новгородская обл.",
  "Волот, Новгородская обл.",
  "Деманск, Новгородская обл.",
  "Зарубино, Новгородская обл.",
  "Кресцы, Новгородская обл.",
  "Любытино, Новгородская обл.",
  "Малая Вишера, Новгородская обл.",
  "Марево, Новгородская обл.",
  "Мошенское, Новгородская обл.",
  "Новгород, Новгородская обл.",
  "Окуловка, Новгородская обл.",
  "Парфино, Новгородская обл.",
  "Пестово, Новгородская обл.",
  "Поддорье, Новгородская обл.",
  "Сольцы, Новгородская обл.",
  "Старая Русса, Новгородская обл.",
  "Хвойное, Новгородская обл.",
  "Холм, Новгородская обл.",
  "Чудово, Новгородская обл.",
  "Шимск, Новгородская обл.",
  "Баган, Новосибирская обл.",
  "Барабинск, Новосибирская обл.",
  "Бердск, Новосибирская обл.",
  "Биаза, Новосибирская обл.",
  "Болотное, Новосибирская обл.",
  "Венгерово, Новосибирская обл.",
  "Довольное, Новосибирская обл.",
  "Завьялово, Новосибирская обл.",
  "Искитим, Новосибирская обл.",
  "Карасук, Новосибирская обл.",
  "Каргат, Новосибирская обл.",
  "Колывань, Новосибирская обл.",
  "Краснозерское, Новосибирская обл.",
  "Крутиха, Новосибирская обл.",
  "Куйбышев, Новосибирская обл.",
  "Купино, Новосибирская обл.",
  "Кыштовка, Новосибирская обл.",
  "Маслянино, Новосибирская обл.",
  "Михайловский, Новосибирская обл.",
  "Мошково, Новосибирская обл.",
  "Новосибирск, Новосибирская обл.",
  "Ордынское, Новосибирская обл.",
  "Северное, Новосибирская обл.",
  "Сузун, Новосибирская обл.",
  "Татарск, Новосибирская обл.",
  "Тогучин, Новосибирская обл.",
  "Убинское, Новосибирская обл.",
  "Усть-Тарка, Новосибирская обл.",
  "Чаны, Новосибирская обл.",
  "Черепаново, Новосибирская обл.",
  "Чистоозерное, Новосибирская обл.",
  "Чулым, Новосибирская обл.",
  "Береговой, Омская обл.",
  "Большеречье, Омская обл.",
  "Большие Уки, Омская обл.",
  "Горьковское, Омская обл.",
  "Знаменское, Омская обл.",
  "Исилькуль, Омская обл.",
  "Калачинск, Омская обл.",
  "Колосовка, Омская обл.",
  "Кормиловка, Омская обл.",
  "Крутинка, Омская обл.",
  "Любинский, Омская обл.",
  "Марьяновка, Омская обл.",
  "Муромцево, Омская обл.",
  "Называевск, Омская обл.",
  "Нижняя Омка, Омская обл.",
  "Нововаршавка, Омская обл.",
  "Одесское, Омская обл.",
  "Оконешниково, Омская обл.",
  "Омск, Омская обл.",
  "Павлоградка, Омская обл.",
  "Полтавка, Омская обл.",
  "Русская Поляна, Омская обл.",
  "Саргатское, Омская обл.",
  "Седельниково, Омская обл.",
  "Таврическое, Омская обл.",
  "Тара, Омская обл.",
  "Тевриз, Омская обл.",
  "Тюкалинск, Омская обл.",
  "Усть-Ишим, Омская обл.",
  "Черлак, Омская обл.",
  "Шербакуль, Омская обл.",
  "Абдулино, Оренбургская обл.",
  "Адамовка, Оренбургская обл.",
  "Айдырлинский, Оренбургская обл.",
  "Акбулак, Оренбургская обл.",
  "Аккермановка, Оренбургская обл.",
  "Асекеево, Оренбургская обл.",
  "Беляевка, Оренбургская обл.",
  "Бугуруслан, Оренбургская обл.",
  "Бузулук, Оренбургская обл.",
  "Гай, Оренбургская обл.",
  "Грачевка, Оренбургская обл.",
  "Домбаровский, Оренбургская обл.",
  "Дубенский, Оренбургская обл.",
  "Илек, Оренбургская обл.",
  "Ириклинский, Оренбургская обл.",
  "Кувандык, Оренбургская обл.",
  "Курманаевка, Оренбургская обл.",
  "Матвеевка, Оренбургская обл.",
  "Медногорск, Оренбургская обл.",
  "Новоорск, Оренбургская обл.",
  "Новосергиевка, Оренбургская обл.",
  "Новотроицк, Оренбургская обл.",
  "Октябрьское, Оренбургская обл.",
  "Оренбург, Оренбургская обл.",
  "Орск, Оренбургская обл.",
  "Первомайский, Оренбургская обл.",
  "Переволоцкий, Оренбургская обл.",
  "Пономаревка, Оренбургская обл.",
  "Саракташ, Оренбургская обл.",
  "Светлый, Оренбургская обл.",
  "Северное, Оренбургская обл.",
  "Соль-Илецк, Оренбургская обл.",
  "Сорочинск, Оренбургская обл.",
  "Ташла, Оренбургская обл.",
  "Тоцкое, Оренбургская обл.",
  "Тюльган, Оренбургская обл.",
  "Шарлык, Оренбургская обл.",
  "Энергетик, Оренбургская обл.",
  "Ясный, Оренбургская обл.",
  "Болхов, Орловская обл.",
  "Верховье, Орловская обл.",
  "Глазуновка, Орловская обл.",
  "Дмитровск-Орловский, Орловская обл.",
  "Долгое, Орловская обл.",
  "Залегощь, Орловская обл.",
  "Змиевка, Орловская обл.",
  "Знаменское, Орловская обл.",
  "Колпны, Орловская обл.",
  "Красная Заря, Орловская обл.",
  "Кромы, Орловская обл.",
  "Ливны, Орловская обл.",
  "Малоархангельск, Орловская обл.",
  "Мценск, Орловская обл.",
  "Нарышкино, Орловская обл.",
  "Новосиль, Орловская обл.",
  "Орел, Орловская обл.",
  "Покровское, Орловская обл.",
  "Сосково, Орловская обл.",
  "Тросна, Орловская обл.",
  "Хомутово, Орловская обл.",
  "Хотынец, Орловская обл.",
  "Шаблыкино, Орловская обл.",
  "Башмаково, Пензенская обл.",
  "Беднодемьяновск, Пензенская обл.",
  "Беково, Пензенская обл.",
  "Белинский, Пензенская обл.",
  "Бессоновка, Пензенская обл.",
  "Вадинск, Пензенская обл.",
  "Верхозим, Пензенская обл.",
  "Городище, Пензенская обл.",
  "Евлашево, Пензенская обл.",
  "Земетчино, Пензенская обл.",
  "Золотаревка, Пензенская обл.",
  "Исса, Пензенская обл.",
  "Каменка, Пензенская обл.",
  "Колышлей, Пензенская обл.",
  "Кондоль, Пензенская обл.",
  "Кузнецк, Пензенская обл.",
  "Лопатино, Пензенская обл.",
  "Малая Сердоба, Пензенская обл.",
  "Мокшан, Пензенская обл.",
  "Наровчат, Пензенская обл.",
  "Неверкино, Пензенская обл.",
  "Нижний Ломов, Пензенская обл.",
  "Никольск, Пензенская обл.",
  "Пачелма, Пензенская обл.",
  "Пенза, Пензенская обл.",
  "Русский Камешкир, Пензенская обл.",
  "Сердобск, Пензенская обл.",
  "Сосновоборск, Пензенская обл.",
  "Сура, Пензенская обл.",
  "Тамала, Пензенская обл.",
  "Шемышейка, Пензенская обл.",
  "Барда, Пермская обл.",
  "Березники, Пермская обл.",
  "Большая Соснова, Пермская обл.",
  "Верещагино, Пермская обл.",
  "Гайны, Пермская обл.",
  "Горнозаводск, Пермская обл.",
  "Гремячинск, Пермская обл.",
  "Губаха, Пермская обл.",
  "Добрянка, Пермская обл.",
  "Елово, Пермская обл.",
  "Зюкайка, Пермская обл.",
  "Ильинский, Пермская обл.",
  "Карагай, Пермская обл.",
  "Керчевский, Пермская обл.",
  "Кизел, Пермская обл.",
  "Коса, Пермская обл.",
  "Кочево, Пермская обл.",
  "Красновишерск, Пермская обл.",
  "Краснокамск, Пермская обл.",
  "Кудымкар, Пермская обл.",
  "Куеда, Пермская обл.",
  "Кунгур, Пермская обл.",
  "Лысьва, Пермская обл.",
  "Ныроб, Пермская обл.",
  "Нытва, Пермская обл.",
  "Октябрьский, Пермская обл.",
  "Орда, Пермская обл.",
  "Оса, Пермская обл.",
  "Оханск, Пермская обл.",
  "Очер, Пермская обл.",
  "Пермь, Пермская обл.",
  "Соликамск, Пермская обл.",
  "Суксун, Пермская обл.",
  "Уинское, Пермская обл.",
  "Усолье, Пермская обл.",
  "Усть-Кишерть, Пермская обл.",
  "Чайковский, Пермская обл.",
  "Частые, Пермская обл.",
  "Чердынь, Пермская обл.",
  "Чернореченский, Пермская обл.",
  "Чернушка, Пермская обл.",
  "Чусовой, Пермская обл.",
  "Юрла, Пермская обл.",
  "Юсьва, Пермская обл.",
  "Анучино, Приморский край",
  "Арсеньев, Приморский край",
  "Артем, Приморский край",
  "Артемовский, Приморский край",
  "Большой Камень, Приморский край",
  "Валентин, Приморский край",
  "Владивосток, Приморский край",
  "Высокогорск, Приморский край",
  "Горные Ключи, Приморский край",
  "Горный, Приморский край",
  "Дальнегорск, Приморский край",
  "Дальнереченск, Приморский край",
  "Зарубино, Приморский край",
  "Кавалерово, Приморский край",
  "Каменка, Приморский край",
  "Камень-Рыболов, Приморский край",
  "Кировский, Приморский край",
  "Лазо, Приморский край",
  "Лесозаводск, Приморский край",
  "Лучегорск, Приморский край",
  "Михайловка, Приморский край",
  "Находка, Приморский край",
  "Новопокровка, Приморский край",
  "Ольга, Приморский край",
  "Партизанск, Приморский край",
  "Пограничный, Приморский край",
  "Покровка, Приморский край",
  "Русский, Приморский край",
  "Самарга, Приморский край",
  "Славянка, Приморский край",
  "Спасск-Дальний, Приморский край",
  "Терней, Приморский край",
  "Уссурийск, Приморский край",
  "Фокино, Приморский край",
  "Хасан, Приморский край",
  "Хороль, Приморский край",
  "Черниговка, Приморский край",
  "Чугуевка, Приморский край",
  "Яковлевка, Приморский край",
  "Бежаницы, Псковская обл.",
  "Великие Луки, Псковская обл.",
  "Гдов, Псковская обл.",
  "Дедовичи, Псковская обл.",
  "Дно, Псковская обл.",
  "Заплюсье, Псковская обл.",
  "Идрица, Псковская обл.",
  "Красногородское, Псковская обл.",
  "Кунья, Псковская обл.",
  "Локня, Псковская обл.",
  "Невель, Псковская обл.",
  "Новоржев, Псковская обл.",
  "Новосокольники, Псковская обл.",
  "Опочка, Псковская обл.",
  "Остров, Псковская обл.",
  "Палкино, Псковская обл.",
  "Печоры, Псковская обл.",
  "Плюсса, Псковская обл.",
  "Порхов, Псковская обл.",
  "Псков, Псковская обл.",
  "Пустошка, Псковская обл.",
  "Пушкинские Горы, Псковская обл.",
  "Пыталово, Псковская обл.",
  "Себеж, Псковская обл.",
  "Струги-Красные, Псковская обл.",
  "Усвяты, Псковская обл.",
  "Азов, Ростовская обл.",
  "Аксай, Ростовская обл.",
  "Алмазный, Ростовская обл.",
  "Аютинск, Ростовская обл.",
  "Багаевский, Ростовская обл.",
  "Батайск, Ростовская обл.",
  "Белая Калитва, Ростовская обл.",
  "Боковская, Ростовская обл.",
  "Большая Мартыновка, Ростовская обл.",
  "Вешенская, Ростовская обл.",
  "Волгодонск, Ростовская обл.",
  "Восход, Ростовская обл.",
  "Гигант, Ростовская обл.",
  "Горняцкий, Ростовская обл.",
  "Гуково, Ростовская обл.",
  "Донецк, Ростовская обл.",
  "Донской, Ростовская обл.",
  "Дубовское, Ростовская обл.",
  "Егорлыкская, Ростовская обл.",
  "Жирнов, Ростовская обл.",
  "Заветное, Ростовская обл.",
  "Заводской, Ростовская обл.",
  "Зверево, Ростовская обл.",
  "Зерноград, Ростовская обл.",
  "Зимовники, Ростовская обл.",
  "Кагальницкая, Ростовская обл.",
  "Казанская, Ростовская обл.",
  "Каменоломни, Ростовская обл.",
  "Каменск-Шахтинский, Ростовская обл.",
  "Кашары, Ростовская обл.",
  "Коксовый, Ростовская обл.",
  "Константиновск, Ростовская обл.",
  "Красный Сулин, Ростовская обл.",
  "Куйбышево, Ростовская обл.",
  "Матвеев Курган, Ростовская обл.",
  "Мигулинская, Ростовская обл.",
  "Миллерово, Ростовская обл.",
  "Милютинская, Ростовская обл.",
  "Морозовск, Ростовская обл.",
  "Новочеркасск, Ростовская обл.",
  "Новошахтинск, Ростовская обл.",
  "Обливская, Ростовская обл.",
  "Орловский, Ростовская обл.",
  "Песчанокопское, Ростовская обл.",
  "Покровское, Ростовская обл.",
  "Пролетарск, Ростовская обл.",
  "Ремонтное, Ростовская обл.",
  "Родионово-Несветайская, Ростовская обл.",
  "Ростов-на-Дону, Ростовская обл.",
  "Сальск, Ростовская обл.",
  "Семикаракорск, Ростовская обл.",
  "Таганрог, Ростовская обл.",
  "Тарасовский, Ростовская обл.",
  "Тацинский, Ростовская обл.",
  "Усть-Донецкий, Ростовская обл.",
  "Целина, Ростовская обл.",
  "Цимлянск, Ростовская обл.",
  "Чалтырь, Ростовская обл.",
  "Чертково, Ростовская обл.",
  "Шахты, Ростовская обл.",
  "Шолоховский, Ростовская обл.",
  "Александро-Невский, Рязанская обл.",
  "Горняк, Рязанская обл.",
  "Гусь Железный, Рязанская обл.",
  "Елатьма, Рязанская обл.",
  "Ермишь, Рязанская обл.",
  "Заречный, Рязанская обл.",
  "Захарово, Рязанская обл.",
  "Кадом, Рязанская обл.",
  "Касимов, Рязанская обл.",
  "Кораблино, Рязанская обл.",
  "Милославское, Рязанская обл.",
  "Михайлов, Рязанская обл.",
  "Пителино, Рязанская обл.",
  "Пронск, Рязанская обл.",
  "Путятино, Рязанская обл.",
  "Рыбное, Рязанская обл.",
  "Ряжск, Рязанская обл.",
  "Рязань, Рязанская обл.",
  "Сапожок, Рязанская обл.",
  "Сараи, Рязанская обл.",
  "Сасово, Рязанская обл.",
  "Скопин, Рязанская обл.",
  "Спас-Клепики, Рязанская обл.",
  "Спасск-Рязанский, Рязанская обл.",
  "Старожилово, Рязанская обл.",
  "Ухолово, Рязанская обл.",
  "Чучково, Рязанская обл.",
  "Шацк, Рязанская обл.",
  "Шилово, Рязанская обл.",
  "Алексеевка, Самарская обл.",
  "Безенчук, Самарская обл.",
  "Богатое, Самарская обл.",
  "Богатырь, Самарская обл.",
  "Большая Глущица, Самарская обл.",
  "Большая Черниговка, Самарская обл.",
  "Борское, Самарская обл.",
  "Волжский, Самарская обл.",
  "Жигулевск, Самарская обл.",
  "Зольное, Самарская обл.",
  "Исаклы, Самарская обл.",
  "Камышла, Самарская обл.",
  "Кинель, Самарская обл.",
  "Кинель-Черкасы, Самарская обл.",
  "Клявлино, Самарская обл.",
  "Кошки, Самарская обл.",
  "Красноармейское, Самарская обл.",
  "Красный Яр, Самарская обл.",
  "Куйбышев, Самарская обл.",
  "Нефтегорск, Самарская обл.",
  "Новокуйбышевск, Самарская обл.",
  "Октябрьск, Самарская обл.",
  "Отрадный, Самарская обл.",
  "Пестравка, Самарская обл.",
  "Похвистнево, Самарская обл.",
  "Приволжье, Самарская обл.",
  "Самара, Самарская обл.",
  "Сургут (Самарская обл.), Самарская обл.",
  "Сызрань, Самарская обл.",
  "Тольятти, Самарская обл.",
  "Хворостянка, Самарская обл.",
  "Чапаевск, Самарская обл.",
  "Челно-Вершины, Самарская обл.",
  "Шентала, Самарская обл.",
  "Шигоны, Самарская обл.",
  "Александров Гай, Саратовская обл.",
  "Аркадак, Саратовская обл.",
  "Аткарск, Саратовская обл.",
  "Базарный Карабулак, Саратовская обл.",
  "Балаково, Саратовская обл.",
  "Балашов, Саратовская обл.",
  "Балтай, Саратовская обл.",
  "Возрождение, Саратовская обл.",
  "Вольск, Саратовская обл.",
  "Воскресенское, Саратовская обл.",
  "Горный, Саратовская обл.",
  "Дергачи, Саратовская обл.",
  "Духовницкое, Саратовская обл.",
  "Екатериновка, Саратовская обл.",
  "Ершов, Саратовская обл.",
  "Заречный, Саратовская обл.",
  "Ивантеевка, Саратовская обл.",
  "Калининск, Саратовская обл.",
  "Каменский, Саратовская обл.",
  "Красноармейск, Саратовская обл.",
  "Красный Кут, Саратовская обл.",
  "Лысые Горы, Саратовская обл.",
  "Маркс, Саратовская обл.",
  "Мокроус, Саратовская обл.",
  "Новоузенск, Саратовская обл.",
  "Новые Бурасы, Саратовская обл.",
  "Озинки, Саратовская обл.",
  "Перелюб, Саратовская обл.",
  "Петровск, Саратовская обл.",
  "Питерка, Саратовская обл.",
  "Пугачев, Саратовская обл.",
  "Ровное, Саратовская обл.",
  "Романовка, Саратовская обл.",
  "Ртищево, Саратовская обл.",
  "Самойловка, Саратовская обл.",
  "Саратов, Саратовская обл.",
  "Степное, Саратовская обл.",
  "Татищево, Саратовская обл.",
  "Турки, Саратовская обл.",
  "Хвалынск, Саратовская обл.",
  "Энгельс, Саратовская обл.",
  "Абый, Саха (Якутия)",
  "Алдан, Саха (Якутия)",
  "Амга, Саха (Якутия)",
  "Батагай, Саха (Якутия)",
  "Бердигестях, Саха (Якутия)",
  "Беркакит, Саха (Якутия)",
  "Бестях, Саха (Якутия)",
  "Борогонцы, Саха (Якутия)",
  "Верхневилюйск, Саха (Якутия)",
  "Верхнеколымск, Саха (Якутия)",
  "Верхоянск, Саха (Якутия)",
  "Вилюйск, Саха (Якутия)",
  "Витим, Саха (Якутия)",
  "Власово, Саха (Якутия)",
  "Жиганск, Саха (Якутия)",
  "Зырянка, Саха (Якутия)",
  "Кангалассы, Саха (Якутия)",
  "Канкунский, Саха (Якутия)",
  "Ленск, Саха (Якутия)",
  "Майя, Саха (Якутия)",
  "Менкеря, Саха (Якутия)",
  "Мирный, Саха (Якутия)",
  "Нерюнгри, Саха (Якутия)",
  "Нычалах, Саха (Якутия)",
  "Нюрба, Саха (Якутия)",
  "Олекминск, Саха (Якутия)",
  "Покровск, Саха (Якутия)",
  "Сангар, Саха (Якутия)",
  "Саскылах, Саха (Якутия)",
  "Среднеколымск, Саха (Якутия)",
  "Сунтар, Саха (Якутия)",
  "Тикси, Саха (Якутия)",
  "Усть-Мая, Саха (Якутия)",
  "Усть-Нера, Саха (Якутия)",
  "Хандыга, Саха (Якутия)",
  "Хонуу, Саха (Якутия)",
  "Черский, Саха (Якутия)",
  "Чокурдах, Саха (Якутия)",
  "Чурапча, Саха (Якутия)",
  "Якутск, Саха (Якутия)",
  "Александровск-Сахалинский, Сахалин",
  "Анбэцу, Сахалин",
  "Анива, Сахалин",
  "Бошняково, Сахалин",
  "Быков, Сахалин",
  "Вахрушев, Сахалин",
  "Взморье, Сахалин",
  "Гастелло, Сахалин",
  "Горнозаводск, Сахалин",
  "Долинск, Сахалин",
  "Ильинский, Сахалин",
  "Катангли, Сахалин",
  "Корсаков, Сахалин",
  "Курильск, Сахалин",
  "Макаров, Сахалин",
  "Невельск, Сахалин",
  "Ноглики, Сахалин",
  "Оха, Сахалин",
  "Поронайск, Сахалин",
  "Северо-Курильск, Сахалин",
  "Смирных, Сахалин",
  "Томари, Сахалин",
  "Тымовское, Сахалин",
  "Углегорск, Сахалин",
  "Холмск, Сахалин",
  "Шахтерск, Сахалин",
  "Южно-Курильск, Сахалин",
  "Южно-Сахалинск, Сахалин",
  "Алапаевск, Свердловская обл.",
  "Алтынай, Свердловская обл.",
  "Арамиль, Свердловская обл.",
  "Артемовский, Свердловская обл.",
  "Арти, Свердловская обл.",
  "Асбест, Свердловская обл.",
  "Ачит, Свердловская обл.",
  "Байкалово, Свердловская обл.",
  "Басьяновский, Свердловская обл.",
  "Белоярский, Свердловская обл.",
  "Березовский, Свердловская обл.",
  "Богданович, Свердловская обл.",
  "Буланаш, Свердловская обл.",
  "Верхний Тагил, Свердловская обл.",
  "Верхняя Пышма, Свердловская обл.",
  "Верхняя Салда, Свердловская обл.",
  "Верхняя Синячиха, Свердловская обл.",
  "Верхняя Сысерть, Свердловская обл.",
  "Верхняя Тура, Свердловская обл.",
  "Верхотурье, Свердловская обл.",
  "Висим, Свердловская обл.",
  "Волчанск, Свердловская обл.",
  "Воронцовка, Свердловская обл.",
  "Гари, Свердловская обл.",
  "Дегтярск, Свердловская обл.",
  "Екатеринбург, Свердловская обл.",
  "Ертарский, Свердловская обл.",
  "Заводоуспенское, Свердловская обл.",
  "Зыряновский, Свердловская обл.",
  "Зюзельский, Свердловская обл.",
  "Ивдель, Свердловская обл.",
  "Изумруд, Свердловская обл.",
  "Ирбит, Свердловская обл.",
  "Ис, Свердловская обл.",
  "Каменск-Уральский, Свердловская обл.",
  "Камышлов, Свердловская обл.",
  "Карпинск, Свердловская обл.",
  "Карпунинский, Свердловская обл.",
  "Качканар, Свердловская обл.",
  "Кировград, Свердловская обл.",
  "Краснотурьинск, Свердловская обл.",
  "Красноуральск, Свердловская обл.",
  "Красноуфимск, Свердловская обл.",
  "Кушва, Свердловская обл.",
  "Лесной, Свердловская обл.",
  "Михайловск, Свердловская обл.",
  "Невьянск, Свердловская обл.",
  "Нижние Серги, Свердловская обл.",
  "Нижний Тагил, Свердловская обл.",
  "Нижняя Салда, Свердловская обл.",
  "Нижняя Тура, Свердловская обл.",
  "Новая Ляля, Свердловская обл.",
  "Новоуральск, Свердловская обл.",
  "Оус, Свердловская обл.",
  "Первоуральск, Свердловская обл.",
  "Полевской, Свердловская обл.",
  "Пышма, Свердловская обл.",
  "Ревда, Свердловская обл.",
  "Реж, Свердловская обл.",
  "Свердловск, Свердловская обл.",
  "Североуральск, Свердловская обл.",
  "Серов, Свердловская обл.",
  "Сосьва, Свердловская обл.",
  "Среднеуральск, Свердловская обл.",
  "Сухой Лог, Свердловская обл.",
  "Сысерть, Свердловская обл.",
  "Таборы, Свердловская обл.",
  "Тавда, Свердловская обл.",
  "Талица, Свердловская обл.",
  "Тугулым, Свердловская обл.",
  "Туринск, Свердловская обл.",
  "Туринская Слобода, Свердловская обл.",
  "Алагир, Северная Осетия",
  "Ардон, Северная Осетия",
  "Беслан, Северная Осетия",
  "Бурон, Северная Осетия",
  "Владикавказ, Северная Осетия",
  "Дигора, Северная Осетия",
  "Моздок, Северная Осетия",
  "Орджоникидзе, Северная Осетия",
  "Чикола, Северная Осетия",
  "Велиж, Смоленская обл.",
  "Верхнеднепровский, Смоленская обл.",
  "Ворга, Смоленская обл.",
  "Вязьма, Смоленская обл.",
  "Гагарин, Смоленская обл.",
  "Глинка, Смоленская обл.",
  "Голынки, Смоленская обл.",
  "Демидов, Смоленская обл.",
  "Десногорск, Смоленская обл.",
  "Дорогобуж, Смоленская обл.",
  "Духовщина, Смоленская обл.",
  "Екимовичи, Смоленская обл.",
  "Ельня, Смоленская обл.",
  "Ершичи, Смоленская обл.",
  "Издешково, Смоленская обл.",
  "Кардымово, Смоленская обл.",
  "Красный, Смоленская обл.",
  "Монастырщина, Смоленская обл.",
  "Новодугино, Смоленская обл.",
  "Починок, Смоленская обл.",
  "Рославль, Смоленская обл.",
  "Рудня, Смоленская обл.",
  "Сафоново, Смоленская обл.",
  "Смоленск, Смоленская обл.",
  "Сычевка, Смоленская обл.",
  "Угра, Смоленская обл.",
  "Хиславичи, Смоленская обл.",
  "Холм-Жирковский, Смоленская обл.",
  "Шумячи, Смоленская обл.",
  "Ярцево, Смоленская обл.",
  "Александровское, Ставропольский край",
  "Арзгир, Ставропольский край",
  "Благодарный, Ставропольский край",
  "Буденновск, Ставропольский край",
  "Георгиевск, Ставропольский край",
  "Дивное, Ставропольский край",
  "Домбай, Ставропольский край",
  "Донское, Ставропольский край",
  "Ессентуки, Ставропольский край",
  "Железноводск, Ставропольский край",
  "Зеленокумск, Ставропольский край",
  "Изобильный, Ставропольский край",
  "Иноземцево, Ставропольский край",
  "Ипатово, Ставропольский край",
  "Карачаевск, Ставропольский край",
  "Кисловодск, Ставропольский край",
  "Кочубеевское, Ставропольский край",
  "Красногвардейское, Ставропольский край",
  "Курсавка, Ставропольский край",
  "Левокумское, Ставропольский край",
  "Минеральные Воды, Ставропольский край",
  "Невинномысск, Ставропольский край",
  "Нефтекумск, Ставропольский край",
  "Новоалександровск, Ставропольский край",
  "Новоалександровская, Ставропольский край",
  "Новопавловск, Ставропольский край",
  "Новоселицкое, Ставропольский край",
  "Преградная, Ставропольский край",
  "Пятигорск, Ставропольский край",
  "Светлоград, Ставропольский край",
  "Солнечнодольск, Ставропольский край",
  "Ставрополь, Ставропольский край",
  "Степное, Ставропольский край",
  "Теберда, Ставропольский край",
  "Усть-Джегута, Ставропольский край",
  "Хабез, Ставропольский край",
  "Черкесск, Ставропольский край",
  "Бондари, Тамбовская обл.",
  "Гавриловка Вторая, Тамбовская обл.",
  "Жердевка, Тамбовская обл.",
  "Знаменка, Тамбовская обл.",
  "Инжавино, Тамбовская обл.",
  "Кирсанов, Тамбовская обл.",
  "Котовск, Тамбовская обл.",
  "Мичуринск, Тамбовская обл.",
  "Мордово, Тамбовская обл.",
  "Моршанск, Тамбовская обл.",
  "Мучкапский, Тамбовская обл.",
  "Первомайский, Тамбовская обл.",
  "Петровское, Тамбовская обл.",
  "Пичаево, Тамбовская обл.",
  "Рассказово, Тамбовская обл.",
  "Ржакса, Тамбовская обл.",
  "Староюрьево, Тамбовская обл.",
  "Тамбов, Тамбовская обл.",
  "Токаревка, Тамбовская обл.",
  "Уварово, Тамбовская обл.",
  "Умет, Тамбовская обл.",
  "Агрыз, Татарстан",
  "Азнакаево, Татарстан",
  "Аксубаево, Татарстан",
  "Актюбинский, Татарстан",
  "Алексеевское, Татарстан",
  "Альметьевск, Татарстан",
  "Альметьевск, Татарстан",
  "Апастово, Татарстан",
  "Арск, Татарстан",
  "Бавлы, Татарстан",
  "Базарные Матаки, Татарстан",
  "Балтаси, Татарстан",
  "Богатые Сабы, Татарстан",
  "Брежнев, Татарстан",
  "Бугульма, Татарстан",
  "Буинск, Татарстан",
  "Васильево, Татарстан",
  "Верхний Услон, Татарстан",
  "Высокая Гора, Татарстан",
  "Дербешкинский, Татарстан",
  "Елабуга, Татарстан",
  "Заинск, Татарстан",
  "Зеленодольск, Татарстан",
  "Казань, Татарстан",
  "Камское Устье, Татарстан",
  "Карабаш, Татарстан",
  "Куйбышев, Татарстан",
  "Кукмод, Татарстан",
  "Кукмор, Татарстан",
  "Лаишево, Татарстан",
  "Лениногорск, Татарстан",
  "Мамадыш, Татарстан",
  "Менделеевск, Татарстан",
  "Мензелинск, Татарстан",
  "Муслюмово, Татарстан",
  "Набережные Челны, Татарстан",
  "Нижнекамск, Татарстан",
  "Новошешминск, Татарстан",
  "Нурлат, Татарстан",
  "Пестрецы, Татарстан",
  "Рыбная Слобода, Татарстан",
  "Сарманово, Татарстан",
  "Старое Дрожжаное, Татарстан",
  "Тетюши, Татарстан",
  "Чистополь, Татарстан",
  "Андреаполь, Тверская обл.",
  "Бежецк, Тверская обл.",
  "Белый, Тверская обл.",
  "Белый Городок, Тверская обл.",
  "Березайка, Тверская обл.",
  "Бологое, Тверская обл.",
  "Васильевский Мох, Тверская обл.",
  "Выползово, Тверская обл.",
  "Вышний Волочек, Тверская обл.",
  "Жарковский, Тверская обл.",
  "Западная Двина, Тверская обл.",
  "Заречье, Тверская обл.",
  "Зубцов, Тверская обл.",
  "Изоплит, Тверская обл.",
  "Калашниково, Тверская обл.",
  "Калинин, Тверская обл.",
  "Калязин, Тверская обл.",
  "Кашин, Тверская обл.",
  "Кесова Гора, Тверская обл.",
  "Кимры, Тверская обл.",
  "Конаково, Тверская обл.",
  "Красный Холм, Тверская обл.",
  "Кувшиново, Тверская обл.",
  "Лесное, Тверская обл.",
  "Лихославль, Тверская обл.",
  "Максатиха, Тверская обл.",
  "Молоково, Тверская обл.",
  "Нелидово, Тверская обл.",
  "Оленино, Тверская обл.",
  "Осташков, Тверская обл.",
  "Пено, Тверская обл.",
  "Рамешки, Тверская обл.",
  "Ржев, Тверская обл.",
  "Сандово, Тверская обл.",
  "Селижарово, Тверская обл.",
  "Сонково, Тверская обл.",
  "Спирово, Тверская обл.",
  "Старица, Тверская обл.",
  "Тверь, Тверская обл.",
  "Торжок, Тверская обл.",
  "Торопец, Тверская обл.",
  "Удомля, Тверская обл.",
  "Фирово, Тверская обл.",
  "Александровское, Томская обл.",
  "Асино, Томская обл.",
  "Бакчар, Томская обл.",
  "Батурино, Томская обл.",
  "Белый Яр, Томская обл.",
  "Зырянское, Томская обл.",
  "Итатка, Томская обл.",
  "Каргасок, Томская обл.",
  "Катайга, Томская обл.",
  "Кожевниково, Томская обл.",
  "Колпашево, Томская обл.",
  "Кривошеино, Томская обл.",
  "Мельниково, Томская обл.",
  "Молчаново, Томская обл.",
  "Парабель, Томская обл.",
  "Первомайское, Томская обл.",
  "Подгорное, Томская обл.",
  "Северск, Томская обл.",
  "Стрежевой, Томская обл.",
  "Томск, Томская обл.",
  "Тымск, Томская обл.",
  "Ак-Довурак, Тува (Тувинская Респ.)",
  "Бай Хаак, Тува (Тувинская Респ.)",
  "Кызыл, Тува (Тувинская Респ.)",
  "Самагалтай, Тува (Тувинская Респ.)",
  "Сарыг-Сеп, Тува (Тувинская Респ.)",
  "Суть-Холь, Тува (Тувинская Респ.)",
  "Тоора-Хем, Тува (Тувинская Респ.)",
  "Туран, Тува (Тувинская Респ.)",
  "Тээли, Тува (Тувинская Респ.)",
  "Хову-Аксы, Тува (Тувинская Респ.)",
  "Чадан, Тува (Тувинская Респ.)",
  "Шагонар, Тува (Тувинская Респ.)",
  "Эрзин, Тува (Тувинская Респ.)",
  "Агеево, Тульская обл.",
  "Алексин, Тульская обл.",
  "Арсеньево, Тульская обл.",
  "Барсуки, Тульская обл.",
  "Бегичевский, Тульская обл.",
  "Белев, Тульская обл.",
  "Богородицк, Тульская обл.",
  "Болохово, Тульская обл.",
  "Велегож, Тульская обл.",
  "Венев, Тульская обл.",
  "Волово, Тульская обл.",
  "Горелки, Тульская обл.",
  "Донской, Тульская обл.",
  "Дубна, Тульская обл.",
  "Епифань, Тульская обл.",
  "Ефремов, Тульская обл.",
  "Заокский, Тульская обл.",
  "Казановка, Тульская обл.",
  "Кимовск, Тульская обл.",
  "Киреевск, Тульская обл.",
  "Куркино, Тульская обл.",
  "Ленинский, Тульская обл.",
  "Новомосковск, Тульская обл.",
  "Одоев, Тульская обл.",
  "Плавск, Тульская обл.",
  "Суворов, Тульская обл.",
  "Тула, Тульская обл.",
  "Узловая, Тульская обл.",
  "Щекино, Тульская обл.",
  "Ясногорск, Тульская обл.",
  "Абатский, Тюменская обл.",
  "Аксарка, Тюменская обл.",
  "Армизонское, Тюменская обл.",
  "Аромашево, Тюменская обл.",
  "Белоярский, Тюменская обл.",
  "Бердюжье, Тюменская обл.",
  "Большое Сорокино, Тюменская обл.",
  "Вагай, Тюменская обл.",
  "Викулово, Тюменская обл.",
  "Винзили, Тюменская обл.",
  "Голышманово, Тюменская обл.",
  "Губкинский, Тюменская обл.",
  "Заводопетровский, Тюменская обл.",
  "Заводоуковск, Тюменская обл.",
  "Излучинск, Тюменская обл.",
  "Исетское, Тюменская обл.",
  "Ишим, Тюменская обл.",
  "Казанское, Тюменская обл.",
  "Казым-Мыс, Тюменская обл.",
  "Когалым, Тюменская обл.",
  "Кондинское, Тюменская обл.",
  "Красноселькуп, Тюменская обл.",
  "Лабытнанги, Тюменская обл.",
  "Ларьяк, Тюменская обл.",
  "Мегион, Тюменская обл.",
  "Мужи, Тюменская обл.",
  "Муравленко, Тюменская обл.",
  "Надым, Тюменская обл.",
  "Находка, Тюменская обл.",
  "Нефтеюганск, Тюменская обл.",
  "Нижневартовск, Тюменская обл.",
  "Нижняя Тавда, Тюменская обл.",
  "Новый Уренгой, Тюменская обл.",
  "Ноябрьск, Тюменская обл.",
  "Нягань, Тюменская обл.",
  "Октябрьское, Тюменская обл.",
  "Омутинский, Тюменская обл.",
  "Радужный, Тюменская обл.",
  "Салехард, Тюменская обл.",
  "Сладково, Тюменская обл.",
  "Советский, Тюменская обл.",
  "Сургут, Тюменская обл.",
  "Тазовский, Тюменская обл.",
  "Тарко-Сале, Тюменская обл.",
  "Тобольск, Тюменская обл.",
  "Тюмень, Тюменская обл.",
  "Уват, Тюменская обл.",
  "Унъюган, Тюменская обл.",
  "Упорово, Тюменская обл.",
  "Урай, Тюменская обл.",
  "Ханты-Мансийск, Тюменская обл.",
  "Юрибей, Тюменская обл.",
  "Ялуторовск, Тюменская обл.",
  "Яр-Сале, Тюменская обл.",
  "Ярково, Тюменская обл.",
  "Алнаши, Удмуртия",
  "Балезино, Удмуртия",
  "Вавож, Удмуртия",
  "Воткинск, Удмуртия",
  "Глазов, Удмуртия",
  "Грахово, Удмуртия",
  "Дебесы, Удмуртия",
  "Завьялово, Удмуртия",
  "Игра, Удмуртия",
  "Ижевск, Удмуртия",
  "Кама, Удмуртия",
  "Камбарка, Удмуртия",
  "Каракулино, Удмуртия",
  "Кез, Удмуртия",
  "Кизнер, Удмуртия",
  "Киясово, Удмуртия",
  "Красногорское, Удмуртия",
  "Можга, Удмуртия",
  "Сарапул, Удмуртия",
  "Селты, Удмуртия",
  "Сюмси, Удмуртия",
  "Ува, Удмуртия",
  "Устинов, Удмуртия",
  "Шаркан, Удмуртия",
  "Юкаменское, Удмуртия",
  "Якшур-Бодья, Удмуртия",
  "Яр, Удмуртия",
  "Базарный Сызган, Ульяновская обл.",
  "Барыш, Ульяновская обл.",
  "Большое Нагаткино, Ульяновская обл.",
  "Вешкайма, Ульяновская обл.",
  "Глотовка, Ульяновская обл.",
  "Димитровград, Ульяновская обл.",
  "Игнатовка, Ульяновская обл.",
  "Измайлово, Ульяновская обл.",
  "Инза, Ульяновская обл.",
  "Ишеевка, Ульяновская обл.",
  "Канадей, Ульяновская обл.",
  "Карсун, Ульяновская обл.",
  "Кузоватово, Ульяновская обл.",
  "Майна, Ульяновская обл.",
  "Новая Малыкла, Ульяновская обл.",
  "Новоспасское, Ульяновская обл.",
  "Павловка, Ульяновская обл.",
  "Радищево, Ульяновская обл.",
  "Сенгилей, Ульяновская обл.",
  "Старая Кулатка, Ульяновская обл.",
  "Старая Майна, Ульяновская обл.",
  "Сурское, Ульяновская обл.",
  "Тереньга, Ульяновская обл.",
  "Ульяновск, Ульяновская обл.",
  "Чердаклы, Ульяновская обл.",
  "Аксай, Уральская обл.",
  "Дарьинское, Уральская обл.",
  "Деркул, Уральская обл.",
  "Джамбейты, Уральская обл.",
  "Джаныбек, Уральская обл.",
  "Казталовка, Уральская обл.",
  "Калмыково, Уральская обл.",
  "Каратобе, Уральская обл.",
  "Переметное, Уральская обл.",
  "Сайхин, Уральская обл.",
  "Уральск, Уральская обл.",
  "Федоровка, Уральская обл.",
  "Фурманово, Уральская обл.",
  "Чапаев, Уральская обл.",
  "Амурск, Хабаровский край",
  "Аян, Хабаровский край",
  "Березовый, Хабаровский край",
  "Бикин, Хабаровский край",
  "Бира, Хабаровский край",
  "Биракан, Хабаровский край",
  "Богородское, Хабаровский край",
  "Болонь, Хабаровский край",
  "Ванино, Хабаровский край",
  "Волочаевка Вторая, Хабаровский край",
  "Высокогорный, Хабаровский край",
  "Вяземский, Хабаровский край",
  "Горный, Хабаровский край",
  "Гурское, Хабаровский край",
  "Дормидонтовка, Хабаровский край",
  "Заветы Ильича, Хабаровский край",
  "Известковый, Хабаровский край",
  "Иннокентьевка, Хабаровский край",
  "Комсомольск-на-Амуре, Хабаровский край",
  "Ленинское, Хабаровский край",
  "Нелькан, Хабаровский край",
  "Николаевск-на-Амуре, Хабаровский край",
  "Облучье, Хабаровский край",
  "Охотск, Хабаровский край",
  "Переяславка, Хабаровский край",
  "Смидович, Хабаровский край",
  "Советская Гавань, Хабаровский край",
  "Софийск, Хабаровский край",
  "Троицкое, Хабаровский край",
  "Тугур, Хабаровский край",
  "Хабаровск, Хабаровский край",
  "Чегдомын, Хабаровский край",
  "Чумикан, Хабаровский край",
  "Абакан, Хакасия",
  "Саяногорск, Хакасия",
  "Аган, Ханты-Мансийский АО",
  "Игрим, Ханты-Мансийский АО",
  "Излучинск, Ханты-Мансийский АО",
  "Лангепас, Ханты-Мансийский АО",
  "Лянтор, Ханты-Мансийский АО",
  "Мегион, Ханты-Мансийский АО",
  "Нефтеюганск, Ханты-Мансийский АО",
  "Нижневартовск, Ханты-Мансийский АО",
  "Нягань, Ханты-Мансийский АО",
  "Покачи, Ханты-Мансийский АО",
  "Приобье, Ханты-Мансийский АО",
  "Пыть-Ях, Ханты-Мансийский АО",
  "Радужный, Ханты-Мансийский АО",
  "Сургут, Ханты-Мансийский АО",
  "Урай, Ханты-Мансийский АО",
  "Ханты-Мансийск, Ханты-Мансийский АО",
  "Югорск, Ханты-Мансийский АО",
  "Агаповка, Челябинская обл.",
  "Аргаяш, Челябинская обл.",
  "Аша, Челябинская обл.",
  "Бакал, Челябинская обл.",
  "Бреды, Челябинская обл.",
  "Варна, Челябинская обл.",
  "Верхнеуральск, Челябинская обл.",
  "Верхний Уфалей, Челябинская обл.",
  "Еманжелинск, Челябинская обл.",
  "Златоуст, Челябинская обл.",
  "Карабаш, Челябинская обл.",
  "Карталы, Челябинская обл.",
  "Касли, Челябинская обл.",
  "Катав-Ивановск, Челябинская обл.",
  "Копейск, Челябинская обл.",
  "Коркино, Челябинская обл.",
  "Кунашак, Челябинская обл.",
  "Куса, Челябинская обл.",
  "Кыштым, Челябинская обл.",
  "Магнитогорск, Челябинская обл.",
  "Миасс, Челябинская обл.",
  "Озерск, Челябинская обл.",
  "Октябрьское, Челябинская обл.",
  "Пласт, Челябинская обл.",
  "Сатка, Челябинская обл.",
  "Сим, Челябинская обл.",
  "Снежинск, Челябинская обл.",
  "Трехгорный, Челябинская обл.",
  "Троицк, Челябинская обл.",
  "Увельский, Челябинская обл.",
  "Уйское, Челябинская обл.",
  "Усть-Катав, Челябинская обл.",
  "Фершампенуаз, Челябинская обл.",
  "Чебаркуль, Челябинская обл.",
  "Челябинск, Челябинская обл.",
  "Чесма, Челябинская обл.",
  "Южно-Уральск, Челябинская обл.",
  "Юрюзань, Челябинская обл.",
  "Аргун, Чечено-Ингушетия",
  "Грозный, Чечено-Ингушетия",
  "Гудермез, Чечено-Ингушетия",
  "Малгобек, Чечено-Ингушетия",
  "Назрань, Чечено-Ингушетия",
  "Наурская, Чечено-Ингушетия",
  "Ножай-Юрт, Чечено-Ингушетия",
  "Орджоникидзевская, Чечено-Ингушетия",
  "Советское, Чечено-Ингушетия",
  "Урус-Мартан, Чечено-Ингушетия",
  "Шали, Чечено-Ингушетия",
  "Агинское, Читинская обл.",
  "Аксеново-Зиловское, Читинская обл.",
  "Акша, Читинская обл.",
  "Александровский Завод, Читинская обл.",
  "Амазар, Читинская обл.",
  "Арбагар, Читинская обл.",
  "Атамановка, Читинская обл.",
  "Балей, Читинская обл.",
  "Борзя, Читинская обл.",
  "Букачача, Читинская обл.",
  "Газимурский Завод, Читинская обл.",
  "Давенда, Читинская обл.",
  "Дарасун, Читинская обл.",
  "Дровяная, Читинская обл.",
  "Дульдурга, Читинская обл.",
  "Жиндо, Читинская обл.",
  "Забайкальск, Читинская обл.",
  "Итака, Читинская обл.",
  "Калга, Читинская обл.",
  "Карымское, Читинская обл.",
  "Кличка, Читинская обл.",
  "Ключевский, Читинская обл.",
  "Кокуй, Читинская обл.",
  "Краснокаменск, Читинская обл.",
  "Красный Чикой, Читинская обл.",
  "Кыра, Читинская обл.",
  "Моготуй, Читинская обл.",
  "Могоча, Читинская обл.",
  "Нерчинск, Читинская обл.",
  "Нерчинский Завод, Читинская обл.",
  "Нижний Часучей, Читинская обл.",
  "Оловянная, Читинская обл.",
  "Первомайский, Читинская обл.",
  "Петровск-Забайкальский, Читинская обл.",
  "Приаргунск, Читинская обл.",
  "Сретенск, Читинская обл.",
  "Тупик, Читинская обл.",
  "Улеты, Читинская обл.",
  "Хилок, Читинская обл.",
  "Чара, Читинская обл.",
  "Чернышевск, Читинская обл.",
  "Чита, Читинская обл.",
  "Шелопугино, Читинская обл.",
  "Шилка, Читинская обл.",
  "Алатырь, Чувашия",
  "Аликово, Чувашия",
  "Батырева, Чувашия",
  "Буинск, Чувашия",
  "Вурнары, Чувашия",
  "Ибреси, Чувашия",
  "Канаш, Чувашия",
  "Киря, Чувашия",
  "Комсомольское, Чувашия",
  "Красноармейское, Чувашия",
  "Красные Четаи, Чувашия",
  "Кугеси, Чувашия",
  "Мариинский Посад, Чувашия",
  "Моргауши, Чувашия",
  "Новочебоксарск, Чувашия",
  "Порецкое, Чувашия",
  "Урмары, Чувашия",
  "Цивильск, Чувашия",
  "Чебоксары, Чувашия",
  "Шемурша, Чувашия",
  "Шумерля, Чувашия",
  "Ядрин, Чувашия",
  "Яльчики, Чувашия",
  "Янтиково, Чувашия",
  "Анадырь, Чукотский АО",
  "Билибино, Чукотский АО",
  "Губкинский, Ямало-Ненецкий АО",
  "Заполярный, Ямало-Ненецкий АО",
  "Муравленко, Ямало-Ненецкий АО",
  "Надым, Ямало-Ненецкий АО",
  "Новый Уренгой, Ямало-Ненецкий АО",
  "Ноябрьск, Ямало-Ненецкий АО",
  "Пуровск, Ямало-Ненецкий АО",
  "Салехард, Ямало-Ненецкий АО",
  "Тарко, Ямало-Ненецкий АО",
  "Андропов, Ярославская обл.",
  "Берендеево, Ярославская обл.",
  "Большое Село, Ярославская обл.",
  "Борисоглебский, Ярославская обл.",
  "Брейтово, Ярославская обл.",
  "Бурмакино, Ярославская обл.",
  "Варегово, Ярославская обл.",
  "Волга, Ярославская обл.",
  "Гаврилов Ям, Ярославская обл.",
  "Данилов, Ярославская обл.",
  "Любим, Ярославская обл.",
  "Мышкино, Ярославская обл.",
  "Некрасовское, Ярославская обл.",
  "Новый Некоуз, Ярославская обл.",
  "Переславль-Залесский, Ярославская обл.",
  "Пошехонье-Володарск, Ярославская обл.",
  "Ростов, Ярославская обл.",
  "Рыбинск, Ярославская обл.",
  "Тутаев, Ярославская обл.",
  "Углич, Ярославская обл.",
  "Ярославль, Ярославская обл."],
find = function (arr, find) {
      return arr.filter(function (value) {
          return (value + "").toLowerCase().indexOf(find.toLowerCase()) != -1;
      });
  };
var provider = {
  suggest: function (request, options) {
      var res = find(arr, request),
          arrayResult = [],
          results = Math.min(options.results, res.length);
      for (var i = 0; i < results; i++) {
          arrayResult.push({displayName: res[i], value: res[i]})
      }
      return ymaps.vow.resolve(arrayResult);
  }
};

</script>
<style>
#map,
.ymaps-2-1-79-inner-panes {height: 400px;margin-bottom:20px}
</style>
    ';
    }

    return $field;
}



add_filter("woocommerce_form_field","change_woocommerce_field_markup", 10, 4);
// add_filter("woocommerce_after_cart_table","change_woocommerce_field_markup", 10, 4);



add_filter('woocommerce_checkout_before_customer_details', 'woocommerce_checkout_before_customer_details_action');
function woocommerce_checkout_before_customer_details_action()
{
    echo '<h1 class="headline">Оформление заказа</h1><div class="checkout-cols-wrapper"><div class="checkout-left-sidebar">';
}
add_filter('woocommerce_checkout_before_order_review', 'woocommerce_checkout_before_order_review_action');
function woocommerce_checkout_before_order_review_action()
{
    echo '<div class="checkout-right-sidebar"><div class="checkout-right-wrapper">';
}


add_filter('woocommerce_checkout_after_order_review', 'closing_div');
add_filter('woocommerce_after_checkout_form', 'closing_div');
add_filter('woocommerce_checkout_after_order_review', 'closing_div');
function closing_div()
{
    echo '</div>';
}


add_filter('woocommerce_checkout_after_customer_details', 'payment_section');
function payment_section(){
    get_template_part('template-parts/section', 'payments');
    echo '</div>';
}

add_filter( 'woocommerce_cross_sells_orderby', function() { return 'date'; } );
add_filter( 'woocommerce_cross_sells_order', function() { return 'desc'; } );


add_action( 'woocommerce_product_options_general_product_data', 'product_custom_metas' );

function product_custom_metas() {
    echo '<div class="option_group">';
    woocommerce_wp_text_input(
        array(
            'id'          => '_custom_product_id',
            'label'       => '"Внешний ID" из МС',
            'value' => get_post_meta( get_the_ID(), '_custom_product_id', true )
        )
    );
    if(wc_get_product(get_the_ID())->get_type() == 'bundle'){
        woocommerce_wp_text_input(
            array(
                'id'          => '_custom_complex_name',
                'label'       => 'Название комплектации',
                'value' => get_post_meta( get_the_ID(), '_custom_complex_name', true )
            )
        );
    }
    echo '</div>';
}

add_action( 'woocommerce_process_product_meta', 'save_product_custom_metas', 10, 2 );
function save_product_custom_metas( $id, $post ){
    update_post_meta( $id, '_custom_product_id', $_POST['_custom_product_id'] );
    update_post_meta( $id, '_custom_complex_name', $_POST['_custom_complex_name'] );
}


add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');

function woocommerce_ajax_add_to_cart() {

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        WC_AJAX :: get_refreshed_fragments();
    } else {

        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

        echo wp_send_json($data);
    }

    wp_die();
}

add_action('woocommerce_checkout_order_processed', 'remove_bundle', 10, 1);

function remove_bundle($order_id){
    $order = wc_get_order($order_id);
    foreach ($order->get_items() as $item_id => $item) {
        if ($item->get_product()->get_type() == 'bundle' || $item->get_product()->get_type() == 'woosb') {
            wc_delete_order_item($item_id);
        }
    }
}




add_action( 'woocommerce_product_query_meta_query', 'filter_product_archive' );
function filter_product_archive(){
    return array(
        'relation' => 'AND',
        array(
            'key' => '_thumbnail_id',
            'compare' => '>',
            'value' => '0'
        ),
        array(
            'key' => '_price',
            'compare' => '>',
            'value' => '0'
        )
    );
}

function searchfilter($query) {

    if ($query->is_search && !is_admin() ) {
        $query->set( 'post_type',array('product') );
        $query->set( 'orderby', 'meta_value_num' );
        $query->set( 'meta_key', '_price' );
    }

    return $query;
}

add_filter('pre_get_posts','searchfilter');



function mn_custom_validate_billing_phone() {
    if($_POST['billing_phone'][17] == '_') {
        wc_add_notice( 'ah shit. here wo go again', 'error' );
    }
}
add_action('woocommerce_checkout_process', 'mn_custom_validate_billing_phone');

/*add_filter('woocommerce_default_address_fields', 'override_default_address_checkout_fields', 20, 1);
function override_default_address_checkout_fields( $address_fields ) {
    $address_fields['first_name']['placeholder'] = 'Fornavn';
    $address_fields['last_name']['placeholder'] = 'Efternavn';
    $address_fields['address_1']['placeholder'] = 'Adresse';
    $address_fields['state']['placeholder'] = 'Stat';
    $address_fields['postcode']['placeholder'] = 'Postnummer';
    $address_fields['city']['placeholder'] = 'By';
    return $address_fields;
}*/

