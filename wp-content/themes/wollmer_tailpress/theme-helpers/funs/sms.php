<?php
add_action('wp_ajax_sms_pin', 'sms_pin');
add_action('wp_ajax_nopriv_sms_pin', 'sms_pin');
add_action('wp_ajax_sms_login', 'sms_login');
add_action('wp_ajax_nopriv_sms_login', 'sms_login');

// SMS AUTORIZE
function sms_login()
{
  global $smsapi;
  $codes = json_decode(file_get_contents('sms_codes'), 1);

  $codes[$_POST['phone']] = rand(1000, 9999);

  // if ($_POST['phone'][1] == '9' && strlen($_POST['phone']) == 11) {
  if ($_POST['phone'][1] == '9') {

    $__phone = $_POST['phone'];
    $str = "7";
    $__phone = str_replace(['+','-',' '],'',$__phone);
    $__phone[0]=$str;

    file_put_contents('sms_codes', json_encode($codes));
    
    
    file_get_contents('https://sms.ru/sms/send?api_id='.$smsapi.'&to=' . $__phone . '&msg=PIN:' . $codes[$__phone] . '&json=1&from=Wollmer.ru');

  } else {
    wp_die('BOT!');
  }
  wp_die($_POST['phone'].' '.$codes[$_POST['phone']]);
}

function sms_pin()
{

  $codes = json_decode(file_get_contents('sms_codes'), 1);

  if ($codes[$_POST['phone']] == $_POST['pin']) {

    $userx_id = username_exists($_POST['phone']);

    if (gettype($userx_id) == 'boolean') {
      $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
      $user_idx = wp_create_user($_POST['phone'], $random_password, $_POST['phone'] . '@webique.ru');
      wp_clear_auth_cookie();
      wp_set_current_user($user_idx);
      wp_set_auth_cookie($user_idx);

      wp_update_user([
        'ID'       => $user_idx,
        'first_name' => $_POST['name']
      ]);
      carbon_set_user_meta($user_idx, 'tel', $_POST['phone']);

      die('ok');
    }
    if (gettype($userx_id) == 'integer') {

      $userss = get_userdatabylogin($_POST['phone']);

      wp_clear_auth_cookie();
      wp_set_current_user($userss->ID);
      wp_set_auth_cookie($userss->ID);

      wp_update_user([
        'ID'       => $userss->ID,
        'first_name' => $_POST['name']
      ]);

      die('ok');
    }
  } else {
    die('error');
  }
}