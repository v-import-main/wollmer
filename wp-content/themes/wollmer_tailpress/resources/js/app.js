import { Carousel } from "@fancyapps/ui/dist/carousel/carousel.esm.js";
import { Fancybox } from "@fancyapps/ui/dist/fancybox/fancybox.esm.js";
import { Thumbs } from '@fancyapps/ui/dist/carousel/carousel.thumbs.esm.js';

import Swiper, { Navigation, EffectCreative, Parallax } from 'swiper';
import Inputmask from 'Inputmask';



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
if(document.querySelector('#customer_details')){
  var i_phone = new Inputmask('+7 (999) 999-99-99');
  // var i_email = new Inputmask('email');
  
  i_phone.mask('#billing_phone');
  // i_email.mask('#billing_email');
}

if (document.querySelector('.multicomplex')) {
//HERE!  
const sliderEl = document.querySelector('.multicomplex');

function createPostersSlider(el) {
  const swiperEl = el.querySelector('.swiper');

  const calcNextOffset = () => {
    const parentWidth = swiperEl.parentElement.offsetWidth;
    const swiperWidth = swiperEl.offsetWidth;
    let nextOffset =
      (parentWidth - (parentWidth - swiperWidth) / 2) / swiperWidth;
    nextOffset = Math.max(nextOffset, 1);
    return `${nextOffset * -100}%`;
  };

  const postersSwiper = new Swiper(swiperEl, {
    modules: [Navigation, Parallax, EffectCreative],
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    effect: 'creative',
    speed: 600,
    resistanceRatio: 0,
    grabCursor: true,
    // loop: true,
    parallax: true,
    creativeEffect: {
      limitProgress: 3,
      perspective: true,
      shadowPerProgress: true,
      prev: {
        shadow: true,
        translate: [calcNextOffset(), 0, 0],
      },
      next: {
        translate: ['15%', 0, -200],
      },
    },
    breakpoints: {
      1440: {
        creativeEffect: {
          limitProgress: 3,
          perspective: true,
          shadowPerProgress: true,
          prev: {
            shadow: true,
            translate: [calcNextOffset(), 0, 0],
          },
          next: {
            translate: ['75%', 0, -200],
          },
        },
      },
      1200: {
        creativeEffect: {
          limitProgress: 3,
          perspective: true,
          shadowPerProgress: true,
          prev: {
            shadow: true,
            translate: [calcNextOffset(), 0, 0],
          },
          next: {
            translate: ['40%', 0, -200],
          },
        },
      }
    }
  });
  return postersSwiper;
}

createPostersSlider(sliderEl);
}


