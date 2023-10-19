<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Abstract_Settings' ) ) :

abstract class Woodev_Abstract_Settings {
	
	public $id;
	
	protected $settings = [];
	
	public function __construct( $id ) {

		$this->id = $id;

		$this->register_settings();
		$this->load_settings();
	}
	
	abstract protected function register_settings();
	
	protected function load_settings() {

		foreach ( $this->settings as $setting_id => $setting ) {

			$value = get_option( $this->get_option_name_prefix() . '_' . $setting_id, null );
			$value = $this->get_value_from_database( $value, $setting );

			$this->settings[ $setting_id ]->set_value( $value );
		}
	}
	
	public function register_setting( $id, $type, array $args = [] ) {

		try {

			if ( ! empty( $this->settings[ $id ] ) ) {
				throw new Woodev_Plugin_Exception( "Setting {$id} is already registered" );
			}

			if ( ! in_array( $type, $this->get_setting_types(), true ) ) {
				throw new Woodev_Plugin_Exception( "{$type} is not a valid setting type" );
			}

			$setting = new Woodev_Setting();

			$setting->set_id( $id );
			$setting->set_type( $type );

			$args = wp_parse_args( $args, [
				'name'         => '',
				'description'  => '',
				'is_multi'     => false,
				'options'      => [],
				'default'      => null,
			] );

			$setting->set_name( $args['name'] );
			$setting->set_description( $args['description'] );
			$setting->set_default( $args['default'] );
			$setting->set_is_multi( $args['is_multi'] );

			if ( is_array( $args['options'] ) ) {
				$setting->set_options( $args['options'] );
			}

			$this->settings[ $id ] = $setting;

			return true;

		} catch ( Exception $exception ) {

			wc_doing_it_wrong( __METHOD__, 'Could not register setting: ' . $exception->getMessage(), '1.1.2' );

			return false;
		}
	}
	
	public function unregister_setting( $id ) {

		unset( $this->settings[ $id ] );
	}
	
	public function register_control( $setting_id, $type, array $args = [] ) {

		try {

			if ( ! in_array( $type, $this->get_control_types(), true ) ) {
				throw new UnexpectedValueException( "{$type} is not a valid control type" );
			}

			$setting = $this->get_setting( $setting_id );

			if ( ! $setting ) {
				throw new InvalidArgumentException( "Setting {$setting_id} does not exist" );
			}

			$setting_control_types = $this->get_setting_control_types( $setting );
			if ( ! empty( $setting_control_types ) && ! in_array( $type, $setting_control_types, true ) ) {
				throw new UnexpectedValueException( "{$type} is not a valid control type for setting {$setting->get_id()} of type {$setting->get_type()}" );
			}

			$args = wp_parse_args( $args, [
				'name'        => $setting->get_name(),
				'description' => $setting->get_description(),
				'options'     => [],
			] );

			$control = new Woodev_Control();

			$control->set_setting_id( $setting_id );
			$control->set_type( $type );
			$control->set_name( $args['name'] );
			$control->set_description( $args['description'] );

			if ( is_array( $args['options'] ) ) {
				$control->set_options( $args['options'], $setting->get_options() );
			}

			$setting->set_control( $control );

			return true;

		} catch ( Exception $exception ) {

			wc_doing_it_wrong( __METHOD__, 'Could not register setting control: ' . $exception->getMessage(), '1.1.2' );

			return false;
		}
	}
	
	public function get_id() {

		return $this->id;
	}
	
	public function get_settings( array $ids = [] ) {

		$settings = $this->settings;

		if ( ! empty( $ids ) ) {

			foreach ( array_keys( $this->settings ) as $id ) {

				if ( ! in_array( $id, $ids, true ) ) {
					unset( $settings[ $id ] );
				}
			}
		}

		return $settings;
	}
	
	public function get_setting( $id ) {

		return ! empty( $this->settings[ $id ] ) ? $this->settings[ $id ] : null;
	}
	
