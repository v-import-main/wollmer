<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$id = sanitize_text_field( $_GET['id'] );
$html = get_post_meta( $id, 'html', true );

$flat_pm_personalization = get_option( 'flat_pm_personalization' );
$m = 0;
if( $flat_pm_personalization['block']['minheight'] === 'true' ) $m++;
if( $flat_pm_personalization['block']['autorefresh'] === 'true' ) $m++;
if( $flat_pm_personalization['block']['timeout'] === 'true' ) $m++;
$m = 12 / $m;
$is_adblock = $flat_pm_personalization['block']['adblock'] === 'false';
?>
<div id="tab-html" class="col s12 white">
	<div class="list">
		<?php
		if( is_array( $html ) && isset( $html['block'] ) ){
			$i = 0;
			foreach( $html['block'] as $sub_block ){
				$is_turned = $sub_block['turned'] === 'true';
		?>
		<div class="sub_block">
			<input type="hidden" name="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][id]" value="<?php echo esc_attr( $sub_block['id'] ); ?>">
			<input type="checkbox" id="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][expand]" <?php if( $i++ == 0 ) echo ' checked'; ?>>

			<div class="sub_block_collapsible_header">
				<label class="waves-effect" for="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][expand]"></label>

				<div class="btn-flat">
					<i class="material-icons">expand_more</i>
				</div>
				<div class="btn-flat">
					<i class="material-icons">expand_less</i>
				</div>

				<input type="text" class="sub_block_name"
					name="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][name]"
					placeholder="<?php esc_attr_e( 'Sub block name', 'flatpm_l10n' ); ?>"
					value="<?php echo esc_attr( $sub_block['name'] ); ?>"
				>

				<div class="main-control">
					<button type="button" class="btn waves-effect tooltipped mobile active"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Smartphone', 'flatpm_l10n' ); ?>"
					>
						<i class="material-icons">phone_android</i>
					</button>

					<button type="button" class="btn waves-effect tooltipped tablet active"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Tablet', 'flatpm_l10n' ); ?>"
					>
						<i class="material-icons">tablet_android</i>
					</button>

					<button type="button" class="btn waves-effect tooltipped laptop active"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Laptop', 'flatpm_l10n' ); ?>"
					>
						<i class="material-icons">laptop</i>
					</button>

					<button type="button" class="btn waves-effect tooltipped desktop active"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'PC', 'flatpm_l10n' ); ?>"
					>
						<i class="material-icons">desktop_windows</i>
					</button>

					<input type="number" min="0" placeholder="<?php esc_attr_e( 'from', 'flatpm_l10n' ); ?>"
						name="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][minwidth]"
						class="tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Screen width from', 'flatpm_l10n' ); ?>"
						value="<?php echo esc_attr( $sub_block['minwidth'] ); ?>"
						style="width:80px"
					>
					<input type="number" min="0" placeholder="<?php esc_attr_e( 'to', 'flatpm_l10n' ); ?>"
						name="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][maxwidth]"
						class="tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Screen width up to', 'flatpm_l10n' ); ?>"
						value="<?php echo esc_attr( $sub_block['maxwidth'] ); ?>"
						style="width:80px"
					>

					<input type="number" min="1"
						name="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][abgroup]"
						class="tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Group for A/B', 'flatpm_l10n' ); ?>"
						value="<?php echo esc_attr( $sub_block['abgroup'] ); ?>"
						onkeyup="this.setAttribute( 'value', this.value );"
					>

					<input type="checkbox"
						name="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][turned]"
						id="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][turned]"
						<?php if( $is_turned ) echo 'checked'; ?>
					>

					<label class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Enabled', 'flatpm_l10n' ); ?>"
						for="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][turned]"
					>
						<i class="material-icons" style="color:#81C06D!important">turned_in</i>
					</label>
					<label class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Disabled', 'flatpm_l10n' ); ?>"
						for="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][turned]"
					>
						<i class="material-icons" style="color:#d87a87!important">turned_in_not</i>
					</label>

					<button type="button" class="btn waves-effect tooltipped delete_sub_block"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Delete', 'flatpm_l10n' ); ?>"
					>
						<i class="material-icons" style="color:#d87a87!important">delete_forever</i>
					</button>
				</div>

				<div class="controls controls--move-block btn-small z-depth-0">
					<i class="material-icons">apps</i>
				</div>
			</div>

			<div class="sub_block_collapsible_content">
				<div class="col s12 <?php echo ! $is_adblock ? 'm6' : 'm12'; ?>">
					<h5>
						<?php _e( 'Main ad code', 'flatpm_l10n' ); ?>
					</h5>

					<div class="html_editor_wrapper">
						<input type="checkbox" id="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][html][more]">
						<label for="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][html][more]"
							class="button add_media"
							data-more="<?php _e( 'Show macros', 'flatpm_l10n' ); ?>"
							data-less="<?php _e( 'Hide macros', 'flatpm_l10n' ); ?>"
						></label>

						<?php
						$content_sub_block = $sub_block['html']['code'];
						wp_editor( $content_sub_block, 'html[block][block_' . esc_attr( $sub_block['id'] ) . '][html][code]', array(
							'textarea_name' => 'html[block][block_' . esc_attr( $sub_block['id'] ) . '][html][code]',
							'editor_class'  => 'default',
							'editor_height' => 230,
							'tinymce'       => false,
							'textarea_rows' => 10,
						) );
						?>
					</div>

					<div class="input-field col s12 l<?php echo esc_attr( $m ); ?>"
						<?php if( $flat_pm_personalization['block']['minheight'] === 'false' ){ echo 'style="display:none"'; } ?>
					>
						<input name="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][html][minheight]"
							type="number" min="0" class="validate tooltipped no-border center-align"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Min height', 'flatpm_l10n' ); ?>"
							placeholder="<?php esc_attr_e( 'Min height', 'flatpm_l10n' ); ?>"
							value="<?php echo esc_attr( $sub_block['html']['minheight'] ); ?>"
						>
					</div>
					<div class="input-field col s12 l<?php echo esc_attr( $m ); ?>"
						<?php if( $flat_pm_personalization['block']['autorefresh'] === 'false' ){ echo 'style="display:none"'; } ?>
					>
						<input name="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][html][autorefresh]"
							type="number" min="0" class="validate tooltipped no-border center-align"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Auto-reload', 'flatpm_l10n' ); ?>"
							placeholder="<?php esc_attr_e( 'Auto-reload', 'flatpm_l10n' ); ?>"
							value="<?php echo esc_attr( $sub_block['html']['autorefresh'] ); ?>"
						>
					</div>
					<div class="input-field col s12 l<?php echo esc_attr( $m ); ?>"
						<?php if( $flat_pm_personalization['block']['timeout'] === 'false' ){ echo 'style="display:none"'; } ?>
					>
						<input name="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][html][timeout]"
							type="number" min="0" class="validate tooltipped no-border center-align"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Code insertion delay', 'flatpm_l10n' ); ?>"
							placeholder="<?php esc_attr_e( 'Code insertion delay', 'flatpm_l10n' ); ?>"
							value="<?php echo esc_attr( $sub_block['html']['timeout'] ); ?>"
						>
					</div>
				</div>

				<div class="col s12 m6" <?php if( $is_adblock ){ echo 'style="display:none"'; } ?>>
					<h5>
						<?php _e( 'For <span style="color:red">ADblock</span> users', 'flatpm_l10n' ); ?>
					</h5>

					<div class="html_editor_wrapper">
						<input type="checkbox" id="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][adb][more]">
						<label for="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][adb][more]"
							class="button add_media"
							data-more="<?php _e( 'Show macros', 'flatpm_l10n' ); ?>"
							data-less="<?php _e( 'Hide macros', 'flatpm_l10n' ); ?>"
						></label>

						<?php
						$content_sub_block = $sub_block['adb']['code'];
						wp_editor( $content_sub_block, 'html[block][block_' . esc_attr( $sub_block['id'] ) . '][adb][code]', array(
							'textarea_name' => 'html[block][block_' . esc_attr( $sub_block['id'] ) . '][adb][code]',
							'editor_class'  => 'default',
							'editor_height' => 230,
							'tinymce'       => false,
							'textarea_rows' => 10,
						) );
						?>
					</div>

					<div class="input-field col s12 l<?php echo esc_attr( $m ); ?>"
						<?php if( $flat_pm_personalization['block']['minheight'] === 'false' ){ echo 'style="display:none"'; } ?>
					>
						<input name="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][adb][minheight]"
							type="number" min="0" class="validate tooltipped no-border center-align"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Min height', 'flatpm_l10n' ); ?>"
							placeholder="<?php esc_attr_e( 'Min height', 'flatpm_l10n' ); ?>"
							value="<?php echo esc_attr( $sub_block['adb']['minheight'] ); ?>"
						>
					</div>
					<div class="input-field col s12 l<?php echo esc_attr( $m ); ?>"
						<?php if( $flat_pm_personalization['block']['autorefresh'] === 'false' ){ echo 'style="display:none"'; } ?>
					>
						<input name="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][adb][autorefresh]"
							type="number" min="0" class="validate tooltipped no-border center-align"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Auto-reload', 'flatpm_l10n' ); ?>"
							placeholder="<?php esc_attr_e( 'Auto-reload', 'flatpm_l10n' ); ?>"
							value="<?php echo esc_attr( $sub_block['adb']['autorefresh'] ); ?>"
						>
					</div>
					<div class="input-field col s12 l<?php echo esc_attr( $m ); ?>"
						<?php if( $flat_pm_personalization['block']['timeout'] === 'false' ){ echo 'style="display:none"'; } ?>
					>
						<input name="html[block][block_<?php echo esc_attr( $sub_block['id'] ); ?>][adb][timeout]"
							type="number" min="0" class="validate tooltipped no-border center-align"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Code insertion delay', 'flatpm_l10n' ); ?>"
							placeholder="<?php esc_attr_e( 'Code insertion delay', 'flatpm_l10n' ); ?>"
							value="<?php echo esc_attr( $sub_block['adb']['timeout'] ); ?>"
						>
					</div>
				</div>
			</div>
		</div>
		<?php
			}
		}
		?>
	</div>

	<div class="row">
		<div class="col s12 center-align">
			<button type="button" class="btn-small waves-effect add_subblock">
				<?php _e( 'Add another subblock', 'flatpm_l10n' ); ?>
			</button>
		</div>
	</div>
</div>