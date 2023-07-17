<?php
$advantages = get_post(1009);
?>


<section id="advantages">
<h2><?= $advantages->post_title; ?></h2>
<?= $advantages->post_content; ?>
</section>