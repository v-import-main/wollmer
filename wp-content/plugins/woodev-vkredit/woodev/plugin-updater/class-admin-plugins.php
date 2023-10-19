<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Woodev_Admin_Plugins {
	
	public static function get_extension_data() {		
		
		if ( false === ( $addons = get_transient( 'woodev_extensions' ) ) ) {
			
			$parameters = array( 'number' => 30 );
			
			$raw_extensions = wp_safe_remote_get( add_query_arg( $parameters, 'https://woodev.ru/edd-api/v2/products/' ), array( 'user-agent' => 'Woodev Plugins Page' ) );
			
			if ( ! is_wp_error( $raw_extensions ) ) {
				
				$addons = json_decode( wp_remote_retrieve_body( $raw_extensions ) )->products;
				
				if ( $addons ) {
					set_transient( 'woodev_extensions', $addons, WEEK_IN_SECONDS );
				}
			}
		}
		
		return $addons;
	}

	public static function output() {
		
		$addons   = self::get_extension_data();
		
		include_once dirname( __FILE__ ) . '/views/html-admin-page-plugins.php';
	}
}