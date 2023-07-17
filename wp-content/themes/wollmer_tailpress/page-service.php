<?php
/**
 * Template Name: Services
*/
get_header(); ?>

	<div class="container my-8 mx-auto page-service">

	<?php if ( have_posts() ) : ?>

		<?php
		while ( have_posts() ) :
			the_post();
			?>
      <h1 class="headline"><?php the_title();?></h1>
      <section class="entry-content">
        <?php the_content();?> 
    </section>
    <?php get_template_part( 'template-parts/section', 'map' ); ?>

		<?php endwhile; ?>

	<?php endif; ?>

	</div>

<?php
get_footer();
