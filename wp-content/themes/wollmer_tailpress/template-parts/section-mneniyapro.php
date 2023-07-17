<?php
// global $product;
$product = wc_get_product(get_the_ID());
if( has_term( 'komplektuyuschie', 'product_cat', $product->get_id() ) ) return;
if( has_term( 'programma-wollmer-care', 'product_cat', $product->get_id() ) ) return;
// if( has_term( 'aksessuary', 'product_cat', $product->get_id() ) ) return;

$sku = $product->get_sku();
if($product->get_type() === 'woosb' || $product->get_type() === 'bundle'){
  $siblibgs = $product->get_upsells();
  foreach ( $siblibgs as $_product_id ) {
    $_product = get_product($_product_id);
    if($_product->get_type() === 'woosb' || $_product->get_type() === 'bundle'){
      continue;
    } else {
      $sku = $_product->get_sku();
      break;
    }
  }
}
?>

<script type="text/javascript" src="//cdn.mneniya.pro/widgetscipts/wollmerru/mp-widget.js"></script>
<div class="section-mneniyapro hidden order-4">
  <div id="revseq" class="mp-widget"
    mp-show-rating-value="true"
    id="mneniyapro-section"
    mp-show-service-logo="false"
    data-mp-productSKUs="<?= $sku; ?>"
    data-mp-widget-type="Product">
  </div>
</div>
<script>
  addEventListener('DOMContentLoaded', (event) => {

    function checkForElement() {
      var element = document.querySelector('.mp-total-score span');
      if (!element) {
        setTimeout(checkForElement, 3000);
      } else {
        // console.log('val',element);
        document.querySelector('.rating-top-count').innerHTML = element.innerText.replace(/[()]/g,'');
        document.querySelector('.rating-top').classList.remove('invisible');
        document.querySelector('.section-mneniyapro').classList.remove('hidden');
      }
    }
    checkForElement();

  });
</script>