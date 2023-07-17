<?php get_header(); ?>

<main class="max-w-[1440px] mx-auto px-4 sm:px-20 py-6 sm:py-[52px] bg-white grid gap-12">
	<div class="grid lg:grid-cols-2 gap-2 my-auto">
		<picture>
			<source srcset="/wp-content/themes/wollmer_tailpress/css/404.jpg" type="image/jpeg">
			<source srcset="/wp-content/themes/wollmer_tailpress/css/404.webp" type="image/webp">
			<img class="rounded-xl object-cover" src="/wp-content/themes/wollmer_tailpress/css/404.webp" alt="Ничего не найдено">
		</picture>
		<div class="grid gap-9 h-min my-auto lg:justify-start">
			<h2 class="text-2xl md:text-4xl font-semibold text-center"> Что-то пошло не так... </h2>
			<div class="flex justify-center lg:justify-start">
				<a href="/" class="btn">На главную</a>
			</div>
		</div>
	</div>
</main>
	
<?php
get_footer();
