<nav id="bar">
  <a href="/">
    <span class="<?= is_front_page() ? 'active' : ''; ?>">
      <?= file_get_contents(tailpress_asset('resources/svg/bar_home.svg')); ?>
    </span>
    <p>Главная</p>
  </a>
  <span class="catalog-nav-toggler">
    <span>
      <?= file_get_contents(tailpress_asset('resources/svg/bar_catalog.svg')); ?>
    </span>
    <p>Каталог</p>
</span>
  <span>
    <span class="search-mobile-toggler">
      <?= file_get_contents(tailpress_asset('resources/svg/search.svg')); ?>
    </span>
    <p>Поиск</p>
  </span>
  <a href="/cart/">
    <span>
      <?= file_get_contents(tailpress_asset('resources/svg/bar_cart.svg')); ?>
    </span>
    <p>Корзина</p>
  </a>
  <?php if(1>2){ ?>
  <a href="/personal/" >
    <span>
      <?= file_get_contents(tailpress_asset('resources/svg/bar_personal.svg')); ?>
    </span>
    <p>Профиль</p>
  </a>
  <?php } ?>
</nav>