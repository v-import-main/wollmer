<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flat_pm_personalization = get_option( 'flat_pm_personalization' );
$default_folder = $flat_pm_personalization['default_folder'];

$user = array(
	'geo'      => __( 'GEO of the country / city', 'flatpm_l10n' ),
	'referer'  => __( 'REFERER referral source', 'flatpm_l10n' ),
	'browser'  => __( 'User\'s browser', 'flatpm_l10n' ),
	'os'       => __( 'Operating system', 'flatpm_l10n' ),
	'isp'      => __( 'ISP - Internet Service Provider', 'flatpm_l10n' ),
	'utm'      => __( 'UTM - get request in address bar', 'flatpm_l10n' ),
	'cookies'  => __( 'Cookies', 'flatpm_l10n' ),
	'date'     => __( 'Date', 'flatpm_l10n' ),
	'time'     => __( 'Time', 'flatpm_l10n' ),
	'schedule' => __( 'Schedule', 'flatpm_l10n' ),
	'role'     => __( 'User role on the site', 'flatpm_l10n' ),
	'agent'    => __( 'User-agent', 'flatpm_l10n' ),
	'ip'       => __( 'Blocking by IP', 'flatpm_l10n' ),
);

$view = array(
	'pixels'    => __( 'Based on pixels', 'flatpm_l10n' ),
	'symbols'   => __( 'Based on symbols', 'flatpm_l10n' ),
	'once'      => __( 'Based on selectors (Once)', 'flatpm_l10n' ),
	'iterable'  => __( 'Based on selectors (Iterable)', 'flatpm_l10n' ),
	'outgoing'  => __( 'Popup / Sticky side', 'flatpm_l10n' ),
	'preroll'   => __( 'Video pre-roll', 'flatpm_l10n' ),
	'hoverroll' => __( 'Hover-roll', 'flatpm_l10n' ),
	// 'vignette'  => __( 'Follow links (Adsense vignette ads)', 'flatpm_l10n' ),
);

$html = array(
	'minheight'   => __( 'Min height', 'flatpm_l10n' ),
	'autorefresh' => __( 'Auto-reload', 'flatpm_l10n' ),
	'timeout'     => __( 'Code insertion delay', 'flatpm_l10n' ),
	'adblock'     => __( 'Adblock field', 'flatpm_l10n' ),
);
?>
<div id="tab-personalization" class="col s12 white">
	<div class="col s12">
		<h5><?php _e( 'Personalization:', 'flatpm_l10n' ); ?></h5>
	</div>

	<div class="col s12">
		<p><?php _e( 'FlatPM is a plugin to improve the comfort of managing ads. We understand that some targeting methods will interfere with your management.', 'flatpm_l10n' ); ?></p>
		<p><?php _e( 'Here you can hide some controls in the plugin to improve your ad management experience.', 'flatpm_l10n' ); ?></p>
	</div>

	<div class="col s12">
		<p>
			<label>
				<input type="checkbox" name="flat_pm_personalization[disabled_tooltip]" <?php if( $flat_pm_personalization['disabled_tooltip'] === 'true' ) echo 'checked'; ?>>
				<span><?php _e( 'Disable tooltips', 'flatpm_l10n' ); ?></span>
			</label>
		</p>
		<div class="col s12">
			<?php _e( 'Disable plugin tooltips', 'flatpm_l10n' ); ?>
		</div>
	</div>

	<div class="col s12">
		<br>
		<br>
		<div class="row">
			<div class="col s12">
				<?php _e( 'You can select a default folder that will open automatically on the all blocks page.', 'flatpm_l10n' ); ?>
			</div>
			<div class="input-field col s12 m6 l4 xl3">
				<select name="flat_pm_personalization[default_folder]">
					<option value="all" <?php selected( $default_folder, 'all' ); ?>><?php _e( 'All blocks', 'flatpm_l10n' ); ?></option>
					<?php
					$args = array(
						'taxonomy'   => 'flat_pm_block_folders',
						'hide_empty' => false,
						'orderby'    => 'none'
					);

					$folders = get_terms( $args );

					if( ! empty( $folders ) && ! is_wp_error( $folders ) ){
						foreach( $folders as $folder ){
							echo '<option value="' . esc_attr( $folder->term_id ) . '" ' . selected( $default_folder, $folder->term_id, false ) . '>' . esc_html( $folder->name ) . '</option>';
						}

						echo '<option value="999999999" ' . selected( $default_folder, '999999999', false ) . '>' . __( 'No folder', 'flatpm_l10n' ) . '</option>';
					}
					?>
				</select>
				<label><?php _e( 'Default folder', 'flatpm_l10n' ); ?></label>
			</div>
		</div>
	</div>

	<div class="col s12 m6">
		<h4><?php _e( 'Blocks:', 'flatpm_l10n' ); ?></h4>

		<p><b><?php _e( 'User targeting', 'flatpm_l10n' ); ?></b></p>

		<?php
		foreach( $user as $key => $value ){
			$checked = ( $flat_pm_personalization['block'][ $key ] === 'true' ) ? 'checked' : '';

			echo '
			<p>
				<label>
					<input name="flat_pm_personalization[block][' . esc_attr( $key ) . ']" type="checkbox" ' . esc_attr( $checked ) . '>
					<span>' . esc_html( $value ) . '</span>
				</label>
			</p>';
		}
		?>

		<p><b><?php _e( 'Output options', 'flatpm_l10n' ); ?></b></p>

		<?php
		foreach( $view as $key => $value ){
			$checked = ( $flat_pm_personalization['block'][ $key ] === 'true' ) ? 'checked' : '';

			echo '
			<p>
				<label>
					<input name="flat_pm_personalization[block][' . esc_attr( $key ) . ']" type="checkbox" ' . esc_attr( $checked ) . '>
					<span>' . esc_html( $value ) . '</span>
				</label>
			</p>';
		}
		?>

		<p><b><?php _e( 'HTML advanced options', 'flatpm_l10n' ); ?></b></p>

		<?php
		foreach( $html as $key => $value ){
			$checked = ( $flat_pm_personalization['block'][ $key ] === 'true' ) ? 'checked' : '';

			echo '
			<p>
				<label>
					<input name="flat_pm_personalization[block][' . esc_attr( $key ) . ']" type="checkbox" ' . esc_attr( $checked ) . '>
					<span>' . esc_html( $value ) . '</span>
				</label>
			</p>';
		}
		?>
	</div>

	<div class="col s12 m6">
		<h4><?php _e( 'Folders:', 'flatpm_l10n' ); ?></h4>

		<p><b><?php _e( 'User targeting', 'flatpm_l10n' ); ?></b></p>

		<?php
		foreach( $user as $key => $value ){
			$checked = ( $flat_pm_personalization['folder'][ $key ] === 'true' ) ? 'checked' : '';

			echo '
			<p>
				<label>
					<input name="flat_pm_personalization[folder][' . esc_attr( $key ) . ']" type="checkbox" ' . esc_attr( $checked ) . '>
					<span>' . esc_html( $value ) . '</span>
				</label>
			</p>';
		}
		?>
	</div>

	<div class="row"></div>
</div>