<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Background_Job_Handler' ) ) :

abstract class Woodev_Background_Job_Handler extends Woodev_Async_Request {
	
	protected $prefix = 'woodev';
	
	protected $action = 'background_job';
	
	protected $data_key = 'data';
	
	protected $start_time = 0;
	
	protected $cron_hook_identifier;
	
	protected $cron_interval_identifier;
	
	protected $debug_message;
	
	public function __construct() {

		parent::__construct();

		$this->cron_hook_identifier     = $this->identifier . '_cron';
		$this->cron_interval_identifier = $this->identifier . '_cron_interval';

		$this->add_hooks();
	}
	
	protected function add_hooks() {
	
		add_action( $this->cron_hook_identifier, array( $this, 'handle_cron_healthcheck' ) );
		add_filter( 'cron_schedules', array( $this, 'schedule_cron_healthcheck' ) );
		
		add_action( "wp_ajax_nopriv_{$this->identifier}_test", array( $this, 'handle_connection_test_response' ) );
		add_filter( 'woocommerce_debug_tools', array( $this, 'add_debug_tool' ) );
		add_filter( 'gettext', array( $this, 'translate_success_message' ), 10, 3 );
	}
	
	public function dispatch() {
		
		$this->schedule_event();
		
		return parent::dispatch();
	}
	
	public function maybe_handle() {

		if ( $this->is_process_running() ) {
			wp_die();
		}

		if ( $this->is_queue_empty() ) {
			wp_die();
		}
		
		remove_filter( 'nonce_user_logged_out', array( WC()->session, 'nonce_user_logged_out' ) );

		check_ajax_referer( $this->identifier, 'nonce' );
		
		add_filter( 'nonce_user_logged_out', array( WC()->session, 'nonce_user_logged_out' ) );

		$this->handle();

		wp_die();
	}
	
