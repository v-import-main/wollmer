<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flat_pm_advanced = get_option( 'flat_pm_advanced' );
?>
<div id="tab-advanced" class="col s12 white">
	<div class="col s12">
		<h5><?php _e( 'Advanced Settings:', 'flatpm_l10n' ); ?></h5>
	</div>

	<div class="col s12">
		<p>
			<label>
				<input type="checkbox" name="flat_pm_advanced[fast_start]" <?php if( $flat_pm_advanced['fast_start'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'Enable Fast Mode programmatically', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<div class="col s12">
			<?php _e( 'By default, the plugin adds a quick start script to the article after the 9th paragraph tag (only works on pages with content).', 'flatpm_l10n' ); ?>
			<br>
			<?php _e( 'Disable this setting if you want to set up the quick start script manually.', 'flatpm_l10n' ); ?> <?php _e( 'Read more in the <a href="https://mehanoid.pro/">documentation</a>.', 'flatpm_l10n' ); ?>
		</div>
	</div>

	<div class="col s12">
		<br>
		<br>
		<p>
			<label>
				<input type="checkbox" name="flat_pm_advanced[sidebar]" <?php if( $flat_pm_advanced['sidebar'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'Scroll flatPM_sidebar to the specified selector', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<div class="col s12" style="margin-bottom:10px">
			<?php _e( 'By default, the plugin provides for sticking the block in the sidebar only until the end of the article.', 'flatpm_l10n' ); ?>
			<br>
			<?php _e( 'Specify the block selector to which the block in the sidebar should scroll, by default - <code>.fpm_end</code>', 'flatpm_l10n' ); ?>
		</div>
		<div class="input-field col s12 m8 l5 xl4">
			<input id="flatpm_sidebar_selector" name="flat_pm_advanced[sidebar_selector]" type="text" class="validate" value="<?php echo esc_attr( $flat_pm_advanced['sidebar_selector'] ); ?>">
			<label for="flatpm_sidebar_selector"><?php _e( 'Selector', 'flatpm_l10n' ); ?></label>
		</div>
		<div class="input-field col s12 m4 l3 xl2">
			<input id="flatpm_sidebar_bottom" name="flat_pm_advanced[sidebar_bottom]" type="number" class="validate" value="<?php echo esc_attr( $flat_pm_advanced['sidebar_bottom'] ); ?>">
			<label for="flatpm_sidebar_bottom"><?php _e( 'Bottom padding', 'flatpm_l10n' ); ?></label>
		</div>
	</div>

	<div class="col s12">
		<br>
		<p>
			<label>
				<input type="checkbox" name="flat_pm_advanced[disabled_rtb]" <?php if( $flat_pm_advanced['disabled_rtb'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'Disable automatic change of RTB codes', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<div class="col s12">
			<?php _e( 'By default, the plugin modifies the RTB (РСЯ Yandex) codes so that one code can be used more than once per page.', 'flatpm_l10n' ); ?>
		</div>

		<div class="col s12 m6">
			<p><b><?php _e( 'Default code:', 'flatpm_l10n' ); ?></b></p>
			<textarea class="default fpm-example-code">&lt;!-- Yandex.RTB R-A-XXXXXXX-X --&gt;
&lt;div id=&quot;yandex_rtb_R-A-XXXXXXX-X&quot;&gt;&lt;/div&gt;
&lt;script&gt;window.yaContextCb.push(()=&gt;{
	Ya.Context.AdvManager.render({
		renderTo: 'yandex_rtb_R-A-XXXXXXX-X',
		blockId: 'R-A-XXXXXXX-X'
	})
})&lt;/script&gt;</textarea>
		</div>

		<div class="col s12 m6">
			<p><b><?php _e( 'Code after FlatPM processing:', 'flatpm_l10n' ); ?></b></p>
			<textarea class="default fpm-example-code">&lt;!-- Yandex.RTB R-A-XXXXXXX-X --&gt;
&lt;div id=&quot;yandex_rtb_flatYYYY_R-A-XXXXXXX-X&quot;&gt;&lt;/div&gt;
&lt;script&gt;window.yaContextCb.push(()=&gt;{
	Ya.Context.AdvManager.render({ pageNumber: ZZZ,
		renderTo: 'yandex_rtb_flatYYYY_R-A-XXXXXXX-X',
		blockId: 'R-A-XXXXXXX-X'
	})
})&lt;/script&gt;</textarea>
		</div>
	</div>

	<div class="col s12">
		<br>
		<br>

		<p><?php _e( 'This button will clear all HTML data from all blocks, but will not remove the blocks themselves.', 'flatpm_l10n' ); ?></p>

		<button type="button" class="btn clear_all_html"><?php _e( 'Clear all HTML', 'flatpm_l10n' ); ?></button>
	</div>

	<div class="row"></div>
</div>