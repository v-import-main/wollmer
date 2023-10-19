<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flat_pm_license = get_option( 'flat_pm_license' );
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'License management', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row">
	<form class="main col s12 update_license" style="padding-top:0">
		<input type="hidden" name="method" value="update_license">

		<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

		<div class="row">
			<div class="col s12 white" style="border-radius:10px">
				<div class="col s12">
					<h5><?php _e( 'Your license key', 'flatpm_l10n' ); ?></h5>

					<p><?php _e( 'To activate all the functionality of the PRO version, paste your key in the field below.', 'flatpm_l10n' ); ?></p>

					<br>

					<div class="input-field" style="max-width:500px">
						<input style="font-family:monospace" type="text" name="flat_pm_license" id="flat_pm_license" value="<?php echo $flat_pm_license; ?>">
						<label for="flat_pm_license"><?php _e( 'License key', 'flatpm_l10n' ); ?></label>
					</div>
				</div>

				<div class="row"></div>
			</div>
		</div>

		<br>

		<div class="row">
			<button type="submit" class="btn btn-large waves-effect waves-light">
				<b><?php _e( 'Save settings', 'flatpm_l10n' ); ?></b>
			</button>
		</div>
	</form>

	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>

<?php delete_transient( 'license_transient' ); ?>