<?php
$product_id = wc_get_product()->get_id();
$product = wc_get_product( $product_id );

$preview_image_id = carbon_get_post_meta(get_the_ID(),'scheme');

?>
<section id="chars">
    <?php if($preview_image_id){ ?>
    <div class="columns">
        <div class="left-col">
            <img src="<?= wp_get_attachment_url($preview_image_id); ?>" alt="Схема <?= get_the_title(); ?>">
        </div>
        <?php } ?>
        <div class="right-col">
            <ul>
            <?php
                $attributes = $product->get_attributes();
                $key = 0;
                foreach ( $attributes as $attribute ) {

                    $attribute_name = wc_attribute_label($attribute->get_name());

                    // if($attribute_name === 'Комплект'){
                    //     continue;
                    // } else {
                        $key++;
                    // }

                    $attribute_terms = $attribute->get_terms();
                    
                    if($key == 10 && count($attributes) > 12){ ?>
                        <div class="showmore-atts">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="28" width="28" height="28" rx="14" transform="rotate(90 28 0)" fill="#E5E5E5"/>
                                <path d="M18.375 14.875L17.7656 14.2494L14.4375 17.5656V8.75H13.5625V17.5656L10.2493 14.2494L9.625 14.875L14 19.25L18.375 14.875Z" fill="#171818"/>
                            </svg>
                            <span>Показать все характеристики</span>
                        </div>
                    <?php } ?>
                        <li class="<?= $key >= 10 && count($attributes) > 12 ? '!hidden' : '' ?>">
                            <p class="left"><?= $attribute_name; ?></p>
                            <div class="right">
                    <?php
                    foreach ($attribute_terms as $term) {
                        $term_name = $term->name;
                        // $term_value = $product->get_attribute($attribute->get_name(), $term->slug);
                        ?>
                            <p><?= $term_name; ?></p>
                        <?php
                    }
                    ?>
                    </div>
                    </li>
                    <?php
                }
            ?>
            </ul>
            <?php if(carbon_get_post_meta(get_the_ID(),'pdf')){ ?>
            <a class="btn pdf" href="<?= wp_get_attachment_url(carbon_get_post_meta(get_the_ID(),'pdf')); ?>">
                <svg width="20px" height="20px" preserveAspectRatio=”none” viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3 6.1519V19.3095C3.99197 18.8639 5.40415 18.4 7 18.4C8.58915 18.4 9.9999 18.8602 11 19.3094V6.1519C10.7827 6.02653 10.4894 5.8706 10.1366 5.71427C9.31147 5.34869 8.20352 5 7 5C5.26385 5 3.74016 5.72499 3 6.1519ZM13 6.1519V19.3578C13.9977 18.9353 15.41 18.5 17 18.5C18.596 18.5 20.0095 18.9383 21 19.3578V6.1519C20.2598 5.72499 18.7362 5 17 5C15.7965 5 14.6885 5.34869 13.8634 5.71427C13.5106 5.8706 13.2173 6.02653 13 6.1519ZM12 4.41985C11.7302 4.26422 11.3734 4.07477 10.9468 3.88572C9.96631 3.45131 8.57426 3 7 3C4.69187 3 2.76233 3.97065 1.92377 4.46427C1.30779 4.82687 1 5.47706 1 6.11223V20.0239C1 20.6482 1.36945 21.1206 1.79531 21.3588C2.21653 21.5943 2.78587 21.6568 3.30241 21.3855C4.12462 20.9535 5.48348 20.4 7 20.4C8.90549 20.4 10.5523 21.273 11.1848 21.6619C11.6757 21.9637 12.2968 21.9725 12.7959 21.6853C13.4311 21.32 15.0831 20.5 17 20.5C18.5413 20.5 19.9168 21.0305 20.7371 21.4366C21.6885 21.9075 23 21.2807 23 20.0593V6.11223C23 5.47706 22.6922 4.82687 22.0762 4.46427C21.2377 3.97065 19.3081 3 17 3C15.4257 3 14.0337 3.45131 13.0532 3.88572C12.6266 4.07477 12.2698 4.26422 12 4.41985Z" fill="#000000"/>
                </svg>
                <span>
                    Инструкция к товару
                </span>
            </a>
            <?php } ?>
        </div>
    </div>
</section>
