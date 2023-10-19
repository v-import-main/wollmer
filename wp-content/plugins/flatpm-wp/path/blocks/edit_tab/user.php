<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$id = sanitize_text_field( $_GET['id'] );
$user = get_post_meta( $id, 'user', true );

$flat_pm_personalization = get_option( 'flat_pm_personalization' );

$browsers = array(
	'Chrome'    => __( 'Chrome', 'flatpm_l10n' ),
	'YaBrowser' => __( 'Yandex browser', 'flatpm_l10n' ),
	'Opera'     => __( 'Opera', 'flatpm_l10n' ),
	'Firefox'   => __( 'Firefox', 'flatpm_l10n' ),
	'Edge'      => __( 'Edge', 'flatpm_l10n' ),
	'Safari'    => __( 'Safari', 'flatpm_l10n' ),
);

$os = array(
	'Windows' => __( 'Windows', 'flatpm_l10n' ),
	'Mac'     => __( 'MacOS', 'flatpm_l10n' ),
	'iPhone'  => __( 'iOS', 'flatpm_l10n' ),
	'Linux'   => __( 'Android / Linux', 'flatpm_l10n' ),
);

global $wp_roles;
?>
<div id="tab-user" class="col s12 white">
	<ul class="collapsible">
		<li <?php if( $flat_pm_personalization['block']['geo'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'GEO of the country / city:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>

			<div class="collapsible-body">
				<div class="switch">
					<label <?php if( ! flat_do_some() ){ echo ' class="tooltipped"'; } ?> <?php if( ! flat_do_some() ){ echo flat_pm_get_pro_tooltip(); } ?>>
						Off
						<input class="hidden" type="checkbox" name="user[geo][enabled]" <?php if( ! flat_do_some() ){ echo 'disabled'; }else{ if( $user['geo']['enabled'] === 'true') echo ' checked'; } ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row">
					<div class="col s12">
						<b>
							<?php _e( 'Countries:', 'flatpm_l10n' ); ?>
							<i class="material-icons tooltipped"
								data-position="right"
								data-tooltip="<?php esc_attr_e( 'Enter each country or city on a new line.', 'flatpm_l10n' ); ?>"
							>info_outline</i>
						</b>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Show from:', 'flatpm_l10n' ); ?></p>

						<textarea class="default" name="user[geo][country][allow]" placeholder="<?php esc_attr_e( 'For example: United Kingdom or GB', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['geo']['country']['allow'] ); ?></textarea>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Hide from:', 'flatpm_l10n' ); ?></p>

						<textarea class="default" name="user[geo][country][disallow]" placeholder="<?php esc_attr_e( 'For example: United Kingdom or GB', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['geo']['country']['disallow'] ); ?></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col s12">
						<b>
							<?php _e( 'Cities:', 'flatpm_l10n' ); ?>
							<i class="material-icons tooltipped"
								data-position="right"
								data-tooltip="<?php esc_attr_e( 'Enter each country or city on a new line.', 'flatpm_l10n' ); ?>"
							>info_outline</i>
						</b>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Show from:', 'flatpm_l10n' ); ?></p>

						<textarea class="default" name="user[geo][city][allow]" placeholder="<?php esc_attr_e( 'For example: London', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['geo']['city']['allow'] ); ?></textarea>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Hide from:', 'flatpm_l10n' ); ?></p>

						<textarea class="default" name="user[geo][city][disallow]" placeholder="<?php esc_attr_e( 'For example: London', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['geo']['city']['disallow'] ); ?></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col s12">
						<?php _e( 'Your country:', 'flatpm_l10n' ); ?> <span class="your_country"></span>
						<br>
						<?php _e( 'Your city:', 'flatpm_l10n' ); ?> <span class="your_city"></span>
						<br>
						<?php _e( 'Check geolocation by ip: http://ip-api.com/json/', 'flatpm_l10n' ); ?>
					</div>
				</div>
			</div>
		</li>

		<li <?php if( $flat_pm_personalization['block']['referer'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'REFERER referral source:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>
			<div class="collapsible-body">
				<div class="switch">
					<label>
						Off
						<input class="hidden" type="checkbox" name="user[referer][enabled]" <?php if( $user['referer']['enabled'] === 'true') echo 'checked'; ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row">
					<div class="col s12">
						<b>
							<?php _e( 'REFERER', 'flatpm_l10n' ); ?>
							<i class="material-icons tooltipped"
								data-position="right"
								data-tooltip="
								<span style='text-align:left;display:block'>
									<?php esc_attr_e( 'Enter each REFERER on a new line.', 'flatpm_l10n' ); ?>
									<br>
									<br>
									<?php esc_attr_e( 'The definition occurs in part of the string, i.e. you can enter only part of the domain<br>for example: <code>google.</code>, instead of listing all: <code>google.com, google.fr, google.de</code>', 'flatpm_l10n' ); ?>
									<br>
									<br>
									<code>///:direct</code> - <?php esc_attr_e( 'for users without a referrer (direct referrals).', 'flatpm_l10n' ); ?>
									<br>
									<code>///:iframe</code> - <?php esc_attr_e( 'for iframes (when the site is viewed through iframes).', 'flatpm_l10n' ); ?>
									<br>
									<code>zen.yandex</code> - <?php esc_attr_e( 'for transitions from Yandex.Zen', 'flatpm_l10n' ); ?>
									<br>
									<code>toloka.</code> - <?php esc_attr_e( 'for tolokers', 'flatpm_l10n' ); ?>
								</span>"
							>info_outline</i>
						</b>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Show from:', 'flatpm_l10n' ); ?></p>

						<div class="quicktags-referer-toolbar">
							<button type="button" data-value="///:direct">
								<?php _e( 'Direct', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="google.">
								<?php _e( 'Google', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="yandex.<?php echo PHP_EOL ?>ya.">
								<?php _e( 'Yandex', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="bing.">
								<?php _e( 'Bing', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="yahoo.">
								<?php _e( 'Yahoo!', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="///:iframe">
								<?php _e( 'iFrame', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="zen.yandex">
								<?php _e( 'Yandex.Zen', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="toloka.">
								<?php _e( 'Tolokers', 'flatpm_l10n' ); ?>
							</button>
						</div>

						<textarea class="default" name="user[referer][allow]" placeholder="<?php esc_attr_e( 'For example: google.com', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['referer']['allow'] ); ?></textarea>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Hide from:', 'flatpm_l10n' ); ?></p>

						<div class="quicktags-referer-toolbar">
							<button type="button" data-value="///:direct">
								<?php _e( 'Direct', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="google.">
								<?php _e( 'Google', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="yandex.<?php echo PHP_EOL ?>ya.">
								<?php _e( 'Yandex', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="bing.">
								<?php _e( 'Bing', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="yahoo.">
								<?php _e( 'Yahoo!', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="///:iframe">
								<?php _e( 'iFrame', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="zen.yandex">
								<?php _e( 'Yandex.Zen', 'flatpm_l10n' ); ?>
							</button>
							<button type="button" data-value="toloka.">
								<?php _e( 'Tolokers', 'flatpm_l10n' ); ?>
							</button>
						</div>

						<textarea class="default" name="user[referer][disallow]" placeholder="<?php esc_attr_e( 'For example: google.com', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['referer']['disallow'] ); ?></textarea>
					</div>
				</div>
			</div>
		</li>

		<li <?php if( $flat_pm_personalization['block']['browser'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'User\'s browser:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>
			<div class="collapsible-body">
				<div class="switch">
					<label>
						Off
						<input class="hidden" type="checkbox" name="user[browser][enabled]" <?php if( $user['browser']['enabled'] === 'true') echo 'checked'; ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row" style="margin-bottom:0">
					<div class="input-field col s12 m6">
						<select multiple name="user[browser][allow]" id="user_browser_enabled">
							<option value="" disabled><?php _e( 'Select browsers', 'flatpm_l10n' ); ?></option>
							<?php
							if( !empty( $user['browser']['allow'] ) && is_array( $user['browser']['allow'] ) ){
								foreach( $browsers as $key => $value ){
									$selected = ( in_array( $key , $user['browser']['allow'] ) ) ? 'selected' : '';

									echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
								}
							}else{
								foreach( $browsers as $key => $value ){
									echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
								}
							}
							?>
						</select>
						<label><?php _e( 'Show from:', 'flatpm_l10n' ); ?></label>
					</div>

					<div class="input-field col s12 m6">
						<select multiple name="user[browser][disallow]" id="user_browser_disabled">
							<option value="" disabled><?php _e( 'Select browsers', 'flatpm_l10n' ); ?></option>
							<?php
							if( !empty( $user['browser']['disallow'] ) && is_array( $user['browser']['disallow'] ) ){
								foreach( $browsers as $key => $value ){
									$selected = ( in_array( $key , $user['browser']['disallow'] ) ) ? 'selected' : '';

									echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
								}
							}else{
								foreach( $browsers as $key => $value ){
									echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
								}
							}
							?>
						</select>
						<label><?php _e( 'Hide from:', 'flatpm_l10n' ); ?></label>
					</div>
				</div>
			</div>
		</li>

		<li <?php if( $flat_pm_personalization['block']['os'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'Operating system:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>
			<div class="collapsible-body">
				<div class="switch">
					<label>
						Off
						<input class="hidden" type="checkbox" name="user[os][enabled]" <?php if( $user['os']['enabled'] === 'true') echo 'checked'; ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row" style="margin-bottom:0">
					<div class="input-field col s12 m6">
						<select multiple name="user[os][allow]" id="user_os_enabled">
							<option value="" disabled><?php _e( 'Select OS', 'flatpm_l10n' ); ?></option>
							<?php
							if( !empty( $user['os']['allow'] ) && is_array( $user['os']['allow'] ) ){
								foreach( $os as $key => $value ){
									$selected = ( in_array( $key , $user['os']['allow'] ) ) ? 'selected' : '';

									echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
								}
							}else{
								foreach( $os as $key => $value ){
									echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
								}
							}
							?>
						</select>
						<label><?php _e( 'Show from:', 'flatpm_l10n' ); ?></label>
					</div>

					<div class="input-field col s12 m6">
						<select multiple name="user[os][disallow]" id="user_os_disabled">
							<option value="" disabled><?php _e( 'Select OS', 'flatpm_l10n' ); ?></option>
							<?php
							if( !empty( $user['os']['disallow'] ) && is_array( $user['os']['disallow'] ) ){
								foreach( $os as $key => $value ){
									$selected = ( in_array( $key , $user['os']['disallow'] ) ) ? 'selected' : '';

									echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
								}
							}else{
								foreach( $os as $key => $value ){
									echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
								}
							}
							?>
						</select>
						<label><?php _e( 'Hide from:', 'flatpm_l10n' ); ?></label>
					</div>
				</div>
			</div>
		</li>

		<li <?php if( $flat_pm_personalization['block']['isp'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'ISP - Internet Service Provider:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>
			<div class="collapsible-body">
				<div class="switch">
					<label <?php if( ! flat_do_some() ){ echo ' class="tooltipped"'; } ?> <?php if( ! flat_do_some() ){ echo flat_pm_get_pro_tooltip(); } ?>>
						Off
						<input class="hidden" type="checkbox" name="user[isp][enabled]" <?php if( ! flat_do_some() ){ echo 'disabled'; }else{ if( $user['isp']['enabled'] === 'true') echo ' checked'; } ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row">
					<div class="col s12">
						<b>
							<?php _e( 'ISP', 'flatpm_l10n' ); ?>
							<i class="material-icons tooltipped"
								data-position="right"
								data-tooltip="
								<span style='text-align:left;display:block'>
									<?php esc_attr_e( 'Enter each ISP on a new line.', 'flatpm_l10n' ); ?>
									<br>
									<br>
									<?php esc_attr_e( 'The definition occurs in part of the string, i.e. you can enter only a part<br>for example: <code>SpaceX</code>', 'flatpm_l10n' ); ?>
								</span>"
							>info_outline</i>
						</b>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Show from:', 'flatpm_l10n' ); ?></p>

						<textarea class="default" name="user[isp][allow]" placeholder="<?php esc_attr_e( 'For example: SpaceX Starlink', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['isp']['allow'] ); ?></textarea>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Hide from:', 'flatpm_l10n' ); ?></p>

						<textarea class="default" name="user[isp][disallow]" placeholder="<?php esc_attr_e( 'For example: SpaceX Starlink', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['isp']['disallow'] ); ?></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col s12">
						<?php _e( 'Your ISP:', 'flatpm_l10n' ); ?> <span class="your_isp"></span>
						<br>
						<?php _e( 'Check ISP by ip: http://ip-api.com/json/', 'flatpm_l10n' ); ?>
					</div>
				</div>
			</div>
		</li>

		<li <?php if( $flat_pm_personalization['block']['utm'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'UTM - get request in address bar:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>
			<div class="collapsible-body">
				<div class="switch">
					<label>
						Off
						<input class="hidden" type="checkbox" name="user[utm][enabled]" <?php if( $user['utm']['enabled'] === 'true') echo 'checked'; ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row">
					<div class="col s12">
						<b>
							<?php _e( 'GET-request', 'flatpm_l10n' ); ?>
							<i class="material-icons tooltipped"
								data-position="right"
								data-tooltip="
								<span style='text-align:left;display:block'>
									<?php esc_attr_e( 'Enter each get-request on a new line.', 'flatpm_l10n' ); ?>
									<br>
									<br>
									<?php esc_attr_e( 'Separate the name of the get parameter and its value with a equal sign', 'flatpm_l10n' ); ?> <code>=</code>
									<br>
									<?php esc_attr_e( 'The equal sign can be <code><</code> or <code>></code> for integer values. And also <code>*</code> for substring search.', 'flatpm_l10n' ); ?>
									<br>
									<br>
									<?php esc_attr_e( 'If the value of the get parameter must be empty, do not write anything after the equal sign, but the equal sign itself is needed!', 'flatpm_l10n' ); ?>
									<br>
									<?php esc_attr_e( 'If it doesn\'t matter what value the get-parameter takes, then you don\'t need to put a equal sign!', 'flatpm_l10n' ); ?>
								</span>"
							>info_outline</i>
						</b>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Show from:', 'flatpm_l10n' ); ?></p>

						<textarea class="default" name="user[utm][allow]" placeholder="<?php esc_attr_e( 'For example: utm_campaign = direct', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['utm']['allow'] ); ?></textarea>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Hide from:', 'flatpm_l10n' ); ?></p>

						<textarea class="default" name="user[utm][disallow]" placeholder="<?php esc_attr_e( 'For example: utm_campaign = direct', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['utm']['disallow'] ); ?></textarea>
					</div>
				</div>
			</div>
		</li>

		<li <?php if( $flat_pm_personalization['block']['cookies'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'Cookies:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>
			<div class="collapsible-body">
				<div class="switch">
					<label>
						Off
						<input class="hidden" type="checkbox" name="user[cookies][enabled]" <?php if( $user['cookies']['enabled'] === 'true') echo 'checked'; ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row">
					<div class="col s12">
						<b>
							<?php _e( 'Cookie', 'flatpm_l10n' ); ?>
							<i class="material-icons tooltipped"
								data-position="right"
								data-tooltip="
								<span style='text-align:left;display:block'>
									<?php esc_attr_e( 'Enter each cookie on a new line.', 'flatpm_l10n' ); ?>
									<br>
									<br>
									<?php esc_attr_e( 'Separate the cookie key and its value with a equal sign', 'flatpm_l10n' ); ?> <code>=</code>
									<br>
									<?php esc_attr_e( 'The equal sign can be <code><</code> or <code>></code> for integer values. And also <code>*</code> for substring search.', 'flatpm_l10n' ); ?>
									<br>
									<br>
									<?php esc_attr_e( 'If the value of cookies should be empty, do not write anything after the equal sign, but the equal sign itself is needed!', 'flatpm_l10n' ); ?>
									<br>
									<?php esc_attr_e( 'If it doesn\'t matter what value cookies take, then you don\'t need to put a equal sign!', 'flatpm_l10n' ); ?>
								</span>"
							>info_outline</i>
						</b>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Show from:', 'flatpm_l10n' ); ?></p>

						<textarea class="default" name="user[cookies][allow]" placeholder="<?php esc_attr_e( 'For example: key = value', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['cookies']['allow'] ); ?></textarea>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Hide from:', 'flatpm_l10n' ); ?></p>

						<textarea class="default" name="user[cookies][disallow]" placeholder="<?php esc_attr_e( 'For example: key = value', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['cookies']['disallow'] ); ?></textarea>
					</div>
				</div>
			</div>
		</li>

		<li <?php if( $flat_pm_personalization['block']['date'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'Date:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>
			<div class="collapsible-body">
				<div class="switch">
					<label>
						Off
						<input class="hidden" type="checkbox" name="user[date][enabled]" <?php if( $user['date']['enabled'] === 'true') echo 'checked'; ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row" style="margin-bottom:0">
					<div class="input-field col s12 m6 l3">
						<input type="text" class="datepicker" name="user[date][from]" id="user_date_from" value="<?php echo esc_attr( $user['date']['from'] ); ?>">
						<label for="user_date_from"><?php _e( 'Start from:', 'flatpm_l10n' ); ?></label>
					</div>
					<div class="input-field col s12 m6 l3">
						<input type="text" class="datepicker" name="user[date][to]" id="user_date_to" value="<?php echo esc_attr( $user['date']['to'] ); ?>">
						<label for="user_date_to"><?php _e( 'Finish in:', 'flatpm_l10n' ); ?></label>
					</div>
				</div>
			</div>
		</li>

		<li <?php if( $flat_pm_personalization['block']['time'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'Time:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>
			<div class="collapsible-body">
				<div class="switch">
					<label>
						Off
						<input class="hidden" type="checkbox" name="user[time][enabled]" <?php if( $user['time']['enabled'] === 'true') echo 'checked'; ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row" style="margin-bottom:0">
					<div class="input-field col s12 m6 l3">
						<input type="text" class="timepicker" name="user[time][from]" id="user_time_from" value="<?php echo esc_attr( $user['time']['from'] ); ?>">
						<label for="user_time_from"><?php _e( 'Start from:', 'flatpm_l10n' ); ?></label>
					</div>
					<div class="input-field col s12 m6 l3">
						<input type="text" class="timepicker" name="user[time][to]" id="user_time_to" value="<?php echo esc_attr( $user['time']['to'] ); ?>">
						<label for="user_time_to"><?php _e( 'Finish in:', 'flatpm_l10n' ); ?></label>
					</div>
				</div>
			</div>
		</li>

		<li <?php if( $flat_pm_personalization['block']['schedule'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'Schedule:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>
			<div class="collapsible-body">
				<div class="switch">
					<label <?php if( ! flat_do_some() ){ echo ' class="tooltipped"'; } ?> <?php if( ! flat_do_some() ){ echo flat_pm_get_pro_tooltip(); } ?>>
						Off
						<input class="hidden" type="checkbox" name="user[schedule][enabled]" <?php if( ! flat_do_some() ){ echo 'disabled'; }else{ if( $user['schedule']['enabled'] === 'true') echo ' checked'; } ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row">
					<div class="col s12">
						<?php _e( 'When enabled, this ad will be shown on the selected days of the week at the selected time in the GMT+0 time zone.', 'flatpm_l10n' ); ?>
						<br>
						<?php _e( 'Please note that 1 box is 1 hour, if, for example, the box Mon 00 is selected, then the message will be displayed on Monday from 00 to 01 am.', 'flatpm_l10n' ); ?>
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col" style="max-width:100%;overflow:auto">
						<input type="hidden" name="user[schedule][value]" value="<?php echo esc_attr( $user['schedule']['value'] ); ?>">

						<table class="table no-border table-schedule no-hover">
							<tbody data-sheetdata="<?php echo esc_attr( $user['schedule']['value'] ); ?>"></tbody>
						</table>
					</div>
				</div>
			</div>
		</li>

		<li <?php if( $flat_pm_personalization['block']['role'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'User role on the site:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>
			<div class="collapsible-body">
				<div class="switch">
					<label <?php if( ! flat_do_some() ){ echo ' class="tooltipped"'; } ?> <?php if( ! flat_do_some() ){ echo flat_pm_get_pro_tooltip(); } ?>>
						Off
						<input class="hidden" type="checkbox" name="user[role][enabled]" <?php if( ! flat_do_some() ){ echo 'disabled'; }else{ if( $user['role']['enabled'] === 'true') echo ' checked'; } ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row" style="margin-bottom:0">
					<div class="input-field col s12 m6">
						<select multiple name="user[role][allow]" id="user_role_enabled">
							<option value="" disabled><?php _e( 'Select Roles', 'flatpm_l10n' ); ?></option>
							<?php
							if( !empty( $user['role']['allow'] ) && is_array( $user['role']['allow'] ) ){
								foreach( $wp_roles->get_names() as $key => $value ){
									$selected = ( in_array( $key , $user['role']['allow'] ) ) ? 'selected' : '';

									echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '">' . esc_html( translate_user_role( $value ) ) . '</option>';
								}
							}else{
								foreach( $wp_roles->get_names() as $key => $value ){
									echo '<option value="' . esc_attr( $key ) . '">' . esc_html( translate_user_role( $value ) ) . '</option>';
								}
							}
							?>
						</select>
						<label><?php _e( 'Show from:', 'flatpm_l10n' ); ?></label>
					</div>

					<div class="input-field col s12 m6">
						<select multiple name="user[role][disallow]" id="user_role_disabled">
							<option value="" disabled><?php _e( 'Select Roles', 'flatpm_l10n' ); ?></option>
							<?php
							if( !empty( $user['role']['disallow'] ) && is_array( $user['role']['disallow'] ) ){
								foreach( $wp_roles->get_names() as $key => $value ){
									$selected = ( in_array( $key , $user['role']['disallow'] ) ) ? 'selected' : '';

									echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '">' . esc_html( translate_user_role( $value ) ) . '</option>';
								}
							}else{
								foreach( $wp_roles->get_names() as $key => $value ){
									echo '<option value="' . esc_attr( $key ) . '">' . esc_html( translate_user_role( $value ) ) . '</option>';
								}
							}
							?>
						</select>
						<label><?php _e( 'Hide from:', 'flatpm_l10n' ); ?></label>
					</div>
				</div>
			</div>
		</li>

		<li <?php if( $flat_pm_personalization['block']['agent'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'User-agent:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>
			<div class="collapsible-body">
				<div class="switch">
					<label>
						Off
						<input class="hidden" type="checkbox" name="user[agent][enabled]" <?php if( $user['agent']['enabled'] === 'true') echo 'checked'; ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row">
					<div class="col s12">
						<b>
							<?php _e( 'User-agent', 'flatpm_l10n' ); ?>
							<i class="material-icons tooltipped"
								data-position="right"
								data-tooltip="
								<span style='text-align:left;display:block'>
									<?php esc_attr_e( 'Enter each User-agent on a new line.', 'flatpm_l10n' ); ?>
									<br>
									<br>
									<?php esc_attr_e( 'The definition occurs in part of the string, i.e. you can enter only part of the user agent<br>for example:', 'flatpm_l10n' ); ?> <code>Mozilla/5.0 (X11; Linux x86_64)</code>
								</span>"
							>info_outline</i>
						</b>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Show from:', 'flatpm_l10n' ); ?></p>

						<textarea class="default" name="user[agent][allow]" placeholder="<?php esc_attr_e( 'For example: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['agent']['allow'] ); ?></textarea>
					</div>
					<div class="col s12 m6">
						<p><?php _e( 'Hide from:', 'flatpm_l10n' ); ?></p>

						<textarea class="default" name="user[agent][disallow]" placeholder="<?php esc_attr_e( 'For example: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 'flatpm_l10n' ); ?>"><?php echo esc_html( $user['agent']['disallow'] ); ?></textarea>
					</div>
				</div>
			</div>
		</li>

		<li <?php if( $flat_pm_personalization['block']['ip'] === 'false' ){ echo 'style="display:none"'; } ?>>
			<div class="collapsible-header">
				<b><?php _e( 'Blocking by IP:', 'flatpm_l10n' ); ?></b>
				<span class="badge"></span>
			</div>
			<div class="collapsible-body">
				<div class="switch">
					<label <?php if( ! flat_do_some() ){ echo ' class="tooltipped"'; } ?> <?php if( ! flat_do_some() ){ echo flat_pm_get_pro_tooltip(); } ?>>
						Off
						<input class="hidden" type="checkbox" name="user[ip][enabled]" <?php if( ! flat_do_some() ){ echo 'disabled'; }else{ if( $user['ip']['enabled'] === 'true') echo ' checked'; } ?>>
						<span class="lever"></span>
						On
					</label>
				</div>

				<br>

				<div class="row">
					<div class="col s12">
						<?php _e( 'The list of ips to block is filled in the <code>Blacklist IP</code> section or in the file', 'flatpm_l10n' ); ?> <code><?php echo esc_html( ABSPATH ); ?>ip.txt</code><br><br>
						<?php _e( 'You can also use a range for the IP address, for example:', 'flatpm_l10n' ); ?> <b>37.146.224.0-37.146.224.255</b>
						<br>
						<?php _e( 'Your IP:', 'flatpm_l10n' ); ?> <span class="your_ip"><?php echo flat_pm_get_real_ip(); ?></span>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>