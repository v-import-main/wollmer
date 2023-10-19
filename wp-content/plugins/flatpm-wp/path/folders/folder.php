<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fpm_filters = ( isset( $_COOKIE['fpm_filters'] ) ) ? sanitize_text_field( $_COOKIE['fpm_filters'] ) : false;

if( $fpm_filters !== false ){
	$fpm_filters = map_deep( json_decode( stripslashes( $fpm_filters ), true ), 'sanitize_text_field' );
}

$flat_pm_unfold = get_option( 'flat_pm_unfold' );
$flat_pm_main = get_option( 'flat_pm_main' );
$flat_pm_personalization = get_option( 'flat_pm_personalization' );

$flat_pm_main['statistics_collect'] = 'false';

function getRandIntArray( $n, $min = 100, $max = 500 ){
	$range = range( $min, $max );
	shuffle( $range );
	return array_slice( $range, 0, $n );
}

function getLastNDays( $days, $format = 'd.m' ){
	$d = date('d');
	$m = date('m');
	$y = date('Y');
	$dateArray = array();
	for( $i = 0; $i <= $days - 1; $i++ ){
		$dateArray[] = date( $format, mktime( 0, 0, 0, $m, ( $d - $i ), $y ) );
	}
	return array_reverse( $dateArray );
}

$device = array(
	'mobile'  => __( 'Smartphone', 'flatpm_l10n' ),
	'tablet'  => __( 'Tablet', 'flatpm_l10n' ),
	'laptop'  => __( 'Laptop', 'flatpm_l10n' ),
	'desktop' => __( 'PC', 'flatpm_l10n' ),
);

$filters = array(
	'geo'      => __( 'GEO', 'flatpm_l10n' ),
	'referer'  => __( 'REFERER', 'flatpm_l10n' ),
	'browser'  => __( 'Browser', 'flatpm_l10n' ),
	'os'       => __( 'OS', 'flatpm_l10n' ),
	'isp'      => __( 'ISP', 'flatpm_l10n' ),
	'utm'      => __( 'UTM', 'flatpm_l10n' ),
	'cookies'  => __( 'Cookies', 'flatpm_l10n' ),
	'date'     => __( 'Date', 'flatpm_l10n' ),
	'time'     => __( 'Time', 'flatpm_l10n' ),
	'schedule' => __( 'Schedule', 'flatpm_l10n' ),
	'role'     => __( 'Roles', 'flatpm_l10n' ),
	'agent'    => __( 'User-agent', 'flatpm_l10n' ),
	'ip'       => __( 'Blocking by IP', 'flatpm_l10n' ),
	'ab'       => __( 'A/B test', 'flatpm_l10n' ),
);

$types = array(
	'pixels'    => __( 'By pixels', 'flatpm_l10n' ),
	'symbols'   => __( 'By symbols', 'flatpm_l10n' ),
	'once'      => __( 'Once', 'flatpm_l10n' ),
	'iterable'  => __( 'Iterable', 'flatpm_l10n' ),
	'outgoing'  => __( 'Outgoing', 'flatpm_l10n' ),
	'preroll'   => __( 'Pre-roll', 'flatpm_l10n' ),
	'hoverroll' => __( 'Hover-roll', 'flatpm_l10n' ),
	// 'vignette'  => __( 'Vignette', 'flatpm_l10n' ),
);

$status = array(
	'turned'     => __( 'Enabled', 'flatpm_l10n' ),
	'not-turned' => __( 'Disabled', 'flatpm_l10n' ),
);
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'Your ad blocks', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<?php wp_nonce_field( 'flat_pm_nonce' ); ?>
<input type="checkbox" name="unfold" id="unfold" <?php if( $flat_pm_unfold == 'true' ) echo 'checked'; ?>>

