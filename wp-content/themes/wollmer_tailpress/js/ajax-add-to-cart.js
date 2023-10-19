(function ($) {
  //temp
  // $(document).find('.quantity+.single_add_to_cart_button').attr('data-fancybox','addedmodal').attr('data-src','#addedmodal');
  //temp

  $(document).on('click', '.single_add_to_cart_button', function (e) {
    e.preventDefault();
	  
    document.querySelector('button[type="submit"].single_add_to_cart_button').disabled = true;

    var badge_count = $('#cart_icon').next('.badge').text() !== '' ? parseInt($('#cart_icon').next('.badge').text()) : '';
    console.log(badge_count);
    if(badge_count !== 0) $('#cart_icon').next('.badge').remove();

    var $thisbutton = $(this),
      $form = $thisbutton.closest('form.cart'),
      id = $thisbutton.val(),
      product_qty = $form.find('input[name=quantity]').val() || 1,
      product_id = $form.find('input[name=product_id]').val() || id,
      variation_id = $form.find('input[name=variation_id]').val() || 0;

    var data = {
      action: 'woocommerce_ajax_add_to_cart',
      product_id: product_id,
      product_sku: '',
      quantity: product_qty,
      variation_id: variation_id
    };

    $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

    $.ajax({
      type: 'post',
      url: wc_add_to_cart_params.ajax_url,
      data: data,

      beforeSend: function (response) {
         $thisbutton.removeClass('added').addClass('loading');
       },

      complete: function (response) {
        $thisbutton.addClass('added').removeClass('loading');
        document.querySelector('button[type="submit"].single_add_to_cart_button').disabled = false;
		document.querySelector('.cart-notice').classList.add('active');
		setTimeout(() => {
      	document.querySelector('.cart-notice').classList.remove('active');
    	}, 3000); 
		$('#cart_icon').after('<a href="/cart/" class="badge">'+(badge_count+1)+'</a>');
		
      },
      success: function (response) {
        if (response.error && response.product_url) {
          window.location = response.product_url;
          return;
        } else {
          $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
        }
      }
    });

    return false;
  });

  $(document).on('click', '.complex_add_to_cart_button', function (e) {
    e.preventDefault();

    var $thisbutton = $(this);
    $('.fancybox__slide.is-selected').css('opacity','0');
    var product_name = ' - ' + $thisbutton.parents('.complex-content').find('h3').text();
    var regular_price = $thisbutton.parents('.complex-content').find('.price-new').html();
    var data = {
      action: 'woocommerce_ajax_add_to_cart',
      product_id: $(this).data('id'),
      product_sku: '',
      quantity: 1
    };

    $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

    $.ajax({
      type: 'post',
      url: wc_add_to_cart_params.ajax_url,
      data: data,
      beforeSend: function (response) {
        $thisbutton.removeClass('added').addClass('loading');
      },
      complete: function (response) {
        $thisbutton.addClass('added').removeClass('loading');
        $('.fancybox__slide.is-selected').css('opacity','100');
      },
      success: function (response) {
        $('.fancybox__slide.is-selected').find('.subheadline').append(product_name);
        $('.fancybox__slide.is-selected').find('.regular-price').text(regular_price);
        if (response.error && response.product_url) {
          window.location = response.product_url;
          return;
        } else {
          $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
        }
      }
    });

    return false;
  });

})(jQuery);
