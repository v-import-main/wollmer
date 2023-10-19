<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_exclude_block' ) ){
	function flat_pm_exclude_block( $method, $meta ){
		$old_meta = get_post_meta( (int) $meta['id'], 'exclude_block_flat_pm', true );

		$new_meta = ( $old_meta === 'no' ) ? 'yes' : 'no';

		update_post_meta( (int) $meta['id'], 'exclude_block_flat_pm', (string) $new_meta );

		flat_pm_clear_all_cache();

		die( json_encode( array(
			'method' => $method,
			'data' => $new_meta
		) ) );
	}
}