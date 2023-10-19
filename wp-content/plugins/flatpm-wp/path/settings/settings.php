<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'Plugin settings', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row">
	<form class="main col s12 settings_update" style="padding-top:0">
		<input type="hidden" name="method" value="settings_update">

		<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

		<div class="row">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab">
						<a class="waves-effect active" href="#tab-main"><?php _e( 'Main Settings', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-pagespeed"><?php _e( 'PageSpeed Insights', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-styles"><?php _e( 'Stylization', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-advanced"><?php _e( 'Advanced', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-personalization"><?php _e( 'Personalization', 'flatpm_l10n' ); ?></a>
					</li>
				</ul>
			</div>
		</div>

		<div class="row">
			<?php include_once 'settings_tab/main.php'; ?>
			<?php include_once 'settings_tab/pagespeed.php'; ?>
			<?php include_once 'settings_tab/styles.php'; ?>
			<?php include_once 'settings_tab/advanced.php'; ?>
			<?php include_once 'settings_tab/personalization.php'; ?>
		</div>

		<br>

		<div class="row">
			<button type="submit" class="btn btn-large waves-effect waves-light">
				<b><?php _e( 'Save settings', 'flatpm_l10n' ); ?></b>
			</button>
		</div>
	</form>

	<div id="confirm-clear-all-html" class="modal" style="width:600px" tabindex="0">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Confirm HTML cleanup', 'flatpm_l10n' ) ?></h4>
			<p><?php _e( 'This action will permanently clear all HTML in your blocks. (only if you didn\'t make a backup beforehand)', 'flatpm_l10n' ) ?></p>

			<button class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
			<button class="modal-close waves-effect btn-flat confirm-clear-all-html"><?php _e( 'I confirm', 'flatpm_l10n' ); ?></button>
		</div>
	</div>

	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>