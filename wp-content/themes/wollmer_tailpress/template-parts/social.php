<div class="social social2">
  <?php
  $soc = ['youtube', 'vk', 'telegram', 'whatsapp', 'facebook', 'instagram'];
  foreach ($soc as $key => $soc_el) {
    if (carbon_get_theme_option($soc_el . '_toggler') && carbon_get_theme_option($soc_el) !== '') { ?>
      <a target="_blank" href="<?= carbon_get_theme_option($soc_el); ?>" class="<?= in_array($soc_el, ['whatsapp', 'telegram']) ? '' : 'soc_show'; ?>">
        <?= file_get_contents(tailpress_asset('resources/svg/' . $soc_el . '.svg')); ?>
      </a>
  <?php
    }
  }
  ?>
</div>