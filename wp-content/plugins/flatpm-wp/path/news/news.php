<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="news">
	<?php
	$flat_get_news = get_transient( 'flat_get_news' );

	if( false === $flat_get_news ){
		$args = array(
			'sslverify' => false
		);

		$response = wp_remote_get( __( 'https://mehanoid.pro/micro-services/news/flatpm/en.html', 'flatpm_l10n' ), $args );

		if( ! is_wp_error( $response ) ){
			echo $response['body'];

			set_transient( 'flat_get_news', $response['body'], DAY_IN_SECONDS );
		}
	}else{
		echo $flat_get_news;
	}
	?>
</div>