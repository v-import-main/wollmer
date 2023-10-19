<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'Database update', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row">
	<form class="main col s12 migration_process" style="padding-top:0">
		<input type="hidden" name="method" value="migration_process">

		<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

		<?php
		$deprecated_settings_counter = 0;
		$deprecated_settings = array(
			'flat_plugin_options_me',
			'flat_plugin_settings_me',
			'flat_plugin_header_footer_me',
			'flat_plugin_video_me',
			'flat_pm_cross_color',
			'flat_pm_cross_background',
			'flat_pm_cross_text_color',
			'flat_pm_cross_offset',
			'flat_pm_cross_width',
			'flat_pm_cross_height',
			'flat_pm_cross_weight',
		);
		?>

		<div class="row">
			<div class="col s12 white" style="border-radius:10px">
				<div class="col s12">
					<p>
						<?php _e( 'You have outdated data.', 'flatpm_l10n' ) ?>
					</p>
					<p>
						<?php _e( 'Probably you used the plugin before version 3.0.0', 'flatpm_l10n' ) ?><br>
						<?php _e( 'The old settings are not supported by the new version, so you need to start the data migration process!', 'flatpm_l10n' ) ?>
					</p>
					<p>
						<?php _e( 'Some features are now completely unavailable. Blocks of this type will be disabled.', 'flatpm_l10n' ) ?>
					</p>

					<h5><?php _e( 'Plugin options', 'flatpm_l10n' ); ?>:</h5>

					<ul class="collapsible">
						<?php
						foreach( $deprecated_settings as $key ){
							$option = get_option( $key );

							if( !empty( $option ) ){
								$deprecated_settings_counter++;

								$additional_data = '';
								if( $key === 'flat_plugin_video_me' ){
									$additional_data = '
										data-selector="' . esc_html( $option['selector'] ) . '"
										data-xpath=""';
								}

								echo '
								<li data-process="no" data-type="setting"
									data-id="' . $key . '"
									' . $additional_data . '
								>
									<div class="collapsible-header">
										<span>' . __( 'Option needs to be updated', 'flatpm_l10n' ) . ': <b>' . $key . '</b></span>
									</div>
									<div class="collapsible-body">
										<pre style="max-height:350px;max-width:60vw;overflow:auto"><b>' . __( 'Data', 'flatpm_l10n' ) . ':</b><br>' . htmlentities( print_r( $option, true ) ) . '</pre>
									</div>
								</li>';
							}
						} unset( $key );

						if( $deprecated_settings_counter == 0 ){
							echo '<li>' . __( 'No options for migration', 'flatpm_l10n' ) . '</li>';
						}
						?>
					</ul>

					<br>

					<h5><?php _e( 'Blocks', 'flatpm_l10n' ); ?>:</h5>

					<ul class="collapsible">
						<?php
						$blocks_args = array(
							'posts_per_page' => -1,
							'post_type'      => 'flat_pm_block',
							'no_found_rows'  => true,
							'post_status'    => 'publish',
							'order'          => 'ASC',
							'orderby'        => 'meta_value_num',
							'meta_key'       => 'flat_pm_order_ID',
							'meta_query'     => array(
								array(
									'key'     => 'flat_pm_block_enabled',
									'compare' => 'EXISTS'
								)
							)
						);

						$deprecated_blocks_query = new WP_Query;
						$deprecated_blocks = $deprecated_blocks_query->query( $blocks_args );

						$i = 1;

						foreach( $deprecated_blocks as $block ){
							$post_meta = get_post_meta( $block->ID );
							$flat_pm_view = get_post_meta( $block->ID, 'flat_pm_view', true );

							$selector = '';

							if( isset( $flat_pm_view['how']['onсe'] ) ){
								$selector = $flat_pm_view['how']['onсe']['selector'];
							}

							if( isset( $flat_pm_view['how']['iterable'] ) ){
								$selector = $flat_pm_view['how']['iterable']['selector'];
							}

							$selector = str_replace(
								array( '.flat_pm_start', '.flat_pm_end' ),
								array( '.fpm_start', '.fpm_end' ),
								$selector
							);

							echo '
							<li data-process="no"
								data-type="block"
								data-id="' . esc_html( $block->ID ) . '"
								data-selector="' . esc_html( $selector ) . '"
								data-xpath=""
								data-order="' . $i++ . '"
							>
								<div class="collapsible-header">
									<span>' . __( 'Block needs to be updated', 'flatpm_l10n' ) . ': <b>' . get_the_title( $block->ID ) . '</b></span>
								</div>
								<div class="collapsible-body">
									<pre style="max-height:350px;max-width:60vw;overflow:auto"><b>' . __( 'Data', 'flatpm_l10n' ) . ':</b><br>' . htmlentities( print_r( $post_meta, true ) ) . '</pre>
								</div>
							</li>';
						} unset( $block );

						if( count( $deprecated_blocks ) == 0 ){
							echo '<li>' . __( 'No options for migration', 'flatpm_l10n' ) . '</li>';
						}
						?>
					</ul>

					<br>

					<h5><?php _e( 'Folders', 'flatpm_l10n' ); ?>:</h5>

					<ul class="collapsible">
						<?php
						$folders_args = array(
							'taxonomy'   => 'flat_pm_block_folders',
							'hide_empty' => false,
							'orderby'    => 'none',
							'meta_query'     => array(
								array(
									'key'     => 'flat_pm_folder_enabled',
									'compare' => 'EXISTS'
								)
							)
						);

						$deprecated_folders = get_terms( $folders_args );

						foreach( $deprecated_folders as $folder ){
							echo '
							<li data-process="no" data-type="folder" data-id="' . $folder->term_id . '">
								<div class="collapsible-header">
									<span>' . __( 'Folder needs to be updated', 'flatpm_l10n' ) . ': <b>' . $folder->name . '</b></span>
								</div>
								<div class="collapsible-body">
									<pre style="max-height:350px;max-width:60vw;overflow:auto"><b>' . __( 'Data', 'flatpm_l10n' ) . ':</b><br>' . htmlentities( print_r( get_term_meta( $folder->term_id ), true ) ) . '</pre>
								</div>
							</li>';
						} unset( $folder );

						if( count( $deprecated_folders ) == 0 ){
							echo '<li>' . __( 'No options for migration', 'flatpm_l10n' ) . '</li>';
						}
						?>
					</ul>
				</div>

				<div class="row"></div>
			</div>
		</div>

		<br>

		<div class="row">
			<p>
				<?php _e( 'After the operation has started, do not close this page and do not reload it until the migration is complete.', 'flatpm_l10n' ) ?>
			</p>

			<?php _e( 'Progress', 'flatpm_l10n' ) ?>:

			<div class="progress">
				<div class="determinate" style="width: 0%"></div>
			</div>

			<button type="submit" class="btn btn-large waves-effect waves-light">
				<b><?php _e( 'Start migration process', 'flatpm_l10n' ); ?></b>
			</button>
		</div>
	</form>

	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>

<?php delete_transient( 'license_transient' ); ?>