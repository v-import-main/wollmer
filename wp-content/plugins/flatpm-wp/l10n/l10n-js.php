<?php
wp_localize_script( 'flat_pm_custom', 'fpm_l10n', array(
	'other' => array(
		'change_not_saved' => __( 'changes not saved', 'flatpm_l10n' ),
		'untitled'     => __( 'Untitled', 'flatpm_l10n' ),
		'image'        => __( 'Image', 'flatpm_l10n' ),
		'link'         => __( 'Link', 'flatpm_l10n' ),
		'sticky'       => __( 'Sticky', 'flatpm_l10n' ),
		'sidebar'      => __( 'For sidebar', 'flatpm_l10n' ),
		'slider'       => __( 'Slider', 'flatpm_l10n' ),
		'broken_file'  => __( 'File is broken', 'flatpm_l10n' ),
		'empty_export' => __( 'The export file is empty!', 'flatpm_l10n' ),
		'php_error'    => __( 'php script returned error', 'flatpm_l10n' ),
	),
	'timepicker' => array(
		'cancel' => __( 'Cancel' ),
		'clear'  => __( 'Clear' ),
		'done'   => __( 'Ok' )
	),
	'datepicker' => array(
		'cancel'        => __( 'Cancel' ),
		'clear'         => __( 'Clear' ),
		'done'          => __( 'Ok' ),
		'close'         => __( 'Close' ),
		'default'       => __( 'Now' ),
		'today'         => __( 'Today' ),
		'previousMonth' => '<',
		'nextMonth'     => '>',
		'months' => array(
			__( 'January' ),
			__( 'February' ),
			__( 'March' ),
			__( 'April' ),
			__( 'May' ),
			__( 'June' ),
			__( 'July' ),
			__( 'August' ),
			__( 'September' ),
			__( 'October' ),
			__( 'November' ),
			__( 'December' )
		),
		'monthsShort' => array(
			__( 'Jan' ),
			__( 'Feb' ),
			__( 'Mar' ),
			__( 'Apr' ),
			__( 'May' ),
			__( 'Jun' ),
			__( 'Jul' ),
			__( 'Aug' ),
			__( 'Sep' ),
			__( 'Oct' ),
			__( 'Nov' ),
			__( 'Dec' )
		),
		'weekdays' => array(
			__( 'Sunday' ),
			__( 'Monday' ),
			__( 'Tuesday' ),
			__( 'Wednesday' ),
			__( 'Thursday' ),
			__( 'Friday' ),
			__( 'Saturday' )
		),
		'weekdaysShort' => array(
			__( 'Sun' ),
			__( 'Mon' ),
			__( 'Tue' ),
			__( 'Wed' ),
			__( 'Thu' ),
			__( 'Fri' ),
			__( 'Sat' )
		),
		'weekdaysAbbrev' => array(
			__( 'Sun' ),
			__( 'Mon' ),
			__( 'Tue' ),
			__( 'Wed' ),
			__( 'Thu' ),
			__( 'Fri' ),
			__( 'Sat' )
		)
	)
) );
?>