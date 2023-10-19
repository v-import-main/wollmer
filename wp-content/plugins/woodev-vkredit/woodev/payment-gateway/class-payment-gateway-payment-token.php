<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Woodev_Payment_Gateway_Payment_Token' ) ) :


class Woodev_Payment_Gateway_Payment_Token {
	
	protected $id;
	
	protected $data;
	
	protected $img_url;
	
	public function __construct( $id, $data ) {
		
		if ( isset( $data['type'] ) && 'credit_card' == $data['type'] && ( ! isset( $data['card_type'] ) || ! $data['card_type'] ) && isset( $data['account_number'] ) ) {
			$data['card_type'] = Woodev_Payment_Gateway_Helper::card_type_from_account_number( $data['account_number'] );
		}
		
		unset( $data['account_number'] );

		$this->id    = $id;
		$this->data  = $data;
	}
	
	public function get_token() {
		return $this->get_id();
	}
	
	public function get_id() {
		return $this->id;
	}
	
	public function is_default() {
		return isset( $this->data['default'] ) && $this->data['default'];
	}
	
	public function set_default( $default ) {
		$this->data['default'] = $default;
	}
	
	public function is_credit_card() {
		return 'credit_card' == $this->data['type'];
	}
	
	public function is_check() {
		return $this->is_echeck();
	}
	
	public function is_echeck() {
		return ! $this->is_credit_card();
	}
	
	public function get_type() {
		return $this->data['type'];
	}
	
	public function get_card_type() {
		return isset( $this->data['card_type'] ) ? $this->data['card_type'] : null;
	}
	
	public function set_card_type( $card_type ) {

		$this->data['card_type'] = $card_type;
	}
	
	public static function type_from_account_number( $account_number ) {
		return Woodev_Payment_Gateway_Helper::card_type_from_account_number( $account_number );
	}
	
	public function get_account_type() {
		return isset( $this->data['account_type'] ) ? $this->data['account_type'] : null;
	}
	
	public function set_account_type( $account_type ) {
		$this->data['account_type'] = $account_type;
	}
	
	public function get_type_full() {

		if ( $this->is_credit_card() ) {
			$type = $this->get_card_type() ? $this->get_card_type() : 'card';
		} else {
			$type = $this->get_account_type() ? $this->get_account_type() : 'bank';
		}

		return Woodev_Payment_Gateway_Helper::payment_type_to_name( $type );
	}
	
	public function get_last_four() {
		return isset( $this->data['last_four'] ) ? $this->data['last_four'] : null;
	}
	
	public function set_last_four( $last_four ) {
		$this->data['last_four'] = $last_four;
	}
	
	public function get_exp_month() {
		return isset( $this->data['exp_month'] ) ? $this->data['exp_month'] : null;
	}
	
	public function set_exp_month( $month ) {
		$this->data['exp_month'] = $month;
	}
	
	public function get_exp_year() {
		return isset( $this->data['exp_year'] ) ? $this->data['exp_year'] : null;
	}
	
	public function set_exp_year( $year ) {
		$this->data['exp_year'] = $year;
	}
	
	public function get_exp_date() {
		return $this->get_exp_month() . '/' . substr( $this->get_exp_year(), -2 );
	}
	
	public function set_image_url( $url ) {
		$this->img_url = $url;
	}
	
	public function get_image_url() {
		return $this->img_url;
	}
	
	public function to_datastore_format() {
		return $this->data;
	}
}

endif;