<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="tab-flatpm" class="col s12 white">
	<div class="col s12">
		<h5><?php _e( 'List of shortcodes:', 'flatpm_l10n' ); ?></h5>

		<table>
			<tbody>
				<tr>
					<td>{{user-ccode}}</td>
					<td><?php _e( 'Displays the country code (like UK, US, FR) of the current user, the value is taken from the cookie - fpm_ccode', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>{{user-country}}</td>
					<td><?php _e( 'Displays the country of the current user, the value is taken from the cookie - fpm_country', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>{{user-city}}</td>
					<td><?php _e( 'Displays the city of the current user, the value is taken from the cookie - fpm_city', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>{{user-role}}</td>
					<td><?php _e( 'Displays the role of the current user, the value is taken from the cookie - fpm_role', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>{{user-isp}}</td>
					<td><?php _e( 'Displays the ISP (Internet Service Provider) of the current user, the value is taken from the cookie - fpm_isp', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>{{user-visit}}</td>
					<td><?php _e( 'Displays the visit number of the current user, the value is taken from the cookie - fpm_visit', 'flatpm_l10n' ); ?></td>
				</tr>

				<tr>
					<td>{{user-year-now}}</td>
					<td><?php _e( 'Displays the user\'s current year', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>{{user-month-now}}</td>
					<td><?php _e( 'Displays the user\'s current month', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>{{user-day-now}}</td>
					<td><?php _e( 'Displays the user\'s current day', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>{{user-hour-now}}</td>
					<td><?php _e( 'Displays the user\'s current hours', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>{{user-minute-now}}</td>
					<td><?php _e( 'Displays the user\'s current minutes', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>{{rand}}</td>
					<td>
						<?php _e( 'Will output a random number. Within one block, the random number will not be unique, and will be repeated.', 'flatpm_l10n' ); ?><br><br>
						<code>
						{{rand<b style="color:#d87a87">_1</b>}} - <?php _e( 'To display two or more different random numbers, use groups', 'flatpm_l10n' ); ?><br>
						{{rand<b style="color:var(--color-green-black)">(1, 10)</b>}} - <?php _e( 'If you want to get a random number from the min-max interval', 'flatpm_l10n' ); ?><br>
						{{rand<b style="color:#d87a87">_1</b><b style="color:var(--color-green-black)">(1, 10)</b>}} - <?php _e( 'You can combine these two properties', 'flatpm_l10n' ); ?>
						</code>
					</td>
				</tr>


				<tr>
					<td>[fpm_block_id]</td>
					<td><?php _e( 'Displays the id of the current ad block', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_post_id]</td>
					<td><?php _e( 'Displays the id of the current post', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_post_type]</td>
					<td><?php _e( 'Displays the type of the current post', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_post_date]</td>
					<td><?php _e( 'Displays the publication date of the current post', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_post_time]</td>
					<td><?php _e( 'Displays the publication time of the current post', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_post_modified]</td>
					<td><?php _e( 'Displays when the publication was last modified', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_post_slug]</td>
					<td><?php _e( 'Displays the slug of the current post', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_post_title]</td>
					<td><?php _e( 'Displays the title of the current post &lt;h1&gt;&lt;/h1&gt;', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_url]</td>
					<td><?php _e( 'Displays the current url', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_title]</td>
					<td><?php _e( 'Displays the current title of the page &lt;title&gt;&lt;/title&gt;', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_description]</td>
					<td><?php _e( 'Displays the current description of the page &lt;meta name=&quot;description&quot; content=&quot;&quot;&gt;', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_term_id]</td>
					<td><?php _e( 'Displays the id of the current term', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_term_name]</td>
					<td><?php _e( 'Displays the name of the current term', 'flatpm_l10n' ); ?></td>
				</tr>
				<tr>
					<td>[fpm_term_slug]</td>
					<td><?php _e( 'Displays the slug of the current term', 'flatpm_l10n' ); ?></td>
				</tr>
			</tbody>
		</table>

		<p><?php _e( 'Shortcodes in curly braces <b>{{shortcode}}</b> - processed on the <b>js</b> side.', 'flatpm_l10n' ); ?></p>
		<p><?php _e( 'Shortcodes in square brackets <b>[shortcode]</b> - processed on the <b>php</b> side.', 'flatpm_l10n' ); ?></p>
	</div>

	<div class="row"></div>
</div>