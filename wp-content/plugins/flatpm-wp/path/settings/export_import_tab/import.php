<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form id="tab-import" class="col s12 white">
	<input type="hidden" name="method" value="import">

	<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

	<div class="col s12">
		<h5><?php _e( 'Import Settings:', 'flatpm_l10n' ); ?></h5>
	</div>

	<div class="col s12">
		<p>
			<label>
				<input class="with-gap" type="radio" name="import[delete_existing]" value="no" checked>
				<span><?php _e( 'Do not delete existing blocks and folders before import', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<p>
			<label>
				<input class="with-gap" type="radio" name="import[delete_existing]" value="yes">
				<span><?php _e( 'Delete all existing blocks and folders before import', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
	</div>

	<div class="col">
		<div class="file-field input-field">
			<div class="btn">
				<span><?php _e( 'Choose file', 'flatpm_l10n' ); ?></span>
				<input type="file" accept="application/JSON">
			</div>
			<div class="file-path-wrapper">
				<input class="file-path validate" type="text" placeholder="<?php esc_attr_e( 'Only .json supported', 'flatpm_l10n' ); ?>">
			</div>

			<input type="hidden" name="import[json]">
		</div>
	</div>

	<div class="col s12">
		<b><?php _e( 'What exactly needs to be imported?', 'flatpm_l10n' ); ?></b>
	</div>

	<div class="col s12">
		<p>
			<label>
				<input type="checkbox" name="import[blocks]" checked>
				<span><?php _e( 'Blocks', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<p>
			<label>
				<input type="checkbox" name="import[folders]" checked>
				<span><?php _e( 'Folders', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<p>
			<label>
				<input type="checkbox" name="import[header_footer]" checked>
				<span><?php _e( 'Header and footer', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<p>
			<label>
				<input type="checkbox" name="import[ip]" checked>
				<span><?php _e( 'Blacklist IP', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<p>
			<label>
				<input type="checkbox" name="import[settings]" checked>
				<span><?php _e( 'Settings', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<p>
			<label>
				<input type="checkbox" name="import[styles]" checked>
				<span><?php _e( 'Styles', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<p>
			<label>
				<input type="checkbox" name="import[license]">
				<span><?php _e( 'License', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
	</div>

	<div class="col s12">
		<p>
			<?php _e( 'Please be careful and check everything before starting the import!', 'flatpm_l10n' ); ?><br>
			<?php _e( 'The import process may take a long time.', 'flatpm_l10n' ); ?>
		</p>
	</div>

	<div class="col s12">
		<button type="submit" class="btn-large waves-effect waves-light">
			<i class="material-icons medium left">cloud_upload</i>
			<b style="font-weight:500"><?php _e( 'Start the import process', 'flatpm_l10n' ); ?></b>
		</button>

		<?php if( ! flat_do_some() ){ ?><p><?php _e( 'Import is available only for users of the PRO version.', 'flatpm_l10n' ); ?></p><?php } ?>
	</div>

	<div class="row"></div>
</form>