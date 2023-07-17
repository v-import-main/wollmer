<?php get_header(); ?>

<div class="container mx-auto">

	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
			?>

		<?php endwhile; ?>

	<?php endif; ?>

</div>

<?php
get_footer();
