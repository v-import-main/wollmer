<div class="container mx-auto">
	<?php
	if(!is_cart() && !is_checkout()){
		// get_template_part( 'template-parts/contact','form' );
	}
	?>
</div>
</main>

<?php
// do_action( 'tailpress_content_end' );
?>

</div>

<?php
// do_action( 'tailpress_content_after' );
?>

<footer>
	<?php
	// do_action( 'tailpress_footer' );

	$email = carbon_get_theme_option('email');
	$phone = carbon_get_theme_option('phone');
	$schedule = carbon_get_theme_option('schedule');
	?>
	<div class="cols">

		<div class="col contact-col">
			<a href="/" class="logo">
				<?= file_get_contents(tailpress_asset('resources/svg/logo_text.svg')); ?>
			</a>
			<div class="contacts">
				<a href="mailto:<?= $email; ?>">
					<?= file_get_contents(tailpress_asset('resources/svg/foot_email.svg')); ?>
					<?= $email; ?>
				</a>
				<a href="tel:<?= preg_replace("/[^0-9]/", "",$phone); ?>">
					<?= file_get_contents(tailpress_asset('resources/svg/foot_phone.svg')); ?>
					<?= $phone; ?>
				</a>
				<p>
					<?= file_get_contents(tailpress_asset('resources/svg/foot_clock.svg')); ?>
					<?= $schedule; ?>
				</p>
			</div>
			<p>Wollmer.ru &copy; <?= date_i18n('Y'); ?></p>
			<?php get_template_part('template-parts/social'); ?>
		</div>
		<div class="col about-col">
			<h3>О Wollmer</h3>
			<?php
			$backup = $wp_query;
			$wp_query = NULL;
			$wp_query = new WP_Query(array('post_type' => 'post')); 
			wp_nav_menu(
				array(
					'container_id'    => 'primary-menu',
					'menu_class'      => '',
					'theme_location'  => 'primary',
					'li_class'        => '',
					'fallback_cb'     => false,
				)
			);	
			?>
		<!-- <a class="callback" href="#contact-form">Обратная связь с директором</a> -->
		</div>
		<div class="col categories-col">
			<h3>Продукция</h3>
			<?php
				wp_nav_menu(
					array(
						'container_id'    => 'cats-menu',
						'menu_class'      => '',
						'theme_location'  => 'footer_cats',
						'li_class'        => '',
						'fallback_cb'     => false,
					)
				);
				$wp_query = $backup;
			?>
		</div>
	</div>
</footer>

<?php
// get_template_part('template-parts/bottom', 'bar');
get_template_part('template-parts/nav', 'catalog');
get_template_part('template-parts/mobile', 'search');
// get_template_part('template-parts/modal', 'auth');
?>
<?php if(
	// !is_cart() && !is_checkout())
	is_product()
	) { ?>
	<?php
	get_template_part('template-parts/modal', 'added');
	get_template_part('template-parts/btn', 'top');
	?>
<?php } ?>
</div>

<?php wp_footer(); ?>
<?php
echo carbon_get_theme_option('lowerbody');

// echo '<pre style="margin-bottom: 100px;">';
// global $wp_scripts;
// print_r($wp_scripts);
// print_r(get_intermediate_image_sizes());
// echo '</pre>';

?>
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>
</body>
</html>