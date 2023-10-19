<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form id="tab-export" class="col s12 white">
	<input type="hidden" name="method" value="export">

	<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

	<div class="col s12">
		<h5><?php _e( 'Export Settings:', 'flatpm_l10n' ); ?></h5>
	</div>

	<div class="col s12">
		<p><b><?php _e( 'What exactly do you want to export?', 'flatpm_l10n' ); ?></b></p>

		<?php
		$args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'flat_pm_block',
			'order'            => 'ASC',
			'orderby'          => 'meta_value_num',
			'meta_key'         => 'order',
			'no_found_rows'    => true,
			'post_status'      => 'publish',
		);

		$query = new WP_Query( $args );
		?>
		<p>
			<label>
				<input type="checkbox" name="export[blocks][enabled]" <?php echo ( ! $query->have_posts() ) ? 'disabled' : ''; ?>>
				<span><?php _e( 'Blocks', 'flatpm_l10n' ); ?></span>
			</label>
		</p>

		<div class="expand-list">
			<button type="button"
				class="btn btn-small btn-floating tooltipped white z-depth-0 waves-effect modal-trigger select_all"
				data-position="top"
				data-tooltip="<?php esc_attr_e( 'Select all', 'flatpm_l10n' ); ?>"
			>
				<i class="material-icons" style="color:#2188ab!important">done_all</i>
			</button>

			<button type="button"
				class="btn btn-small btn-floating tooltipped white z-depth-0 waves-effect modal-trigger cancel_all"
				data-position="top"
				data-tooltip="<?php esc_attr_e( 'Cancel all', 'flatpm_l10n' ); ?>"
			>
				<i class="material-icons" style="color:#d87a87!important">close</i>
			</button>

			<div class="items">
				<?php
				if( $query->have_posts() ){
					while( $query->have_posts() ){
						$query->the_post();
				?>
				<div class="item">
					<label>
						<input type="checkbox" name="export[blocks][list][<?php echo get_the_ID(); ?>]" checked>
						<span><?php echo get_the_title(); ?></span>
					</label>
				</div>
				<?php
					}
				}
				?>
			</div>
		</div>

		<?php
		$args = array(
			'taxonomy'   => 'flat_pm_block_folders',
			'hide_empty' => false,
			'orderby'    => 'none'
		);

		$folders = get_terms( $args );
		?>
		<p>
			<label>
				<input type="checkbox" name="export[folders][enabled]" <?php echo ( empty( $folders ) || is_wp_error( $folders ) ) ? 'disabled' : '' ?>>
				<span><?php _e( 'Folders', 'flatpm_l10n' ); ?></span>
			</label>
		</p>

		<div class="expand-list">
			<button type="button"
				class="btn btn-small btn-floating tooltipped white z-depth-0 waves-effect modal-trigger select_all"
				data-position="top"
				data-tooltip="<?php esc_attr_e( 'Select all', 'flatpm_l10n' ); ?>"
			>
				<i class="material-icons" style="color:#2188ab!important">done_all</i>
			</button>

			<button type="button"
				class="btn btn-small btn-floating tooltipped white z-depth-0 waves-effect modal-trigger cancel_all"
				data-position="top"
				data-tooltip="<?php esc_attr_e( 'Cancel all', 'flatpm_l10n' ); ?>"
			>
				<i class="material-icons" style="color:#d87a87!important">close</i>
			</button>

			<div class="items">
				<?php
				if( ! empty( $folders ) && ! is_wp_error( $folders ) ){
					foreach( $folders as $folder ){
				?>
				<div class="item">
					<label>
						<input type="checkbox" name="export[folders][list][<?php echo $folder->term_id; ?>]" checked>
						<span><?php echo esc_html( $folder->name ); ?></span>
					</label>
				</div>
				<?php
					}
				} wp_reset_postdata();
				?>
			</div>
		</div>

		<p>
			<label>
				<input type="checkbox" name="export[header_footer][enabled]">
				<span><?php _e( 'Header and footer', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<p>
			<label>
				<input type="checkbox" name="export[ip][enabled]">
				<span><?php _e( 'Blacklist IP', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<p>
			<label>
				<input type="checkbox" name="export[settings][enabled]">
				<span><?php _e( 'Settings', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<p>
			<label>
				<input type="checkbox" name="export[styles][enabled]">
				<span><?php _e( 'Styles', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<p>
			<label>
				<input type="checkbox" name="export[license][enabled]">
				<span><?php _e( 'License', 'flatpm_l10n' ); ?></span>
			</label>
			<br>
			<span style="color:red">*</span> <?php _e( 'Disconnect the license in your <a href="https://mehanoid.pro/lk/login/" target="_blank">personal account</a> from the current site so that the license can be activated on the new domain during import.', 'flatpm_l10n' ); ?>
		</p>
		<br>
	</div>

	<div class="col s12">
		<button type="submit" class="btn-large waves-effect waves-light">
			<i class="material-icons left">cloud_download</i>
			<b style="font-weight:500"><?php _e( 'Create export file', 'flatpm_l10n' ); ?></b>
		</button>

		<?php if( ! flat_do_some() ){ ?><p><?php _e( 'Export is available only for users of the PRO version.', 'flatpm_l10n' ); ?></p><?php } ?>
	</div>

	<div class="row"></div>
</form>