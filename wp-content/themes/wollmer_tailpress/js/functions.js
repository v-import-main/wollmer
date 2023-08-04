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


/*$(document).on("change",".radio_option", function(){
    if ($('#vis_0_flat_rate1').prop("checked")) {
        $('#billing_address_1_field').addClass("active");
        $('#billing_street_field').addClass("active");
        $('#billing_kv_field').addClass("active");
    } else {
        $('#billing_address_1_field').removeClass("active");
        $('#billing_street_field').removeClass("active");
        $('#billing_kv_field').removeClass("active");
    }
});*/

/*$(document).ready(function() {
    var radioButtons = $('input[name="shipping_method_vis"]');
    radioButtons.each(function() {
        if ($(this).is(':checked')) {
            if ($(this).val() == "1) {
                $('#billing_address_1_field').addClass("active");
                $('#billing_street_field').addClass("active");
                $('#billing_kv_field').addClass("active");
            } else if ($(this).val() == "2") {
                $('#billing_address_1_field').removeClass("active");
                $('#billing_street_field').removeClass("active");
                $('#billing_kv_field').removeClass("active");
            }
        }
    });
});*/

/*
document.addEventListener('DOMContentLoaded', function() {
    var radioButtons = document.getElementsByName('shipping_method_vis');
    for (var i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            if(radioButtons[i].getElementById('vis_0_flat_rate1')){
                document.getElementById('billing_address_1_field').classList.add('active');
            }else if(radioButtons[i].getElementById('vis_0_flat_rate1')){
                document.getElementById('billing_address_1_field').classList.remove('active');
            }
        }
    }
});
*/

let inp = document.querySelectorAll('.radio_option');
let box_1 = document.querySelectorAll('#curier .address-field:nth-child(9)');
let box_2 = document.querySelectorAll('#curier .address-field:nth-child(8)');
let box_3 = document.querySelectorAll('#curier .address-field:nth-child(7)');
let box_4 = document.querySelectorAll('#curier .address-field:nth-child(6)');

for (let i = 0; i < inp.length; i++) {
    if (inp[i].checked) {
        box_1[i].classList.add('active');
        box_2[i].classList.add('active');
        box_3[i].classList.add('active');
        box_4[i].classList.add('active');
    }
    inp[i].addEventListener('change', () => {
        box_1.forEach((el) => el.classList.remove('active'));
        box_1[i].classList.add('active');
    });
    inp[i].addEventListener('change', () => {
        box_2.forEach((el) => el.classList.remove('active'));
        box_2[i].classList.add('active');
    });
    inp[i].addEventListener('change', () => {
        box_3.forEach((el) => el.classList.remove('active'));
        box_3[i].classList.add('active');
    });
    inp[i].addEventListener('change', () => {
        box_4.forEach((el) => el.classList.remove('active'));
        box_4[i].classList.add('active');
    });
}

$(document).ready(function() {
    var token = 'c5148ad3b5c68eaebc9bf5c1258f90af442e05bc'
    var type = "ADDRESS";
    var $region = $("#billing_address_1");
    var $street = $("#billing_street");
    var $house = $("#billing_house");
    var $city   = $("#billing_city");

    function showPostalCode(suggestion) {
        $("#postal_code").val(suggestion.data.postal_code);
    }

    function clearPostalCode() {
        $("#postal_code").val("");
    }

// регион и район
    $region.suggestions({
        token: token,
        type: type,
        hint: false,
        bounds: "region-city"
    });

// город и населенный пункт
    $city.suggestions({
        token: token,
        type: type,
        hint: false,
        bounds: "city-settlement",
        constraints: $region
    });

// улица
    $street.suggestions({
        token: token,
        type: type,
        hint: false,
        bounds: "street",
        constraints: $city,
        count: 15,
    });


// дом
    $house.suggestions({
        token: token,
        type: type,
        hint: false,
        noSuggestionsHint: false,
        bounds: "house",
        constraints: $street
    });


    console.log($house.suggestions())

});


