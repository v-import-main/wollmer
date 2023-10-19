<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_REST_API_Settings' ) ) :

class Woodev_REST_API_Settings extends WP_REST_Controller {
	
	protected $settings;
	
	public function __construct( Woodev_Abstract_Settings $settings ) {

		$this->settings  = $settings;
		$this->namespace = 'wc/v3';
		$this->rest_base = "{$settings->get_id()}/settings";
	}
	
	public function register_routes() {

		register_rest_route(
			$this->namespace, "/{$this->rest_base}", [
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_items' ],
					'permission_callback' => [ $this, 'get_items_permissions_check' ],
				],
				'schema' => [ $this, 'get_public_item_schema' ],
			]
		);

		register_rest_route(
			$this->namespace, "/{$this->rest_base}/(?P<id>[\w-]+)", [
				'args' => [
					'id' => [
						'description' => __( 'Unique identifier for the resource.', 'woocommerce' ),
						'type'        => 'string',
					],
				],
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_item' ],
					'permission_callback' => [ $this, 'get_items_permissions_check' ],
				],
				[
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => [ $this, 'update_item' ],
					'permission_callback' => [ $this, 'update_item_permissions_check' ],
					'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
				],
				'schema' => [ $this, 'get_public_item_schema' ],
			]
		);
	}
	
	public function get_items_permissions_check( $request ) {

		if ( ! wc_rest_check_manager_permissions( 'settings', 'read' ) ) {
			return new WP_Error( 'wc_rest_cannot_view', __( 'Sorry, you cannot list resources.' ), [ 'status' => rest_authorization_required_code() ] );
		}

		return true;
	}
	
	public function get_items( $request ) {

		$items = [];

		foreach ( $this->settings->get_settings() as $setting ) {
			$items[] = $this->prepare_setting_item( $setting, $request );
		}

		return rest_ensure_response( $items );
	}
	
	public function get_item( $request ) {

		$setting_id = $request->get_param( 'id' );

		if ( $setting = $this->settings->get_setting( $setting_id ) ) {

			return rest_ensure_response( $this->prepare_setting_item( $setting, $request ) );

		} else {

			return new WP_Error(
				'wc_rest_setting_not_found',
				sprintf(
					__( 'Setting %s does not exist' ),
					$setting_id
				),
				[ 'status' => 404 ]
			);
		}
	}
	
	public function update_item_permissions_check( $request ) {

		if ( ! wc_rest_check_manager_permissions( 'settings', 'edit' ) ) {
			return new WP_Error( 'wc_rest_cannot_edit', __( 'Sorry, you cannot edit this resource.' ), [ 'status' => rest_authorization_required_code() ] );
		}

		return true;
	}
	
	public function update_item( $request ) {

		try {

			$setting_id = $request->get_param( 'id' );
			$value      = $request->get_param( 'value' );
			$this->settings->update_value( $setting_id, $value );

			return rest_ensure_response( $this->prepare_setting_item( $this->settings->get_setting( $setting_id ), $request ) );

		} catch ( Exception $e ) {

			return new WP_Error(
				'wc_rest_setting_could_not_update',
				sprintf(
					__( 'Could not update setting: %s' ),
					$e->getMessage()
				),
				[ 'status' => $e->getCode() ?: 400 ]
			);
		}
	}
	
	public function prepare_setting_item( $setting, $request ) {

		if ( $setting instanceof Woodev_Setting ) {

			$item = [
				'id'          => $setting->get_id(),
				'type'        => $setting->get_type(),
				'name'        => $setting->get_name(),
				'description' => $setting->get_description(),
				'is_multi'    => $setting->is_is_multi(),
				'options'     => $setting->get_options(),
				'default'     => $setting->get_default(),
				'value'       => $setting->get_value(),
				'control'     => null,
			];

			if ( $control = $setting->get_control() ) {
				$item['control'] = [
					'type'        => $control->get_type(),
					'name'        => $control->get_name(),
					'description' => $control->get_description(),
					'options'     => $control->geT_options(),
				];
			}

		} else {

			$item = [];
		}

		return $item;
	}
	
	public function get_item_schema() {

		$schema = [
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => "{$this->settings->get_id()}_setting",
			'type'       => 'object',
			'properties' => [
				'id'          => [
					'description' => __( 'Unique identifier of the setting.' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'readonly'    => true,
				],
				'type'        => [
					'description' => __( 'The type of the setting.' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'enum'        => $this->settings->get_setting_types(),
					'readonly'    => true,
				],
				'name'        => [
					'description' => __( 'The name of the setting.' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'readonly'    => true,
				],
				'description' => [
					'description' => __( 'The description of the setting. It may or may not be used for display.' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'readonly'    => true,
				],
				'is_multi'    => [
					'description' => __( 'Whether the setting stores an array of values or a single value.' ),
					'type'        => 'boolean',
					'context'     => [ 'view', 'edit' ],
					'readonly'    => true,
				],
				'options'     => [
					'description' => __( 'A list of valid options, used for validation before storing the value.' ),
					'type'        => 'array',
					'context'     => [ 'view', 'edit' ],
					'readonly'    => true,
				],
				'default'     => [
					'description' => __( 'Optional default value for the setting.' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'readonly'    => true,
				],
				'value'       => [
					'description' => __( 'The value of the setting.' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
				],
				'control'     => [
					'description' => __( 'Optional object that defines how the user will interact with and update the setting.' ),
					'type'        => 'object',
					'properties'  => [
						'type'        => [
							'description' => __( 'The type of the control.' ),
							'type'        => 'string',
							'context'     => [ 'view', 'edit' ],
							'enum'        => $this->settings->get_control_types(),
							'readonly'    => true,
						],
						'name'        => [
							'description' => __( "The name of the control. Inherits the setting's name." ),
							'type'        => 'string',
							'context'     => [ 'view', 'edit' ],
							'readonly'    => true,
						],
						'description' => [
							'description' => __( "The description of the control. Inherits the setting's description." ),
							'type'        => 'string',
							'context'     => [ 'view', 'edit' ],
							'readonly'    => true,
						],
						'options'     => [
							'description' => __( 'A list of key/value pairs defining the display value of each setting option. The keys should match the options defined in the base setting for validation.' ),
							'type'        => 'array',
							'context'     => [ 'view', 'edit' ],
							'readonly'    => true,
						],
					],
					'context'     => [ 'view', 'edit' ],
					'readonly'    => true,
				],
			],
		];

		return $this->add_additional_fields_schema( $schema );
	}

}

endif;
