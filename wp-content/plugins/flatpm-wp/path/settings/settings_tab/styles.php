<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flat_pm_stylization = get_option( 'flat_pm_stylization' );

$popup_animation = $flat_pm_stylization['outgoing']['popup_animation'];
$sticky_animation = $flat_pm_stylization['outgoing']['sticky_animation'];
?>
<div id="tab-styles" class="col s12 white">
	<div class="col s12">
		<h5><?php _e( 'Styling settings:', 'flatpm_l10n' ); ?></h5>
	</div>

	<div class="col s12">
		<h6><?php _e( 'Cross for all types of blocks:', 'flatpm_l10n' ); ?></h6>

		<p>
			<label>
				<input type="checkbox" id="post_types_post" name="flat_pm_stylization[cross][offset]" <?php if( $flat_pm_stylization['cross']['offset'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'Display a cross and a timer outside the block', 'flatpm_l10n' ); ?></span>
			</label>
			<div class="col s12">
				<?php _e( 'By default, the cross and the timer are displayed inside the pop-up block.', 'flatpm_l10n' ); ?>
			</div>
		</p>

		<div class="row"></div>

		<div class="row">
			<div class="input-field col s12 m6 l4 xl3 clr-field" style="color: <?php echo esc_attr( $flat_pm_stylization['cross']['background'] ); ?>;">
				<button aria-labelledby="clr-open-label"></button>
				<input id="cross_background" name="flat_pm_stylization[cross][background]" type="text" class="coloris validate" value="<?php echo esc_attr( $flat_pm_stylization['cross']['background'] ); ?>">
				<label for="cross_background"><?php _e( 'Cross background color', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="input-field col s12 m6 l4 xl3 clr-field" style="color: <?php echo esc_attr( $flat_pm_stylization['cross']['crosshair'] ); ?>;">
				<button aria-labelledby="clr-open-label"></button>
				<input id="cross_crosshair" name="flat_pm_stylization[cross][crosshair]" type="text" class="coloris validate" value="<?php echo esc_attr( $flat_pm_stylization['cross']['crosshair'] ); ?>">
				<label for="cross_crosshair"><?php _e( 'Crosshair color', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="input-field col s12 m6 l4 xl3 clr-field" style="color: <?php echo esc_attr( $flat_pm_stylization['cross']['text'] ); ?>;">
				<button aria-labelledby="clr-open-label"></button>
				<input id="cross_text" name="flat_pm_stylization[cross][text]" type="text" class="coloris validate" value="<?php echo esc_attr( $flat_pm_stylization['cross']['text'] ); ?>">
				<label for="cross_text"><?php _e( 'Timer text color', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="input-field col s12 m6 l4 xl3 show-on-xl" style="opacity:0;pointer-events:none;display:none">
				<input type="text">
			</div>

			<div class="input-field col s12 m6 l4 xl3">
				<input id="cross_width" name="flat_pm_stylization[cross][width]" type="number" class="validate" min="0" value="<?php echo esc_attr( $flat_pm_stylization['cross']['width'] ); ?>">
				<label for="cross_width"><?php _e( 'Width in pixels', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="input-field col s12 m6 l4 xl3">
				<input id="cross_height" name="flat_pm_stylization[cross][height]" type="number" class="validate" min="0" value="<?php echo esc_attr( $flat_pm_stylization['cross']['height'] ); ?>">
				<label for="cross_height"><?php _e( 'Height in pixels', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="input-field col s12 m6 l4 xl3">
				<input id="cross_thickness" name="flat_pm_stylization[cross][thickness]" type="number" class="validate" min="0" value="<?php echo esc_attr( $flat_pm_stylization['cross']['thickness'] ); ?>">
				<label for="cross_thickness"><?php _e( 'Thickness in pixels', 'flatpm_l10n' ); ?></label>
			</div>
		</div>

		<br>
		<div class="divider"></div>
	</div>

	<div class="row"></div>
	<div class="row"></div>

	<div class="col s12">
		<h6><?php _e( 'Popup / Sticky side style:', 'flatpm_l10n' ); ?></h6>

		<br>

		<div class="row">
			<div class="input-field col s12 m6 l4 xl3">
				<select name="flat_pm_stylization[outgoing][popup_animation]">
					<option value="0" <?php selected( $popup_animation, '0' ); ?>><?php _e( 'Without animation', 'flatpm_l10n' ); ?></option>
					<option value="1" <?php selected( $popup_animation, '1' ); ?>><?php _e( 'Fade in &amp; Scale', 'flatpm_l10n' ); ?></option>
					<option value="2" <?php selected( $popup_animation, '2' ); ?>><?php _e( 'Slide in', 'flatpm_l10n' ); ?></option>
					<option value="3" <?php selected( $popup_animation, '3' ); ?>><?php _e( 'Newspaper', 'flatpm_l10n' ); ?></option>
					<option value="4" <?php selected( $popup_animation, '4' ); ?>><?php _e( 'Super Scaled', 'flatpm_l10n' ); ?></option>
				</select>
				<label><?php _e( 'Popup animation', 'flatpm_l10n' ); ?></label>
			</div>
			<div class="input-field col s12 m6 l4 xl3">
				<select name="flat_pm_stylization[outgoing][sticky_animation]">
					<option value="0" <?php selected( $sticky_animation, '0' ); ?>><?php _e( 'Without animation', 'flatpm_l10n' ); ?></option>
					<option value="1" <?php selected( $sticky_animation, '1' ); ?>><?php _e( 'Fade in &amp; Scale', 'flatpm_l10n' ); ?></option>
					<option value="2" <?php selected( $sticky_animation, '2' ); ?>><?php _e( 'Slide in', 'flatpm_l10n' ); ?></option>
					<option value="3" <?php selected( $sticky_animation, '3' ); ?>><?php _e( 'Newspaper', 'flatpm_l10n' ); ?></option>
					<option value="4" <?php selected( $sticky_animation, '4' ); ?>><?php _e( 'Super Scaled', 'flatpm_l10n' ); ?></option>
				</select>
				<label><?php _e( 'Sticky side animation', 'flatpm_l10n' ); ?></label>
			</div>
			<div class="input-field col s12 m6 l4 xl3">
				<input id="popup_blur" name="flat_pm_stylization[outgoing][speed]" type="number" class="validate" min="0" value="<?php echo esc_attr( $flat_pm_stylization['outgoing']['speed'] ); ?>">
				<label for="popup_blur"><?php _e( 'Animation speed in ms', 'flatpm_l10n' ); ?></label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12 m6 l4 xl3 clr-field" style="color: <?php echo esc_attr( $flat_pm_stylization['outgoing']['background'] ); ?>;">
				<button aria-labelledby="clr-open-label"></button>
				<input id="popup_background" name="flat_pm_stylization[outgoing][background]" type="text" class="coloris validate" value="<?php echo esc_attr( $flat_pm_stylization['outgoing']['background'] ); ?>">
				<label for="popup_background"><?php _e( 'Background color', 'flatpm_l10n' ); ?></label>
			</div>
			<div class="input-field col s12 m6 l4 xl3 clr-field" style="color: <?php echo esc_attr( $flat_pm_stylization['outgoing']['overlay'] ); ?>">
				<button aria-labelledby="clr-open-label"></button>
				<input id="popup_overlay" name="flat_pm_stylization[outgoing][overlay]" type="text" class="coloris validate" value="<?php echo esc_attr( $flat_pm_stylization['outgoing']['overlay'] ); ?>">
				<label for="popup_overlay"><?php _e( 'Overlay color', 'flatpm_l10n' ); ?></label>
			</div>
			<div class="input-field col s12 m6 l4 xl3">
				<input id="popup_blur" name="flat_pm_stylization[outgoing][blur]" type="number" class="validate" min="0" value="<?php echo esc_attr( $flat_pm_stylization['outgoing']['blur'] ); ?>">
				<label for="popup_blur"><?php _e( 'Background blur', 'flatpm_l10n' ); ?></label>
			</div>
			<div class="col s12">
				<?php _e( 'It is recommended not to set a value greater than 30 to blur the background.', 'flatpm_l10n' ); ?>
			</div>
		</div>

		<br>
		<div class="divider"></div>
	</div>

	<div class="row"></div>
	<div class="row"></div>

	<div class="col s12">
		<h6><?php _e( 'Style of pop-up block when clicking on a link:', 'flatpm_l10n' ); ?></h6>

		<p><?php _e( 'An analogue of advertising from Adsense vignette ads is full-screen ads when switching between pages. The user sees them when they leave the page.', 'flatpm_l10n' ); ?></p>

		<br>
		<div class="divider"></div>
	</div>

	<div class="row"></div>
	<div class="row"></div>

	<div class="col s12" style="--data-preloader-background: transparent; --data-preloader-color: transparent;">
		<h6><?php _e( 'Ad preloader style:', 'flatpm_l10n' ); ?></h6>

		<br>

		<div class="row">
			<div class="input-field col s12 m6 l4 xl3 clr-field" style="color: <?php echo esc_attr( $flat_pm_stylization['ad_preloader']['background'] ); ?>;">
				<button aria-labelledby="clr-open-label"></button>
				<input id="ad_preloader_background" name="flat_pm_stylization[ad_preloader][background]" type="text" class="coloris validate" value="<?php echo esc_attr( $flat_pm_stylization['ad_preloader']['background'] ); ?>">
				<label for="ad_preloader_background"><?php _e( 'Preloader background/border color', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="input-field col s12 m6 l4 xl3 clr-field" style="color: <?php echo esc_attr( $flat_pm_stylization['ad_preloader']['color'] ); ?>;">
				<button aria-labelledby="clr-open-label"></button>
				<input id="ad_preloader_color" name="flat_pm_stylization[ad_preloader][color]" type="text" class="coloris validate" value="<?php echo esc_attr( $flat_pm_stylization['ad_preloader']['color'] ); ?>">
				<label for="ad_preloader_color"><?php _e( 'Preloader text color', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="input-field col s12 m6 l4 xl3">
				<input id="ad_preloader_text" name="flat_pm_stylization[ad_preloader][text]" type="text" class="validate" value="<?php echo esc_attr( $flat_pm_stylization['ad_preloader']['text'] ); ?>">
				<label for="ad_preloader_text"><?php _e( 'Preloader text', 'flatpm_l10n' ); ?></label>
			</div>
		</div>

		<div class="row">
			<div class="col s12">
				<label>
					<input class="with-gap" name="flat_pm_stylization[ad_preloader][style]" type="radio"
						value="none"
						<?php checked( $flat_pm_stylization['ad_preloader']['style'], 'none' ); ?>
					>
					<span>
						1. <?php _e( 'Without style', 'flatpm_l10n' ); ?>
					</span>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="col s12 m6 l3">
				<label>
					<input class="with-gap" name="flat_pm_stylization[ad_preloader][style]" type="radio"
						value="animation"
						<?php checked( $flat_pm_stylization['ad_preloader']['style'], 'animation' ); ?>
					>
					<span style="width:100%;padding:0;text-indent:35px">
						2. <?php _e( 'Skeleton animation', 'flatpm_l10n' ); ?>

						<span data-preloader-type="animation"></span>
					</span>
				</label>
			</div>

			<div class="col s12 m6 l3">
				<label>
					<input class="with-gap" name="flat_pm_stylization[ad_preloader][style]" type="radio"
						value="greybackground"
						<?php checked( $flat_pm_stylization['ad_preloader']['style'], 'greybackground' ); ?>
					>
					<span style="width:100%;padding:0;text-indent:35px">
						3. <?php _e( 'Background', 'flatpm_l10n' ); ?>

						<span data-preloader-type="greybackground"></span>
					</span>
				</label>
			</div>

			<div class="col s12 m6 l3">
				<label>
					<input class="with-gap" name="flat_pm_stylization[ad_preloader][style]" type="radio"
						value="greyborder"
						<?php checked( $flat_pm_stylization['ad_preloader']['style'], 'greyborder' ); ?>
					>
					<span style="width:100%;padding:0;text-indent:35px">
						4. <?php _e( 'Border', 'flatpm_l10n' ); ?>

						<span data-preloader-type="greyborder"></span>
					</span>
				</label>
			</div>

			<div class="col s12 m6 l3">
				<label>
					<input class="with-gap" name="flat_pm_stylization[ad_preloader][style]" type="radio"
						value="only_text"
						<?php checked( $flat_pm_stylization['ad_preloader']['style'], 'only_text' ); ?>
					>
					<span style="width:100%;padding:0;text-indent:35px">
						5. <?php _e( 'Text', 'flatpm_l10n' ); ?>

						<span data-preloader-type="none"></span>
					</span>
				</label>
			</div>
		</div>
	</div>

	<div class="row"></div>
</div>