<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flat_pm_pagespeed = get_option( 'flat_pm_pagespeed' );
?>
<div id="tab-pagespeed" class="col s12 white">
	<div class="col s12">
		<h5><?php _e( 'PageSpeed Insights settings:', 'flatpm_l10n' ); ?></h5>
	</div>

	<div class="col s12">
		<p>
			<label>
				<input type="checkbox" name="flat_pm_pagespeed[lazyload]" <?php if( $flat_pm_pagespeed['lazyload'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'LazyLoad for blocks', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<div class="col s12">
			<?php _e( 'A complete LazyLoad. Blocks will be displayed as you scroll down the page.', 'flatpm_l10n' ); ?>
			<br>
			<?php _e( 'Specify trashhold in pixels. Default - <code>300</code>', 'flatpm_l10n' ); ?>
		</div>
		<div class="input-field col s12 m6 l4 xl3">
			<input id="threshold" name="flat_pm_pagespeed[threshold]" type="number" class="validate" min="0" value="<?php echo esc_attr( $flat_pm_pagespeed['threshold'] ); ?>">
			<label for="threshold"><?php _e( 'Threshold', 'flatpm_l10n' ); ?></label>
		</div>
	</div>

	<div class="col s12">
		<br>
		<br>
		<p>
			<label>
				<input type="checkbox" name="flat_pm_pagespeed[deffered]" <?php if( $flat_pm_pagespeed['deffered'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'Postpone ads until you interact with the site', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<div class="col s12">
			<?php _e( 'Blocks will be displayed only after the user interacts with the site: mousemove, touch-event for smartphones, etc.', 'flatpm_l10n' ); ?>
			<br>
			<?php _e( 'Specify your events with a space. Default - <code>touchstart mousemove</code>', 'flatpm_l10n' ); ?>
		</div>
		<div class="input-field col s12 m6 l8 xl6">
			<input id="deffered_events" name="flat_pm_pagespeed[deffered_events]" type="text" class="validate" value="<?php echo esc_attr( $flat_pm_pagespeed['deffered_events'] ); ?>">
			<label for="deffered_events"><?php _e( 'Events', 'flatpm_l10n' ); ?></label>
		</div>
	</div>

	<div class="col s12">
		<br>
		<br>
		<p>
			<label>
				<input type="checkbox" name="flat_pm_pagespeed[timeout]" <?php if( $flat_pm_pagespeed['timeout'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'Postpone ads in milliseconds', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<div class="col s12">
			<?php _e( 'This option is useful if the user opened the site in a new tab and viewed it later.', 'flatpm_l10n' ); ?>
			<br>
			<?php _e( 'Blocks will be displayed after the specified time or after user interaction with the site (for this, the option above must be enabled).', 'flatpm_l10n' ); ?>
			<br>
			<?php _e( 'Specify the time in milliseconds. The default time is <code>800</code>', 'flatpm_l10n' ); ?>
		</div>
		<div class="input-field col s12 m6 l4 xl3">
			<input id="timeout_time" name="flat_pm_pagespeed[timeout_time]" type="number" class="validate" min="0" value="<?php echo esc_attr( $flat_pm_pagespeed['timeout_time'] ); ?>">
			<label for="timeout_time"><?php _e( 'Time', 'flatpm_l10n' ); ?></label>
		</div>
	</div>

	<div class="col s12">
		<br>
		<br>
		<p>
			<label>
				<input type="checkbox" name="flat_pm_pagespeed[pagespeed]" <?php if( $flat_pm_pagespeed['pagespeed'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'Do not display blocks for PageSpeed Insights', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<div class="col s12">
			<?php _e( 'This option disables the display of ads for Google PageSpeed Insights crawlers. Blocks will be displayed only for real site visitors.', 'flatpm_l10n' ); ?>
		</div>
	</div>

	<div class="row"></div>
</div>