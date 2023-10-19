<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_clear_all_cache' ) ){
	function flat_pm_clear_all_cache(){
		$flat_pm_main = get_option( 'flat_pm_main' );

		if( isset( $flat_pm_main['auto_clear_cache'] ) && $flat_pm_main['auto_clear_cache'] === 'true' ){

			if( class_exists( 'd_cache' ) ){
				$fpm_d_cache = new d_cache();
				$fpm_d_cache->clear_all();
			}

			if( class_exists( 'HyperCache' ) ){
				$fpm_HyperCache = new HyperCache();
				$fpm_HyperCache->clean();
			}

			if( function_exists( 'w3tc_flush_all' ) ){
				w3tc_flush_all();
			}

			if( function_exists( 'wp_cache_clean_cache' ) ){
				global $file_prefix;
				wp_cache_clean_cache( $file_prefix );
			}

			if( class_exists( 'WpFastestCache' ) ){
				$fpm_WpFastestCache = new WpFastestCache();
				$fpm_WpFastestCache->deleteCache();
				$fpm_WpFastestCache->deleteCache( true );
			}

			if( class_exists( 'rocket_clean_domain' ) ){
				rocket_clean_domain();
			}

			if( class_exists( 'autoptimizeCache' ) ){
				autoptimizeCache::clearall();
			}

			if( class_exists( 'Breeze_Admin' ) ){
				do_action( 'breeze_clear_all_cache' );
			}

			if( has_action( 'litespeed_purge_all' ) ){
				do_action( 'litespeed_purge_all' );
			}

		}
	}
}