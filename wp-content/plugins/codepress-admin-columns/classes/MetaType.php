<?php

namespace AC;

use LogicException;

final class MetaType {

	const POST = 'post';
	const USER = 'user';
	const COMMENT = 'comment';
	const TERM = 'term';
	const SITE = 'site';

	/**
	 * @var string
	 */
	private $meta_type;

	/**
	 * @param string $meta_type
	 */
	public function __construct( $meta_type ) {
		$this->meta_type = $meta_type;

		$this->validate();
	}

	/**
	 * @return string
	 */
	public function get() {
		return $this->meta_type;
	}

	/**
	 * @throws LogicException
	 */
	private function validate() {
		$types = [
			self::POST,
			self::USER,
			self::COMMENT,
			self::TERM,
			self::SITE,
		];

		if ( ! in_array( $this->meta_type, $types ) ) {
			throw new LogicException( 'Invalid meta type.' );
		}
	}

	public function __toString(): string {
		return $this->meta_type;
	}

}