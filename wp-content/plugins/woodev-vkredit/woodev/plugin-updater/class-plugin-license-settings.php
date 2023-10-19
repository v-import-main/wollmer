<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_License_Settings' ) ) :

class Woodev_License_Settings {

	protected $plugin_url;
	
	public function __construct( $plugin_url ) {

		$this->plugin_url = $plugin_url;
		
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_head', array( $this, 'menu_remove_item' ) );
	}
	
	public function admin_menu() {
		
		add_menu_page( 'Woodev', 'Woodev', 'manage_options', 'woodev', null, null, '65' );
		
		//add_submenu_page( 'woodev', 'Настройки', 'Настройки', 'manage_options', 'woodev-settings', array( $this, 'settings_page' ) );
		add_submenu_page( 'woodev', 'Лицензии', 'Лицензии', 'manage_options', 'woodev-licenses', array( $this, 'license_page' ) );
		add_submenu_page( 'woodev', 'Каталог плагинов Woodev', 'Плагины', 'manage_options', 'woodev-plugins', array( $this, 'plugins_page' ) );
	}
	
	public function license_page() {

		$license_sections = $this->get_license_settings();
		
		$output  = '<div class="start woodev-helper container">';
		$output .= '<form method="post" id="mainform" action="options.php" enctype="multipart/form-data">';
		$output .= '<div class="wrap wrap-licenses">';
		$output .= '<table class="form-table">';

		if ( empty( $license_sections ) ) {

			$message  = 'Нет активных плагинов Woodev, требующих лицензионных ключей';
			$message .= '<a href="https://woodev.ru/shop" style="margin-left:10px;" class="button button-primary">Посмотреть плагины &rarr;</a>';

			$output .= '<div class="notice-info notice inline"><p>' . wp_kses_post( $message ) . '</p></div>';

		} else {

			$output .= '<h2>Лицензионные ключи Woodev</h2>';
			$output .= '<p>Для автоматического обновления введите лицензионные ключи от ваших плагинов на этой странице.</p>';

			ob_start();

			settings_fields( 'woodev_plugin_license_settings' );

			do_settings_sections( 'woodev_plugin_license_settings_section' );

			submit_button();

			$output .= ob_get_clean();

		}
		
		$output .= '</table></div></form></div>';

		echo $output;
		
	}
	
	public function plugins_page() {
		
		if( ! class_exists( 'Woodev_Admin_Plugins' ) ) {
			include_once( 'class-admin-plugins.php' );
		}
		
		Woodev_Admin_Plugins::output();
	}
	
	public function register_settings() {

		$settings = $this->get_license_settings();

		add_settings_section(
			'woodev_plugin_license_settings_section',
			__return_null(),
			'__return_false',
			'woodev_plugin_license_settings_section'
		);

		foreach ( $settings as $setting ) {

			$setting = wp_parse_args( $setting, array(
				'section'       => 'woodev-licenses',
				'id'            => null,
				'desc'          => '',
				'name'          => '',
				'size'          => null,
				'options'       => '',
				'std'           => '',
				'min'           => null,
				'max'           => null,
				'step'          => null,
				'chosen'        => null,
				'multiple'      => null,
				'placeholder'   => null,
				'allow_blank'   => true,
				'readonly'      => false,
				'faux'          => false,
				'tooltip_title' => false,
				'tooltip_desc'  => false,
				'field_class'   => '',
			) );

			add_settings_field(
				$setting['id'],
				$setting['name'],
				array( $this, 'license_key_callback' ),
				'woodev_plugin_license_settings_section',
				'woodev_plugin_license_settings_section',
				$setting
			);

			register_setting( 'woodev_plugin_license_settings', $setting['id'], array( $this, 'woodev_settings_sanitize' ) );
		}
	}
	
