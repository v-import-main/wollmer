<?php

namespace AC\Column;

use AC\Column;

abstract class Meta extends Column {

	/**
	 * Return the meta_key of this column
	 * @return string
	 */
	abstract public function get_meta_key();

	/**
	 * Is data stored serialized?
	 * @var bool
	 */
	private $serialized = false;

	/**
	 * @return bool
	 */
	public function is_serialized() {
		return $this->serialized;
	}

	/**
	 * @param bool $serialized
	 */
	public function set_serialized( $serialized ) {
		$this->serialized = (bool) $serialized;
	}

	/**
	 * @param $id
	 *
	 * @return bool|mixed
	 * @see   Column::get_raw_value()
	 * @since 2.0.3
	 */
	public function get_raw_value( $id ) {
		return $this->get_meta_value( $id, $this->get_meta_key() );
	}

	/**
	 * Retrieve metadata object type (e.g., comment, post, or user)
	 * @return string
	 * @since 3.0
	 */
	public function get_meta_type() {
		return $this->get_list_screen()->get_meta_type();
	}

	/**
	 * Get meta value
	 *
	 * @param int    $id
	 * @param string $meta_key
	 * @param bool   $single
	 *
	 * @return mixed
	 */
	public function get_meta_value( $id, $meta_key, $single = true ) {
		return get_metadata( $this->get_meta_type(), $id, $meta_key, $single );
	}

}