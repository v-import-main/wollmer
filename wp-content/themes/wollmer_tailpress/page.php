<?php get_header(); ?>

<div class="container my-8 mx-auto">

	<?php if (have_posts()) : ?>

		<?php
		while (have_posts()) :
			the_post();
		?>
			<div class="entry-content">
				<h1><?= get_the_title(); ?></h1>
				<?php
				the_content();
				?>
			</div>
		<?php endwhile; ?>

	<?php endif; ?>

</div>

<?php
get_footer();
