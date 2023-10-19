<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Admin_Notice_Handler' ) ) :

class Woodev_Admin_Notice_Handler {

	private $plugin;
	
	private $admin_notices = array();
	
	static private $admin_notice_placeholder_rendered = false;
	
	static private $admin_notice_js_rendered = false;
	
	public function __construct( $plugin ) {

		$this->plugin      = $plugin;
		
		add_action( 'admin_notices', array( $this, 'render_admin_notices'         ), 15 );
		add_action( 'admin_footer',  array( $this, 'render_delayed_admin_notices' ), 15 );
		add_action( 'admin_footer',  array( $this, 'render_admin_notice_js'       ), 20 );
		
		add_action( 'wp_ajax_woodev_plugin_' . $this->get_plugin()->get_id() . '_dismiss_notice', array( $this, 'handle_dismiss_notice' ) );
	}
	
	public function add_admin_notice( $message, $message_id, $params = array() ) {

		$params = wp_parse_args( $params, array(
			'dismissible'             => true,
			'always_show_on_settings' => true,
			'notice_class'            => 'updated',
		) );

		if ( $this->should_display_notice( $message_id, $params ) ) {
			$this->admin_notices[ $message_id ] = array(
				'message'  => $message,
				'rendered' => false,
				'params'   => $params,
			);
		}
	}
	
	public function should_display_notice( $message_id, $params = array() ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}

		$params = wp_parse_args( $params, array(
			'dismissible'             => true,
			'always_show_on_settings' => true,
		) );
		
		if ( $params['always_show_on_settings'] && $this->get_plugin()->is_plugin_settings() ) {
			return true;
		}
		
		if ( ! $params['dismissible'] ) {
			return true;
		}
		
		return ! $this->is_notice_dismissed( $message_id );
	}
	
	public function render_admin_notices( $is_visible = true ) {
	
		if ( ! is_bool( $is_visible ) ) {
			$is_visible = true;
		}

		foreach ( $this->admin_notices as $message_id => $message_data ) {
			if ( ! $message_data['rendered'] ) {
				$message_data['params']['is_visible'] = $is_visible;
				$this->render_admin_notice( $message_data['message'], $message_id, $message_data['params'] );
				$this->admin_notices[ $message_id ]['rendered'] = true;
			}
		}

		if ( $is_visible && ! self::$admin_notice_placeholder_rendered ) {
			echo '<div class="js-woodev-plugin-admin-notice-placeholder"></div>';
			self::$admin_notice_placeholder_rendered = true;
		}

	}
	
	public function render_delayed_admin_notices() {
		$this->render_admin_notices( false );
	}
	
	public function render_admin_notice( $message, $message_id, $params = array() ) {

		$params = wp_parse_args( $params, array(
			'dismissible'             => true,
			'is_visible'              => true,
			'always_show_on_settings' => true,
			'notice_class'            => 'updated',
		) );

		$classes = array(
			'js-woodev-plugin-admin-notice',
			$params['notice_class'],
		);
		
		$dismissible = $params['dismissible'] && ( ! $params['always_show_on_settings'] || ! $this->get_plugin()->is_plugin_settings() );

		if ( version_compare( get_bloginfo( 'version' ), '4.2', '>=' ) ) {

			$classes[] = 'notice';

			if ( $dismissible ) {
				$classes[] = 'is-dismissible';
			}

		} else {

			if ( $dismissible ) {
				$dismiss_link = '<a href="#" class="js-woodev-plugin-notice-dismiss" style="float: right;">Скрыть</a>';
				$message .= ' ' . $dismiss_link;
			}
		}

		echo sprintf(
			'<div class="%1$s" data-plugin-id="%2$s" data-message-id="%3$s" %4$s><p>%5$s</p></div>',
			esc_attr( implode( ' ', $classes ) ),
			esc_attr( $this->get_plugin()->get_id() ),
			esc_attr( $message_id ),
			( ! $params['is_visible'] ) ? 'style="display:none;"' : '',
			wp_kses_post( $message )
		);
	}
	
	public function render_admin_notice_js() {
	
		if ( empty( $this->admin_notices ) || self::$admin_notice_js_rendered ) {
			return;
		}

		self::$admin_notice_js_rendered = true;

		ob_start();
		?>
		$( '.js-woodev-plugin-admin-notice' ).on( 'click.wp-dismiss-notice', '.notice-dismiss', function( e ) {

			var $notice = $( this ).closest( '.js-woodev-plugin-admin-notice' );

			log_dismissed_notice(
				$( $notice ).data( 'plugin-id' ),
				$( $notice ).data( 'message-id' )
			);

		} );
		
		$( 'a.js-woodev-plugin-notice-dismiss' ).click( function( e ) {

			e.preventDefault();

			var $notice = $( this ).closest( '.js-woodev-plugin-admin-notice' );

			log_dismissed_notice(
				$( $notice ).data( 'plugin-id' ),
				$( $notice ).data( 'message-id' )
			);

			$( $notice ).fadeOut();

		} );

		function log_dismissed_notice( pluginID, messageID ) {

			$.get(
				ajaxurl,
				{
					action:    'woodev_plugin_' + pluginID + '_dismiss_notice',
					messageid: messageID
				}
			);
		}

		// move any delayed notices up into position .show();
		$( '.js-woodev-plugin-admin-notice:hidden' ).insertAfter( '.js-woodev-plugin-admin-notice-placeholder' ).show();
		<?php
		$javascript = ob_get_clean();

		Woodev_Helper::enqueue_js( $javascript );
	}
	
	public function dismiss_notice( $message_id, $user_id = null ) {

		if ( is_null( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		$dismissed_notices = $this->get_dismissed_notices( $user_id );

		$dismissed_notices[ $message_id ] = true;

		update_user_meta( $user_id, '_woodev_plugin_' . $this->get_plugin()->get_id() . '_dismissed_messages', $dismissed_notices );
		
		do_action( 'woodev_' . $this->get_plugin()->get_id(). '_dismiss_notice', $message_id, $user_id );
	}
	
	public function undismiss_notice( $message_id, $user_id = null ) {

		if ( is_null( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		$dismissed_notices = $this->get_dismissed_notices( $user_id );

		$dismissed_notices[ $message_id ] = false;

		update_user_meta( $user_id, '_woodev_plugin_' . $this->get_plugin()->get_id() . '_dismissed_messages', $dismissed_notices );
	}
	
	public function is_notice_dismissed( $message_id, $user_id = null ) {

		$dismissed_notices = $this->get_dismissed_notices( $user_id );

		return isset( $dismissed_notices[ $message_id ] ) && $dismissed_notices[ $message_id ];
	}
	
	public function get_dismissed_notices( $user_id = null ) {

		if ( is_null( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		$dismissed_notices = get_user_meta( $user_id, '_woodev_plugin_' . $this->get_plugin()->get_id() . '_dismissed_messages', true );

		if ( empty( $dismissed_notices ) ) {
			return array();
		} else {
			return $dismissed_notices;
		}
	}
	
	public function handle_dismiss_notice() {
		$this->dismiss_notice( $_REQUEST['messageid'] );
	}
	
	protected function get_plugin() {
		return $this->plugin;
	}

}

endif;
