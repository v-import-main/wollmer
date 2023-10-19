<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flat_pm_main = get_option( 'flat_pm_main' );
?>
<div id="tab-main" class="col s12 white">
	<div class="col s12">
		<h5><?php _e( 'Main Settings:', 'flatpm_l10n' ); ?></h5>
	</div>

	<!-- <div class="col s12">
		<p>
			<label class="tooltipped" data-position="top" data-tooltip="<?php _e( 'Will be available in the next patch', 'flatpm_l10n' ); ?>">
				<input name="flat_pm_main[statistics_collect]" type="checkbox" <?php if( $flat_pm_main['statistics_collect'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'Collect statistics on impressions and clicks', 'flatpm_l10n' ); ?></span>
			</label>
		</p>

		<div class="col s12">
			<?php _e( 'On the list page of all blocks, show in charts:', 'flatpm_l10n' ); ?>
		</div>

		<div class="col s12" style="display:flex;column-gap:40px;flex-wrap:wrap">
			<p>
				<label>
					<input class="with-gap" name="flat_pm_main[statistics_view]" type="radio" value="impressions" <?php checked( $flat_pm_main['statistics_view'], 'impressions' ); ?>>
					<span><?php _e( 'Impressions', 'flatpm_l10n' ); ?></span>
				</label>
			</p>
			<p>
				<label>
					<input class="with-gap" name="flat_pm_main[statistics_view]" type="radio" value="clicks" <?php checked( $flat_pm_main['statistics_view'], 'clicks' ); ?>>
					<span><?php _e( 'Clicks', 'flatpm_l10n' ); ?></span>
				</label>
			</p>
			<p>
				<label>
					<input class="with-gap" name="flat_pm_main[statistics_view]" type="radio" value="ctr" <?php checked( $flat_pm_main['statistics_view'], 'ctr' ); ?>>
					<span><?php _e( 'CTR', 'flatpm_l10n' ); ?></span>
				</label>
			</p>
		</div>
	</div> -->

	<div class="col s12">
		<!-- <br>
		<br> -->
		<p>
			<label>
				<input type="checkbox" name="flat_pm_main[dublicate_adblock]" <?php if( $flat_pm_main['dublicate_adblock'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'Duplicate main code to code for users <span style="color:red">ADblock</span>', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<div class="col s12">
			<?php _e( 'To avoid filling in the same code in both boxes, you can enable this option. Due to this, less json code will be output in the html of your page.', 'flatpm_l10n' ); ?>
		</div>
	</div>

	<div class="col s12">
		<br>
		<br>
		<p>
			<label>
				<input type="checkbox" name="flat_pm_main[editor_manage]" <?php if( $flat_pm_main['editor_manage'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'Allow users with the editor role to manage the plugin', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<div class="col s12">
			<?php _e( 'If you want to grant access to the plugin, but not give administrator rights - enable this setting, then users with the "Editor" status will get these privileges.', 'flatpm_l10n' ); ?>
		</div>
	</div>

	<div class="col s12">
		<br>
		<br>
		<p>
			<label>
				<input type="checkbox" name="flat_pm_main[auto_clear_cache]" <?php if( $flat_pm_main['auto_clear_cache'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'Enable auto flush cache', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<div class="col s12">
			<?php _e( 'Auto reset cache on significant actions in the plugin: adding/editing a block/folder, moving blocks to folders.', 'flatpm_l10n' ); ?>
			<br>
			<?php _e( 'Supported caching plugins:', 'flatpm_l10n' ); ?>
			<ol>
				<li>WP Rocket</li>
				<li>W3 Total Cache</li>
				<li>WP Super Cache</li>
				<li>WP Fastest Cache</li>
				<li>LiteSpeed Cache</li>
				<li>Hyper Cache</li>
				<li>Autoptimize</li>
				<li>Breeze – WordPress Cache Plugin</li>
				<li>d-wp</li>
			</ol>
		</div>
	</div>

	<div class="row"></div>
</div>