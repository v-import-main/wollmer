<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Job_Batch_Handler' ) ) :

class Woodev_Job_Batch_Handler {
	
	protected $job_handler;
	
	protected $plugin;
	
	protected $items_per_batch = 20;
	
	public function __construct( $job_handler, Woodev_Plugin $plugin ) {

		if ( ! is_admin() ) {
			return;
		}

		$this->job_handler = $job_handler;
		$this->plugin      = $plugin;

		$this->add_hooks();

		$this->render_js();
	}
	
	protected function add_hooks() {

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'wp_ajax_' . $this->get_job_handler()->get_identifier() . '_process_batch', array( $this, 'ajax_process_batch' ) );
		add_action( 'wp_ajax_' . $this->get_job_handler()->get_identifier() . '_cancel_job', array( $this, 'ajax_cancel_job' ) );
	}
	
	public function enqueue_scripts() {

		wp_enqueue_script( $this->get_job_handler()->get_identifier() . '_batch_handler',  $this->get_plugin()->get_framework_assets_url() . '/js/admin/woodev-admin-job-batch-handler.js', array( 'jquery' ), $this->get_plugin()->get_version() );
	}
	
	protected function render_js() {
		
		$args = apply_filters( $this->get_job_handler()->get_identifier() . '_batch_handler_js_args', $this->get_js_args(), $this );

		wc_enqueue_js( sprintf( 'window.%1$s_batch_handler = new %2$s( %3$s );',
			esc_js( $this->get_job_handler()->get_identifier() ),
			esc_js( $this->get_js_class() ),
			json_encode( $args )
		) );
	}
	
	protected function get_js_args() {

		return array(
			'id'            => $this->get_job_handler()->get_identifier(),
			'process_nonce' => wp_create_nonce( $this->get_job_handler()->get_identifier() . '_process_batch' ),
			'cancel_nonce'  => wp_create_nonce( $this->get_job_handler()->get_identifier() . '_cancel_job' ),
		);
	}
	
	protected function get_js_class() {
		return 'Woodev_Job_Batch_Handler';
	}
	
	public function ajax_process_batch() {

		check_ajax_referer( $this->get_job_handler()->get_identifier() . '_process_batch', 'security' );

		if ( empty( $_POST['job_id'] ) ) {
			return;
		}

		try {

			$job = $this->process_batch( $_POST['job_id'] );

			$job = $this->process_job_status( $job );

			wp_send_json_success( (array) $job );

		} catch( Woodev_Plugin_Exception $e ) {

			$data = ( ! empty( $job ) ) ? (array) $job : array();

			$data['message'] = $e->getMessage();

			wp_send_json_error( $data );
		}
	}
	
	public function ajax_cancel_job() {

		check_ajax_referer( $this->get_job_handler()->get_identifier() . '_cancel_job', 'security' );

		if ( empty( $_POST['job_id'] ) ) {
			return;
		}

		$this->get_job_handler()->delete_job( $_POST['job_id'] );

		wp_send_json_success();
	}
	
	protected function process_job_status( $job ) {

		$job->percentage = Woodev_Helper::number_format( (int) $job->progress / (int) $job->total * 100 );

		return $job;
	}
	
	public function process_batch( $job_id ) {

		$job = $this->get_job_handler()->get_job( $job_id );

		if ( ! $job ) {
			throw new Woodev_Plugin_Exception( 'Неверный ID задания' );
		}

		return $this->get_job_handler()->process_job( $job, $this->get_items_per_batch() );
	}
	
	protected function get_items_per_batch() {
	
		$items_per_batch = absint( apply_filters( $this->get_job_handler()->get_identifier() . '_batch_handler_items_per_batch', $this->items_per_batch ) );

		return $items_per_batch > 0 ? $items_per_batch : 1;
	}
	
	protected function get_job_handler() {

		return $this->job_handler;
	}
	protected function get_plugin() {

		return $this->plugin;
	}

}

endif;
