<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="collapsible-header">
	<b><?php _e( 'Popup / Sticky side:', 'flatpm_l10n' ); ?></b>
	<span class="badge"></span>
</div>

<div class="collapsible-body">
	<div class="switch">
		<label>
			Off
			<input class="hidden" type="checkbox" name="view[outgoing][enabled]">
			<span class="lever"></span>
			On
		</label>
	</div>

	<br>
	<br>

	<div class="row">
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio" value="left-top">
				<span><?php _e( 'Left-top', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio" value="top-center">
				<span><?php _e( 'Top-center', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio" value="right-top">
				<span><?php _e( 'Right-top', 'flatpm_l10n' ); ?></span>
			</label>
		</div>

		<div class="col s12 m4 xl3 show-on-xl" style="opacity:0;pointer-events:none;display:none">
			<label>
				<input class="with-gap" type="radio">
				<span>hidden text</span>
			</label>
		</div>


		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio" value="left-center">
				<span><?php _e( 'Left-center', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio" value="center">
				<span><?php _e( 'In the center', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio" value="right-center">
				<span><?php _e( 'Right-center', 'flatpm_l10n' ); ?></span>
			</label>
		</div>

		<div class="col s12 m4 xl3 show-on-xl" style="opacity:0;pointer-events:none;display:none">
			<label>
				<input class="with-gap" type="radio">
				<span>hidden text</span>
			</label>
		</div>


		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio" value="left-bottom" checked>
				<span><?php _e( 'Left-bottom', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio" value="bottom-center">
				<span><?php _e( 'Bottom-center', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio" value="right-bottom">
				<span><?php _e( 'Right-bottom', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
	</div>

	<div class="row">
		<div class="col s12" style="display:flex;flex-wrap:wrap;column-gap:20px;align-items:center">
			<div class="input-field">
				<input id="view_outgoing_show_after" type="number" class="validate" min="0" name="view[outgoing][show]">
				<label for="view_outgoing_show_after"><?php _e( 'Show after', 'flatpm_l10n' ); ?></label>
			</div>
			<div class="input-field">
				<input id="view_outgoing_hide_after" type="number" class="validate" min="0" name="view[outgoing][hide]">
				<label for="view_outgoing_hide_after"><?php _e( 'Hide after', 'flatpm_l10n' ); ?></label>
			</div>
			<label>
				<input class="with-gap" name="view[outgoing][type]" type="radio" value="sec" checked>
				<span><?php _e( 'Seconds', 'flatpm_l10n' ); ?></span>
			</label>
			<label>
				<input class="with-gap" name="view[outgoing][type]" type="radio" value="px">
				<span><?php _e( 'Pixels', 'flatpm_l10n' ); ?></span>
			</label>
			<label>
				<input class="with-gap" name="view[outgoing][type]" type="radio" value="vh">
				<span><?php _e( 'Vh', 'flatpm_l10n' ); ?></span>
			</label>
			<label>
				<input class="with-gap" name="view[outgoing][type]" type="radio" value="%">
				<span><?php _e( '%', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
	</div>

	<div class="row">
		<div class="col s12">
			<label>
				<input type="checkbox" name="view[outgoing][cross]" checked>
				<span><?php _e( 'Display a cross', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
	</div>

	<div class="row">
		<div class="col s12">
			<label>
				<input type="checkbox" name="view[outgoing][timer]">
				<span>
					<?php _e( 'Display close timer', 'flatpm_l10n' ); ?>
					<i class="material-icons tooltipped"
						data-position="bottom"
						data-tooltip="<?php esc_attr_e( 'Before the appearance of the cross, a timer with a countdown of N seconds will be displayed. As soon as the timer ends, a cross will be displayed.', 'flatpm_l10n' ); ?>"
					>info_outline</i>
				</span>
			</label>

			<div class="col s12"><br></div>

			<div class="input-field col">
				<input id="view_outgoing_timer_count" type="number" class="validate" min="0" name="view[outgoing][timeout]">
				<label for="view_outgoing_timer_count"><?php _e( 'Time in seconds', 'flatpm_l10n' ); ?></label>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col s12">
			<label>
				<input type="checkbox" name="view[outgoing][again]">
				<span>
					<?php _e( 'Display the block again after closing after N seconds', 'flatpm_l10n' ); ?>
				</span>
			</label>

			<div class="col s12"><br></div>

			<div class="input-field col">
				<input id="view_outgoing_interval" type="number" class="validate" min="0" name="view[outgoing][interval]">
				<label for="view_outgoing_interval"><?php _e( 'Time in seconds', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="input-field col">
				<input id="view_outgoing_count" type="number" class="validate" min="0" name="view[outgoing][count]">
				<label for="view_outgoing_count">
					<i class="material-icons tooltipped"
						data-position="bottom"
						data-tooltip="<?php esc_attr_e( 'Leave blank or set 0 to remove the restriction.', 'flatpm_l10n' ); ?>"
					>info_outline</i>
					<?php _e( 'How many times', 'flatpm_l10n' ); ?>
				</label>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col s12">
			<label>
				<input type="checkbox" name="view[outgoing][cookie]" checked>
				<span>
					<?php _e( 'Display the block after closing it (click on the cross) when the user revisits the site', 'flatpm_l10n' ); ?>
					<i class="material-icons tooltipped"
						data-position="bottom"
						data-tooltip="<?php esc_attr_e( 'If the option is disabled, then when the user visits the site again, this block will not be displayed for the user.', 'flatpm_l10n' ); ?>"
					>info_outline</i>
				</span>
			</label>
		</div>
	</div>

	<div class="row">
		<div class="col s12">
			<label>
				<input type="checkbox" name="view[outgoing][close]">
				<span>
					<?php _e( 'Display the block immediately if the user tries to close the page', 'flatpm_l10n' ); ?>
					<i class="material-icons tooltipped"
						data-position="bottom"
						data-tooltip="<?php esc_attr_e( 'Fires on window.onblur, document.onvisibilitychange event.', 'flatpm_l10n' ); ?>"
					>info_outline</i>
				</span>
			</label>
		</div>
	</div>

	<div class="row">
		<div class="col s12">
			<label>
				<input type="checkbox" name="view[outgoing][action]">
				<span>
					<?php _e( 'Display the block immediately if the user clicks on an element with a selector', 'flatpm_l10n' ); ?>
					<i class="material-icons tooltipped"
						data-position="bottom"
						data-tooltip="<?php esc_attr_e( 'For example: you can implement the display of a contact form by clicking on a button.', 'flatpm_l10n' ); ?>"
					>info_outline</i>
				</span>
			</label>

			<div class="col s12"><br></div>

			<div class="input-field col">
				<input id="view_outgoing_action_selector" type="text" name="view[outgoing][selector]">
				<label for="view_outgoing_action_selector"><?php _e( 'Selector', 'flatpm_l10n' ); ?></label>
				<span class="helper-text" data-error="<?php _e( 'Wrong selector', 'flatpm_l10n' ); ?>" data-success=""></span>
			</div>
		</div>
	</div>
</div>