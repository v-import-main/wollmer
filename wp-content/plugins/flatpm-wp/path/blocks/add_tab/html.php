<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
		<div class="sub_block">
			<input type="hidden" name="html[block][block_0][id]" value="0">
			<input type="checkbox" id="html[block][block_0][expand]" checked>

			<div class="sub_block_collapsible_header">
				<label class="waves-effect" for="html[block][block_0][expand]"></label>

				<div class="btn-flat">
					<i class="material-icons">expand_more</i>
				</div>
				<div class="btn-flat">
					<i class="material-icons">expand_less</i>
				</div>

				<input type="text" class="sub_block_name" name="html[block][block_0][name]" placeholder="<?php esc_attr_e( 'Sub block name', 'flatpm_l10n' ); ?>">

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
						name="html[block][block_0][minwidth]"
						class="tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Screen width from', 'flatpm_l10n' ); ?>"
						value=""
						style="width:80px"
					>
					<input type="number" min="0" placeholder="<?php esc_attr_e( 'to', 'flatpm_l10n' ); ?>"
						name="html[block][block_0][maxwidth]"
						class="tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Screen width up to', 'flatpm_l10n' ); ?>"
						value=""
						style="width:80px"
					>

					<input type="number" min="1"
						name="html[block][block_0][abgroup]"
						class="tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Group for A/B', 'flatpm_l10n' ); ?>"
						onkeyup="this.setAttribute( 'value', this.value );"
					>

					<input type="checkbox" name="html[block][block_0][turned]" id="html[block][block_0][turned]" checked>

					<label class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Enabled', 'flatpm_l10n' ); ?>"
						for="html[block][block_0][turned]"
					>
						<i class="material-icons" style="color:#81C06D!important">turned_in</i>
					</label>
					<label class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Disabled', 'flatpm_l10n' ); ?>"
						for="html[block][block_0][turned]"
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
						<input type="checkbox" id="html[block][block_0][html][more]">
						<label for="html[block][block_0][html][more]"
							class="button add_media"
							class="button add_media"
							data-more="<?php _e( 'Show macros', 'flatpm_l10n' ); ?>"
							data-less="<?php _e( 'Hide macros', 'flatpm_l10n' ); ?>"
						></label>

						<?php
						$content_sub_block = '';
						wp_editor( $content_sub_block, 'html[block][block_0][html][code]', array(
							'textarea_name' => 'html[block][block_0][html][code]',
							'editor_class'  => 'default',
							'editor_height' => 230,
							'tinymce'       => false,
							'textarea_rows' => 10,
						) );
						?>
					</div>

					<div class="input-field col s12 l<?php echo $m; ?>"
						<?php if( $flat_pm_personalization['block']['minheight'] === 'false' ){ echo 'style="display:none"'; } ?>
					>
						<input name="html[block][block_0][html][minheight]"
							type="number" min="0" class="validate tooltipped no-border center-align"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Min height', 'flatpm_l10n' ); ?>"
							placeholder="<?php esc_attr_e( 'Min height', 'flatpm_l10n' ); ?>"
							value=""
						>
					</div>
					<div class="input-field col s12 l<?php echo $m; ?>"
						<?php if( $flat_pm_personalization['block']['autorefresh'] === 'false' ){ echo 'style="display:none"'; } ?>
					>
						<input name="html[block][block_0][html][autorefresh]"
							type="number" min="0" class="validate tooltipped no-border center-align"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Auto-reload', 'flatpm_l10n' ); ?>"
							placeholder="<?php esc_attr_e( 'Auto-reload', 'flatpm_l10n' ); ?>"
							value=""
						>
					</div>
					<div class="input-field col s12 l<?php echo $m; ?>"
						<?php if( $flat_pm_personalization['block']['timeout'] === 'false' ){ echo 'style="display:none"'; } ?>
					>
						<input name="html[block][block_0][html][timeout]"
							type="number" min="0" class="validate tooltipped no-border center-align"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Code insertion delay', 'flatpm_l10n' ); ?>"
							placeholder="<?php esc_attr_e( 'Code insertion delay', 'flatpm_l10n' ); ?>"
							value=""
						>
					</div>
				</div>

				<div class="col s12 m6" <?php if( $is_adblock ){ echo 'style="display:none"'; } ?>>
					<h5>
						<?php _e( 'For <span style="color:red">ADblock</span> users', 'flatpm_l10n' ); ?>
					</h5>

					<div class="html_editor_wrapper">
						<input type="checkbox" id="html[block][block_0][adb][more]">
						<label for="html[block][block_0][adb][more]"
							class="button add_media"
							data-more="<?php _e( 'Show macros', 'flatpm_l10n' ); ?>"
							data-less="<?php _e( 'Hide macros', 'flatpm_l10n' ); ?>"
						></label>

						<?php
						$content_sub_block = '';
						wp_editor( $content_sub_block, 'html[block][block_0][adb][code]', array(
							'textarea_name' => 'html[block][block_0][adb][code]',
							'editor_class'  => 'default',
							'editor_height' => 230,
							'tinymce'       => false,
							'textarea_rows' => 10,
						) );
						?>
					</div>

					<div class="input-field col s12 l<?php echo $m; ?>"
						<?php if( $flat_pm_personalization['block']['minheight'] === 'false' ){ echo 'style="display:none"'; } ?>
					>
						<input name="html[block][block_0][adb][minheight]"
							type="number" min="0" class="validate tooltipped no-border center-align"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Min height', 'flatpm_l10n' ); ?>"
							placeholder="<?php esc_attr_e( 'Min height', 'flatpm_l10n' ); ?>"
							value=""
						>
					</div>
					<div class="input-field col s12 l<?php echo $m; ?>"
						<?php if( $flat_pm_personalization['block']['autorefresh'] === 'false' ){ echo 'style="display:none"'; } ?>
					>
						<input name="html[block][block_0][adb][autorefresh]"
							type="number" min="0" class="validate tooltipped no-border center-align"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Auto-reload', 'flatpm_l10n' ); ?>"
							placeholder="<?php esc_attr_e( 'Auto-reload', 'flatpm_l10n' ); ?>"
							value=""
						>
					</div>
					<div class="input-field col s12 l<?php echo $m; ?>"
						<?php if( $flat_pm_personalization['block']['timeout'] === 'false' ){ echo 'style="display:none"'; } ?>
					>
						<input name="html[block][block_0][adb][timeout]"
							type="number" min="0" class="validate tooltipped no-border center-align"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Code insertion delay', 'flatpm_l10n' ); ?>"
							placeholder="<?php esc_attr_e( 'Code insertion delay', 'flatpm_l10n' ); ?>"
							value=""
						>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col s12 center-align">
			<button type="button" class="btn-small waves-effect add_subblock">
				<?php _e( 'Add another subblock', 'flatpm_l10n' ); ?>
			</button>
		</div>
	</div>
</div>