	public function license_key_callback( $args ) {

		$woodev_option = get_option( $args['id'] );
		$messages  = array();
		$license   = get_option( $args['options']['is_valid_license_option'] );

		if ( $woodev_option ) {
			$value = $woodev_option;
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		if( ! empty( $license ) && is_object( $license ) ) {
			
			if ( false === $license->success ) {

				switch( $license->error ) {

					case 'expired' :
						$class      = 'expired';
						$messages[] = sprintf(
							'Срок действия вашего лицензионного ключа истёк %1$s. Пожалуйста %2$sпродлите ваш лицензионный ключ%3$s.',
							date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) ),
							'<a href="https://woodev.ru/checkout/?edd_license_key=' . $value . '&utm_campaign=admin&utm_source=licenses&utm_medium=expired" target="_blank">',
							'</a>'
						);
						$license_status = 'license-' . $class . '-notice';
					break;

					case 'revoked' :
						$class      = 'error';
						$messages[] = sprintf(
							'Ваш лицензионный ключ был отключён. Пожалуйста %1$sсвяжитесь с администарцией сайта%2$s woodev.ru для получения дополнительной информации.',
							'<a href="https://woodev.ru/support?utm_campaign=admin&utm_source=licenses&utm_medium=revoked" target="_blank">',
							'</a>'
						);
						$license_status = 'license-' . $class . '-notice';
					break;

					case 'missing' :
						$class      = 'error';
						$messages[] = sprintf(
							'Недействительный лицензионный ключ. Пожалуйста %1$sвойдите на страницу вашего аккаунта%2$s, что бы проверить лицензию.',
							'<a href="https://woodev.ru/checkout/purchase-history/?utm_campaign=admin&utm_source=licenses&utm_medium=missing" target="_blank">',
							'</a>'
						);
						$license_status = 'license-' . $class . '-notice';
					break;

					case 'invalid' :
					case 'site_inactive' :
						$class = 'error';
						$messages[] = sprintf(
							'%1$s не активирован для этого сайта. Пожалуйста %2$sввойдите на страницу вашего аккаунта%3$s для управления лицензии.',
							$args['name'],
							'<a href="https://woodev.ru/checkout/purchase-history/?utm_campaign=admin&utm_source=licenses&utm_medium=invalid" target="_blank">',
							'</a>'
						);
						$license_status = 'license-' . $class . '-notice';
					break;

					case 'no_activations_left':
						$class = 'error';
						$messages[] = sprintf( 'Ваш лицензионный ключ достиг предела активации. Вы можете %1$sапгрейдить лицензию на большее количества активаций%2$s.', '<a href="https://woodev.ru/checkout/purchase-history/?utm_campaign=admin&utm_source=licenses&utm_medium=no_activations_left">', '</a>' );
						$license_status = 'license-' . $class . '-notice';
					break;

					case 'license_not_activable':
						$class = 'error';
						$messages[] = 'Данный лицензионный ключ не активируемый, введите лицензионный ключ именно для данного плагина.';
						$license_status = 'license-' . $class . '-notice';
					break;
					
					case 'item_name_mismatch' :
						$class      = 'error';
						$messages[] = sprintf( 'Неверный лицензионный ключ для %s. Название принадлежащего к этой лицензии плагина не совпадает.', $args['name'] );
						$license_status = 'license-' . $class . '-notice';
					break;

					default :
						$class = 'error';
						$error = ! empty(  $license->error ) ?  $license->error : 'неизвестная ошибка';
						$messages[] = sprintf( 'Произошла ошибка с этим лицензионным ключом: %1$s. Пожалуйста %2$sсвяжитесь с нами%3$s для уточнения причины ошибки.', $error, '<a href="https://woodev.ru/support">', '</a>'  );
						$license_status = 'license-' . $class . '-notice';
					break;
				}

			} else {

				switch( $license->license ) {

					case 'valid' :
					default:
						$class = 'valid';
						$now        = current_time( 'timestamp' );
						$expiration = strtotime( $license->expires, current_time( 'timestamp' ) );

						if ( 'lifetime' === $license->expires ) {

							$messages[] = 'Пожизненая лицензия.';
							$license_status = 'license-lifetime-notice';

						} elseif( $expiration > $now && $expiration - $now < ( DAY_IN_SECONDS * 30 ) ) {

							$messages[] = sprintf(
								'Срок действия вашего лицензионного ключа скоро истекает. Это произойдёт %1$s! Пожалуйста %2$sобновите ваш лицензионный ключ%3$s сейчас, иначе вы не сможете получать автоматическое обновление и тех поддержку связанную с работоспособностью плагина.',
								date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) ),
								'<a href="https://woodev.ru/checkout/?edd_license_key=' . $value . '&utm_campaign=admin&utm_source=licenses&utm_medium=renew" target="_blank">',
								'</a>'
							);
							$license_status = 'license-expires-soon-notice';

						} else {

							$messages[] = sprintf(
								'Срок действия вашего лицензионного ключа истекает %s.',
								date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) )
							);
							$license_status = 'license-expiration-date-notice';
						}
					break;
				}
			}

		} else {

			$class = 'empty';
			$messages[] = sprintf( 'Что бы получать обновления, введите ваш действующий лицензионный ключ для %s.', $args['name'] );
			$license_status = null;
		}

		$class .= ' ' . sanitize_html_class( $args['field_class'] );

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="text" class="' . sanitize_html_class( $size ) . '-text" id="' . sanitize_text_field( $args['id'] ) . '" name="' . sanitize_text_field( $args['id'] ) . '" value="' . esc_attr( $value ) . '"/>';

		if ( ( is_object( $license ) && 'valid' == $license->license ) || 'valid' == $license ) {
			$html .= '<input type="submit" class="button-secondary" name="' . $args['id'] . '_deactivate" value="Деактивировать"/>';
		}

		$html .= '<label for="' . sanitize_text_field( $args['id'] ) . '"> '  . wp_kses_post( $args['desc'] ) . '</label>';

		if ( ! empty( $messages ) ) {
			foreach( $messages as $message ) {
				$html .= '<div class="woodev-licenses-data woodev-licenses-' . $class . ' ' . $license_status . '">';
				$html .= '<p>' . $message . '</p></div>';
			}
		}

		wp_nonce_field( sanitize_text_field( $args['id'] ) . '-nonce', sanitize_text_field( $args['id'] ) . '-nonce' );
		echo $html;
	}
	
	public function menu_remove_item() {
		global $submenu;

		if ( isset( $submenu['woodev'] ) ) {
			unset( $submenu['woodev'][0] );
		}
	}
	
	function woodev_settings_sanitize( $input = '' ) {

		$setting_types = array(
			'text',
		);

		foreach ( $setting_types as $type ) {

			switch( $type ) {

				case 'text':
					$input = sanitize_text_field( $input );
				break;
			}
		}

		add_settings_error( 'woodev-licenses-settings', '', 'Настройки обновлены', 'updated' );

		return $input;
	}
	
	public function get_license_settings() {
		return apply_filters( 'woodev_plugin_license_settings', array() );
	}
	
	public function get_license_settings_url() {
		return admin_url( 'admin.php?page=woodev-licenses' );
	}
}

endif;
