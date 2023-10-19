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

		<div class="col contact-col 22222">
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
            <?php get_template_part('template-parts/social'); ?>
            <a href="/legal/">Правовая информация</a>
            <p>Wollmer.ru &copy; <?= date_i18n('Y'); ?></p>

		</div>
		<div class="col about-col">
			<h3 id="primary-menu-h3">О Wollmer
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 15L12 9L18 15" stroke="#D1D1D1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </h3>
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
			<h3 id="cats-menu-h3">Продукция
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 15L12 9L18 15" stroke="#D1D1D1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </h3>
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
        <div class="col subscribe" >
            <h3>Скидка 500 ₽ — на первый заказ</h3>
            <p class="subtitle">Подпишись на рассылку и получи промокод на скидку</p>

            <form method="POST" action="https://cp.unisender.com/ru/subscribe?hash=6xr6faea6iqmjrnhmbuusxncjhacrdnd71c1uc1dedup39xnj9yoy" name="subscribtion_form" target="_blank">
                <div class="subscribe-form-item subscribe-form-item--container">
                    <div class="subscribe-form-item subscribe-form-item--input-email">
                        <input class="subscribe-form-item__control subscribe-form-item__control--input-email" type="text" name="email" value=""  required>
                        <label class="subscribe-form-item__label subscribe-form-item__label--input-email subscribe-form-item__label--required">E-mail</label>
                    </div>
                    <div class="subscribe-form-item subscribe-form-item--btn-submit">
                        <input class="subscribe-form-item__btn subscribe-form-item__btn--btn-submit" type="submit" value="">
                        <?= file_get_contents(tailpress_asset('resources/svg/arrow-right.svg')); ?>
                    </div>
                </div>
                <input type="hidden" name="charset" value="UTF-8">
                <input type="hidden" name="default_list_id" value="1">
                <input type="hidden" name="overwrite" value="2">
                <input type="hidden" name="is_v5" value="1">
            </form>

            <span>Подписываясь на рассылку, вы соглашаетесь с условиями <a href="">политики конфиденциальности</a></span>


        </div>
        <div class="col col-tablet">
            <a href="/legal/">Правовая информация</a>
            <p>Wollmer.ru &copy; <?= date_i18n('Y'); ?></p>
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
<script>
    document.getElementById('primary-menu-h3').onclick = function() {
        document.getElementById('primary-menu').classList.toggle('active');
        document.getElementById('primary-menu-h3').classList.toggle('active');
    }
    document.getElementById('cats-menu-h3').onclick = function() {
        document.getElementById('cats-menu').classList.toggle('active');
        document.getElementById('cats-menu-h3').classList.toggle('active');
    }
</script>
<!--<script async src="https://lib.usedesk.ru/secure.usedesk.ru/widget_165526_47193.js"></script>-->
</body>
</html>