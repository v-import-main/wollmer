<section id="section-database" class="<?= is_front_page() ? 'db' : 'product'; ?>">
  <?php
  $prod_tags = [
    'Дополнительная гарантия 1 год',
    'Ремонт/замена без диагностики',
    'Подменный товар на время ремонта',
    'Скидка 10% на все товары Wollmer',
    'Бесплатная замена расходников',
    'Trade-in 20%',
  ];
  $tags = [
    [
      'title' => 'Wollmer Care',
      'permalink' => '/care/',
    ],
    [
      'title' => 'О компании Wollmer',
      'permalink' => '/about-us/',
    ],
    [
      'title' => 'Сервисное обслуживание',
      'permalink' => '/service/',
    ],
    [
      'title' => 'Доставка и оплата',
      'permalink' => '/payment-and-delivery/',
    ],
    [
      'title' => 'Аксессуары',
      'permalink' => '/products/aksessuary/',
    ],
    [
      'title' => 'Обмен и возврат',
      'permalink' => '/exchange/',
    ],
  ];


  if ( is_front_page() ) { ?>
    <h2>База знаний Wollmer</h2>
    <div class="taglist main">
      <?php foreach ($tags as $tag) { ?>
        <a href="<?= $tag['permalink']; ?>"><?= $tag['title']; ?></a>
      <?php } ?>
    </div>
  <?php } else {
    // global $product;
    
    $product = wc_get_product(get_the_ID());
    if(get_care($product) !== false) {
  ?>
    <div class="product-info">
      <h2>Wollmer Care</h2>
      <p>Программа постгарантийного обслуживания техники и специальных привилегий WOLLMER CARE</p>
      <a class="button ajax_add_to_cart add_to_cart_button addtocart" data-product_id="<?= get_care( $product ); ?>" data-quantity="1" href="?add-to-cart=<?= get_care( $product ); ?>&quantity=1">
        <span>Добавить страховку</span>
      </a>
      <span class="button">Уже в корзине</span>
    </div>
    <div class="taglist">
      <?php foreach ( $prod_tags as $tag ) { ?>
        <span><?= $tag; ?></span>
      <?php } ?>
    </div>
    <a class="button ajax_add_to_cart add_to_cart_button addtocart" data-product_id="<?= get_care( $product ); ?>" data-quantity="1" href="?add-to-cart=<?= get_care( $product ); ?>&quantity=1">
      <span>Добавить страховку</span>
    </a>
    <span class="button">Уже в корзине</span>
  <?php }
  } ?>
</section>