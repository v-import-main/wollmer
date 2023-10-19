<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Control' ) ) :

class Woodev_Control {
	
	const TYPE_TEXT = 'text';
	
	const TYPE_TEXTAREA = 'textarea';
	
	const TYPE_NUMBER = 'number';
	
	const TYPE_EMAIL = 'email';
	
	const TYPE_PASSWORD = 'password';
	
	const TYPE_DATE = 'date';
	
	const TYPE_CHECKBOX = 'checkbox';
	
	const TYPE_RADIO = 'radio';
	
	const TYPE_SELECT = 'select';
	
	const TYPE_FILE = 'file';
	
	const TYPE_COLOR = 'color';
	
	const TYPE_RANGE = 'range';
	
	protected $setting_id;
	
	protected $type;
	
	protected $name = '';
	
	protected $description = '';
	
	protected $options = [];
	
	public function get_setting_id() {

		return $this->setting_id;
	}
	
	public function get_type() {

		return $this->type;
	}
	
	public function get_name() {

		return $this->name;
	}
	
	public function get_description() {

		return $this->description;
	}
	
	public function get_options() {

		return $this->options;
	}
	
	public function set_setting_id( $value ) {

		if ( ! is_string( $value ) ) {
			throw new Woodev_Plugin_Exception( 'Setting ID value must be a string' );
		}

		$this->setting_id = $value;
	}
	
	public function set_type( $value, array $valid_types = [] ) {

		if ( ! empty( $valid_types ) && ! in_array( $value, $valid_types, true ) ) {

			throw new Woodev_Plugin_Exception( sprintf(
				'Control type must be one of %s',
				Woodev_Helper::list_array_items( $valid_types, 'or' )
			) );
		}

		$this->type = $value;
	}
	
	public function set_name( $value ) {

		if ( ! is_string( $value ) ) {
			throw new Woodev_Plugin_Exception( 'Control name value must be a string' );
		}

		$this->name = $value;
	}
	
	public function set_description( $value ) {

		if ( ! is_string( $value ) ) {
			throw new Woodev_Plugin_Exception( 'Control description value must be a string' );
		}

		$this->description = $value;
	}
	
	public function set_options( array $options, array $valid_options = [] ) {

		if ( ! empty( $valid_options ) ) {

			foreach ( array_keys( $options ) as $key ) {

				if ( ! in_array( $key, $valid_options, true ) ) {
					unset( $options[ $key ] );
				}
			}
		}

		$this->options = $options;
	}


}

endif;
