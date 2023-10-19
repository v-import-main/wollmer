<?php

if ( ! class_exists( 'Woodev_Setting' ) ) :

class Woodev_Setting {
	
	const TYPE_STRING = 'string';
	
	const TYPE_URL = 'url';
	
	const TYPE_EMAIL = 'email';
	
	const TYPE_INTEGER = 'integer';
	
	const TYPE_FLOAT = 'float';
	
	const TYPE_BOOLEAN = 'boolean';
	
	protected $id;
	
	protected $type;
	
	protected $name;
	
	protected $description;
	
	protected $is_multi = false;
	
	protected $options = [];
	
	protected $default;
	
	protected $value;
	
	protected $control;
	
	public function get_id() {

		return $this->id;
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
	
	public function is_is_multi() {

		return $this->is_multi;
	}
	
	public function get_options() {

		return $this->options;
	}
	
	public function get_default() {

		return $this->default;
	}
	
	public function get_value() {

		return $this->value;
	}
	
	public function get_control() {

		return $this->control;
	}
	
	public function set_id( $id ) {

		$this->id = $id;
	}
	
	public function set_type( $type ) {

		$this->type = $type;
	}
	
	public function set_name( $name ) {

		$this->name = $name;
	}
	
	public function set_description( $description ) {

		$this->description = $description;
	}
	
	public function set_is_multi( $is_multi ) {

		$this->is_multi = $is_multi;
	}
	
	public function set_options( $options ) {

		foreach ( $options as $key => $option ) {

			if ( ! $this->validate_value( $option ) ) {
				unset( $options[ $key ] );
			}
		}

		$this->options = $options;
	}
	
	public function set_default( $value ) {

		if ( $this->is_is_multi() ) {

			$_value = array_filter( (array) $value, [ $this, 'validate_value' ] );
			
			$value = ! empty( $_value ) ? $_value : null;

		} elseif ( ! $this->validate_value( $value ) ) {

			$value = null;
		}

		$this->default = $value;
	}
	
	public function set_value( $value ) {

		$this->value = $value;
	}
	
	public function set_control( $control ) {

		$this->control = $control;
	}
	
	public function update_value( $value ) {

		if ( ! $this->validate_value( $value ) ) {

			throw new Woodev_Plugin_Exception( "Setting value for setting {$this->id} is not valid for the setting type {$this->type}", 400 );

		} elseif ( ! empty( $this->options ) && ! in_array( $value, $this->options ) ) {

			throw new Woodev_Plugin_Exception( sprintf(
				'Setting value for setting %s must be one of %s',
				$this->id,
				Woodev_Helper::list_array_items( $this->options, 'or' )
			), 400 );

		} else {

			$this->set_value( $value );
		}
	}
	
	public function validate_value( $value ) {

		$validate_method = "validate_{$this->get_type()}_value";

		return is_callable( [ $this, $validate_method ] ) ? $this->$validate_method( $value ) : true;
	}
	
	protected function validate_string_value( $value ) {

		return is_string( $value );
	}
	
	protected function validate_url_value( $value ) {

		return wc_is_valid_url( $value );
	}
	
	protected function validate_email_value( $value ) {

		return (bool) is_email( $value );
	}
	
	public function validate_integer_value( $value ) {

		return is_int( $value );
	}
	
	protected function validate_float_value( $value ) {

		return is_int( $value ) || is_float( $value );
	}
	
	protected function validate_boolean_value( $value ) {

		return is_bool( $value );
	}
}

endif;
