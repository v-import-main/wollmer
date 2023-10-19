<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Data_Compatibility' ) ) :

abstract class Woodev_Data_Compatibility {
	
	protected static $compat_props = array();
	
	public static function get_prop( $object, $prop, $context = 'edit', $compat_props = array() ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Data::get_prop()' );

		return is_callable( array( $object, "get_{$prop}" ) ) ? $object->{"get_{$prop}"}( $context ) : null;
	}
	
	public static function set_props( $object, $props, $compat_props = array() ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Data::set_props()' );

		return $object->set_props( $props );
	}
	
	public static function get_meta( $object, $key = '', $single = true, $context = 'edit' ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Data::get_meta()' );

		return $object->get_meta( $key, $single, $context );
	}
	
	public static function add_meta_data( $object, $key, $value, $unique = false ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Data::add_meta_data()' );

		$object->add_meta_data( $key, $value, $unique );
		$object->save_meta_data();
	}
	
	public static function update_meta_data( $object, $key, $value, $meta_id = '' ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Data::update_meta_data()' );

		$object->update_meta_data( $key, $value, $meta_id );
		$object->save_meta_data();
	}
	
	public static function delete_meta_data( $object, $key ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'WC_Data::delete_meta_data()' );

		$object->delete_meta_data( $key );
		$object->save_meta_data();
	}

}

endif;
