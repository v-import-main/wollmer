import { Fancybox, Carousel } from '@fancyapps/ui';

if (document.querySelector('.reels-cat-list')) {
  const reelsCatCarousel = new Carousel(document.querySelector('.reels-cat-list'), {
    Navigation: false,
    Dots: false,
    center: false,
    slidesPerPage: 'auto',
    infinite: false
  });
}

if (document.querySelector('.news-list')) {

  let newsCarousel = new Carousel(document.querySelector('.news-list'), {
    Navigation: false,
    Dots: true,
    center: false,
    slidesPerPage: 1,
    infinite: false,
    on: {
      refresh: carousel => {
        // Update total count
        console.log('refreshNews', carousel.pages.length);
      },
    }
  });
}



if (document.querySelector('.reels-wrapper')) {

  let reelsCarousel = new Carousel(document.querySelector('.reels-wrapper'), {
    Navigation: false,
    Dots: true,
    center: false,
    slidesPerPage: 'auto',
    infinite: false,
    clickSlide: true,
    on: {
      refresh: carousel => {
        // Update total count
        console.log('refreshReels', carousel.pages.length);

        console.log('wtf', carousel);

        if(carousel.pages.length<6){
          document.querySelector('.reels-items-list').classList.add('cleared');
        }
      },
      change: carousel => {
        // Update index of the current page
        console.log('index ', carousel.page);
        if (carousel.page + 1 >= carousel.pages.length) {
          document.querySelector('.reels-items-list').classList.add('end');
        } else {
          document.querySelector('.reels-items-list').classList.remove('end');
        }
      }
    }
  });
}


if (document.querySelector('[data-fancybox="video_gallery"]')) {
  Fancybox.bind('[data-fancybox="video_gallery"]', {
    Toolbar: false,
    click: false,
    Thumbs: false,
    Carousel: {
      Dots: true
    },
    closeButton: 'top',
    Image: {
      zoom: false,
      click: false
    },
    on: {
      init: Fancybox => {
        document.querySelector('body').classList.add('video_gallery_modal');
        document.querySelector('body').classList.remove('reviews_gallery_modal');
      }
    }
  });
}

if (document.querySelector('[data-fancybox="reviews_gallery"]')) {
  Fancybox.bind('[data-fancybox="reviews_gallery"]', {
    Toolbar: false,
    click: false,
    Thumbs: false,
    Carousel: {
      Dots: true,
      Navigation: true,
    },
    closeButton: 'top',
    Image: {
      zoom: false,
      click: false
    },
    on: {
      init: Fancybox => {
        document.querySelector('body').classList.add('reviews_gallery_modal');
        document.querySelector('body').classList.remove('video_gallery_modal');
      }
    }
  });
}

$ = jQuery;

$(document).ready(function () {
  $('body').on('click', function (e) {
    let needle = '';
    console.log($(e.target));

    if ($(e.target).hasClass('item-reels-cat')) {
      needle = $(e.target);
      get_selected_cat_reviews(needle);

    } else if ($(e.target).parent().hasClass('item-reels-cat')) {
      needle = $(e.target).parent();
      get_selected_cat_reviews(needle);

    } else if ($(e.target).parent().parent().hasClass('item-reels-cat')) {
      needle = $(e.target).parent().parent();
      get_selected_cat_reviews(needle);

    } else if ($(e.target).hasClass('item-news-cat')) {
      needle = $(e.target);
      get_selected_cat_videos(needle);
      needle.siblings('.item-news-cat').removeClass('active');
      needle.addClass('active');
      
    } else if ($(e.target).parent().hasClass('item-news-cat')) {
      needle = $(e.target).parent();
      get_selected_cat_videos(needle);
      needle.siblings('.item-news-cat').removeClass('active');
      needle.addClass('active');

    } else if ($(e.target).parent().parent().hasClass('item-news-cat')) {
      needle = $(e.target).parent().parent();
      get_selected_cat_videos(needle);
      needle.siblings('.item-news-cat').removeClass('active');
      needle.addClass('active');
    } else if (
      $(e.target).parent().parent().parent().hasClass('catalog-nav-toggler') ||
      $(e.target).parent().parent().hasClass('catalog-nav-toggler') ||
      $(e.target).parent().hasClass('catalog-nav-toggler') ||
      $(e.target).hasClass('catalog-nav-toggler') ||
      $(e.target).hasClass('nav-bg')
    ) {
      $('#nav-catalog').toggleClass('active');
      $('body').toggleClass('paused');
    } else if (
      $(e.target).parent().parent().hasClass('search-cross') ||
      $(e.target).parent().hasClass('search-cross') ||
      $(e.target).hasClass('search-cross')
    ) {
      $(e.target).closest('.search-cross').prev('.search-input').val('');

    } else if (
      $(e.target).parent().parent().parent().hasClass('search-mobile-toggler') ||
      $(e.target).parent().parent().hasClass('search-mobile-toggler') ||
      $(e.target).parent().hasClass('search-mobile-toggler') ||
      $(e.target).hasClass('search-mobile-toggler')
    ) {
      $('#mobile-search').toggleClass('active');
      $('body').toggleClass('paused');
      $('#bar').toggleClass('frontest');
    }
  });
});




