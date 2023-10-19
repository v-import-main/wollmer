<?php

defined( 'ABSPATH' ) or exit;

if( ! class_exists( 'Woodev_Plugin_Setup_Wizard' ) ) :

abstract class Woodev_Plugin_Setup_Wizard {


	const ACTION_FINISH = 'finish';

	protected $required_capability = 'manage_options';
	
	protected $current_step = '';
	
	protected $steps = array();
	
	private $id;
	
	private $plugin;
	
	public function __construct( Woodev_Plugin $plugin ) {

		if ( ! is_admin() || ! current_user_can( $this->required_capability ) || ! Woodev_Helper::is_woocommerce_active() ) {
			return;
		}

		$this->id     = $plugin->get_id();
		$this->plugin = $plugin;

		$this->register_steps();

		$this->steps = apply_filters( "woodev_{$this->id}_setup_wizard_steps", $this->steps, $this );

		if ( $this->has_steps() ) {

			if ( $this->is_setup_page() ) {
				$this->init_setup();
			} else {

				$this->add_hooks();
				if ( Woodev_Helper::get_request( "woodev_{$this->id}_setup_wizard_complete" ) ) {
					$this->complete_setup();
				}
			}
		}
	}
	
	abstract protected function register_steps();
	
	protected function add_hooks() {
		
		add_action( 'admin_notices', array( $this, 'add_admin_notices' ) );
		
		if ( ! $this->is_complete() ) {
			add_filter( 'plugin_action_links_' . plugin_basename( $this->get_plugin()->get_plugin_file() ), array( $this, 'add_setup_link' ), 20 );
		}
	}
	
	public function add_admin_notices() {

		$current_screen = get_current_screen();

		if ( ( $current_screen && 'plugins' === $current_screen->id ) || $this->get_plugin()->is_plugin_settings() ) {

			if ( $this->is_complete() && $this->get_documentation_notice_message() ) {
				$notice_id = "woodev_{$this->id}_docs";
				$message   = $this->get_documentation_notice_message();
			} else {
				$notice_id = "woodev_{$this->id}_setup";
				$message   = $this->get_setup_notice_message();
			}

			$this->get_plugin()->get_admin_notice_handler()->add_admin_notice( $message, $notice_id, array(
				'always_show_on_settings' => false,
			) );
		}
	}
	
	protected function get_documentation_notice_message() {

		if ( $this->get_plugin()->get_documentation_url() ) {
			$message = sprintf(
				'Спасибо за установку плагина %1$s! Для начала работы, пожалуйста, уделите немного времени на %2$sизучение документации%3$s.',
				esc_html( $this->get_plugin()->get_plugin_name() ),
				'<a href="' . esc_url( $this->get_plugin()->get_documentation_url() )  . '" target="_blank">', '</a>'
			);

		} else {

			$message = '';
		}

		return $message;
	}
	
	protected function get_setup_notice_message() {

		return sprintf(
			'Спасибо за установку плагина %1$s! Для начала работы, пожалуйста, уделите немного времени и воспользуйтесь %2$sбыстрой и лёгкой пошаговой установкой плагина%3$s.',
			esc_html( $this->get_plugin()->get_plugin_name() ),
			'<a href="' . esc_url( $this->get_setup_url() )  . '">', '</a>'
		);
	}
	
	public function add_setup_link( $action_links ) {
		unset( $action_links['configure'] );

		$setup_link = array(
			'setup' => sprintf( '<a href="%s">%s</a>', $this->get_setup_url(), 'Настроить плагин' ),
		);

		return array_merge( $setup_link, $action_links );
	}
	
	protected function init_setup() {

		$current_step   = sanitize_key( Woodev_Helper::get_request( 'step' ) );
		$current_action = sanitize_key( Woodev_Helper::get_request( 'action' ) );

		if ( ! $current_action ) {

			if ( $this->has_step( $current_step ) ) {
				$this->current_step = $current_step;
			} elseif ( $first_step_url = $this->get_step_url( key( $this->steps ) ) ) {
				wp_safe_redirect( $first_step_url );
				exit;
			} else {
				wp_safe_redirect( $this->get_dashboard_url() );
				exit;
			}
		}
		
		add_action( 'admin_menu', array( $this, 'add_page' ) );
		add_action( 'admin_init', array( $this, 'render_page' ) );
	}
	
