<?php get_header(); ?>

<div class="container mx-auto">

	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<?php
			// if(current_user_can('administrator')){
			// 	get_template_part( 'template-parts/test', 'section' );
			// } else {
			// 	echo 'please stand by';
			// }
			?>

			<?php the_content(); ?>
			<?php get_template_part( 'template-parts/section', 'database' ); ?>

		<?php endwhile; ?>

	<?php endif; ?>

</div>

<?php

get_footer();