function get_selected_cat_reviews(cat) {
  console.log(cat.data('reviewCat'));
  jQuery.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
      dataType: 'json',
      action: 'get_selected_cat_reviews',
      term_id: cat.data('reviewCat')
    },
    success: function (data) {
      $('.reels-items-list').html(data);

      reelsCarousel = new Carousel(document.querySelector('.reels-wrapper'), {
        Navigation: false,
        Dots: true,
        center: false,
        slidesPerPage: 'auto',
        infinite: false,
        on: {
          refresh: carousel => {
            // Update total count
            console.log('refreshReels2', carousel.pages.length);
          },
          change: carousel => {
            // Update index of the current page
            console.log('index ', carousel.page);
            if (carousel.page + 1 >= carousel.pages.length) {
              document.querySelector('.reels-items-list').classList.add('end');
            } else {
              document.querySelector('.reels-items-list').classList.remove('end');
            }
          }
        }
      });
    },
    error: function (errorThrown) {
      console.log(errorThrown);
    }
  });
}

function get_selected_cat_videos(cat) {
  console.log(cat.data('videoCat'));
  jQuery.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
      dataType: 'json',
      action: 'get_selected_cat_videos',
      term_id: cat.data('videoCat')
    },
    success: function (data) {
      console.log(data);
      $('.news-list').html(data);

      let newsCarousel = new Carousel(document.querySelector('.news-list'), {
        Navigation: false,
        Dots: true,
        center: false,
        slidesPerPage: 1,
        infinite: false,
        on: {
          refresh: carousel => {
            // Update total count
            console.log('refreshVideo', carousel.pages.length);
          },
        }
      });
    },
    error: function (errorThrown) {
      console.log(errorThrown);
    }
  });
}

var lastScrollTop = 0;
$(window).scroll(function (event) {
  var st = $(this).scrollTop();
  if (st > 150) {
    if (st > lastScrollTop) {
      // downscroll code
      $('body').removeClass('fixed_header');
    } else {
      $('body').addClass('fixed_header');
      // upscroll code
    }
    lastScrollTop = st;
  }
  if (st > 550) {
    $('body').addClass('show_subheader');
  } else {
    $('body').removeClass('show_subheader');
  }
});

function generateURL(id) {
  let query = '?rel=0&showinfo=0&autoplay=1';
  return 'https://www.youtube.com/embed/' + id + query;
}

function createIframe(id) {
  let iframe = document.createElement('iframe');

  iframe.setAttribute('allowfullscreen', '');
  iframe.setAttribute('allow', 'autoplay');
  iframe.setAttribute('src', generateURL(id));

  return iframe;
}

function setupVideo(id) {
  let videoPlayer = document.querySelector('#video-player');

  let iframe = createIframe(id);
  videoPlayer.insertBefore(iframe, videoPlayer.querySelector('img'));
}
