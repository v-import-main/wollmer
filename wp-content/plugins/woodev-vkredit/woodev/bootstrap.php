<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Plugin_Bootstrap' ) ) :

class Woodev_Plugin_Bootstrap {
	
	protected static $instance = null;
	
	protected $registered_plugins = array();
	
	protected $active_plugins = array();
	
	protected $incompatible_framework_plugins = array();

	protected $incompatible_wc_version_plugins = array();
	
	protected $incompatible_wp_version_plugins = array();
	
	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load_plugins' ) );
		add_action( 'admin_init', array( $this, 'maybe_deactivate_framework_plugins' ) );
	}
	
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	
	public function register_plugin( $version, $plugin_name, $path, $callback, $args = array() ) {
		$this->registered_plugins[] = array( 'version' => $version, 'plugin_name' => $plugin_name, 'path' => $path, 'callback' => $callback, 'args' => $args );
	}
	
	public function load_plugins() {

		usort( $this->registered_plugins, array( $this, 'compare' ) );

		$loaded_framework = null;

		foreach ( $this->registered_plugins as $plugin ) {
			
			if( ! class_exists( 'Woodev_Plugin' ) ) {
				require_once( $this->get_plugin_path( $plugin['path'] ) . '/woodev/class-plugin.php' );
				$loaded_framework = $plugin;
				$this->active_plugins[] = $plugin;
			}
			
			if ( ! empty( $loaded_framework['args']['backwards_compatible'] ) && version_compare( $loaded_framework['args']['backwards_compatible'], $plugin['version'], '>' ) ) {

				$this->incompatible_framework_plugins[] = $plugin;
				continue;
			}
			
			if ( ! empty( $plugin['args']['minimum_wc_version'] ) && version_compare( $this->get_wc_version(), $plugin['args']['minimum_wc_version'], '<' ) ) {

				$this->incompatible_wc_version_plugins[] = $plugin;
				continue;
			}
			
			if ( ! empty( $plugin['args']['minimum_wp_version'] ) && version_compare( get_bloginfo( 'version' ), $plugin['args']['minimum_wp_version'], '<' ) ) {

				$this->incompatible_wp_version_plugins[] = $plugin;
				continue;
			}
			
			if( ! in_array( $plugin, $this->active_plugins ) ) {
				$this->active_plugins[] = $plugin;
			}
			
			if ( isset( $plugin['args']['is_payment_gateway'] ) && ! class_exists( 'Woodev_Payment_Gateway' ) ) {
				require_once( $this->get_plugin_path( $plugin['path'] ) . '/woodev/payment-gateway/class-payment-gateway-plugin.php' );
			}
			
			if ( isset( $plugin['args']['load_shipping_method'] ) && ! class_exists( 'Woodev_Abstract_Shipping_Method' ) ) {
				require_once( $this->get_plugin_path( $plugin['path'] ) . '/woodev/shipping-method/class-shipping-method.php' );
			}
			
			$plugin['callback']();
		}
		
		if ( ( $this->incompatible_framework_plugins || $this->incompatible_wc_version_plugins || $this->incompatible_wp_version_plugins ) && is_admin() && ! defined( 'DOING_AJAX' ) && ! has_action( 'admin_notices', array( $this, 'render_update_notices' ) ) ) {

			add_action( 'admin_notices', array( $this, 'render_update_notices' ) );
		}
		
		do_action( 'woodev_plugins_loaded' );
	}
	
	public function maybe_deactivate_framework_plugins() {

		if ( isset( $_GET['woodev_framework_deactivate_newer'] ) ) {
			if ( 'yes' == $_GET['woodev_framework_deactivate_newer'] ) {
				
				if ( count( $this->incompatible_framework_plugins ) == 0 ) {
					return;
				}

				$plugins = array();

				foreach ( $this->active_plugins as $plugin ) {
					$plugins[] = plugin_basename( $plugin['path'] );
				}
				
				deactivate_plugins( $plugins );
				
				wp_redirect( admin_url( 'plugins.php?plugin_status=inactive&woodev_framework_deactivate_newer=' . count( $plugins ) ) );
				exit;
			} else {
				add_action( 'admin_notices', array( $this, 'render_deactivation_notice' ) );
			}
		}
	}
	
	public function render_deactivation_notice() {
		$count = $_GET['woodev_framework_deactivate_newer'];
		$text = $count > 1 ? sprintf( 'Деактивировано %d плагина', $count ) : 'Плагин деактивирован';
		printf( '<div class="updated"><p>%s</p></div>', $text );
	}
	
	public function render_update_notices() {
		
		if ( ! empty( $this->incompatible_framework_plugins ) ) {

			$plugin_count = count( $this->incompatible_framework_plugins );

			echo '<div class="error">';
				
				echo '<p>';
					echo esc_html( _n( 'Следующий плагин отключен, потому что он устарел и несовместим с новыми плагинами на вашем сайте:', 'Следующие плагины отключены, потому что они устарели и несовместимы с новыми плагинами на вашем сайте:', $plugin_count ) );
				echo '</p>';
				
				echo '<ul>';
					foreach ( $this->incompatible_framework_plugins as $plugin ) {
						printf( '<li>%s</li>', esc_html( $plugin['plugin_name'] ) );
					}
				echo '</ul>';
				
				echo '<p>';
					printf(
						esc_html( _n( 'Что бы решить эту проблему, пожалуйста %1$sобновите%2$s (рекомендуется) %3$sили%4$s %5$sдеактивируйте%6$s вышеуказанный плагин, или %7$sдеактивируйте эти%8$s:', 'Что бы решить эту проблему, пожалуйста %1$sобновите%2$s (рекомендуется) %3$sили%4$s %5$sдеактивируйте%6$s вышеуказанные плагины, или %7$sдеактивируйте эти%8$s:', $plugin_count ) ),
						'<a href="' . esc_url( admin_url( 'update-core.php' ) ) . '">', '</a>',
						'<em>', '</em>',
						'<a href="' . esc_url( admin_url( 'update-core.php' ) ) . '">', '</a>',
						'<a href="' . esc_url( admin_url( 'plugins.php?woodev_framework_deactivate_newer=yes' ) ) . '">', '</a>'
					);
				echo '</p>';
				echo '<ul>';
					foreach ( $this->active_plugins as $plugin ) {
						printf( '<li>%s</li>', esc_html( $plugin['plugin_name'] ) );
					}
				echo '</ul>';

			echo '</div>';
		}
		
		if ( ! empty( $this->incompatible_wc_version_plugins ) ) {

			printf( '<div class="error"><p>%s</p><ul>', count( $this->incompatible_wc_version_plugins ) > 1 ? 'Следующие плагины неактивны, потому что им требуется более новая версия WooCommerce:' : 'Следующий плагин неактивен, потому что для него требуется более новая версия WooCommerce:' );

			foreach ( $this->incompatible_wc_version_plugins as $plugin ) {
				echo '<li>' . sprintf( 'Для плагина %1$s требуется WooCommerce версии %2$s или выше', esc_html( $plugin['plugin_name'] ), esc_html( $plugin['args']['minimum_wc_version'] ) ) . '</li>';
			}
			
			echo '</ul><p>' . sprintf( 'Пожалуйста %1$sобновите WooCommerce%2$s', '<a href="' . esc_url( admin_url( 'update-core.php' ) ) . '">', '&nbsp;&raquo;</a>' ) . '</p></div>';
		}
		
		if ( ! empty( $this->incompatible_wp_version_plugins ) ) {

			printf( '<div class="error"><p>%s</p><ul>', count( $this->incompatible_wp_version_plugins ) > 1 ? 'Следующие плагины неактивны, поскольку для них требуется более новая версия WordPress:' : 'Следующий плагин неактивен, потому что для него требуется более новая версия WordPress:' );

			foreach ( $this->incompatible_wp_version_plugins as $plugin ) {
				printf( '<li>Для плагина %s требуется WordPress версии %s или выше</li>', esc_html( $plugin['plugin_name'] ), esc_html( $plugin['args']['minimum_wp_version'] ) );
			}

			echo '</ul><p>Пожалуйста <a href="' . esc_url( admin_url( 'update-core.php' ) ) . '">обновите WordPress&nbsp;&raquo;</a></p></div>';
		}
	}
	
	public static function is_woocommerce_active() {

		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}

		return in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins );
	}
	
	public function compare( $a, $b ) {
		return version_compare( $b['version'], $a['version'] );
	}
	
	public function get_plugin_path( $file ) {
		return untrailingslashit( plugin_dir_path( $file ) );
	}
	
	protected function get_wc_version() {

		if ( defined( 'WC_VERSION' )          && WC_VERSION )          return WC_VERSION;
		if ( defined( 'WOOCOMMERCE_VERSION' ) && WOOCOMMERCE_VERSION ) return WOOCOMMERCE_VERSION;

		return null;
	}
}

endif;
?>