<div class="flat_pm_wrap row">
	<div class="main col s12 white">
		<div class="row">
			<div class="col s12" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;min-height:52px">
				<a href="<?php echo esc_attr( get_site_url() ); ?>/wp-admin/admin.php?page=fpm_add_blocks" class="left create-new" style="align-items:center">
					<i class="material-icons" style="font-size:28px">control_point_duplicate</i> <b><?php _e( 'CREATE A NEW BLOCK', 'flatpm_l10n' ); ?></b>
				</a>

				<div class="input-field col hide-on-med-and-down" style="margin:0;flex:auto;max-width:700px">
					<input type="text" id="search_code"
						placeholder="<?php esc_attr_e( 'Search a block by code, title or description', 'flatpm_l10n' ); ?>"
						style="border:0;margin-bottom:0!important;text-align:center"
					>
				</div>

				<div class="control-unfold right">
					<?php _e( 'Switch view:', 'flatpm_l10n' ); ?> 
					<label for="unfold" class="btn btn-small btn-floating tooltipped white" data-position="top" data-tooltip="<?php esc_attr_e( 'Compact', 'flatpm_l10n' ); ?>">
						<i class="material-icons">unfold_less</i>
					</label>

					<label for="unfold" class="btn btn-small btn-floating tooltipped white" data-position="top" data-tooltip="<?php esc_attr_e( 'Advanced', 'flatpm_l10n' ); ?>">
						<i class="material-icons">unfold_more</i>
					</label>
				</div>
			</div>
		</div>
		<div class="top-controls row">
			<div class="action input-field col" data-select-count="0">
				<label for="checked-item_all" class="controls controls--checkbox tooltipped" data-position="top" data-tooltip="<?php esc_attr_e( 'Select all', 'flatpm_l10n' ); ?>">
					<input type="checkbox" id="checked-item_all" class="filled-in">
					<span class="empty"></span>
				</label>

				<select>
					<option value="" selected><?php _e( 'Select', 'flatpm_l10n' ); ?></option>
					<?php if( $flat_pm_main['statistics_collect'] === 'true' ){ ?>
						<option value="statistics-on"><?php _e( 'Show statistics', 'flatpm_l10n' ); ?></option>
						<option value="statistics-off"><?php _e( 'Hide statistics', 'flatpm_l10n' ); ?></option>
					<?php } ?>
					<option value="activate"><?php _e( 'Activate', 'flatpm_l10n' ); ?></option>
					<option value="deactivate"><?php _e( 'Deactivate', 'flatpm_l10n' ); ?></option>
					<option value="copy"><?php _e( 'Copy', 'flatpm_l10n' ); ?></option>
					<option value="copy_to_folder"><?php _e( 'Copy to folder', 'flatpm_l10n' ); ?></option>
					<option value="move-to-folder"><?php _e( 'Move to folder', 'flatpm_l10n' ); ?></option>
					<option value="delete"><?php _e( 'Delete', 'flatpm_l10n' ); ?></option>
				</select>
				<label><?php _e( 'Actions:', 'flatpm_l10n' ); ?></label>

				<button class="btn waves-effect waves-light"><?php _e( 'Apply', 'flatpm_l10n' ); ?></button>
			</div>

			<div class="device input-field col">
				<select id="select-device" multiple>
					<option value="" disabled><?php _e( 'Select devices', 'flatpm_l10n' ); ?></option>
					<?php
					foreach( $device as $key => $value ){
						$selected = '';

						if( isset( $fpm_filters['device'] ) && ! empty( $fpm_filters['device'] ) && is_array( $fpm_filters['device'] ) ){
							$selected = ( in_array( $key, $fpm_filters['device'] ) ) ? 'selected' : '';
						}

						echo '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . esc_html( $value ) . '</option>';
					}
					?>
				</select>
				<label for="select-device"><?php _e( 'Sort by device:', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="filter input-field col">
				<select id="select-filter" multiple>
					<option value="" disabled><?php _e( 'Select filters', 'flatpm_l10n' ); ?></option>
					<?php foreach( $filters as $key => $value ){
						if( $key !== 'ab' && $flat_pm_personalization['block'][ $key ] !== 'true' ){
							continue;
						}

						$selected = '';

						if( isset( $fpm_filters['filter'] ) && ! empty( $fpm_filters['filter'] ) && is_array( $fpm_filters['filter'] ) ){
							$selected = ( in_array( $key, $fpm_filters['filter'] ) ) ? 'selected' : '';
						}

						echo '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . esc_html( $value ) . '</option>';
					} ?>
				</select>
				<label for="select-filter"><?php _e( 'Sort by filters:', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="types input-field col">
				<select id="select-types" multiple>
					<option value="" disabled><?php _e( 'Select types', 'flatpm_l10n' ); ?></option>
					<?php foreach( $types as $key => $value ){
						if( $flat_pm_personalization['block'][ $key ] !== 'true' ){
							continue;
						}

						$selected = '';

						if( isset( $fpm_filters['types'] ) && ! empty( $fpm_filters['types'] ) && is_array( $fpm_filters['types'] ) ){
							$selected = ( in_array( $key, $fpm_filters['types'] ) ) ? 'selected' : '';
						}

						echo '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . esc_html( $value ) . '</option>';
					} ?>
				</select>
				<label for="select-types"><?php _e( 'Sort by types:', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="status input-field col">
				<select id="select-status">
					<option value="all"><?php _e( 'All blocks', 'flatpm_l10n' ); ?></option>
					<?php foreach( $status as $key => $value ){
						$selected = '';

						if( isset( $fpm_filters['status'] ) && ! empty( $fpm_filters['status'] ) ){
							$selected = ( $key == $fpm_filters['status'] ) ? 'selected' : '';
						}

						echo '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . esc_html( $value ) . '</option>';
					} ?>
				</select>
				<label for="select-status"><?php _e( 'Sort by status:', 'flatpm_l10n' ); ?></label>
			</div>

			<div class="input-field col">
				<button class="btn btn-floating white z-depth-0 tooltipped waves-effect clear_filters"
					style="width:37.5px;height:37.5px"
					data-position="top"
					data-tooltip="<?php esc_attr_e( 'Clear filters', 'flatpm_l10n' ); ?>"
				>
					<i class="material-icons" style="color:#d87a87!important;height:37.5px">clear</i>
				</button>
			</div>
		</div>

		<div class="list">
			<?php
			$days = 30;
			$labels = htmlspecialchars( json_encode( getLastNDays( $days ) ), ENT_QUOTES, 'UTF-8' );

			$args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'flat_pm_block',
				'order'            => 'ASC',
				'orderby'          => 'meta_value_num',
				'meta_key'         => 'order',
				'no_found_rows'    => true,
				'post_status'      => 'publish',
			);

			$query = new WP_Query( $args );

			if( $query->have_posts() ){
				while( $query->have_posts() ){
					$query->the_post();
					$id = get_the_ID();

					$json_devices = array();
					$json_filters = array();
					$json_types   = array();
					$json_status  = array();
					$json_folder  = array();


					$user = get_post_meta( $id, 'user', true );

					$exclude_keys = array( 'ab' );
					$filters_filtered = array_diff_key( $filters, array_flip( $exclude_keys ) );
					foreach( $filters_filtered as $key => $value ){
						if( $user[ $key ]['enabled'] === 'true' ){
							${ "is_$key" } = true;

							$json_filters []= $key;
						}else{
							${ "is_$key" } = false;
						}
					} unset( $key );


					$view = get_post_meta( $id, 'view', true );

					foreach( $types as $key => $value ){
						if( $view[ $key ]['enabled'] === 'true' ){
							${ "is_$key" } = true;

							$json_types []= $key;
						}else{
							${ "is_$key" } = false;
						}
					} unset( $key );


					$meta_status = array(
						'turned',
					);

					foreach( $meta_status as $key ){
						if( get_post_meta( $id, $key, true ) === 'true' ){
							${ "is_$key" } = true;

							$json_status []= $key;
						}else{
							${ "is_$key" } = false;

							$json_status []= 'not-' . $key;
						}
					} unset( $key );

					$html = get_post_meta( $id, 'html', true );
					$abgroup = get_post_meta( $id, 'abgroup', true );
					$sub_block_count = count( $html['block'] );
					$sub_active_count = count( array_filter( $html['block'], function( $el ){
						return $el['turned'] === 'true';
					} ) );

					$code = '';

					$is_ab = false;

					foreach( $html['block'] as $block ){
						if( $is_ab === false && ( ! empty( $block['abgroup'] ) || ! empty( $abgroup ) ) ){
							$is_ab = true;

							$json_filters []= 'ab';
						}

						if( empty( $block['minwidth'] ) ){
							$block['minwidth'] = 0;
						}

						if( empty( $block['maxwidth'] ) ){
							$block['maxwidth'] = PHP_INT_MAX;
						}

						$minwidth = (int) $block['minwidth'];
						$maxwidth = (int) $block['maxwidth'];

						if( $block['minwidth'] <= 425 ){
							$json_devices['mobile'] = 1;
						}

						if( $block['minwidth'] <= 768 && $block['maxwidth'] >= 426 ){
							$json_devices['tablet'] = 1;
						}

						if( $block['minwidth'] <= 1024 && $block['maxwidth'] >= 769 ){
							$json_devices['laptop'] = 1;
						}

						if( $block['maxwidth'] >= 1025 ){
							$json_devices['desktop'] = 1;
						}

						$code .= $block['html']['code'];
						$code .= $block['adb']['code'];
						$code .= $block['name'];
						$code .= get_the_title();
					}

					$terms = get_the_terms( $id, 'flat_pm_block_folders' );
					if( $terms ){
						$json_folder []= $terms[0]->term_id;
					}else{
						$json_folder []= 999999999;
					}
			?>
			<div class="item row col s12"
				data-devices="<?php echo esc_attr( json_encode( array_keys( $json_devices ) ) ); ?>"
				data-filters="<?php echo esc_attr( json_encode( $json_filters ) ); ?>"
				data-types="<?php echo esc_attr( json_encode( $json_types ) ); ?>"
				data-status="<?php echo esc_attr( json_encode( $json_status ) ); ?>"
				data-folder="<?php echo esc_attr( json_encode( $json_folder ) ); ?>"
				data-block-id="<?php echo esc_attr( $id ); ?>"
				data-code="<?php echo esc_attr( $code ); ?>"
			>
				<input type="checkbox" name="statistics" id="statistics_<?php echo esc_attr( $id ); ?>" class="hidden">
				<input type="checkbox" name="checked-item" id="checked-item_<?php echo esc_attr( $id ); ?>" class="hidden">

				<label for="checked-item_<?php echo esc_attr( $id ); ?>" class="controls controls--checkbox">
					<input type="checkbox" id="checked-item_<?php echo esc_attr( $id ); ?>" class="filled-in">
					<span class="empty"></span>
				</label>

				<div class="list-bg"></div>

				<?php if( $terms ){ ?>
				<span class="folders_name">
					<i class="material-icons">folder</i>
					<span><?php echo esc_html( get_term_meta( $terms[0]->term_id, 'name', true ) ); ?></span>
				</span>
				<?php } ?>

				<a href="<?php echo esc_attr( get_site_url() ); ?>/wp-admin/admin.php?page=fpm_blocks&id=<?php echo esc_attr( $id ); if( $terms ){ echo '&folder=' . esc_attr( $terms[0]->term_id ); } ?>" class="controls controls--title">
					<?php echo get_the_title(); ?>
				</a>

				<?php if( $flat_pm_main['statistics_collect'] === 'true' ){ ?>
				<label for="statistics_<?php echo esc_attr( $id ); ?>" class="controls controls--btn-statistics btn-floating btn-small waves-effect tooltipped" data-position="top" data-tooltip="<?php esc_attr_e( 'Statistics', 'flatpm_l10n' ); ?>">
					<i class="material-icons">timeline</i>
				</label>
				<?php } ?>

				<div class="controls controls--move-block btn-small z-depth-0">
					<i class="material-icons">apps</i>
				</div>

				<div class="layer layer--first">
					<div class="chips">
						<span class="chip"><?php _e( 'Sub-blocks:', 'flatpm_l10n' ); ?> <?php echo esc_html( $sub_active_count ); ?> / <?php echo esc_html( $sub_block_count ); ?></span>

						<?php
						foreach( $json_types as $type ){
							echo '<span class="chip" style="background:#81C06D;color:#fff">' . esc_html( $types[ $type ] ) . '</span>';
						}
						?>

						<?php if( $flat_pm_main['statistics_collect'] === 'true' ){ ?>
							<span class="chip"><?php _e( 'Impressions:', 'flatpm_l10n' ); ?> 234.000</span>
							<span class="chip"><?php _e( 'Clicks:', 'flatpm_l10n' ); ?> 1.000</span>
							<span class="chip"><?php _e( 'CTR:', 'flatpm_l10n' ); ?> 0,43</span>
						<?php } ?>

						<?php
						foreach( $filters as $key => $value ){
							if( ${ "is_$key" } ){
								echo '<span class="chip active">' . esc_html( $value ) . '</span>';
							}
						}
						?>
					</div>

					<code class="tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Shortcode', 'flatpm_l10n' ); ?>"
						<?php if( $flat_pm_main['statistics_collect'] === 'true' ){ echo 'style="min-width:238px"'; } ?>
					>[flat_pm id="<?php echo esc_attr( $id ); ?>"]</code>

					<div class="main-control">
						<input type="number" min="1" class="tooltipped abgroup" data-position="top" data-tooltip="<?php esc_attr_e( 'Group for A/B', 'flatpm_l10n' ); ?>" onkeyup="this.setAttribute( 'value', this.value );" value="<?php echo esc_attr( $abgroup ); ?>">

						<input type="checkbox" name="turned" id="turned_<?php echo esc_attr( $id ); ?>" <?php if( $is_turned ) echo 'checked'; ?>>
						<label class="btn tooltipped turn_on"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Enabled', 'flatpm_l10n' ); ?>"
							for="turned_<?php echo esc_attr( $id ); ?>"
						>
							<i class="material-icons" style="color:#81C06D!important">turned_in</i>
						</label>
						<label class="btn tooltipped turn_off"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Disabled', 'flatpm_l10n' ); ?>"
							for="turned_<?php echo esc_attr( $id ); ?>"
						>
							<i class="material-icons" style="color:#d87a87!important">turned_in_not</i>
						</label>

						<button class="btn waves-effect tooltipped copy" data-position="top" data-tooltip="<?php esc_attr_e( 'Copy', 'flatpm_l10n' ); ?>">
							<i class="material-icons">content_copy</i>
						</button>

						<button class="btn waves-effect tooltipped modal-trigger"
							data-block-id="<?php echo esc_attr( $id ); ?>"
							data-target="confirm-delete-block"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Delete block', 'flatpm_l10n' ); ?>"
						>
							<i class="material-icons" style="color:#d87a87!important">delete_forever</i>
						</button>
					</div>
				</div>
				<div class="layer layer--second">
					<?php
					$values = [
						[
							'label' => 'Label #1',
							'values' => getRandIntArray( $days ),
						],
					];
					?>
					<canvas
						data-values="<?php echo esc_attr( json_encode( $values ), ENT_QUOTES, 'UTF-8' ); ?>"
						data-labels="<?php echo esc_attr( $labels ); ?>"
					></canvas>
				</div>
			</div>
			<?php
				}
			} wp_reset_postdata();
			?>
		</div>

		<div class="col s12">
			<div class="empty-list row hidden">
				<img width="250" height="146" src="<?php echo esc_attr( FLATPM_URL ); ?>assets/admin/img/empty_state.svg">
			</div>
		</div>
	</div>

	<div class="sidebar sidebar--left">
		<?php require FLATPM_FOLDERS_LIST; ?>
	</div>

	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>

	<div id="confirm-delete-block" class="modal" style="width:600px">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Confirm deleting the block', 'flatpm_l10n' ); ?></h4>

			<button class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
			<button class="modal-close waves-effect btn-flat confirm-delete-block"><?php _e( 'I confirm', 'flatpm_l10n' ); ?></button>
		</div>
	</div>
</div>