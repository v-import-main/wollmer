<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$id = sanitize_text_field( $_GET['id'] );
$view = get_post_meta( $id, 'view', true );

$outgoing = $view['outgoing'];
?>
<div class="collapsible-header">
	<b><?php _e( 'Popup / Sticky side:', 'flatpm_l10n' ); ?></b>
	<span class="badge"></span>
</div>

<div class="collapsible-body">
	<div class="switch">
		<label>
			Off
			<input class="hidden" type="checkbox" name="view[outgoing][enabled]" <?php if( $outgoing['enabled'] === 'true') echo 'checked'; ?>>
			<span class="lever"></span>
			On
		</label>
	</div>

	<br>
	<br>

	<div class="row">
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio"
					value="left-top"
					<?php checked( $outgoing['side'], 'left-top' ); ?>
				>
				<span><?php _e( 'Left-top', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio"
					value="top-center"
					<?php checked( $outgoing['side'], 'top-center' ); ?>
				>
				<span><?php _e( 'Top-center', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio"
					value="right-top"
					<?php checked( $outgoing['side'], 'right-top' ); ?>
				>
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
				<input class="with-gap" name="view[outgoing][side]" type="radio"
					value="left-center"
					<?php checked( $outgoing['side'], 'left-center' ); ?>
				>
				<span><?php _e( 'Left-center', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio"
					value="center"
					<?php checked( $outgoing['side'], 'center' ); ?>
				>
				<span><?php _e( 'In the center', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio"
					value="right-center"
					<?php checked( $outgoing['side'], 'right-center' ); ?>
				>
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
				<input class="with-gap" name="view[outgoing][side]" type="radio"
					value="left-bottom"
					<?php checked( $outgoing['side'], 'left-bottom' ); ?>
				>
				<span><?php _e( 'Left-bottom', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio"
					value="bottom-center"
					<?php checked( $outgoing['side'], 'bottom-center' ); ?>
				>
				<span><?php _e( 'Bottom-center', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
		<div class="col s12 m4 xl3">
			<label>
				<input class="with-gap" name="view[outgoing][side]" type="radio"
					value="right-bottom"
					<?php checked( $outgoing['side'], 'right-bottom' ); ?>
				>
				<span><?php _e( 'Right-bottom', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
	</div>

	<div class="row">
		<div class="col s12" style="display:flex;flex-wrap:wrap;column-gap:20px;align-items:center">
			<div class="input-field">
				<input id="view_outgoing_show_after" type="number" class="validate" min="0"
					name="view[outgoing][show]"
					value="<?php echo esc_attr( $outgoing['show'] ); ?>"
				>
				<label for="view_outgoing_show_after"><?php _e( 'Show after', 'flatpm_l10n' ); ?></label>
			</div>
			<div class="input-field">
				<input id="view_outgoing_hide_after" type="number" class="validate" min="0"
					name="view[outgoing][hide]"
					value="<?php echo esc_attr( $outgoing['hide'] ); ?>"
				>
				<label for="view_outgoing_hide_after"><?php _e( 'Hide after', 'flatpm_l10n' ); ?></label>
			</div>
			<label>
				<input class="with-gap" name="view[outgoing][type]" type="radio" value="sec" <?php checked( $outgoing['type'], 'sec' ); ?>>
				<span><?php _e( 'Seconds', 'flatpm_l10n' ); ?></span>
			</label>
			<label>
				<input class="with-gap" name="view[outgoing][type]" type="radio" value="px" <?php checked( $outgoing['type'], 'px' ); ?>>
				<span><?php _e( 'Pixels', 'flatpm_l10n' ); ?></span>
			</label>
			<label>
				<input class="with-gap" name="view[outgoing][type]" type="radio" value="vh" <?php checked( $outgoing['type'], 'vh' ); ?>>
				<span><?php _e( 'Vh', 'flatpm_l10n' ); ?></span>
			</label>
			<label>
				<input class="with-gap" name="view[outgoing][type]" type="radio" value="%" <?php checked( $outgoing['type'], '%' ); ?>>
				<span><?php _e( '%', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
	</div>

	<div class="row">
		<div class="col s12">
			<label>
				<input type="checkbox" name="view[outgoing][cross]" <?php if( $outgoing['cross'] === 'true') echo 'checked'; ?>>
				<span><?php _e( 'Display a cross', 'flatpm_l10n' ); ?></span>
			</label>
		</div>
	</div>

	<div class="row">
		<div class="col s12">
			<label>
				<input type="checkbox" name="view[outgoing][timer]" <?php if( $outgoing['timer'] === 'true') echo 'checked'; ?>>
				<span>
					<?php _e( 'Display close timer', 'flatpm_l10n' ); ?>
					<i class="material-icons tooltipped"
						data-position="bottom"
						data-tooltip="<?php esc_html_e( 'Before the appearance of the cross, a timer with a countdown of N seconds will be displayed. As soon as the timer ends, a cross will be displayed.', 'flatpm_l10n' ); ?>"
					>info_outline</i>
				</span>
			</label>

			<div class="col s12"><br></div>

			<div class="input-field col">
				<input id="view_outgoing_timer_count" type="number" class="validate" min="0"
					name="view[outgoing][timeout]"
					value="<?php echo esc_attr( $outgoing['timeout'] ); ?>"
				>
				<label for="view_outgoing_timer_count"><?php _e( 'Time in seconds', 'flatpm_l10n' ); ?></label>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col s12">
			<label>
				<input type="checkbox" name="view[outgoing][again]" <?php if( isset( $outgoing['again'] ) && $outgoing['again'] === 'true') echo 'checked'; ?>>
				<span>
					<?php _e( 'Display the block again after closing after N seconds', 'flatpm_l10n' ); ?>
				</span>
			</label>

			<div class="col s12"><br></div>

			<div class="input-field col">
				<input id="view_outgoing_interval" type="number" class="validate" min="0"
					name="view[outgoing][interval]"
					value="<?php if( isset( $outgoing['interval'] ) ) echo esc_attr( $outgoing['interval'] ); ?>"
				>
				<label for="view_outgoing_interval"><?php _e( 'Time in seconds', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="input-field col">
				<input id="view_outgoing_count" type="number" class="validate" min="0"
					name="view[outgoing][count]"
					value="<?php if( isset( $outgoing['count'] ) ) echo esc_attr( $outgoing['count'] ); ?>"
				>
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
				<input type="checkbox" name="view[outgoing][cookie]" <?php if( $outgoing['cookie'] === 'true') echo 'checked'; ?>>
				<span>
					<?php _e( 'Display the block after closing it (click on the cross) when the user revisits the site', 'flatpm_l10n' ); ?>
					<i class="material-icons tooltipped"
						data-position="bottom"
						data-tooltip="<?php esc_html_e( 'If the option is disabled, then when the user visits the site again, this block will not be displayed for the user.', 'flatpm_l10n' ); ?>"
					>info_outline</i>
				</span>
			</label>
		</div>
	</div>

	<div class="row">
		<div class="col s12">
			<label>
				<input type="checkbox" name="view[outgoing][close]" <?php if( $outgoing['close'] === 'true') echo 'checked'; ?>>
				<span>
					<?php _e( 'Display the block immediately if the user tries to close the page', 'flatpm_l10n' ); ?>
					<i class="material-icons tooltipped"
						data-position="bottom"
						data-tooltip="<?php esc_html_e( 'Fires on window.onblur, document.onvisibilitychange event.', 'flatpm_l10n' ); ?>"
					>info_outline</i>
				</span>
			</label>
		</div>
	</div>

	<div class="row">
		<div class="col s12">
			<label>
				<input type="checkbox" name="view[outgoing][action]" <?php if( $outgoing['action'] === 'true') echo 'checked'; ?>>
				<span>
					<?php _e( 'Display the block immediately if the user clicks on an element with a selector', 'flatpm_l10n' ); ?>
					<i class="material-icons tooltipped"
						data-position="bottom"
						data-tooltip="<?php esc_html_e( 'For example: you can implement the display of a contact form by clicking on a button.', 'flatpm_l10n' ); ?>"
					>info_outline</i>
				</span>
			</label>

			<div class="col s12"><br></div>

			<div class="input-field col">
				<input id="view_outgoing_action_selector" type="text"
					name="view[outgoing][selector]"
					value="<?php echo esc_attr( $outgoing['selector'] ); ?>"
				>
				<label for="view_outgoing_action_selector"><?php _e( 'Selector', 'flatpm_l10n' ); ?></label>
				<span class="helper-text" data-error="<?php esc_attr_e( 'Wrong selector', 'flatpm_l10n' ); ?>" data-success=""></span>
			</div>
		</div>
	</div>
</div>