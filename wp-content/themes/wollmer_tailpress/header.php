<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php wp_head(); ?>
	
	<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@600&display=swap" as="style">
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@600&display=swap">

	<?php
	if(is_front_page()){
		echo '<link rel="preload" href="/wp-content/uploads/2022/10/large-banners.png.webp" as="image">';
		$css_file = file_get_contents(tailpress_asset('css/frontpage.css'));
		echo '<style type="text/css">' . $css_file . '</style>';
	}
	?>

	<?= carbon_get_theme_option('head'); ?>
</head>

<body <?php body_class('fixed_header bg-white text-gray-800 antialiased'); ?>>
	<?= carbon_get_theme_option('upperbody'); ?>
	<?php do_action('tailpress_site_before'); ?>

	<div id="page" class="min-h-screen flex flex-col">

		<?php do_action('tailpress_header'); ?>

		<?php get_template_part('template-parts/header'); ?>

		<div id="content" class="site-content flex-grow">

			<?php if (is_front_page()) { ?>
				<!-- Start introduction -->
				
				<!-- End introduction -->
			<?php } ?>

			<?php do_action('tailpress_content_start'); ?>

			<main>