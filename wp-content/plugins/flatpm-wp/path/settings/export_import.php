<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'Import / Export', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row">
	<div class="main col s12" style="padding-top:0">
		<div class="row">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab">
						<a class="waves-effect" href="#tab-import"><?php _e( 'Import', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-export"><?php _e( 'Export', 'flatpm_l10n' ); ?></a>
					</li>
				</ul>
			</div>
		</div>

		<div class="row">
			<?php include_once 'export_import_tab/import.php'; ?>
			<?php include_once 'export_import_tab/export.php'; ?>
		</div>
	</div>

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