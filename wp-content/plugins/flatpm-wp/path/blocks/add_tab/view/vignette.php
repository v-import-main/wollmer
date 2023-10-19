<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="collapsible-header">
	<b><?php _e( 'Follow links (Adsense vignette ads):', 'flatpm_l10n' ); ?></b>
	<span class="badge"></span>
</div>

<div class="collapsible-body">
	<div class="switch">
		<label>
			Off
			<input class="hidden" type="checkbox" name="view[vignette][enabled]">
			<span class="lever"></span>
			On
		</label>
	</div>

	<br>

	<div class="row">
		<div class="col s12">
			<p>
				<?php _e( 'An analogue of advertising from Adsense vignette ads is full-screen ads when switching between pages. The user sees them when they leave the page.', 'flatpm_l10n' ); ?><br>
				<?php _e( 'You can customize the display in "Plugin settings -> Stylization -> Style of pop-up block when clicking on a link".', 'flatpm_l10n' ); ?>
			</p>
			<p><?php _e( 'It is recommended not to include more than one of these formats per page.', 'flatpm_l10n' ); ?></p>
		</div>
	</div>

	<div class="row">
		<div class="input-field col s12 l6 xl5">
			<input id="view_vignette_exclude" type="text" name="view[vignette][exclude]">
			<label for="view_vignette_exclude"><?php _e( 'You can specify link selectors to exclude', 'flatpm_l10n' ); ?></label>
			<span class="helper-text" data-error="<?php esc_attr_e( 'Wrong selector', 'flatpm_l10n' ); ?>" data-success=""></span>
		</div>
		<div class="col s12">
			<p><?php _e( 'URL exclusion example:', 'flatpm_l10n' ); ?> <code>[href*=&quot;google.com&quot;]</code></p>
		</div>
	</div>
</div>