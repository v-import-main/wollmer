<?php
return array(
	'origin'  => 'programmatically',
	'id'      => '',
	'turned'  => 'false',
	'name'    => '',
	'content' => array(
		'post_types' => array(),
		'templates' => array(
			'404'        => 'false',
			'home'       => 'false',
			'archives'   => 'false',
			'categories' => 'false',
			'search'     => 'false',
			'paged'      => 'false',
			'singular'   => 'false',
		),
		'restriction' => array(
			'content_less' => '',
			'content_more' => '',
			'title_less'   => '',
			'title_more'   => '',
		),
		'author' => array(
			'allow' => array(),
			'disallow' => array()
		),
		'taxonomy_enabled'  => array(), // type as id => id
		'taxonomy_disabled' => array(), // type as id => id
		'publish_enabled'   => array(), // type as id => id
		'publish_disabled'  => array(), // type as id => id
	),
	'user' => array(
		'geo' => array(
			'enabled'  => 'false',
			'country'  => array(
				'allow'    => '',
				'disallow' => '',
			),
			'city'     => array(
				'allow'    => '',
				'disallow' => '',
			),
		),
		'referer' => array(
			'enabled'  => 'false',
			'allow'    => '',
			'disallow' => '',
		),
		'browser' => array(
			'enabled'  => 'false',
			'allow'    => array(),
			'disallow' => array(),
		),
		'os' => array(
			'enabled'  => 'false',
			'allow'    => array(),
			'disallow' => array(),
		),
		'isp' => array(
			'enabled'  => 'false',
			'allow'    => '',
			'disallow' => '',
		),
		'utm' => array(
			'enabled'  => 'false',
			'allow'    => '',
			'disallow' => '',
		),
		'cookies' => array(
			'enabled'  => 'false',
			'allow'    => '',
			'disallow' => '',
		),
		'date' => array(
			'enabled'  => 'false',
			'from'     => '',
			'to'       => '',
		),
		'time' => array(
			'enabled'  => 'false',
			'from'     => '',
			'to'       => '',
		),
		'schedule' => array(
			'enabled'  => 'false',
			'value'    => '["FFFFFF","FFFFFF","FFFFFF","FFFFFF","FFFFFF","FFFFFF","FFFFFF"]',
		),
		'role' => array(
			'enabled'  => 'false',
			'allow'    => array(),
			'disallow' => array(),
		),
		'agent' => array(
			'enabled'  => 'false',
			'allow'    => '',
			'disallow' => '',
		),
		'ip' => array(
			'enabled'  => 'false',
		),
	)
);
?>