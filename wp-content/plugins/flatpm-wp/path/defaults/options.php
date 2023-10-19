<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'flat_pm_license' => '',
	'flat_pm_unfold' => 'false',
	'flat_pm_css' => '',
	'flat_pm_header_footer' => array(
		'header_enabled'  => 'true',
		'header_code'     => '',
		'header_deffered' => 'false',
		'footer_enabled'  => 'true',
		'footer_code'     => '',
		'footer_deffered' => 'false',
	),
	'flat_pm_main' => array(
		'statistics_collect' => 'false',
		'statistics_view'    => 'impressions',
		'dublicate_adblock'  => 'false',
		'auto_clear_cache'   => 'false',
		'editor_manage'      => 'false',
	),
	'flat_pm_pagespeed' => array(
		'lazyload'        => 'false',
		'threshold'       => '300',
		'deffered'        => 'false',
		'deffered_events' => 'touchstart mousemove',
		'timeout'         => 'false',
		'timeout_time'    => '800',
		'pagespeed'       => 'false',
	),
	'flat_pm_stylization' => array(
		'cross' => array(
			'offset'     => 'false',
			'background' => '#7ca1d1',
			'crosshair'  => '#ffffff',
			'text'       => '#ffffff',
			'width'      => '34',
			'height'     => '34',
			'thickness'  => '3',
		),
		'outgoing' => array(
			'popup_animation'   => '1',
			'sticky_animation'  => '2',
			'speed'             => '300',
			'background'        => '#ffffff',
			'overlay'           => '#0000008a',
			'blur'              => '0',
		),
		'vignette' => array(

		),
		'ad_preloader' => array(
			'text'       => 'Ads',
			'background' => '#eee',
			'color'      => '#a3a3a3',
			'style'      => 'none'
		)
	),
	'flat_pm_advanced' => array(
		'fast_start'       => 'true',
		'sidebar'          => 'false',
		'sidebar_selector' => '.fpm_end',
		'sidebar_bottom'   => '10',
		'disabled_rtb'     => 'false',
	),
	'flat_pm_personalization' => array(
		'disabled_tooltip' => 'false',
		'default_folder'   => 'all',
		'block' => array(
			'geo'         => 'true',
			'referer'     => 'true',
			'browser'     => 'true',
			'os'          => 'true',
			'isp'         => 'true',
			'utm'         => 'true',
			'cookies'     => 'true',
			'date'        => 'true',
			'time'        => 'true',
			'schedule'    => 'true',
			'role'        => 'true',
			'agent'       => 'true',
			'ip'          => 'true',
			'pixels'      => 'true',
			'symbols'     => 'true',
			'once'        => 'true',
			'iterable'    => 'true',
			'outgoing'    => 'true',
			'preroll'     => 'true',
			'hoverroll'   => 'true',
			'vignette'    => 'true',
			'minheight'   => 'true',
			'autorefresh' => 'true',
			'timeout'     => 'true',
			'adblock'     => 'true',
			'folder'      => 'all'
		),
		'folder' => array(
			'geo'         => 'true',
			'referer'     => 'true',
			'browser'     => 'true',
			'os'          => 'true',
			'isp'         => 'true',
			'utm'         => 'true',
			'cookies'     => 'true',
			'date'        => 'true',
			'time'        => 'true',
			'schedule'    => 'true',
			'role'        => 'true',
			'agent'       => 'true',
			'ip'          => 'true',
		),
	),
);
?>