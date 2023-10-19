<?php

class Flamingo_Contact {

	const post_type = 'flamingo_contact';
	const contact_tag_taxonomy = 'flamingo_contact_tag';

	private static $found_items = 0;

	private $id;
	public $email;
	public $name;
	public $props = array();
	public $tags = array();
	public $last_contacted;

	public static function register_post_type() {
		register_post_type( self::post_type, array(
			'labels' => array(
				'name' => __( 'Flamingo Contacts', 'flamingo' ),
				'singular_name' => __( 'Flamingo Contact', 'flamingo' ),
			),
			'rewrite' => false,
			'query_var' => false,
		) );

		register_taxonomy( self::contact_tag_taxonomy, self::post_type, array(
			'labels' => array(
				'name' => __( 'Flamingo Contact Tags', 'flamingo' ),
				'singular_name' => __( 'Flamingo Contact Tag', 'flamingo' ),
			),
			'public' => false,
			'rewrite' => false,
			'query_var' => false,
		) );
	}

	public static function find( $args = '' ) {
		$defaults = array(
			'posts_per_page' => 10,
			'offset' => 0,
			'orderby' => 'ID',
			'order' => 'ASC',
			'meta_key' => '',
			'meta_value' => '',
			'post_status' => 'any',
			'tax_query' => array(),
			'contact_tag_id' => '',
		);

		$args = wp_parse_args( $args, $defaults );

		$args['post_type'] = self::post_type;

		if ( ! empty( $args['contact_tag_id'] ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => self::contact_tag_taxonomy,
				'terms' => $args['contact_tag_id'],
				'field' => 'term_id',
			);
		}

		$q = new WP_Query();
		$posts = $q->query( $args );

		self::$found_items = $q->found_posts;

		$objs = array();

		foreach ( (array) $posts as $post ) {
			$objs[] = new self( $post );
		}

		return $objs;
	}

	public static function count( $args = '' ) {
		if ( $args ) {
			$args = wp_parse_args( $args, array(
				'offset' => 0,
				'post_status' => 'publish',
			) );

			self::find( $args );
		}

		return absint( self::$found_items );
	}

	public static function search_by_email( $email ) {
		$objs = self::find( array(
			'posts_per_page' => 1,
			'orderby' => 'ID',
			'meta_key' => '_email',
			'meta_value' => $email,
		) );

		if ( empty( $objs ) ) {
			return null;
		}

		return $objs[0];
	}

	public static function add( $args = '' ) {
		$args = wp_parse_args( $args, array(
			'email' => '',
			'name' => '',
			'props' => array(),
			'last_contacted' => '0000-00-00 00:00:00',
		) );

		$args = apply_filters( 'flamingo_add_contact', $args );

		if ( empty( $args['email'] ) or ! is_email( $args['email'] ) ) {
			return;
		}

		$obj = self::search_by_email( $args['email'] );

		if ( ! $obj ) {
			$obj = new self();

			$obj->email = $args['email'];
			$obj->name = $args['name'];
			$obj->props = (array) $args['props'];
		}

		if ( '0000-00-00 00:00:00' !== $args['last_contacted'] ) {
			$obj->last_contacted = $args['last_contacted'];
		} elseif ( $datetime = date_create_immutable( 'now', wp_timezone() ) ) {
			$obj->last_contacted = $datetime->format( 'Y-m-d H:i:s' );
		}

		$obj->save();

		return $obj;
	}

	public function __construct( $post = null ) {
		if ( ! empty( $post ) and $post = get_post( $post ) ) {
			$this->id = $post->ID;
			$this->email = get_post_meta( $post->ID, '_email', true );
			$this->name = get_post_meta( $post->ID, '_name', true );
			$this->props = get_post_meta( $post->ID, '_props', true );
			$this->last_contacted =
				get_post_meta( $post->ID, '_last_contacted', true );

			$terms = wp_get_object_terms( $this->id, self::contact_tag_taxonomy );

			if ( ! empty( $terms ) and ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$this->tags[] = $term->name;
				}
			}
		}
	}

	public function __get( $name ) {
		/* translators: 1: Property, 2: Version, 3: Class, 4: Method. */
		$message = __( 'The visibility of the %1$s property has been changed in %2$s. Now the property may only be accessed by the %3$s class. You can use the %4$s method instead.', 'flamingo' );

		if ( 'id' == $name ) {
			if ( WP_DEBUG ) {
				trigger_error( sprintf(
					$message,
					sprintf( '<code>%s</code>', 'id' ),
					esc_html( __( 'Flamingo 2.2', 'flamingo' ) ),
					sprintf( '<code>%s</code>', self::class ),
					sprintf( '<code>%s</code>', 'id()' )
				) );
			}

			return $this->id;
		}
	}

	public function id() {
		return $this->id;
	}

	public function save() {
		$post_title = $this->email;
		$post_name = strtr( $this->email, '@', '-' );

		$fields = flamingo_array_flatten( $this->props );
		$fields = array_merge( $fields, array( $this->email, $this->name ) );
		$fields = array_filter( array_map( 'trim', $fields ) );
		$fields = array_unique( $fields );

		$post_content = implode( "\n", $fields );

		$postarr = array(
			'ID' => absint( $this->id ),
			'post_type' => self::post_type,
			'post_status' => 'publish',
			'post_title' => $post_title,
			'post_name' => $post_name,
			'post_content' => $post_content,
		);

		$post_id = wp_insert_post( $postarr );

		if ( $post_id ) {
			$this->id = $post_id;
			update_post_meta( $post_id, '_email', $this->email );
			update_post_meta( $post_id, '_name', $this->name );
			update_post_meta( $post_id, '_props', $this->props );
			update_post_meta( $post_id, '_last_contacted', $this->last_contacted );

			wp_set_object_terms( $this->id, $this->tags, self::contact_tag_taxonomy );
		}

		return $post_id;
	}

	public function get_prop( $name ) {
		if ( 'name' == $name ) {
			return $this->name;
		}

		if ( isset( $this->props[$name] ) ) {
			return $this->props[$name];
		}

		return '';
	}

	public function delete() {
		if ( empty( $this->id ) ) {
			return;
		}

		if ( $post = wp_delete_post( $this->id, true ) ) {
			$this->id = 0;
		}

		return (bool) $post;
	}

}
