<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="tab-other" class="col s12 white">
	<div class="col s12">
		<h5><?php _e( 'List of shortcodes:', 'flatpm_l10n' ); ?></h5>

		<table>
			<tbody>
				<?php
				global $shortcode_tags;

				$exclude = array(
					'fpm_block_id',
					'fpm_post_id',
					'fpm_post_type',
					'fpm_post_date',
					'fpm_post_time',
					'fpm_post_slug',
					'fpm_post_title',
					'fpm_url',
					'fpm_title',
					'fpm_description',
					'fpm_term_id',
					'fpm_term_name',
					'fpm_term_slug',
				);

				foreach( $shortcode_tags as $code => $function ){
					if( in_array( $code, $exclude ) ) continue;

					echo '<tr><td>[' . esc_html( $code ) . ']</td></tr>';
				}
				?>
			</tbody>
		</table>
	</div>

	<div class="row"></div>
</div>