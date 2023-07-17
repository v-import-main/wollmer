<?php
global $product;

$upsells = $product->get_upsells();
if(count($upsells)){
  $is_slider = count($upsells) > 0;
?>
<section id="complex">
  <h2>Выбери свою комплектацию</h2>
  <div class="complex-wrapper complex-cols-<?= count($upsells)+1; ?> <?= !$is_slider ?: 'multicomplex'; ?>" >
  <?php if($is_slider){ ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    <div class="swiper">
      <div class="swiper-nav">
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
      <div class="complex-inner swiper-wrapper">
        <?php
        set_query_var('complect_id',$product->get_id());
        get_template_part('template-parts/item', 'complex');
        foreach($upsells as $upsell){
          set_query_var('complect_id',$upsell);
          get_template_part('template-parts/item', 'complex');
        }
        ?>
      </div>
    </div>
    <?php }
      set_query_var('complect_id',$product->get_id());
      get_template_part('template-parts/item', 'complex');
      foreach($upsells as $upsell){
        set_query_var('complect_id',$upsell);
        get_template_part('template-parts/item', 'complex');
      }
    ?>
  </div>
</section>
<?php } ?>