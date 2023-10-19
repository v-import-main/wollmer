<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$flat_pm_personalization = get_option( 'flat_pm_personalization' );
$folder_id = ( isset( $_GET['folder'] ) ) ? sanitize_text_field( $_GET['folder'] ) : null;
?>
<div class="folders">
	<div class="folder <?php if( $folder_id === null && $flat_pm_personalization['default_folder'] == 'all' ) echo 'active'; ?>"
		data-folder-id="all"
		data-href="<?php echo esc_attr( get_site_url() ); ?>/wp-admin/admin.php?page=fpm_blocks"
	>
		<button type="button" class="icon">
			<i class="material-icons" style="font-size:50px;height:46px">cloud_queue</i>
			<span class="name"><?php _e( 'All blocks', 'flatpm_l10n' ); ?></span>
		</button>
	</div>

	<?php
	$args = array(
		'taxonomy'   => 'flat_pm_block_folders',
		'hide_empty' => false,
		'orderby'    => 'none'
	);

	$folders = get_terms( $args );

	if( ! empty( $folders ) && ! is_wp_error( $folders ) ){
		foreach( $folders as $folder ){
			$turned = get_term_meta( $folder->term_id, 'turned', true );
			if( $folder_id !== null ){
				$active = ( $folder_id == $folder->term_id ) ? 'active' : '';
			}else{
				$active = ( $flat_pm_personalization['default_folder'] == $folder->term_id ) ? 'active' : '';
			}
	?>
	<div class="folder <?php echo esc_attr( $active ); ?>"
		data-folder-id="<?php echo esc_attr( $folder->term_id ); ?>"
		data-href="<?php echo esc_attr( get_site_url() ); ?>/wp-admin/admin.php?page=fpm_blocks&folder=<?php echo esc_attr( $folder->term_id ); ?>"
	>
		<button type="button" class="icon">
			<?php if( $turned === 'true' ){ ?>
				<span class="filtered">filter</span>
			<?php } ?>

			<i class="material-icons">folder</i>

			<span class="name" title="<?php echo esc_attr( get_term_meta( $folder->term_id, 'name', true ) ); ?>"><?php echo esc_html( get_term_meta( $folder->term_id, 'name', true ) ); ?></span>
		</button>
		<div class="folder-controls">
			<button class="btn btn-floating rename waves-effect tooltipped white rename-folder modal-trigger"
				data-target="confirm-rename-folder"
				data-position="top"
				data-tooltip="<?php esc_attr_e( 'Rename', 'flatpm_l10n' ); ?>"
			>
				<i class="material-icons">edit</i>
			</button>

			<a href="<?php echo esc_attr( get_site_url() ); ?>/wp-admin/admin.php?page=fpm_blocks&folder=<?php echo esc_attr( $folder->term_id ); ?>&edit=1"
				class="btn btn-floating settings waves-effect tooltipped white"
				data-position="top"
				data-tooltip="<?php esc_attr_e( 'Settings', 'flatpm_l10n' ); ?>"
			>
				<i class="material-icons">settings</i>
			</a>

			<button class="btn btn-floating delete waves-effect tooltipped white delete-folder modal-trigger"
				data-target="confirm-delete-folder"
				data-position="top"
				data-tooltip="<?php esc_attr_e( 'Delete', 'flatpm_l10n' ); ?>"
			>
				<i class="material-icons">delete_forever</i>
			</button>
		</div>
	</div>
	<?php
		} unset( $folder );
	}
	?>

	<?php if( ! empty( $folders ) && ! is_wp_error( $folders ) ){ ?>
	<div class="folder <?php if( $flat_pm_personalization['default_folder'] == '999999999' ){ echo 'active'; } ?>"
		data-folder-id="999999999"
		data-href="<?php echo esc_attr( get_site_url() ); ?>/wp-admin/admin.php?page=fpm_blocks"
	>
		<button type="button" class="icon">
			<i class="material-icons" style="font-size:50px;height:46px">cloud_off</i>
			<span class="name"><?php _e( 'No folder', 'flatpm_l10n' ); ?></span>
		</button>
	</div>
	<?php } ?>

	<center>
		<button class="btn btn-floating waves-effect tooltipped white add-folder modal-trigger"
			data-target="confirm-create-folder"
			data-position="top"
			data-tooltip="<?php esc_attr_e( 'Create a folder', 'flatpm_l10n' ); ?>"
		>
			<i class="material-icons" style="color:#2188ab!important">add</i>
		</button>
	</center>
