<div class="nav-bg"></div>
<nav id="nav-catalog">
  <span class="catalog-nav-toggler">
    <?= file_get_contents(tailpress_asset('resources/svg/arrow.svg')); ?>
  </span>
    <?php
    $backup = $wp_query;
    $wp_query = NULL;
    $wp_query = new WP_Query(array('post_type' => 'post')); 
    wp_nav_menu(
      array(
        'menu_class'      => 'categories',
        'theme_location'  => 'footer_cats',
        'li_class'        => '',
        'fallback_cb'     => false,
      )
    ); ?>
    <?php wp_nav_menu(
      array(
        'menu_class'      => 'menu',
        'theme_location'  => 'sidebar',
        'li_class'        => '',
        'fallback_cb'     => false,
      )
    );
    $wp_query = $backup;
    ?>
</nav>