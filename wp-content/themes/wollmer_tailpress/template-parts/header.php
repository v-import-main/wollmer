<?php
$phone = carbon_get_theme_option('phone'); 
?>
<header>
  <div class="header">
    <div class="container">
      <div>
        <div>
          <div class="col-left">
            <div class="logo-wrap">
              <?= file_get_contents(tailpress_asset('resources/svg/logo.svg')); ?>
              <a class="tel" href="tel:<?= preg_replace("/[^0-9]/", "",$phone); ?>"><?= $phone; ?></a>
            </div>
            <div class="search-mobile-toggler">
              <?= file_get_contents(tailpress_asset('resources/svg/search.svg')); ?>
            </div>
          </div>

          <div class="col-mid">
              <a href="/">
                <?= file_get_contents(tailpress_asset('resources/svg/logo_text.svg')); ?>
              </a>
          </div>

          <div class="col-right">
            <div class="subcol-left">
              <?php get_search_form( $args ); ?>
            </div>
            <div class="subcol-right">
              <a href="/cart/" id="cart_icon">
                <?= file_get_contents(tailpress_asset('resources/svg/cart.svg')); ?>
              </a>
              <?php if(WC()->cart->get_cart_contents_count() !== 0){ ?>
                <a href="/cart/" class="badge"><?= WC()->cart->get_cart_contents_count(); ?></a>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php if (is_product() || is_cart()) {
    if(! is_cart()){
      get_template_part('template-parts/product', 'bar'); 
    }
    get_template_part('template-parts/cart', 'notice');
  } ?>
  <div id="modal-suggest"></div>
</header>