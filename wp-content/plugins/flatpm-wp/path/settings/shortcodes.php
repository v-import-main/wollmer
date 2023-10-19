<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'Plugin shortcodes', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row">
	<div class="main col s12" style="padding-top:0">
		<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

		<div class="row">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab">
						<a class="waves-effect active" href="#tab-flatpm"><?php _e( 'Registered by FlatPM', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-other"><?php _e( 'Other available shortcodes', 'flatpm_l10n' ); ?></a>
					</li>
				</ul>
			</div>
		</div>

		<div class="row">
			<?php include_once 'shortcodes_tab/flatpm.php'; ?>
			<?php include_once 'shortcodes_tab/other.php'; ?>
		</div>
	</div>

	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>