	public function add_page() {
		add_dashboard_page( '', '', $this->required_capability, $this->get_slug(), '' );
	}
	
	public function render_page() {

		$error_message = Woodev_Helper::get_post( 'save_step' ) ? $this->save_step( $this->current_step ) : '';

		$page_title = sprintf(
			'Настройка плагина &rsaquo; %s',
			$this->get_plugin()->get_plugin_name()
		);

		if ( ! empty( $this->steps[ $this->current_step ]['name'] ) ) {
			$page_title .= " &rsaquo; {$this->steps[ $this->current_step ]['name']}";
		}

		$this->load_scripts_styles();

		ob_start();

		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
			<head>
				<meta name="viewport" content="width=device-width" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title><?php echo esc_html( $page_title ); ?></title>
				<?php wp_print_scripts( 'wc-setup' ); ?>
				<?php do_action( 'admin_print_scripts' ); ?>
				<?php do_action( 'admin_print_styles' ); ?>
				<?php do_action( 'admin_head' ); ?>
			</head>
			<body class="wc-setup wp-core-ui <?php echo esc_attr( $this->get_slug() ); ?>">
				<?php $this->render_header(); ?>
				<?php $this->render_steps(); ?>
				<?php $this->render_content( $error_message ); ?>
				<?php $this->render_footer(); ?>
			</body>
		</html>
		<?php

		exit;
	}
	
	protected function save_step( $step_id ) {

		$error_message = 'Ой, произошла какая то ошибка. Попробуйте ещё разок...';

		try {

			if ( ! wp_verify_nonce( Woodev_Helper::get_post( 'nonce' ), "woodev_{$this->id}_setup_wizard_save" ) ) {
				throw new Woodev_Plugin_Exception( $error_message );
			}

			if ( $this->has_step( $step_id ) ) {

				if ( is_callable( $this->steps[ $step_id ]['save'] ) ) {
					call_user_func( $this->steps[ $step_id ]['save'], $this );
				}
				
				wp_safe_redirect( $this->get_next_step_url( $step_id ) );
				exit;
			}

		} catch ( Woodev_Plugin_Exception $exception ) {

			return $exception->getMessage() ? $exception->getMessage() : $error_message;
		}
	}
	
