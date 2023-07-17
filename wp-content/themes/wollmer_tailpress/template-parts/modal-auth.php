<div id="modal" class="login-modal">
  <form class="sms_login_step1 transition opacity-100">
    <div class="um-col-1">
      <div class="mb-5">
        <div><label for="sms_name">Ваше имя<span title="Обязательно">*</span></label>
        </div>
        <div>
          <input type="text" class="rounded-xl p-3 w-full text-black focus:outline-none bg-lightgray" name="sms_name" id="sms_name" placeholder="Ваше имя">
        </div>
      </div>
      <div class="mb-5">
        <div><label for="sms_phone">Телефон<span title="Обязательно">*</span></label>
        </div>
        <div>
          <input type="text" class="rounded-xl p-3 w-full text-black focus:outline-none bg-lightgray" name="sms_phone" id="sms_phone" class="input_sms_login" placeholder="79001002030">
        </div>
      </div>
      <div class="text-center">
        <input type="button" value="Получить код" class="btn_sms_login cursor-pointer bg-yellow rounded-full px-9 py-3 text-black font-semibold hover:bg-bryellow" onclick="SwitchToStep2(); return false;">
      </div>
    </div>
  </form>
  <form class="sms_login_step2 my-5 text-center hidden">
    <div id="sms-register" class="text-center">
      <p class="text-sm">Мы отправили Вам по SMS код подтверждения, на указанный номер телефона.
        Пожалуйста, введите его ниже</p>
      <input id="sms-input" type="text" placeholder="Код подтверждения" class="rounded-xl p-3 w-full text-black focus:outline-none bg-lightgray">
      <a href="#" class="resend-sms pointer-events-none opacity-30 select-none transition text-xs underline">Выслать код ещё раз</a>
      <div class="my-5">
        <input type="button" value="Продолжить" class="cursor-pointer bg-yellow rounded-full px-9 py-3 text-black font-semibold hover:bg-bryellow" onclick="SendPin(); return false;">
      </div>
      <div id="sms_login_error" class="hidden">Введен неверный код</div>
    </div>
  </form>
</div>



<script>


// SMS FUNS

var sms_counter = 59;
var sms_counter_stop = 1;

function SmsCounter() {
  if (sms_counter_stop == 0) {
    if (sms_counter == 0) {
      jQuery('#sms_counter').html('<a href="#" onclick="SwitchToStep2(); return false;">Получить новый код</a>');
      sms_counter_stop = 1;
      sms_counter = 59;
    } else {
      jQuery('#sms_counter').html('Получить новый код можно через 00:' + sms_counter);
      sms_counter = sms_counter - 1;
      setTimeout(SmsCounter, 1000);
    }
  }
}

function SwitchPhone() {
  sms_counter_stop = 1;
  sms_counter = 59;
  jQuery('input#sms-input').val('');
  jQuery('.sms_login_step1').css('display', 'block');
  jQuery('.sms_login_step2').css('display', 'none');
}

function SendPin() {
  jQuery.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    dataType: 'html',
    data: {
      action: 'sms_pin',
      name: jQuery('input[name=sms_name]').val(),
      phone: jQuery('input[name=sms_phone]').val().replace(/\D/g, ''),
      pin: jQuery('input#sms-input').val().replace(/\D/g, '')
    },
    success: function (response) {
      if (response == 'ok') {
        jQuery('#sms_login_error').removeClass('hidden');
        location.href = '/my-account/';
      } else {
        jQuery('input#sms-input').val('');
        jQuery('input#sms-input').focus();
        jQuery('#sms_login_error').addClass('hidden');
      }
    },
    error: function (response) {
      alert('Ошибка при отправке формы');
    }
  });
}

function SwitchToStep2() {
  if (jQuery('input[name=sms_phone]').val() != '') {
    jQuery.ajax({
      url: '/wp-admin/admin-ajax.php',
      type: 'POST',
      dataType: 'html',
      data: {
        action: 'sms_login',
        name: jQuery('input[name=sms_name]').val(),
        phone: jQuery('input[name=sms_phone]').val().replace(/\D/g, '')
      },
      success: function (response) {
        jQuery('.sms_login_step2').removeClass('hidden');
        jQuery('input#sms-input').val('');
        jQuery('input#sms-input').focus();
        sms_counter_stop = 0;
        SmsCounter();
      },
      error: function (response) {
        alert('Ошибка при отправке формы');
      }
    });
  }
}

</script>