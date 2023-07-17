<?php get_header(); ?>

<div class="container my-8 mx-auto post-template">

	<?php if (have_posts()) : ?>

		<?php
		while (have_posts()) :
			the_post(); ?>
			<div class="cols-wrapper">
				<?php get_template_part('template-parts/top', 'single'); ?>
				<div class="col-content">
					<div class="single-headline">
						<div class="headline-icon-wrapper">
							<?= file_get_contents(tailpress_asset('resources/svg/arrow.svg')); ?>
						</div>
						<h1><?= get_the_title(); ?></h1>
					</div>
					<div class="entry-content">
						<?php
						the_content();
						?>
						<div id="deadline"></div>
					</div>
				</div>
				<div class="col-sidebar">
					<?php
					get_template_part('template-parts/sidebar', 'single');
					?>
				</div>
			</div>
			<?php get_template_part('template-parts/section', 'recommendations');
			// + надо сделать два элемента - карточки и большую карточку
			?>
		<?php endwhile; ?>

	<?php endif; ?>

</div>

<?php
get_footer();
