<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ) ?>" >
	<input class="input search-input" type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Поиск по товарам" onkeyup="this.setAttribute('value', this.value);"/>
	<div class="search-cross">
  	<?= file_get_contents(tailpress_asset('resources/svg/cross.svg')); ?>
  </div>
	<input class="btn search-btn" type="submit" id="searchsubmit" value="Найти" />
</form>