<?php get_header(); ?>

<div class="container mx-auto">

  <?php get_template_part('template-parts/catalog', 'top'); ?>


  <section id="section-product">
    <div class="product-list">

      <?php if (have_posts()) :
        while (have_posts()) :
          the_post();
          get_template_part('template-parts/item', 'product');
        endwhile;
      endif;
      ?>
      
      <div class="botline">
        <button class="btn">Показать еще</button>
      </div>
    </div>
  </section>
</div>

<?php

get_footer();
