<?php
$tags = [
  [
    'title' => 'Wallmer Care',
    'permalink' => '/',
  ],
  [
    'title' => 'Наши принципы',
    'permalink' => '/',
  ],
  [
    'title' => 'Сервисное обслуживание',
    'permalink' => '/',
  ],
  [
    'title' => 'Где купить?',
    'permalink' => '/',
  ],
  [
    'title' => 'Доставка и оплата',
    'permalink' => '/',
  ],
  [
    'title' => 'Аксессуары',
    'permalink' => '/',
  ],
  [
    'title' => 'Гарантия',
    'permalink' => '/',
  ],
  [
    'title' => 'Техника в разработке',
    'permalink' => '/',
  ]
]
?>

<section id="database">
  <h2>База знаний Wollmer</h2>
  <div class="taglist">
    <?php foreach($tags as $tag) { ?>
      <a href="<?= $tag['permalink']; ?>"><?= $tag['title']; ?></a>
    <?php } ?>
  </div>
</section>