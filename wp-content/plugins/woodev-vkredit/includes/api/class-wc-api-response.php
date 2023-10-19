<?php

defined( 'ABSPATH' ) or exit;

class WC_Tinkoff_API_Response extends Woodev_API_JSON_Response {
	
	public function get_errors() {
		
		$errors = array();
		
		if( $this->errors ) {
			foreach( ( array ) $this->errors as $error ) {
				$errors[] = $error;
			}
		}

		return $errors;
	}
	
	public function get_validations() {
		
		return $this->validations ? $this->validations : false;
	}
	
	public function get_id() {
		
		if( ! $this->id ) {
			throw new Woodev_API_Exception( 'Не удалось получить ID заявки.' );
			return false;
		}
		
		return $this->id;
	}
	
	public function get_form_url() {
		
		if( ! $this->link ) {
			throw new Woodev_API_Exception( 'Не удалось получить URL формы анкеты на кредит.' );
			return false;
		}
		
		return $this->link;
	}
}