<?php get_header(); ?>
<div class="container mx-auto">

  <?php get_template_part('template-parts/top', 'catalog'); ?>


  <section class="section-product">
    <?php
    if(is_shop()){
      if (have_posts()) :
        $home = [];
        $home_acc = [];
        $kitchen = [];
        $kitchen_acc = [];

        while (have_posts()) :
          the_post();
          global $product;
          if (wc_get_product_terms($product->get_id(), 'section_shop_tax')[0]->slug == 'home'){
            $home[] = $product;
          };
          if (wc_get_product_terms($product->get_id(), 'section_shop_tax')[0]->slug == 'kitchen'){
            $kitchen[] = $product;
          };
        endwhile;
        ?>
        <div class="image">
          <?php
          $term_id = get_term_by( 'slug', 'home', 'section_shop_tax')->term_id;
          ?>
          <img src="<?= wp_get_attachment_url(carbon_get_term_meta($term_id,'preview')); ?>" alt="">
        </div>
        <div class="headline">
          <h2>Товары для дома</h2>
        </div>
        <div class="product-list def">
          <?php
          foreach($home as $product) {
            if(wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_ID() ), 'single-post-thumbnail' )) { 
              get_template_part('template-parts/item', 'product',['product' => $product]);
              $home_acc = array_merge($home_acc,$product->get_cross_sell_ids( 'view' ));
            }
          } ?>
          </div>
          <div class="headline">
            <h2>Аксессуары</h2>
          </div>
          <div class="product-list def">
          <?php
          $i=0;
          foreach($home_acc as $key=>$product_id) {
            if(wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' )) { 
              $product = wc_get_product( $product_id );
              get_template_part('template-parts/item', 'product',['product' => $product]);
              $i++;
            }
            if($i==4) break;
          }
          ?>
          </div>
          <div class="botline shown">
          <button class="btn" onclick="show_other_complects(this,'<?= implode(';',array_slice($home_acc,3));?>')">Показать еще</button>
          </div>

        <div class="image">
          <?php
          $term_id = get_term_by( 'slug', 'kitchen', 'section_shop_tax')->term_id;
          ?>
          <img src="<?= wp_get_attachment_url(carbon_get_term_meta($term_id,'preview')); ?>" alt="">
        </div>
        <div class="headline">
          <h2>Товары для кухни</h2>
        </div>
        <div class="product-list def">
          <?php
          foreach($kitchen as $product) {
            if(wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_ID() ), 'single-post-thumbnail' )) { 
              get_template_part('template-parts/item', 'product',['product' => $product]);
              $kitchen_acc = array_merge($kitchen_acc,$product->get_cross_sell_ids( 'view' ));
            }
          }
          ?>
          </div>
          <div class="headline">
            <h2>Аксессуары</h2>
          </div>
          <div class="product-list def">
          <?php
          $i=0;
          foreach($kitchen_acc as $key=>$product_id) {
            if(wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' )) { 
              $product = wc_get_product( $product_id );
              get_template_part('template-parts/item', 'product',['product' => $product]);
              $i++;
            }
            if($i==4) break;
          }
          ?>
          </div>
          <div class="botline shown">
            <button class="btn" onclick="show_other_complects(this,'<?= implode(';',array_slice($kitchen_acc,3));?>')">Показать еще</button>
          </div>
        <?php
        endif;
      } else {
        ?>
        <div class="headline">
          <h2><?= get_queried_object()->name; ?></h2>
        </div>
        <div class="product-list def">
        <?php
         $args = array(
          'post_type' => 'product',
          'stock' => 1,
          'posts_per_page' => 50,
          'product_cat' => get_queried_object()->slug,
          'type' => 'simple',
          'orderby' =>'date',
          'order' => 'ASC'
        );
         $loop = new WP_Query( $args );
          while ($loop->have_posts()) :
            $loop->the_post();
            do_action( 'woocommerce_shop_loop' );
            get_template_part('template-parts/item', 'product');
          endwhile;
          wp_reset_query();
        ?>
        </div>
        <?php
      }
  ?>

  </section>

</div>

<?php

get_footer();
