<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( '\\SkyVerge\\WooCommerce\\PluginFramework\\v5_7_1\\SV_WC_Plugin_Compatibility' ) ) :

class Woodev_Plugin_Compatibility {

	public static function wc_get_is_paid_statuses() {

		wc_deprecated_function( __METHOD__, '5.5.0', '(array) wc_get_is_paid_statuses()' );

		return (array) wc_get_is_paid_statuses();
	}
	
	public static function wc_doing_it_wrong( $function, $message, $version ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_doing_it_wrong()' );

		wc_doing_it_wrong( $function, $message, $version );
	}
	
	public static function wc_format_datetime( $date, $format = '' ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_format_datetime()' );

		return wc_format_datetime( $date, $format );
	}
	
	public static function wc_deprecated_function( $function, $version, $replacement = null ) {

		wc_deprecated_function( __METHOD__, '5.5.0', 'wc_deprecated_function()' );

		wc_deprecated_function( $function, $version, $replacement );
	}
	
	public static function get_latest_wc_versions() {

		$latest_wc_versions = get_transient( 'woodev_plugin_wc_versions' );

		if ( ! is_array( $latest_wc_versions ) ) {
			
			$wp_org_request = wp_remote_get( 'https://api.wordpress.org/plugins/info/1.0/woocommerce.json', [ 'timeout' => 1 ] );

			if ( is_array( $wp_org_request ) && isset( $wp_org_request['body'] ) ) {

				$plugin_info = json_decode( $wp_org_request['body'], true );

				if ( is_array( $plugin_info ) && ! empty( $plugin_info['versions'] ) && is_array( $plugin_info['versions'] ) ) {

					$latest_wc_versions = [];
					
					foreach ( array_keys( array_reverse( $plugin_info['versions'] ) ) as $wc_version ) {
						
						if (
							   is_string( $wc_version )
							&& '' !== $wc_version
							&& is_numeric( $wc_version[0] )
							&& false === strpos( $wc_version, '-' )
						) {
							$latest_wc_versions[] = $wc_version;
						}
					}

					set_transient( 'woodev_plugin_wc_versions', $latest_wc_versions, WEEK_IN_SECONDS );
				}
			}
		}

		return is_array( $latest_wc_versions ) ? $latest_wc_versions : [];
	}
	
	public static function get_wc_version() {

		return defined( 'WC_VERSION' ) && WC_VERSION ? WC_VERSION : null;
	}
	
	public static function is_wc_version( $version ) {

		$wc_version = self::get_wc_version();
		
		return $wc_version === $version || ( $wc_version && version_compare( $wc_version, $version, '=' ) );
	}
	
	public static function is_wc_version_gte_3_0() {

		wc_deprecated_function( __METHOD__, '5.5.0', __CLASS__ . '::is_wc_version_gte()' );

		return self::is_wc_version_gte( '3.0' );
	}
	
	public static function is_wc_version_lt_3_0() {

		wc_deprecated_function( __METHOD__, '5.5.0', __CLASS__ . '::is_wc_version_lt()' );

		return self::is_wc_version_lt( '3.0' );
	}
	
	public static function is_wc_version_gte_3_1() {

		wc_deprecated_function( __METHOD__, '5.5.0', __CLASS__ . '::is_wc_version_gte()' );

		return self::is_wc_version_gte( '3.1' );
	}
	
	public static function is_wc_version_lt_3_1() {

		wc_deprecated_function( __METHOD__, '5.5.0', __CLASS__ . '::is_wc_version_lt()' );

		return self::is_wc_version_lt( '3.1' );
	}
	
	public static function is_wc_version_gte( $version ) {

		$wc_version = self::get_wc_version();

		return $wc_version && version_compare( $wc_version, $version, '>=' );
	}
	
	public static function is_wc_version_lt( $version ) {

		$wc_version = self::get_wc_version();

		return $wc_version && version_compare( $wc_version, $version, '<' );
	}
	
	public static function is_wc_version_gt( $version ) {

		$wc_version = self::get_wc_version();

		return $wc_version && version_compare( $wc_version, $version, '>' );
	}
	
	public static function is_enhanced_admin_available() {

		return self::is_wc_version_gte( '4.0' ) && function_exists( 'wc_admin_url' ) && class_exists( '\\Automattic\\WooCommerce\\Admin\\Composer\\Package' ) && \Automattic\WooCommerce\Admin\Composer\Package::is_package_active();
	}
	
	public static function normalize_wc_screen_id( $slug = 'wc-settings' ) {
		
		$prefix = sanitize_title( __( 'WooCommerce', 'woocommerce' ) );

		return $prefix . '_page_' . $slug;
	}
	
	public static function convert_hr_to_bytes( $value ) {

		if ( function_exists( 'wp_convert_hr_to_bytes' ) ) {

			return wp_convert_hr_to_bytes( $value );
		}

		$value = strtolower( trim( $value ) );
		$bytes = (int) $value;

		if ( false !== strpos( $value, 'g' ) ) {

			$bytes *= GB_IN_BYTES;

		} elseif ( false !== strpos( $value, 'm' ) ) {

			$bytes *= MB_IN_BYTES;

		} elseif ( false !== strpos( $value, 'k' ) ) {

			$bytes *= KB_IN_BYTES;
		}
		
		return min( $bytes, PHP_INT_MAX );
	}


}


endif;