</div>

<div id="confirm-move-to-folder" class="modal" style="width:600px;overflow:visible">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Select a folder to move', 'flatpm_l10n' ); ?></h4>

		<div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:5px">
			<div class="filter input-field col" style="flex:auto;margin-left:0;margin-bottom:0;padding-left:0">
				<select id="select-folder">
					<option value="all"><?php _e( 'All blocks', 'flatpm_l10n' ); ?></option>
					<?php
					if( ! empty( $folders ) && ! is_wp_error( $folders ) ){
						foreach( $folders as $folder ){
							echo '<option value="' . esc_attr( $folder->term_id ) . '">' . esc_html( get_term_meta( $folder->term_id, 'name', true ) ) . '</option>';
						}
					}
					?>
				</select>
				<label for="select-folder" style="left:calc(1rem - 7px)!important"><?php _e( 'Select a folder:', 'flatpm_l10n' ); ?></label>
			</div>
			<button class="modal-close waves-effect btn confirm-move-to-folder" style="height:43px;margin:0 0 10px">
				<?php _e( 'I confirm', 'flatpm_l10n' ); ?>
			</button>
		</div>
	</div>
</div>

<div id="confirm-copy-to-folder" class="modal" style="width:600px;overflow:visible">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Select a folder to copy', 'flatpm_l10n' ); ?></h4>

		<div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:5px">
			<div class="filter input-field col" style="flex:auto;margin-left:0;margin-bottom:0;padding-left:0">
				<select id="select-folder">
					<option value="all"><?php _e( 'All blocks', 'flatpm_l10n' ); ?></option>
					<?php
					if( ! empty( $folders ) && ! is_wp_error( $folders ) ){
						foreach( $folders as $folder ){
							echo '<option value="' . esc_attr( $folder->term_id ) . '">' . esc_html( get_term_meta( $folder->term_id, 'name', true ) ) . '</option>';
						}
					}
					?>
				</select>
				<label for="select-folder" style="left:calc(1rem - 7px)!important"><?php _e( 'Select a folder:', 'flatpm_l10n' ); ?></label>
			</div>
			<button class="modal-close waves-effect btn confirm-copy-to-folder" style="height:43px;margin:0 0 10px">
				<?php _e( 'I confirm', 'flatpm_l10n' ); ?>
			</button>
		</div>
	</div>
</div>

<div id="confirm-rename-folder" class="modal" style="width:600px">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Rename folder', 'flatpm_l10n' ); ?></h4>

		<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:5px">
			<input type="text" name="name" id="name" class="default left"
				placeholder="<?php esc_attr_e( 'New name of folder', 'flatpm_l10n' ); ?>"
				style="margin:0;width:calc(100% - 160px);min-width:256px"
			>
			<button class="modal-close waves-effect btn confirm-rename-folder">
				<?php _e( 'Rename', 'flatpm_l10n' ); ?>
			</button>
		</div>
	</div>
</div>

<div id="confirm-create-folder" class="modal" style="width:600px">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Create new folder', 'flatpm_l10n' ); ?></h4>

		<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:5px">
			<input type="text" name="name" id="name" class="default left"
				placeholder="<?php esc_attr_e( 'New folder name', 'flatpm_l10n' ); ?>"
				style="margin:0;width:calc(100% - 160px);min-width:256px"
			>
			<button class="modal-close waves-effect btn confirm-create-folder">
				<?php _e( 'Create folder', 'flatpm_l10n' ); ?>
			</button>
		</div>
	</div>
</div>

<div id="confirm-delete-folder" class="modal" style="width:600px">
	<div class="modal-content">
		<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
			<i class="material-icons right" style="color:#000!important">close</i>
		</button>

		<h4><?php _e( 'Confirm deleting the folder', 'flatpm_l10n' ); ?></h4>

		<button class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
		<button class="modal-close waves-effect btn-flat confirm-delete-folder"><?php _e( 'I confirm', 'flatpm_l10n' ); ?></button>
	</div>
</div>