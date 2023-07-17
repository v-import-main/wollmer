<?php
$args = array(
  'hide_empty' => true
);
$review_categories = get_terms('category_reviews_tax', $args);
?>

<div id="app">
  <!-- Demo app -->
  <div class="demo-app">
    <!-- Demo content -->
    <div class="demo-stories">
      <?php foreach ($review_categories as $review_category) {
      
      $preview = carbon_get_term_meta($review_category->term_id,'preview') !== '' ?
        wp_get_attachment_url(carbon_get_term_meta($review_category->term_id,'preview')) :
        '/wp-content/uploads/2022/06/frame-1236.png';
        
      ?>
      <a href="#">
        <span class="demo-stories-avatar">
          <img src="<?= $preview; ?>" alt="<?= $review_category->name; ?>">
        </span>
        <span class="demo-stories-name"><?= $review_category->name; ?></span>
      </a>
      <?php } ?>
    </div>
  </div>

  <?php
  foreach ($review_categories as $review_category) {
    $_args = array(
      'post_type'       => 'reviews',
      'posts_per_page'  => -1,
      'tax_query' => array(
        array(
          'taxonomy' => 'category_reviews_tax',
          'field'    => 'term_id',
          'terms'    => $review_category->term_id
        )
      )
    );
  
  
    $reviews = get_posts($_args);
    foreach($reviews as $key=>$review){ ?>
      <p><?= $key.' '.wp_get_attachment_url(carbon_get_post_meta($review->ID, 'image')); ?></p>
    <?php } } ?>


  <!-- Stories Slider -->
  <div class="stories-slider">
    <div class="swiper">
      <div class="swiper-wrapper">
        <?php
        // foreach ($review_categories as $review_category) {
        ?>
          <!-- specific user stories -->
        <div class="swiper-slide">
          <div class="swiper">
            <div class="swiper-wrapper">
              <?php
              $_args = array(
                'post_type'       => 'reviews',
                'posts_per_page'  => -1,
                'tax_query' => array(
                  array(
                    'taxonomy' => 'category_reviews_tax',
                    'field'    => 'term_id',
                    // 'terms'    => $review_category->term_id
                    'terms'    => $review_categories[0]->term_id
                    )
                    )
                  );
                  $reviews = get_posts($_args);
                  foreach($reviews as $review){
                    
                    $image = wp_get_attachment_url(carbon_get_post_meta($review->ID, 'image'));
                    $video_src = carbon_get_post_meta($review->ID, 'video_src');
                    $video_url = carbon_get_post_meta($review->ID, 'video_url');
                    $caption = get_post($review->ID)->post_content !== "" ? '<h3>'. get_the_title($review->ID).'</h3>'.get_post($review->ID)->post_content : '';
                    $href = $image;
                    
                    $preview = carbon_get_term_meta($review_category->term_id,'preview') !== '' ?
                    wp_get_attachment_url(carbon_get_term_meta($review_category->term_id,'preview')) :
                    '/wp-content/uploads/2022/06/frame-1236.png';
                    
                    if($video_url) {
                      $href = $video_url;
                    }
                    if($video_src) {
                      $href = wp_get_attachment_url($video_src);
                    }
                    
                    ?>
                <!-- user's single story -->
              <div class="swiper-slide">
                <a href="#" class="stories-slider-user">
                  <div class="stories-slider-user-avatar">
                    <img src="<?= $preview; ?>" />
                  </div>
                  <div class="stories-slider-user-name"><?= $review_category->name; ?></div>
                  <div class="stories-slider-user-date"></div>
                </a>
                <div class="stories-slider-actions">
                  <button class="stories-slider-close-button"></button>
                </div>
                <div class="stories-slider-content">

                    <?php if(1>2){ ?>

                  <?php if($href === 'http://wollmer.cq77457.tmweb.ru/wp-content/uploads/2022/10/2022-10-20-16-55-06.mp4'){ ?>
                    <video src="<?= $href; ?>" playsinline="" preload="metadata"></video>
                  <?php } else { ?>
                    <img src="<?= $image; ?>" />
                    <?php } ?>


                  <?php } else { ?>
                    <video src="<?= $href; ?>" playsinline="" preload="metadata"></video>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <!-- user's single story -->
            </div>
          </div>
        </div>
        <?php
        // }
        ?>
        <!-- specific user stories -->
      </div>
    </div>
  </div>
</div>