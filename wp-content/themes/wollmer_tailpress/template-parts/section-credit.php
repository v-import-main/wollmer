<?php
global $SHOP_ID;
global $SHOWCASE_ID;
global $product;
$type = '';
$var_prod = false;

if(is_product()){
  $type = 'product';
  
  if( $product->get_stock_quantity() < 1 ) return;
  if( has_term( 'komplektuyuschie', 'product_cat', $product->get_id() ) ) return;
  if( has_term( 'programma-wollmer-care', 'product_cat', $product->get_id() ) ) return;
  if( has_term( 'aksessuary', 'product_cat', $product->get_id() ) ) return;
  
}
if(is_cart()){
  $type = 'cart';
}
?>
<section id="section-credit">
  <p class="h1">Техника для жизни без переплат</p>
  <p class="h2">Купить в рассрочку 0%</p>
  <div class="credit-btns-wrap">
    <button
      type="button"
      onclick="init_tin(3)"
    >на 3 месяца</button>
    <button
      type="button"
      onclick="init_tin(6)"
    >на 6 месяцев</button>
    <button
      type="button"
      onclick="init_tin(12)"
    >на 12 месяцев</button>
  </div>

  <script src="https://forma.tinkoff.ru/static/onlineScript.js"></script>
  <script>
    var type = '<?= $type; ?>';
    var var_prod = '<?= $var_prod; ?>';
    var tin_obj;
    tin_obj = {
      sum: get_cart_sum(),
      items: get_cart_items(),
      demoFlow: 'sms',
      shopId: '<?= $SHOP_ID; ?>',
      showcaseId: '<?= $SHOWCASE_ID; ?>',
    }

    function get_cart_sum() {
      // console.log('var_prod',var_prod);
      // console.log('type',type);
      if(type === 'cart'){
        return document.querySelector('.cart-subtotal .woocommerce-Price-amount bdi').innerHTML.split('&nbsp;')[0].replace(' ', '');
      } else
      if(type === 'product') {
        return document.querySelector('h1').getAttribute('data-price');
      }
    }

    function get_cart_items() {
      let items = [];
      
      if(type === 'cart'){
        let cart_list = document.querySelector('.woocommerce-cart-form tbody').children;
        for (let i = items.length; i < cart_list.length-1; i++ ) {
          if(cart_list[i].innerText !== '' && !cart_list[i].classList.contains('bundled_table_item')) {
            let price_div = cart_list[i].querySelector('.product-price>.amount') ?
              cart_list[i].querySelector('.product-price>.amount>bdi') :
              cart_list[i].querySelector('.product-price>ins>.amount>bdi');
            items[items.length] = {
              // 'name': cart_list[i].querySelector('.product-name a').innerText,
              'name': cart_list[i].querySelector('.product-name').innerText.split('\n')[0],
              'price': parseInt(price_div.innerHTML.split('&nbsp;')[0].replace(' ', '')),
              'quantity': parseInt(cart_list[i].querySelector('.quantity input').value)
            }
          }
        }
        items[items.length] = {
          'name': 'Доставка',
          'price': 400,
          'quantity': 1
        }
      } else if(type === 'product') {
        items[0] = {
          'name': document.querySelector('h1').innerText.split(' - ')[0],
          'price': parseInt(get_cart_sum()),
          'quantity': 1
        }
        items[1] = {
          'name': 'Доставка',
          'price': 400,
          'quantity': 1
        }
      }
      
      return items;
    }

    function init_tin(time) {
      let $time = '';
      let delivery = 400;
      tin_obj.sum = parseInt(get_cart_sum())+delivery;

      console.log('sum',tin_obj.sum);
      console.log('items',tin_obj.items);
      switch (time) {
        case 3:
          $time = 'installment_0_0_3_5,19'; 
          break;
        case 6:
          $time = 'installment_0_0_6_8,84'; 
          break;
        case 12:
          $time = 'installment_0_0_12_15,59'; 
          break;
        default:
          break;
      };

      tin_obj.promoCode = $time;
      
      tinkoff.create(
        tin_obj,
      {view: 'modal'}
      )
    }
  </script>
</section>