<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_print_head_js' ) ){
	function flat_pm_print_head_js() {
		$flat_pm_pagespeed      = get_option( 'flat_pm_pagespeed' );
		$flat_pm_main           = get_option( 'flat_pm_main' );
		$flat_pm_advanced       = get_option( 'flat_pm_advanced' );
		$flat_pm_stylization    = get_option( 'flat_pm_stylization' );

		$output_in_header = array(
			'timer_text' => __( 'Close in', 'flatpm_l10n' ),
			'lazyload'   => $flat_pm_pagespeed['lazyload'],
			'threshold'  => $flat_pm_pagespeed['threshold'],
			'dublicate'  => $flat_pm_main['dublicate_adblock'],
			'rtb'        => $flat_pm_advanced['disabled_rtb'],
			'sidebar'    => $flat_pm_advanced['sidebar'],
			'selector'   => ! empty( $flat_pm_advanced['sidebar_selector'] ) ? $flat_pm_advanced['sidebar_selector'] : '.fpm_end',
			'bottom'     => ! empty( $flat_pm_advanced['sidebar_bottom'] ) ? $flat_pm_advanced['sidebar_bottom'] : '0',
			'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
			'speed'      => $flat_pm_stylization['outgoing']['speed'],
		);

		echo '<!--noptimize-->';
		echo wp_get_inline_script_tag( 'window.fpm_settings = ' . wp_json_encode( $output_in_header ) . ';', array( 'data-noptimize' => '', 'data-wpfc-render' => 'false' ) );
		echo '<!--/noptimize-->';

		include_once 'scripts.php';
	}
}


// !--sub_functions


add_action( 'wp_head', 'flat_pm_print_head_js', FLATPM_INT_MAX );
?>