	public function get_value( $setting_id, $with_default = true ) {

		$setting = $this->get_setting( $setting_id );

		if ( ! $setting ) {
			throw new Woodev_Plugin_Exception( "Setting {$setting_id} does not exist" );
		}

		$value = $setting->get_value();

		if ( $with_default && null === $value ) {
			$value = $setting->get_default();
		}

		return $value;
	}
	
	public function update_value( $setting_id, $value ) {

		$setting = $this->get_setting( $setting_id );

		if ( ! $setting ) {
			throw new Woodev_Plugin_Exception( "Setting {$setting_id} does not exist", 404 );
		}
		
		$setting->update_value( $value );

		$this->save( $setting_id );
	}
	
	public function delete_value( $setting_id ) {

		$setting = $this->get_setting( $setting_id );

		if ( ! $setting ) {
			throw new Woodev_Plugin_Exception( "Setting {$setting_id} does not exist" );
		}

		$setting->set_value( null );

		return delete_option( "{$this->get_option_name_prefix()}_{$setting->get_id()}" );
	}
	
	public function save( $setting_id = '' ) {

		if ( ! empty( $setting_id ) ) {
			$settings = [ $this->get_setting( $setting_id ) ];
		} else {
			$settings = $this->settings;
		}

		$settings = array_filter( $settings );

		foreach ( $settings as $setting ) {

			$option_name   = "{$this->get_option_name_prefix()}_{$setting->get_id()}";
			$setting_value = $setting->get_value();

			if ( null === $setting_value ) {

				delete_option( $option_name );

			} else {

				update_option( $option_name, $this->get_value_for_database( $setting ) );
			}
		}
	}
	
	protected function get_value_for_database( Woodev_Setting $setting ) {

		$value = $setting->get_value();

		if ( null !== $value && Woodev_Setting::TYPE_BOOLEAN === $setting->get_type() ) {
			$value = wc_bool_to_string( $value );
		}

		return $value;
	}
	
	protected function get_value_from_database( $value, Woodev_Setting $setting ) {

		if ( null !== $value ) {

			switch ( $setting->get_type() ) {

				case Woodev_Setting::TYPE_BOOLEAN:
					$value = wc_string_to_bool( $value );
				break;

				case Woodev_Setting::TYPE_INTEGER:
					$value = is_numeric( $value ) ? (int) $value : null;
				break;

				case Woodev_Setting::TYPE_FLOAT:
					$value = is_numeric( $value ) ? (float) $value : null;
				break;
			}
		}

		return $value;
	}
	
	public function get_setting_types() {

		$setting_types = [
			Woodev_Setting::TYPE_STRING,
			Woodev_Setting::TYPE_URL,
			Woodev_Setting::TYPE_EMAIL,
			Woodev_Setting::TYPE_INTEGER,
			Woodev_Setting::TYPE_FLOAT,
			Woodev_Setting::TYPE_BOOLEAN,
		];
		
		return apply_filters( "wc_{$this->get_id()}_settings_api_setting_types", $setting_types, $this );
	}
	
	public function get_control_types() {

		$control_types = [
			Woodev_Control::TYPE_TEXT,
			Woodev_Control::TYPE_TEXTAREA,
			Woodev_Control::TYPE_NUMBER,
			Woodev_Control::TYPE_EMAIL,
			Woodev_Control::TYPE_PASSWORD,
			Woodev_Control::TYPE_DATE,
			Woodev_Control::TYPE_CHECKBOX,
			Woodev_Control::TYPE_RADIO,
			Woodev_Control::TYPE_SELECT,
			Woodev_Control::TYPE_FILE,
			Woodev_Control::TYPE_COLOR,
			Woodev_Control::TYPE_RANGE,
		];
		
		return apply_filters( "wc_{$this->get_id()}_settings_api_control_types", $control_types, $this );
	}
	
	public function get_setting_control_types( $setting ) {

		return apply_filters( "wc_{$this->get_id()}_settings_api_setting_control_types", [], $setting->get_type(), $setting, $this );
	}
	
	public function get_option_name_prefix() {

		return "wc_{$this->id}";
	}


}

endif;
