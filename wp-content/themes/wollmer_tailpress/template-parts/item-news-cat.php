<?php
$video_cat = $args['video_category'];
$key = $args['key'];
?>
<button class="item-news-cat <?= $key==0 ? 'active' : '';?>" data-video-cat="<?= $video_cat->term_id; ?>"><?=$video_cat->name; ?></button>