	protected function load_scripts_styles() {
		
		if( ! function_exists( 'WC' ) ) {
			return;
		}
		
		wp_register_script( 'jquery-blockui', WC()->plugin_url() . '/assets/js/jquery-blockui/jquery.blockUI.min.js', array( 'jquery' ), '2.70', true );
		
		wp_register_script( 'selectWoo', WC()->plugin_url() . '/assets/js/selectWoo/selectWoo.full.min.js', array( 'jquery' ), '1.0.0' );
		wp_register_script( 'wc-enhanced-select', WC()->plugin_url() . '/assets/js/admin/wc-enhanced-select.min.js', array( 'jquery', 'selectWoo' ), $this->get_plugin()->get_version() );
		wp_localize_script(
			'wc-enhanced-select',
			'wc_enhanced_select_params',
			array(
				'i18n_no_matches'           => 'Совпадений не найдено',
				'i18n_ajax_error'           => 'Ошибка загрузки',
				'i18n_input_too_short_1'    => 'Введите 1 или более символов',
				'i18n_input_too_short_n'    => 'Введите %qty% или более символов',
				'i18n_input_too_long_1'     => 'Удалите 1 символ',
				'i18n_input_too_long_n'     => 'Удалите %qty% символа(-ов)',
				'i18n_selection_too_long_1' => 'Вы можете выбрать только 1 элемент',
				'i18n_selection_too_long_n' => 'Вы можете выбрать только %qty% элемента(-ов)',
				'i18n_load_more'            => 'Загрузить ещё результаты&hellip;',
				'i18n_searching'            => 'Поиск&hellip;',
				'ajax_url'                  => admin_url( 'admin-ajax.php' ),
				'search_products_nonce'     => wp_create_nonce( 'search-products' ),
				'search_customers_nonce'    => wp_create_nonce( 'search-customers' ),
				'country_iso'				=> WC()->countries->get_base_country()
			)
		);
		
		wp_enqueue_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), $this->get_plugin()->get_version() );
		wp_enqueue_style( 'wc-setup', WC()->plugin_url() . '/assets/css/wc-setup.css', array( 'dashicons', 'install' ), $this->get_plugin()->get_version() );

		wp_enqueue_style( 'woodev-admin-setup', $this->get_plugin()->get_framework_assets_url() . '/css/admin/woodev-plugin-admin-setup-wizard.min.css', array( 'wc-setup' ), $this->get_plugin()->get_version() );
		wp_enqueue_script( 'woodev-admin-setup', $this->get_plugin()->get_framework_assets_url() . '/js/admin/woodev-plugin-admin-setup-wizard.min.js', array( 'jquery', 'wc-enhanced-select', 'jquery-blockui' ), $this->get_plugin()->get_version() );
	}
	
	protected function render_header() {

		$title     = $this->get_plugin()->get_plugin_name();
		$link_url  = $this->get_plugin()->get_sales_page_url();
		$image_url = $this->get_header_image_url();

		$header_content = $image_url ? '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $title ) . '" />' : $title;

		?>
		<h1 id="wc-logo" class="woodev-plugin-logo <?php echo esc_attr( 'woodev-' . $this->get_plugin()->get_id_dasherized() . '-logo' ); ?>">
			<?php if ( $link_url ) : ?>
				<a href="<?php echo esc_url( $link_url ); ?>" target="_blank"><?php echo $header_content; ?></a>
			<?php else : ?>
				<?php echo esc_html( $header_content ); ?>
			<?php endif; ?>
		</h1>
		<?php
	}
	
	protected function get_header_image_url() {
		return '';
	}
	
	protected function render_steps() {

		?>
		<ol class="wc-setup-steps">

			<?php foreach ( $this->steps as $id => $step ) : ?>

				<?php if ( $id === $this->current_step ) : ?>
					<li class="active"><?php echo esc_html( $step['name'] ); ?></li>
				<?php elseif ( $this->is_step_complete( $id ) ) : ?>
					<li class="done"><a href="<?php echo esc_url( $this->get_step_url( $id ) ); ?>"><?php echo esc_html( $step['name'] ); ?></a></li>
				<?php else : ?>
					<li><?php echo esc_html( $step['name'] ); ?></li>
				<?php endif;?>

			<?php endforeach; ?>

			<li class="<?php echo $this->is_finished() ? 'done' : ''; ?>">Готово!</li>

		</ol>
		<?php
	}
	
	protected function render_content( $error_message = '' ) {

		?>
		<div class="wc-setup-content woodev-plugin-admin-setup-content <?php echo esc_attr( $this->get_slug() ) . '-content'; ?>">

			<?php if ( $this->is_finished() ) : ?>

				<?php $this->render_finished(); ?>

				<?php $this->complete_setup(); ?>

			<?php else : ?>

				<?php if ( $this->is_started() ) : ?>
					<?php $this->render_welcome(); ?>
				<?php endif; ?>

				<?php if ( ! empty( $error_message ) ) : ?>
					<?php $this->render_error( $error_message ); ?>
				<?php endif; ?>

				<form method="post">
					<?php $this->render_step( $this->current_step ); ?>
					<?php wp_nonce_field( "woodev_{$this->id}_setup_wizard_save", 'nonce' ); ?>
				</form>

			<?php endif; ?>

		</div>
		<?php
	}
	
	protected function render_error( $message ) {

		if ( ! empty( $message ) ) {

			printf( '<p class="error">%s</p>', esc_html( $message ) );
		}
	}
	
	protected function render_welcome() {

		?>
		<h1><?php $this->render_welcome_heading()?></h1>
		<p class="welcome"><?php $this->render_welcome_text(); ?></p>
		<?php
	}
	
	protected function render_welcome_heading() {

		printf(
			'Добро пожаловать в настройку %s!',
			$this->get_plugin()->get_plugin_name()
		);
	}
	
	protected function render_welcome_text() {
		echo 'Это поможет вам быстро настроить основные опции плагина для того что бы вы могли начать использовать этот плагин.';
	}
	
	protected function render_finished() {

		?>
		<h1><?php printf( 'Плагин %s готов!', esc_html( $this->get_plugin()->get_plugin_name() ) ); ?></h1>
		<?php $this->render_before_next_steps(); ?>
		<?php $this->render_next_steps(); ?>
		<?php $this->render_after_next_steps(); ?>
		<?php
	}
	
	protected function render_before_next_steps() {}
	
	protected function render_after_next_steps() {}
	
	protected function render_next_steps() {

		$next_steps         = $this->get_next_steps();
		$additional_actions = $this->get_additional_actions();

		if ( ! empty( $next_steps ) || ! empty( $additional_actions ) ) :

			?>
			<ul class="wc-wizard-next-steps">

				<?php foreach ( $next_steps as $step ) : ?>

					<li class="wc-wizard-next-step-item">
						<div class="wc-wizard-next-step-description">

							<p class="next-step-heading">Следующий шаг</p>
							<h3 class="next-step-description"><?php echo esc_html( $step['label'] ); ?></h3>

							<?php if ( ! empty( $step['description'] ) ) : ?>
								<p class="next-step-extra-info"><?php echo esc_html( $step['description'] ); ?></p>
							<?php endif; ?>

						</div>

						<div class="wc-wizard-next-step-action">
							<p class="wc-setup-actions step">
								<?php $button_class = isset( $step['button_class'] ) ? $step['button_class'] : 'button button-primary button-large'; ?>
								<?php $button_class = is_string( $button_class ) || is_array( $button_class ) ? array_map( 'sanitize_html_class', explode( ' ', implode( ' ', (array) $button_class ) ) ) : ''; ?>
								<a class="<?php echo implode( ' ', $button_class ); ?>" href="<?php echo esc_url( $step['url'] ); ?>">
									<?php echo esc_html( $step['name'] ); ?>
								</a>
							</p>
						</div>
					</li>

				<?php endforeach; ?>

				<?php if ( ! empty( $additional_actions ) ) : ?>

					<li class="wc-wizard-additional-steps">
						<div class="wc-wizard-next-step-description">
							<p class="next-step-heading">Вы так же можете:</p>
						</div>
						<div class="wc-wizard-next-step-action">

							<p class="wc-setup-actions step">

								<?php foreach ( $additional_actions as $name => $url ) : ?>

									<a class="button button-large" href="<?php echo esc_url( $url ); ?>">
										<?php echo esc_html( $name ); ?>
									</a>

								<?php endforeach; ?>

							</p>
						</div>
					</li>

				<?php endif; ?>

			</ul>
			<?php

		endif;
	}
	
	protected function get_next_steps() {

		$steps = array();

		if ( $this->get_plugin()->get_documentation_url() ) {

			$steps['view-docs'] = array(
				'name'        => 'Посмотереть документацию',
				'label'       => 'Посмотереть больше настроек',
				'description' => 'Узнайте больше о настройке плагина',
				'url'         => $this->get_plugin()->get_documentation_url(),
			);
		}

		return $steps;
	}
	
	protected function get_additional_actions() {

		$next_steps = $this->get_next_steps();
		$actions    = array();

		if ( $this->get_plugin()->get_settings_url() ) {
			$actions[ 'Настроить плагин' ] = $this->get_plugin()->get_settings_url();
		}

		if ( empty( $next_steps['view-docs'] ) && $this->get_plugin()->get_documentation_url() ) {
			$actions[ 'Посмотереть документацию' ] = $this->get_plugin()->get_documentation_url();
		}

		if ( $this->get_plugin()->get_reviews_url() ) {
			$actions[ 'Оставить отзыв' ] = $this->get_plugin()->get_reviews_url();
		}

		return $actions;
	}
	
	protected function render_step( $step_id ) {

		call_user_func( $this->steps[ $step_id ]['view'], $this );

		?>
		<p class="wc-setup-actions step">

			<?php $label = 'Продолжить'; ?>

			<?php if ( is_callable( $this->steps[ $step_id ]['save'] ) ) : ?>

				<button
					type="submit"
					name="save_step"
					class="button-primary button button-large button-next"
					value="<?php echo esc_attr( $label ); ?>">
					<?php echo esc_html( $label ); ?>
				</button>

			<?php else : ?>

				<a class="button-primary button button-large button-next" href="<?php echo esc_url( $this->get_next_step_url( $step_id ) ); ?>"><?php echo esc_html( $label ); ?></a>

			<?php endif; ?>
		</p>
		<?php
	}
	
	protected function render_form_field( $key, $args, $value = null ) {

		if ( ! isset( $args['class'] ) ) {
			$args['class'] = array();
		} else {
			$args['class'] = (array) $args['class'];
		}
		
		$args['class'][] = 'woodev-plugin-admin-setup-control';
		
		if ( ! empty( $args['required'] ) ) {
			$args['custom_attributes']['required'] = true;
		}
		
		if ( isset( $args['type'] ) && 'select' === $args['type'] ) {
			$args['input_class'][] = 'wc-enhanced-select';
		}
		
		$args['return'] = false;

		if ( isset( $args['type'] ) && 'toggle' === $args['type'] ) {
			$this->render_toggle_form_field( $key, $args, $value );
		} elseif( function_exists( 'woocommerce_form_field' ) ) {
			woocommerce_form_field( $key, $args, $value );
		}
	}
	
	public function render_toggle_form_field( $key, $args, $value ) {

		$args = wp_parse_args( $args, array(
			'type'              => 'text',
			'label'             => '',
			'description'       => '',
			'required'          => false,
			'id'                => $key,
			'class'             => array(),
			'label_class'       => array(),
			'input_class'       => array(),
			'custom_attributes' => array(),
			'default'           => false,
			'allow_html'        => false,
		) );

		$args['class'][] = 'toggle';

		if ( $args['required'] ) {
			$args['class'][] = 'validate-required';
		}

		if ( null === $value ) {
			$value = $args['default'];
		}

		$custom_attributes         = array();
		$args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );

		if ( $args['description'] ) {
			$args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
		}

		if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
			foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}

		$enabled = $value || $args['default'];

		if ( $enabled ) {
			$args['class'][] = 'enabled';
		}

		?>
		<div class="form-row <?php echo esc_attr( implode( ' ', $args['class'] ) ); ?>">

			<p class="name"><?php echo true === $args['allow_html'] ? $args['label'] : esc_html( $args['label'] ); ?></p>

			<?php if ( true === $args['allow_html'] ) : ?>
				<div class="content"><p class="description"><?php echo $args['description']; ?></p></div>
			<?php else : ?>
				<p class="content description"><?php echo esc_html( $args['description'] ); ?></p>
			<?php endif; ?>

			<div class="enable">
				<span class="toggle <?php echo $enabled ? '' : 'disabled'; ?>">
					<input
						id="<?php echo esc_attr( $args['id'] ); ?>"
						type="checkbox"
						class="input-checkbox <?php echo esc_attr( implode( ' ', $args['input_class'] ) ); ?>"
						name="<?php echo esc_attr( $key ); ?>"
						value="yes" <?php checked( true, $value ); ?>
						<?php echo implode( ' ', $custom_attributes ); ?>
					/>
					<label for="<?php echo esc_attr( $args['id'] ); ?>" class="<?php implode(  ' ', (array) $args['label_class'] ); ?>">
				</span>
			</div>

		</div>
		<?php
	}
	
	protected function render_footer() {

		?>
		<?php if ( $this->is_finished() ) : ?>
			<a class="wc-setup-footer-links" href="<?php echo esc_url( $this->get_dashboard_url() ); ?>">Вернутся в админку</a>
		<?php elseif ( $this->is_started() ) : ?>
			<a class="wc-setup-footer-links" href="<?php echo esc_url( $this->get_dashboard_url() ); ?>">Не сейчас</a>
		<?php else : ?>
			<a class="wc-setup-footer-links" href="<?php echo esc_url( $this->get_next_step_url() ); ?>">Пропустить этот шаг</a>
		<?php endif; ?>
		<?php

		do_action( 'wp_print_footer_scripts' );
	}
	
	public function register_step( $id, $name, $view_callback, $save_callback = null ) {

	    try {

			if ( ! is_string( $id ) || empty( $id ) || $this->has_step( $id ) ) {
				throw new Woodev_Plugin_Exception( 'Invalid step ID' );
			}
			
			if ( ! is_string( $name ) || empty( $name ) ) {
				throw new Woodev_Plugin_Exception( 'Invalid step name' );
			}
			
			if ( ! is_callable( $view_callback ) ) {
				throw new Woodev_Plugin_Exception( 'Invalid view callback' );
			}
			
			if ( null !== $save_callback && ! is_callable( $save_callback ) ) {
				throw new Woodev_Plugin_Exception( 'Invalid save callback' );
			}

			$this->steps[ $id ] = array(
				'name' => $name,
				'view' => $view_callback,
				'save' => $save_callback,
			);

			return true;

		} catch ( Woodev_Plugin_Exception $exception ) {
			Woodev_Helper::trigger_error( $exception->getMessage(), E_USER_WARNING );
			return false;
		}
	}
	
	public function complete_setup() {
		return update_option( "woodev_{$this->id}_setup_wizard_complete", 'yes' );
	}
	
	public function is_setup_page() {
		return is_admin() && $this->get_slug() === Woodev_Helper::get_request( 'page' );
	}
	
	public function is_current_step( $step_id ) {
		return $this->current_step === $step_id;
	}
	
	public function is_started() {

		$steps = array_keys( $this->steps );
		return $this->current_step && $this->current_step === reset( $steps );
	}
	
	public function is_finished() {
		return self::ACTION_FINISH === Woodev_Helper::get_request( 'action' );
	}
	
	public function is_complete() {
		return 'yes' === get_option( "woodev_{$this->id}_setup_wizard_complete", 'no' );
	}
	
	public function is_step_complete( $step_id ) {
		return array_search( $this->current_step, array_keys( $this->steps ), true ) > array_search( $step_id, array_keys( $this->steps ), true ) || $this->is_finished();
	}
	
	public function has_steps() {
		return is_array( $this->steps ) && ! empty( $this->steps );
	}
	
	public function has_step( $step_id ) {
		return ! empty( $this->steps[ $step_id ] );
	}
	
	public function get_step_title( $step_id = '' ) {

		$step_title = '';

		if ( ! $step_id ) {
			$step_id = $this->current_step;
		}

		if ( isset( $this->steps[ $step_id ]['name'] ) ) {
			$step_title = $this->steps[ $step_id ]['name'];
		}

		return $step_title;
	}
	
	public function get_setup_url() {

		return add_query_arg( 'page', $this->get_slug(), admin_url( 'index.php' ) );
	}
	
	public function get_next_step_url( $step_id = '' ) {

		if ( ! $step_id ) {
			$step_id = $this->current_step;
		}

		$steps = array_keys( $this->steps );
		
		if ( end( $steps ) === $step_id ) {

			$url = $this->get_finish_url();

		} else {
			
			$step_index = array_search( $step_id, $steps, true );
			$step = false !== $step_index ? $steps[ $step_index + 1 ] : reset( $steps );
			$url = add_query_arg( 'step', $step );
		
		}

		return $url;
	}
	
	public function get_step_url( $step_id ) {

		$url = false;

		if ( $this->has_step( $step_id ) ) {
			$url = add_query_arg( 'step', $step_id, remove_query_arg( 'action' ) );
		}

		return $url;
	}
	
	protected function get_finish_url() {

		return add_query_arg( 'action', self::ACTION_FINISH, remove_query_arg( 'step' ) );
	}
	
	protected function get_dashboard_url() {

		$settings_url  = $this->get_plugin()->get_settings_url();
		$dashboard_url = ! empty( $settings_url ) ? $settings_url : admin_url();

		return add_query_arg( "woodev_{$this->id}_setup_wizard_complete", true, $dashboard_url );
	}


	/**
	 * Gets the setup setup handler's slug.
	 *
	 * @since 5.2.2
	 *
	 * @return string
	 */
	protected function get_slug() {
		return 'woodev-' . $this->get_plugin()->get_id_dasherized() . '-setup';
	}
	
	protected function get_plugin() {
		return $this->plugin;
	}
}

endif;
