<?php

namespace AC;

use WP_Post;

abstract class ListScreenPost extends ListScreenWP {

	/**
	 * @var string Post type
	 */
	private $post_type;

	/**
	 * @param string $post_type
	 */
	public function __construct( $post_type ) {
		$this->set_post_type( $post_type )
		     ->set_meta_type( MetaType::POST );
	}

	/**
	 * @return string
	 */
	public function get_post_type() {
		return $this->post_type;
	}

	/**
	 * @param string $post_type
	 *
	 * @return self
	 */
	protected function set_post_type( $post_type ) {
		$this->post_type = (string) $post_type;

		return $this;
	}

	/**
	 * @param int $id
	 *
	 * @return WP_Post
	 */
	protected function get_object( $id ) {
		return get_post( $id );
	}

	/**
	 * @param string $var
	 *
	 * @return string|false
	 */
	protected function get_post_type_label_var( $var ) {
		$post_type_object = get_post_type_object( $this->get_post_type() );

		return $post_type_object && isset( $post_type_object->labels->{$var} ) ? $post_type_object->labels->{$var} : false;
	}

	/**
	 * Register post specific columns
	 */
	protected function register_column_types() {
		$this->register_column_type( new Column\CustomField );
		$this->register_column_type( new Column\Actions );
	}

}