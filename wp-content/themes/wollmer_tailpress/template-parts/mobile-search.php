<div id="mobile-search">
  <span class="search-mobile-toggler">
    <?= file_get_contents(tailpress_asset('resources/svg/arrow.svg')); ?>
  </span>
  <?php get_search_form( $args ); ?>
</div>
