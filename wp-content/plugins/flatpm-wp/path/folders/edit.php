<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$folder = sanitize_text_field( $_GET['folder'] );
$folder_obj = get_term( $folder );

$is_turned = get_term_meta( $folder_obj->term_id, 'turned', true ) === 'true';
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'Edit folder filter', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row">
	<form class="main col s12 folder_update" style="padding-top:0">
		<input type="hidden" name="method" value="folder_update">
		<input type="hidden" name="id" value="<?php echo esc_attr( $folder_obj->term_id ); ?>">

		<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

		<div class="row white">
			<div class="input-field col s12 m6 right">
				<div class="main-control right">
					<input type="checkbox" name="turned" id="turned" <?php if( $is_turned ) echo 'checked'; ?>>

					<label style="border-radius:50%" class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Enabled', 'flatpm_l10n' ); ?>"
						for="turned"
					>
						<i class="material-icons" style="color:#81C06D!important">turned_in</i>
					</label>
					<label style="border-radius:50%" class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Disabled', 'flatpm_l10n' ); ?>"
						for="turned"
					>
						<i class="material-icons" style="color:#d87a87!important">turned_in_not</i>
					</label>

					<button type="submit" style="border-radius:50%" class="btn waves-effect tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Save', 'flatpm_l10n' ); ?>"
					>
						<i class="material-icons">save</i>
					</button>

					<button type="button" style="border-radius:50%" class="btn waves-effect tooltipped modal-trigger"
						data-block-id="<?php echo esc_attr( $folder_obj->term_id ); ?>"
						data-target="confirm-delete-block"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Delete block', 'flatpm_l10n' ); ?>"
					>
						<i class="material-icons" style="color:#d87a87!important">delete_forever</i>
					</button>
				</div>
			</div>

			<div class="input-field col s12 m6">
				<input type="text" id="block-name" class="validate no-border" name="name" value="<?php echo esc_attr( $folder_obj->name ); ?>" placeholder="<?php esc_attr_e( 'Folder name', 'flatpm_l10n' ); ?>" required>
				<span class="helper-text" data-error="<?php esc_attr_e( 'Please fill out this field', 'flatpm_l10n' ); ?>" data-success=""></span>
			</div>
		</div>

		<div class="row white">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab">
						<a class="waves-effect" href="#tab-content"><?php _e( 'Content targeting', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-user"><?php _e( 'User targeting', 'flatpm_l10n' ); ?></a>
					</li>
				</ul>
			</div>
		</div>

		<div class="row">
			<?php include_once 'edit_tab/content.php'; ?>
			<?php include_once 'edit_tab/user.php'; ?>
		</div>

		<br>

		<div class="row">
			<button type="submit" class="btn btn-large waves-effect waves-light" type="submit">
				<b><?php _e( 'Save folder settings', 'flatpm_l10n' ); ?></b>
			</button>
		</div>
	</form>


	<div id="search-publish-modal" class="modal">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Choose publications', 'flatpm_l10n' ); ?></h4>
			<p><?php _e( 'You can search as a single entry by entering the id, url or title, or as a list.<br>Each query on a new line:', 'flatpm_l10n' ); ?></p>

			<div class="col s12">
				<div class="row" style="margin-bottom:10px">
					<div class="row" style="margin-bottom:0">
						<div class="col s12 m5">
							<textarea class="default" name="search-publish-query" id="search-publish-query" placeholder="<?php esc_attr_e( 'What are we looking for?', 'flatpm_l10n' ); ?>" style="min-height:220.5px"></textarea>
						</div>

						<div class="col s12 m7">
							<ul class="extended_list collection" style="margin:0"></ul>
						</div>
					</div>
				</div>
			</div>

			<small><?php _e( 'minimum query length for url - 8 characters', 'flatpm_l10n' ); ?>,</small>
			<small><?php _e( 'minimum query length for title - 4 characters', 'flatpm_l10n' ); ?></small>
		</div>
	</div>


	<div id="search-taxonomy-modal" class="modal">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Choose taxonomies', 'flatpm_l10n' ); ?></h4>
			<p><?php _e( 'You can search for one taxonomy by entering id, slug or title, or as a list.<br>Each query on a new line:', 'flatpm_l10n' ); ?></p>

			<div class="col s12">
				<div class="row" style="margin-bottom:10px">
					<div class="row" style="margin-bottom:0">
						<div class="col s12 m5">
							<textarea class="default" name="search-taxonomy-query" id="search-taxonomy-query" placeholder="Что будем искать?" style="min-height:220.5px"></textarea>
						</div>

						<div class="col s12 m7">
							<ul class="extended_list collection" style="margin:0"></ul>
						</div>
					</div>
				</div>
			</div>

			<small><?php _e( 'minimum query length for url - 8 characters', 'flatpm_l10n' ); ?>,</small>
			<small><?php _e( 'minimum query length for title - 4 characters', 'flatpm_l10n' ); ?></small>
		</div>
	</div>

	<div id="confirm-delete-block" class="modal" style="width:600px">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Confirm deleting the block', 'flatpm_l10n' ); ?></h4>

			<button class="modal-close waves-effect btn btn-flat"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
			<button class="modal-close waves-effect btn-flat confirm-delete-block"><?php _e( 'I confirm', 'flatpm_l10n' ); ?></button>
		</div>
	</div>

	<div class="sidebar sidebar--left">
		<?php require FLATPM_FOLDERS_LIST; ?>
	</div>

	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>