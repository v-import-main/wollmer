<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$id = sanitize_text_field( $_GET['id'] );
$view = get_post_meta( $id, 'view', true );

$include = array(
	'pixels',
	'symbols',
	'once',
	'iterable',
	'outgoing',
	'preroll',
	'hoverroll',
	// 'vignette',
);
?>
<div id="tab-view" class="col s12 white">
	<h5><?php _e( 'Please select at least one block output option:', 'flatpm_l10n' ); ?></h5>
	<p><?php _e( 'You can choose from several different types.', 'flatpm_l10n' ); ?></p>

	<ul class="collapsible">
		<?php
		foreach( $include as $key ){
			$display = ( $flat_pm_personalization['block'][ $key ] === 'false' ) ? 'display:none' : '';

			echo '<li style="' . esc_attr( $display ) . '">';
			include_once 'view/' . $key . '.php';
			echo '</li>';
		}
		?>
	</ul>
</div>