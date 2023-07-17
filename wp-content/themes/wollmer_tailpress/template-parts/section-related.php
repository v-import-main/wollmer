<?php
global $product;
$list = $product->get_cross_sell_ids( 'view' );
$_list = [];
if(count($list)){
  foreach($list as $product_id) {
    $product = wc_get_product( $product_id );
    if(
      !empty($product->get_image_id())
    ){
      $_list[] = $product_id;
    }
  }
  if(count($_list)){
?>
<section id="section-product" class="section-product">
  <div class="headline">
    <h2>Покупают вместе</h2>
  </div>
  <div class="product-list">
    <?php
  foreach($_list as $product_id) {
    $product = wc_get_product( $product_id );
    get_template_part('template-parts/item', 'product', ['product' => $product]);
  }?>
  </div>
</section>
<?php }
} ?>