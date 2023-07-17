<?php

/**
 * Template Name: Blog
 */

get_header();
?>
<div class="mx-auto">
    <main class="max-w-7xl mx-auto px-4 sm:px-20 py-6 sm:py-[52px] bg-white grid gap-12">
        <?php
        foreach (get_posts(['post_type' => 'post', 'numberposts' => 12])
            as $key=>$_post) {
        ?>
            <?php
            if($key == 0){
                get_template_part('template-parts/blog-single', 'hero',['_post'=>$_post]);
            ?>
            <section class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            } else
            if(($key > 0 && $key < 5) || $key == 6 || $key == 7) {
                get_template_part('template-parts/blog-single', 'quarter',['_post'=>$_post]);
            } else
            if($key == 4) {
            ?>
            </section>
            <section class="grid lg:grid-cols-4 gap-6 h-[400px]">
            <?php
            } else
            if($key == 5) {
                get_template_part('template-parts/blog-single', 'half',['_post'=>$_post]);
            ?>
            <div class="hidden col-span-2 lg:grid grid-cols-2 gap-6">
            <?php
            } else
            if($key == 7) {
            ?>
            </div>
            </section>
            <section class="hidden md:grid grid-cols-3 gap-6">
            <?php
            } else
            if($key > 7 && $key < 11) {
                get_template_part('template-parts/blog-single', 'third',['_post'=>$_post]);
            } else
            if($key == 11) {
            ?>
            </section>
            <a href="#" class="w-full h-full mx-auto w-full md:w-[360px]"><button class="w-full h-full text-sm font-semibold bg-sunglow py-3 px-6 rounded hover:scale-105 transition-all duration-500 ease-in-out transform"> Показать еще </button></a>  
            <?php
            }
            ?>
        <?php } ?>
    </main>
</div>

<?php
get_footer();

?>