	protected function is_queue_empty() {
		global $wpdb;

		$key 		= $this->identifier . '_job_%';
		$queued     = '%"status":"queued"%';
		$processing = '%"status":"processing"%';

		$count = $wpdb->get_var( $wpdb->prepare( "
			SELECT COUNT(*)
			FROM {$wpdb->options}
			WHERE option_name LIKE %s
			AND ( option_value LIKE %s OR option_value LIKE %s )
		", $key, $queued, $processing ) );

		return ( $count > 0 ) ? false : true;
	}
	
	protected function is_process_running() {
		usleep( rand( 100000, 300000 ) );

		return (bool) get_transient( "{$this->identifier}_process_lock" );
	}
	
	protected function lock_process() {
		
		$this->start_time = time();
		
		$lock_duration = ( property_exists( $this, 'queue_lock_time' ) ) ? $this->queue_lock_time : 60;
		
		$lock_duration = apply_filters( "{$this->identifier}_queue_lock_time", $lock_duration );

		set_transient( "{$this->identifier}_process_lock", microtime(), $lock_duration );
	}
	
	protected function unlock_process() {

		delete_transient( "{$this->identifier}_process_lock" );

		return $this;
	}
	
	protected function memory_exceeded() {

		$memory_limit   = $this->get_memory_limit() * 0.9;
		$current_memory = memory_get_usage( true );
		$return         = false;

		if ( $current_memory >= $memory_limit ) {
			$return = true;
		}
		
		return apply_filters( "{$this->identifier}_memory_exceeded", $return );
	}
	
	protected function get_memory_limit() {

		if ( function_exists( 'ini_get' ) ) {
			$memory_limit = ini_get( 'memory_limit' );
		} else {
			$memory_limit = '128M';
		}

		if ( ! $memory_limit || -1 === (int) $memory_limit ) {
			$memory_limit = '32G';
		}

		return Woodev_Plugin_Compatibility::convert_hr_to_bytes( $memory_limit );
	}
	
	protected function time_exceeded() {
		
		$finish = $this->start_time + apply_filters( "{$this->identifier}_default_time_limit", 20 );
		$return = false;

		if ( time() >= $finish ) {
			$return = true;
		}
		
		return apply_filters( "{$this->identifier}_time_exceeded", $return );
	}
	
	public function create_job( $attrs ) {
		global $wpdb;

		if ( empty( $attrs ) ) {
			return null;
		}
		
		$job_id = md5( microtime() . mt_rand() );
		
		$attrs = apply_filters( "{$this->identifier}_new_job_attrs", $attrs, $job_id );
		
		$attrs = wp_parse_args( array(
			'id'         => $job_id,
			'created_at' => current_time( 'mysql' ),
			'created_by' => get_current_user_id(),
			'status'     => 'queued',
		), $attrs );

		$wpdb->insert( $wpdb->options, array(
			'option_name'  => "{$this->identifier}_job_{$job_id}",
			'option_value' => json_encode( $attrs ),
			'autoload'     => 'no'
		) );

		$job = new \stdClass();

		foreach ( $attrs as $key => $value ) {
			$job->{$key} = $value;
		}
		
		do_action( "{$this->identifier}_job_created", $job );

		return $job;
	}
	
	public function get_job( $id = null ) {
		global $wpdb;

		if ( ! $id ) {

			$key        = $this->identifier . '_job_%';
			$queued     = '%"status":"queued"%';
			$processing = '%"status":"processing"%';

			$results = $wpdb->get_var( $wpdb->prepare( "
				SELECT option_value
				FROM {$wpdb->options}
				WHERE option_name LIKE %s
				AND ( option_value LIKE %s OR option_value LIKE %s )
				ORDER BY option_id ASC
				LIMIT 1
			", $key, $queued, $processing ) );

		} else {

			$results = $wpdb->get_var( $wpdb->prepare( "
				SELECT option_value
				FROM {$wpdb->options}
				WHERE option_name = %s
			", "{$this->identifier}_job_{$id}" ) );

		}

		if ( ! empty( $results ) ) {

			$job = new \stdClass();

			foreach ( json_decode( $results, true ) as $key => $value ) {
				$job->{$key} = $value;
			}

		} else {
			return null;
		}
		
		return apply_filters( "{$this->identifier}_returned_job", $job );
	}
	
	public function get_jobs( $args = array() ) {
		global $wpdb;

		$args = wp_parse_args( $args, array(
			'order'   => 'DESC',
			'orderby' => 'option_id',
		) );

		$replacements = array( $this->identifier . '_job_%' );
		$status_query = '';
		
		if ( ! empty( $args['status'] ) ) {

			$statuses     = (array) $args['status'];
			$placeholders = array();

			foreach ( $statuses as $status ) {

				$placeholders[] = '%s';
				$replacements[] = '%"status":"' . sanitize_key( $status ) . '"%';
			}

			$status_query = 'AND ( option_value LIKE ' . implode( ' OR option_value LIKE ', $placeholders ) . ' )';
		}
		
		$order   = sanitize_key( $args['order'] );
		$orderby = sanitize_key( $args['orderby'] );
		
		$query = $wpdb->prepare( "
			SELECT option_value
			FROM {$wpdb->options}
			WHERE option_name LIKE %s
			{$status_query}
			ORDER BY {$orderby} {$order}
		", $replacements );

		$results = $wpdb->get_col( $query );

		if ( empty( $results ) ) {
			return null;
		}

		$jobs = array();

		foreach ( $results as $result ) {

			$job = new \stdClass();

			foreach ( json_decode( $result, true ) as $key => $value ) {
				$job->{$key} = $value;
			}
			
			$job = apply_filters( "{$this->identifier}_returned_job", $job );

			$jobs[] = $job;
		}

		return $jobs;
	}
	
	protected function handle() {

		$this->lock_process();

		do {
			
			$job = $this->get_job();
			
			register_shutdown_function( array( $this, 'handle_shutdown' ), $job );
			
			$this->process_job( $job );

		} while ( ! $this->time_exceeded() && ! $this->memory_exceeded() && ! $this->is_queue_empty() );

		$this->unlock_process();
		
		if ( ! $this->is_queue_empty() ) {
			$this->dispatch();
		} else {
			$this->complete();
		}

		wp_die();
	}
	
	public function process_job( $job, $items_per_batch = null ) {

		if ( ! $this->start_time ) {
			$this->start_time = time();
		}
		
		if ( 'processing' !== $job->status ) {

			$job->status                = 'processing';
			$job->started_processing_at = current_time( 'mysql' );

			$job = $this->update_job( $job );
		}

		$data_key = $this->data_key;

		if ( ! isset( $job->{$data_key} ) ) {
			throw new Exception( sprintf( 'Ключ для задания "%s" не установлен.', $data_key ) );
		}

		if ( ! is_array( $job->{$data_key} ) ) {
			throw new Exception( sprintf( 'Ключ для задания "%s" не является массивом.', $data_key ) );
		}

		$data = $job->{$data_key};

		$job->total = count( $data );
		
		if ( ! isset( $job->progress ) ) {
			$job->progress = 0;
		}
		
		if ( $job->progress && ! empty( $data ) ) {
			$data = array_slice( $data, $job->progress, null, true );
		}
		
		if ( ! empty( $data ) ) {

			$processed       = 0;
			$items_per_batch = (int) $items_per_batch;

			foreach ( $data as $item ) {
			
				$this->process_item( $item, $job );

				$processed++;
				$job->progress++;
				
				$job = $this->update_job( $job );
				
				if ( ( $items_per_batch && $processed >= $items_per_batch ) || $this->time_exceeded() || $this->memory_exceeded() ) {
					break;
				}
			}
		}
		
		if ( $job->progress >= count( $job->{$data_key} ) ) {
			$job = $this->complete_job( $job );
		}

		return $job;
	}
	
	public function update_job( $job ) {

		if ( is_string( $job ) ) {
			$job = $this->get_job( $job );
		}

		if ( ! $job ) {
			return false;
		}

		$job->updated_at = current_time( 'mysql' );

		$this->update_job_option( $job );
		
		do_action( "{$this->identifier}_job_updated", $job );

		return $job;
	}
	
	public function complete_job( $job ) {

		if ( is_string( $job ) ) {
			$job = $this->get_job( $job );
		}

		if ( ! $job ) {
			return false;
		}

		$job->status       = 'completed';
		$job->completed_at = current_time( 'mysql' );

		$this->update_job_option( $job );
		
		do_action( "{$this->identifier}_job_complete", $job );

		return $job;
	}
	
	public function fail_job( $job, $reason = '' ) {

		if ( is_string( $job ) ) {
			$job = $this->get_job( $job );
		}

		if ( ! $job ) {
			return false;
		}

		$job->status    = 'failed';
		$job->failed_at = current_time( 'mysql' );

		if ( $reason ) {
			$job->failure_reason = $reason;
		}

		$this->update_job_option( $job );
		
		do_action( "{$this->identifier}_job_failed", $job );

		return $job;
	}
	
	public function delete_job( $job ) {
		global $wpdb;

		if ( is_string( $job ) ) {
			$job = $this->get_job( $job );
		}

		if ( ! $job ) {
			return false;
		}

		$wpdb->delete( $wpdb->options, array( 'option_name' => "{$this->identifier}_job_{$job->id}" ) );
		
		do_action( "{$this->identifier}_job_deleted", $job );
	}
	
	protected function complete() {
		$this->clear_scheduled_event();
	}
	
	public function schedule_cron_healthcheck( $schedules ) {

		$interval = property_exists( $this, 'cron_interval' ) ? $this->cron_interval : 5;
		
		$interval = apply_filters( "{$this->identifier}_cron_interval", $interval );
		
		$schedules[ $this->identifier . '_cron_interval' ] = array(
			'interval' => MINUTE_IN_SECONDS * $interval,
			'display'  => sprintf( 'Каждые %d минуты(у)', $interval ),
		);

		return $schedules;
	}
	
	public function handle_cron_healthcheck() {

		if ( $this->is_process_running() ) {
			exit;
		}

		if ( $this->is_queue_empty() ) {
			$this->clear_scheduled_event();
			exit;
		}

		$this->dispatch();
	}
	
	protected function schedule_event() {

		if ( ! wp_next_scheduled( $this->cron_hook_identifier ) ) {
			wp_schedule_event( time() + 30, $this->cron_interval_identifier, $this->cron_hook_identifier );
		}
	}
	
	protected function clear_scheduled_event() {

		$timestamp = wp_next_scheduled( $this->cron_hook_identifier );

		if ( $timestamp ) {
			wp_unschedule_event( $timestamp, $this->cron_hook_identifier );
		}
	}
	
	abstract protected function process_item( $item, $job );
	
	public function handle_shutdown( $job ) {

		$error = error_get_last();
		
		if ( $error && E_ERROR === $error['type'] ) {

			$this->fail_job( $job, $error['message'] );

			$this->unlock_process();
		}
	}
	
	private function update_job_option( $job ) {
		global $wpdb;

		return $wpdb->update(
			$wpdb->options,
			array( 'option_value' => json_encode( $job ) ),
			array( 'option_name'  => "{$this->identifier}_job_{$job->id}" )
		);
	}
	
	public function test_connection() {

		$test_url = add_query_arg( 'action', "{$this->identifier}_test", admin_url( 'admin-ajax.php' ) );
		$result   = wp_safe_remote_get( $test_url );
		$body     = ! is_wp_error( $result ) ? wp_remote_retrieve_body( $result ) : null;
		
		return $body && Woodev_Helper::str_exists( $body, '[TEST_LOOPBACK]' );
	}
	
	public function handle_connection_test_response() {

		echo '[TEST_LOOPBACK]';
		exit;
	}
	
	public function add_debug_tool( $tools ) {
		
		$tools['woodev_background_job_test'] = array(
			'name'     => 'Тест фоновой обработки',
			'button'   => 'Запустить тест',
			'desc'     => 'Этот инструмент проверит, способен ли ваш сервер обрабатывать фоновые задания',
			'callback' => array( $this, 'run_debug_tool' ),
		);

		return $tools;
	}
	
	public function run_debug_tool() {

		if ( $this->test_connection() ) {
			$this->debug_message = 'Ура! Ваш сервер умеет обрабатывать фоновые задания.';
			$result = true;
		} else {
			$this->debug_message = 'Не удалось подключиться. Пожалуйста, уточните у вашего хостинг провайдера, что на вашем серевере включены loopback соединения.';
			$result = false;
		}

		return $result;
	}
	
	public function translate_success_message( $translated, $original, $domain ) {

		if ( 'woocommerce' === $domain && ( 'Tool ran.' === $original || 'There was an error calling %s' === $original ) ) {
			$translated = $this->debug_message;
		}

		return $translated;
	}
	
	public function get_identifier() {

		return $this->identifier;
	}

}

endif;
