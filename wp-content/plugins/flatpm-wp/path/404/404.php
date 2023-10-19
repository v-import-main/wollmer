<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( '404 Error', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

<div class="flat_pm_wrap row">
	<div class="main col s12 white">
		<div class="row">
			<div class="col s12">
				<h5><?php _e( 'The requested page does not exist', 'flatpm_l10n' ); ?></h5>
				<p><?php _e( 'Check the link in the address bar, most likely the block or folder with this ID has been deleted.', 'flatpm_l10n' ); ?></p>
				<p><?php _e( 'If you expect to see a block or folder here, and you are sure that the link is correct, then contact support.', 'flatpm_l10n' ); ?></p>
				<br>
			</div>
		</div>
	</div>

	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>