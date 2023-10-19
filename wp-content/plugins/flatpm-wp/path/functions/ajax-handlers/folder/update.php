<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_folder_update' ) ){
	function flat_pm_folder_update( $method, $meta ){
		$origin = ( isset( $meta['origin'] ) && !empty( $meta['origin'] ) ) ? $meta['origin'] : 'ajax';
		$folder_id = ( isset( $meta['id'] ) && !empty( $meta['id'] ) ) ? $meta['id'] : false;
		$order = ( isset( $meta['order'] ) && !empty( $meta['order'] ) ) ? $meta['order'] : false;
		$html = '';

		if( $folder_id ){
			if( ! flat_do_some() ){
				die( json_encode( array(
					'method' => $method,
					'data' => array(
						'message' => '<i class="material-icons">report_problem</i> ' . __( 'You don\'t have PRO version', 'flatpm_l10n' ),
						'status' => 'error'
					)
				) ) );
			}

			$args = array(
				'name' => $meta['name'],
			);

			$folder_id = wp_update_term( (int) $folder_id, 'flat_pm_block_folders', $args );

			$action = 'update';
		}else{
			$folder_id = wp_insert_term( $meta['name'], 'flat_pm_block_folders' );

			$action = 'insert';

			$html = '
			<div class="folder " data-folder-id="' . $folder_id['term_id'] . '" data-href="' . get_site_url() . '/wp-admin/admin.php?page=fpm_blocks&amp;folder=' . $folder_id['term_id'] . '">
				<button type="button" class="icon">
					<i class="material-icons">folder</i>
					<span class="name">' . $meta['name'] . '</span>
				</button>
				<div class="folder-controls">
					<button class="btn btn-floating rename waves-effect tooltipped white rename-folder modal-trigger" data-target="confirm-rename-folder" data-position="top" data-tooltip="' . __( 'Rename', 'flatpm_l10n' ) . '">
						<i class="material-icons">edit</i>
					</button>
					<a href="' . get_site_url() . '/wp-admin/admin.php?page=fpm_blocks&amp;folder=' . $folder_id['term_id'] . '&amp;edit=1" class="btn btn-floating settings waves-effect tooltipped white" data-position="top" data-tooltip="' . __( 'Settings', 'flatpm_l10n' ) . '">
						<i class="material-icons">settings</i>
					</a>
					<button class="btn btn-floating delete waves-effect tooltipped white delete-folder modal-trigger" data-target="confirm-delete-folder" data-position="top" data-tooltip="' . __( 'Delete', 'flatpm_l10n' ) . '">
						<i class="material-icons">delete_forever</i>
					</button>
				</div>
			</div>';
		}

		if( is_wp_error( $folder_id ) ){
			if( $origin === 'ajax' ){
				die( json_encode( array(
					'method' => $method,
					'data' => array(
						'message' => '<i class="material-icons">report_problem</i> ' . __( 'Something went wrong...', 'flatpm_l10n' ),
						'status' => 'error'
					)
				) ) );
			}

			return false;
		}

		$dafault_folder_setting = include FLATPM_DEFAULTS . '/folder.php';

		$allow_options = array(
			'turned',
			'name',
			'content',
			'user'
		);

		foreach( $allow_options as $key ){
			if( ! isset( $meta[$key] ) ){
				$meta[$key] = $dafault_folder_setting[$key];
			}

			update_term_meta( $folder_id['term_id'], $key, $meta[$key] );
		}

		flat_pm_clear_all_cache();

		if( $origin === 'ajax' ){
			die( json_encode( array(
				'method' => $method,
				'data' => array(
					'message' => '<i class="material-icons">check</i> ' . __( 'Settings updated', 'flatpm_l10n' ),
					'status' => 'success',
					'action' => $action,
					'id' => $folder_id['term_id'],
					'name' => $meta['name'],
					'turned' => $meta['turned'],
					'html' => $html
				)
			) ) );
		}

		return true;
	}
}