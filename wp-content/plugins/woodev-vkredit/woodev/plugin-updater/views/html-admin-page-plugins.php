<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="wrap woodev_addons_wrap">

	<h1 class="screen-reader-text">Плагины Woodev</h1>

	<ul class="products">
		<?php foreach ( $addons as $addon ) : ?>
		<li class="product product-<?php echo $addon->info->slug;?>" id="product-<?php echo $addon->info->id;?>">
			<a href="<?php echo esc_attr( $addon->info->link ); ?>">
				<?php if ( ! empty( $addon->info->thumbnail ) ) : ?>
				<span class="product-img-wrap"><img src="<?php echo esc_url( $addon->info->thumbnail ); ?>"/></span>
				<?php else : ?>
				<h2><?php echo esc_html( $addon->info->title ); ?></h2>
				<?php endif; ?>
				<p><?php echo wp_kses_post( $addon->info->excerpt ); ?></p>
			</a>
		</li>
	<?php endforeach; ?>
	</ul>
	
	<div class="clear"></div>
	
	<div class="woodev-addons-footer">
		<a href="https://woodev.ru/shop/?utm_source=woodev-plugin-page&utm_medium=plugin&utm_campaign=woodev&utm_content=Все%20Плагины" class="button-primary" target="_blank">Посмотреть на сайте</a>
	</div>

</div>			