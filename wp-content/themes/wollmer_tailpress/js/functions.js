function show_other_complects(e,accs) {
  $(e).css('opacity','.5');
  $(e).css('cursor','no-drop');
  $(e).css('pointer-events','none');
  setTimeout(() => {
    $(e).css('opacity','1');
    $(e).css('cursor','pointer');
    $(e).css('pointer-events','auto');
  }, 2000);
  jQuery.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
      dataType: 'json',
      action: 'show_other_complects',
      accs: accs
    },
    success: function (data) {
      console.log(data);
      $(e).parent('.botline').prev('.product-list').append(data);
      $(e).hide();
    },
    error: function (errorThrown) {
      console.log(errorThrown);
    }
  });
}


function toggle_ship(e,type) {
  console.log(e);
  $(e).addClass('selected').siblings('a').removeClass('selected');
  $('#'+type).show().siblings().hide();
  // if($(e).hasClass('pvzzz')){
  //   console.log('pvzzz');
  // }
  console.log(type);
  if(type === 'curier') {
    $('#shipping_method_0_flat_rate1').click();
  }
}


function search_suggest(s) {
	if(document.body.clientWidth < 768){
	jQuery("#modal-suggest").appendTo('#mobile-search');
	}

	jQuery.post({
	url: '/wp-admin/admin-ajax.php',
	type: 'POST',
	dataType: 'text',
	data: {
		action: 'search_suggest',
		s: s
	},
	success: function (data, jqXHR) {
		console.log('s:',data);
		// JSON.stringify(filter.serializeArray())
		jQuery('#modal-suggest').css('display', 'flex').html(data);
	},
	error: function (jqXHR, status, errorThrown) {
		console.log('Ошибка: ' + jqXHR.responseText,status);
	}
	});
	return false;
}