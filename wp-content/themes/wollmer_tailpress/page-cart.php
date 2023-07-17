<?php get_header(); ?>
<div class="container my-8 mx-auto 2fpm_start">

  <?php if (have_posts()) : ?>
    <?php
    while (have_posts()) :
      the_post();
    ?>
      <div class="entry-content">
        <div class="title-section">
          <h1><?php the_title(); ?></h1>
          <span><?= WC()->cart->get_cart_contents_count(); ?></span>
        </div>
        <div id="notices">
          <?php wc_print_notices(); ?>
        </div>
        <?php the_content(); ?>
      </div>
      <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
        jQuery('#notices').appendTo(jQuery('.woocommerce-coupon-form'));
        jQuery('body').on('click', 'button.plus, button.minus', function() {

          var qty = jQuery(this).parent().find('input'),
            val = parseInt(qty.val()),
            min = parseInt(qty.attr('min')),
            max = parseInt(qty.attr('max')),
            step = parseInt(qty.attr('step'));

          // дальше меняем значение количества в зависимости от нажатия кнопки
          if (jQuery(this).is('.plus')) {
            if (max && (max <= val)) {
              qty.val(max);
              
            } else {
              qty.val(val + step);
            }
          } else {
            console.log('min:',min);
            console.log('max:',max);
            if (min && (min >= val)) {
              qty.val(min);
            } else if (val > 1) {
              qty.val(val - step);
            } else {
              jQuery(this).parents('.cart_item').find('.remove').trigger('click')
            }
          }

          qty.change();
          jQuery( '[name="update_cart"]' ).trigger( 'click' );
        });

      });
      </script>

    <?php endwhile; ?>

  <?php endif; ?>

</div>

<?php
get_footer();