if (document.querySelector('.reels-wrapper')) {

  let reelsCarousel = new Carousel(document.querySelector('.reels-wrapper'), {
    Navigation: false,
    Dots: true,
    center: false,
    slidesPerPage: 'auto',
    infinite: true,
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

if (document.querySelector('#productMainCarousel')) {
  // Initialise Carousel
  let mainCarousel;
  if (document.querySelector('#top-product').classList.contains('product-square')) {
    let Axis = document.querySelector('#top-product').classList.contains('product-square') ? 'y' : 'x';
    mainCarousel = new Carousel(document.querySelector('#productMainCarousel'), {
      Navigation: false,
      Dots: true,
      axis: 'x',
      Thumbs: {
        type: 'classic',
        Carousel: {
          dragFree: false,
          slidesPerPage: 1,
          Navigation: {
            prevTpl: '<svg width="38" height="18" viewBox="0 0 38 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M37 17L21.0964 2.54315C19.5264 1.11603 17.1153 1.16294 15.6021 2.65005L1 17" stroke="#C2C2C2" stroke-width="2"/></svg>',
            nextTpl: '<svg width="38" height="18" viewBox="0 0 38 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L16.9036 15.4568C18.4736 16.884 20.8847 16.8371 22.3979 15.3499L37 1" stroke="#C2C2C2" stroke-width="2"/></svg>',
          },
          axis: Axis,
          
        },
      },
      breakpoints: {
        '(min-width: 768px)': {
          Dots: false,
          axis: Axis,
        },
      },
    },
    {Thumbs}
    );
  } else {
    mainCarousel = new Carousel(document.querySelector('#productMainCarousel'), {
      Navigation: false,
      Dots: true,
      preload: 1,
      breakpoints: {
        '(min-width: 768px)': {
          Dots: false,
        },
      },
    });
  }
  
  if (document.querySelector('#productThumbCarousel')) {
    // Thumbnails
    const thumbCarousel = new Carousel(document.querySelector('#productThumbCarousel'), {
      Sync: {
        target: mainCarousel,
        friction: 0
      },
      Dots: false,
      Navigation: false,
      center: false,
      slidesPerPage: 'auto',
      infinite: false,
    });
  }
}

if (document.querySelector('#section-product')) {
  // Initialise Carousel
  if (document.querySelector('#section-product .product-list').querySelector('.item-product')) {
    const prodCarousel = new Carousel(document.querySelector('#section-product .product-list'), {
      Dots: false,
      Navigation: true,
      slidesPerPage: 'auto',
      infinite: true
    });
  }
}

if (document.querySelector('.cross-sells')) {
  // Initialise Carousel
  if (document.querySelector('.cross-sells .products').querySelector('.product')) {
    const crossellsCarousel = new Carousel(document.querySelector('.cross-sells .products'), {
      l10n: {
        CLOSE: "Закрыть",
        NEXT: "Следующий",
        PREV: "Предыдущий",
      },
      Dots: false,
      Navigation: true,
      slidesPerPage: 4,
      infinite: true
    });
  }
}

if (document.querySelector('[data-fancybox="backordermodal"]')) {
  Fancybox.bind('[data-fancybox="backordermodal"]', {
    Toolbar: false,
    click: false,
    Thumbs: false
  });
}

if (document.querySelector('[data-fancybox="reviews_gallery"]')) {
  Fancybox.bind('[data-fancybox="reviews_gallery"]', {
    Toolbar: false,
    click: false,
    Thumbs: false
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
    l10n: {
      CLOSE: "Закрыть",
      NEXT: "Следующий",
      PREV: "Предыдущий",
    },
    Toolbar: false,
    click: false,
    Thumbs: false,
    Carousel: {
      Dots: false,
      Navigation: false,
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
  console.log('here1');
  if ( document.body.clientWidth < 601 ) {
    console.log('here2');
    $('#product-bar').appendTo('footer');
  }

	$('form[role="search"]').on('submit', function(e){
		e.preventDefault();
		search_suggest($(e.target).find('.search-input').val());
		return false;
	});

	$('form[role="search"] input.search-input').on('keyup', function(e){
    console.log(e.target.value.length, e.target.value);

    if(e.target.value.length > 3) {
      search_suggest(e.target.value);
    } else {
      $('#modal-suggest').hide();
    }
	});


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

    } else if ($(e.target).hasClass('video-player') || $(e.target).parent().hasClass('video-player') || $(e.target).parent().parent().hasClass('video-player')) {
      let video_wrap = document.querySelector('#video-player');
      setupVideo(video_wrap.getAttribute('data-yt'));
      console.log('12', video_wrap.getAttribute('data-yt'));

    } else if (
      $(e.target).hasClass('video-list-item')) {
      let video_wrap = $('#video-player');
      video_wrap.attr('data-yt', $(e.target).data('yt'));
      video_wrap.find('iframe').remove();
      video_wrap.find('img').attr('src', $(e.target).data('preview'));

    } else if (
      $(e.target).parent().parent().parent().hasClass('catalog-nav-toggler') ||
      $(e.target).parent().parent().hasClass('catalog-nav-toggler') ||
      $(e.target).parent().hasClass('catalog-nav-toggler') ||
      $(e.target).hasClass('catalog-nav-toggler')
    ) {
      $('#nav-catalog').toggleClass('active');
      $('body').toggleClass('paused');
    } else if ( $(e.target).hasClass('nav-bg') ){
      $('#nav-catalog').removeClass('active');
      $('#mobile-search').removeClass('active');
      $('body').removeClass('paused');
    } else if (
      jQuery(e.target).is('button.one-click-btn') )
    {
      var i_phone = new Inputmask('+7 (\\999) 999-99-99');
      i_phone.mask('#oneclick_phone');
    } else if (
      jQuery(e.target).is('.showmore-atts') ||
      $(e.target).parent().is('.showmore-atts')
    ){
      console.log('shw-mr-tts');
      jQuery('.right-col').find('li').each(function(){
        $(this).removeClass('!hidden');
      })
      jQuery('.right-col').find('.showmore-atts').hide();

    } else if (
      $(e.target).hasClass('rank-math-list-item') ||
      $(e.target).parent().hasClass('rank-math-list-item')
    ) {
      $(e.target).closest('.rank-math-list-item').toggleClass('active');

    } else if (
      jQuery(e.target).is('button.backorder-btn') )
    {
      var i_phone = new Inputmask('+7 (999) 999-99-99');
      i_phone.mask('#backorder_phone');
    } else if (
      $(e.target).parent().parent().hasClass('search-cross') ||
      $(e.target).parent().hasClass('search-cross') ||
      $(e.target).hasClass('search-cross')
    ) {
      $(e.target).closest('.search-cross').prev('.search-input').val('');
      $('#modal-suggest').hide();

    } else if (
      $(e.target).parent().parent().parent().hasClass('search-mobile-toggler') ||
      $(e.target).parent().parent().hasClass('search-mobile-toggler') ||
      $(e.target).parent().hasClass('search-mobile-toggler') ||
      $(e.target).hasClass('search-mobile-toggler')
    ) {
      $('#mobile-search').toggleClass('active');
      $('body').toggleClass('paused');
      $('#bar').toggleClass('frontest');

    } else if (
      $(e.target).parent().is('.checkbox_ship'))
    {
      let type = $(e.target).attr('id').replace('vis_','#shipping_method_');
      $(type).click();
      jQuery("body").trigger("update_checkout");
      console.log(type,'clicked');
    } else if (
      $(e.target).parent().is('.checkbox'))
    {
      let type = $(e.target).attr('id').replace('vis_','#payment_method_');
      $(type).click();
      console.log(type);
    // } else if (
    //   jQuery(e.target).is('#billing_phone') || jQuery(e.target).is('#billing_email') || jQuery(e.target).is('#billing_first_name'))
    // {
    //   var i_phone = new Inputmask('+7(999)999-99-99');
    //   var i_email = new Inputmask('email');
      
    //   i_phone.mask('#billing_phone');
    //   i_email.mask('#billing_email');

    //   console.log(123);

    // } else if (
    //   jQuery(e.target).hasClass('.modal_plus') || jQuery(e.target).parents('.modal_plus'))
    // {
    //   var val = $('#addedmodal').find('input').val()+1;
    //   alert(val);
    //   $('.single_add_to_cart_button').siblings('.quantity').find('input[name="quantity"]').val(val);
    //   $('#addedmodal').find('input').val(val);
    // } else if (
    //   jQuery(e.target).hasClass('.modal_minus') || jQuery(e.target).parents('.modal_minus'))
    // {
    //   var val = $('#addedmodal').find('input').val()-1;
    //   alert(val);
    //   $('.single_add_to_cart_button').siblings('.quantity').find('input[name="quantity"]').val(val);
    //   $('#addedmodal').find('input').val(val);

    // } else if (
    //   jQuery(e.target).hasClass('.modal_submit'))
    // {
    //   $('.single_add_to_cart_button').click();
    //   setTimeout(()=>{
    //     // window.location.href = '/cart/';
    //     alert('/cart/');
    //   },1000);  
    }
      // return;
      // alert(0);
  });



  window.modal_plus = ()=> {
    var val = parseInt($('#addedmodal').find('input').val())+1;

    $('.single_add_to_cart_button').siblings('.quantity').find('input[name="quantity"]').val(val);
    $('#addedmodal').find('input').val(val);
  }

  window.modal_minus = () => {
      var val = $('#addedmodal').find('input').val()-1;

      $('.single_add_to_cart_button').siblings('.quantity').find('input[name="quantity"]').val(val);
      $('#addedmodal').find('input').val(val);
  }

  window.modal_submit = () => {
    $('.single_add_to_cart_button').click();
    setTimeout(()=>{
      window.location.href = '/cart/';
    },1000);  
  }
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
        Dots: false,
        center: false,
        slidesPerPage: 'auto',
        infinite: true,
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
  videoPlayer.insertBefore(iframe, videoPlayer.querySelector('picture'));
}


$(document).on('change', '.variation-radios input', function() {
  $('.variation-radios input:checked').each(function(index, element) {
    var $el = $(element);
    $el.parents('.variation-radios').find('input').removeAttr('checked');
    $el.attr('checked','checked');
    var thisName = $el.attr('name');
    var thisVal  = $el.attr('value');
    $('select[name="'+thisName+'"]').val(thisVal).trigger('change');
    var var_price = $(element).siblings('label').find('span.var_price').text();
    var var_name = $(element).siblings('label').find('span.var_name').text();
    $('#addedmodal').find('.regular-price').text(var_price);
    $('#addedmodal').find('.subheadline span').text(var_name);
  });
});
$(document).on('woocommerce_update_variation_values', function() {
  $('.variation-radios input').each(function(index, element) {
    var $el = $(element);
    var thisName = $el.attr('name');
    var thisVal  = $el.attr('value');
    $el.removeAttr('disabled');
    if($('select[name="'+thisName+'"] option[value="'+thisVal+'"]').is(':disabled')) {
      $el.prop('disabled', true);
    }
  });
});