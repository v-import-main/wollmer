<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! interface_exists( 'Woodev_Payment_Gateway_API_Request' ) ) :

interface Woodev_Payment_Gateway_API_Request extends Woodev_API_Request {}

endif;