<?php get_header();?>

<div class="container mx-auto">

  <section class="search section-product">
    <div class="headline">
      <h2>По запросу «<span><?= get_search_query(); ?></span>» найдено <?= get_search_count(); ?></h2>
      <!-- <span class="btn contur">Изменить запрос</span> -->
    </div>
    <div class="product-list def">
      <?php if (have_posts()) :
        while (have_posts()) :
          the_post();
          $product = new WC_Product($post);
          get_template_part('template-parts/item', 'product');
        endwhile;
      endif;
      ?>
    </div>
    <div class="botline">
    <a class="btn" href="/shop/">Все товары</a>
  </div>
  </section>

</div>
<?php

get_footer();
