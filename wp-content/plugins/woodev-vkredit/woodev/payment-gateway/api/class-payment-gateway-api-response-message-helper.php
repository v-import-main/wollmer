<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Woodev_Payment_Gateway_API_Response_Message_Helper' ) ) :

class Woodev_Payment_Gateway_API_Response_Message_Helper {

	public function __construct( $text_domain ) {}
	
	public function get_user_messages( $message_ids ) {
		$messages = array();

		foreach ( $message_ids as $message_id ) {
			$messages[] = $this->get_user_message( $message_id );
		}

		return implode( ' ', $messages );
	}
	
	public function get_user_message( $message_id ) {

		$message = null;

		switch ( $message_id ) {
		
			case 'error':           $message = 'Произошла ошибка, попробуйте еще раз или попробуйте альтернативный способ оплаты'; break;
			case 'decline':         $message = 'Мы не можем обработать ваш заказ с предоставленной вами платежной информацией. Пожалуйста, используйте другой платежный аккаунт или альтернативный способ оплаты.'; break;
			case 'held_for_review': $message = 'Этот заказ приостановлен для рассмотрения. Пожалуйста, свяжитесь с нами для завершения транзакции.'; break;

			case 'held_for_incorrect_csc':    $message = 'Этот заказ приостановлен для проверки из-за неправильного номера подтверждения карты. Вы можете связаться с магазином для завершения транзакции.'; break;
			case 'csc_invalid':               $message = 'Номер подтверждения карты недействителен, пожалуйста, попробуйте еще раз.'; break;
			case 'csc_missing':               $message = 'Пожалуйста, введите номер подтверждения вашей карты и попробуйте снова.'; break;

			case 'card_type_not_accepted':    $message = 'Этот тип карты не принимается, используйте альтернативную карту или другой способ оплаты.'; break;
			case 'card_type_invalid':         $message = 'Тип карты недействителен или не соответствует номеру кредитной карты. Пожалуйста, попробуйте еще раз или используйте альтернативную карту или другой способ оплаты.'; break;
			case 'card_type_missing':         $message = 'Пожалуйста, выберите тип карты и попробуйте снова.'; break;

			case 'card_number_type_invalid': $message = 'Тип карты недействителен или не соответствует номеру кредитной карты. Пожалуйста, попробуйте еще раз или используйте альтернативную карту или другой способ оплаты.'; break;
			case 'card_number_invalid':      $message = 'Номер карты недействителен, пожалуйста, введите заново и попробуйте снова.'; break;
			case 'card_number_missing':      $message = 'Пожалуйста, введите номер вашей карты и попробуйте снова.'; break;

			case 'card_expiry_invalid':       $message = 'Дата истечения срока действия карты недействительна, пожалуйста, введите заново и попробуйте снова.'; break;
			case 'card_expiry_month_invalid': $message = 'Недействительный месяц истечения срока действия карты, пожалуйста, введите заново и попробуйте снова.'; break;
			case 'card_expiry_year_invalid':  $message = 'Год истечения срока действия карты недействителен, пожалуйста, введите заново и попробуйте снова.'; break;
			case 'card_expiry_missing':       $message = 'Пожалуйста, введите дату окончания срока действия вашей карты и попробуйте снова.'; break;

			case 'bank_aba_invalid':            $message = 'Номер банковского маршрута недействителен, пожалуйста, введите заново и попробуйте снова.'; break;
			case 'bank_account_number_invalid': $message = 'Номер банковского счета недействителен, пожалуйста, введите заново и попробуйте снова.'; break;

			case 'card_expired':         $message = 'Срок действия предоставленной карты истек, используйте альтернативную карту или другой способ оплаты.'; break;
			case 'card_declined':        $message = 'Предоставленная карта была отклонена, используйте альтернативную карту или другой способ оплаты.'; break;
			case 'insufficient_funds':   $message = 'Недостаточно средств на счете, используйте альтернативную карту или другой способ оплаты.'; break;
			case 'card_inactive':        $message = 'Карта деактивирована или не авторизована для транзакций, не связанных с картой, пожалуйста, используйте альтернативную карту или другой способ оплаты.'; break;
			case 'credit_limit_reached': $message = 'Достигнут предел кредита для карты, используйте альтернативную карту или другой способ оплаты.'; break;
			case 'csc_mismatch':         $message = 'Контрольный номер карты не совпадает. Пожалуйста, войдите и попробуйте снова.'; break;
			case 'avs_mismatch':         $message = 'Указанный адрес не совпадает с платежным адресом для владельца карты. Пожалуйста, проверьте адрес и попробуйте снова.'; break;
		}

		return apply_filters( 'wc_payment_gateway_transaction_response_user_message', $message, $message_id, $this );
	}


}

endif;