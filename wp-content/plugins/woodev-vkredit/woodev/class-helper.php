<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Woodev_Helper' ) ) :

class Woodev_Helper {

	const MB_ENCODING = 'UTF-8';
	
	/**
	* Возвращает true если строка $haystack начинается на $needle
	*/	
	public static function str_starts_with( $haystack, $needle ) {

		if ( self::multibyte_loaded() ) {

			if ( '' === $needle ) {
				return true;
			}

			return 0 === mb_strpos( $haystack, $needle, 0, self::MB_ENCODING );

		} else {

			$needle = self::str_to_ascii( $needle );

			if ( '' === $needle ) {
				return true;
			}

			return 0 === strpos( self::str_to_ascii( $haystack ), self::str_to_ascii( $needle ) );
		}
	}
	
	/**
	* Возвращает true если строка $haystack заканчивается на $needle
	*/
	
	public static function str_ends_with( $haystack, $needle ) {

		if ( '' === $needle ) {
			return true;
		}

		if ( self::multibyte_loaded() ) {

			return mb_substr( $haystack, -mb_strlen( $needle, self::MB_ENCODING ), null, self::MB_ENCODING ) === $needle;

		} else {

			$haystack = self::str_to_ascii( $haystack );
			$needle   = self::str_to_ascii( $needle );

			return substr( $haystack, -strlen( $needle ) ) === $needle;
		}
	}
	
	/**
	* Возвращает true если $needle содержится в строке $haystack
	*/
	
	public static function str_exists( $haystack, $needle ) {

		if ( self::multibyte_loaded() ) {

			if ( '' === $needle ) {
				return false;
			}

			return false !== mb_strpos( $haystack, $needle, 0, self::MB_ENCODING );

		} else {

			$needle = self::str_to_ascii( $needle );

			if ( '' === $needle ) {
				return false;
			}

			return false !== strpos( self::str_to_ascii( $haystack ), self::str_to_ascii( $needle ) );
		}
	}
	
	/**
	* Возвращает строку $string обрезанную на длину $length с окончанием $omission
	*/
	
	public static function str_truncate( $string, $length, $omission = '...' ) {

		if ( self::multibyte_loaded() ) {

			if ( mb_strlen( $string, self::MB_ENCODING ) <= $length ) {
				return $string;
			}

			$length -= mb_strlen( $omission, self::MB_ENCODING );

			return mb_substr( $string, 0, $length, self::MB_ENCODING ) . $omission;

		} else {

			$string = self::str_to_ascii( $string );

			if ( strlen( $string ) <= $length ) {
				return $string;
			}

			$length -= strlen( $omission );

			return substr( $string, 0, $length ) . $omission;
		}
	}
	
	public static function str_to_ascii( $string ) {
		$string = filter_var( $string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW );
		return filter_var( $string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
	}
	
	public static function str_to_sane_utf8( $string ) {
		$sane_string = preg_replace( '/[^\p{L}\p{Mn}\p{Mc}\p{Nd}\p{Zs}\p{P}\p{Sm}\p{Sc}]/u', '', $string );
		return ( is_null( $sane_string ) || false === $sane_string ) ? $string : $sane_string;
	}
	
	protected static function multibyte_loaded() {
		return extension_loaded( 'mbstring' );
	}
	
	/**
	* Вставляет $element после ключа $insert_key в массив $array
	*/
	
	public static function array_insert_after( Array $array, $insert_key, Array $element ) {

		$new_array = array();

		foreach ( $array as $key => $value ) {

			$new_array[ $key ] = $value;

			if ( $insert_key == $key ) {

				foreach ( $element as $k => $v ) {
					$new_array[ $k ] = $v;
				}
			}
		}

		return $new_array;
	}
	
	/**
	* Рекурсивно генерирует XML из массива
	*/
	
	public static function array_to_xml( $xml_writer, $element_key, $element_value = array() ) {

		if ( is_array( $element_value ) ) {

			if ( '@attributes' === $element_key ) {
				foreach ( $element_value as $attribute_key => $attribute_value ) {

					$xml_writer->startAttribute( $attribute_key );
					$xml_writer->text( $attribute_value );
					$xml_writer->endAttribute();
				}
				return;
			}

			if ( is_numeric( key( $element_value ) ) ) {

				foreach ( $element_value as $child_element_key => $child_element_value ) {

					$xml_writer->startElement( $element_key );

					foreach ( $child_element_value as $sibling_element_key => $sibling_element_value ) {
						self::array_to_xml( $xml_writer, $sibling_element_key, $sibling_element_value );
					}

					$xml_writer->endElement();
				}

			} else {

				$xml_writer->startElement( $element_key );

				foreach ( $element_value as $child_element_key => $child_element_value ) {
					self::array_to_xml( $xml_writer, $child_element_key, $child_element_value );
				}

				$xml_writer->endElement();
			}

		} else {

			if ( '@value' == $element_key ) {

				$xml_writer->text( $element_value );

			} else {

				if ( false !== strpos( $element_value, '<' ) || false !== strpos( $element_value, '>' ) ) {

					$xml_writer->startElement( $element_key );
					$xml_writer->writeCdata( $element_value );
					$xml_writer->endElement();

				} else {

					$xml_writer->writeElement( $element_key, $element_value );
				}

			}

			return;
		}
	}
	
	public static function number_format( $number ) {
		return number_format( ( float ) $number, 2, '.', '' );
	}
	
	/**
	* Безопасно получает значение $key из $_POST
	*/
	
	public static function get_post( $key ) {

		if ( isset( $_POST[ $key ] ) ) {
			return trim( $_POST[ $key ] );
		}

		return '';
	}
	
	/**
	* Безопасно получает значение $key из $_REQUEST
	*/
	
	public static function get_request( $key ) {

		if ( isset( $_REQUEST[ $key ] ) ) {
			return trim( $_REQUEST[ $key ] );
		}

		return '';
	}
	
	public static function wc_notice_count( $notice_type = '' ) {
		if ( function_exists( 'wc_notice_count' ) ) {
			return wc_notice_count( $notice_type );
		}
		return 0;
	}
	
	public static function wc_add_notice( $message, $notice_type = 'success' ) {
		if ( function_exists( 'wc_add_notice' ) ) {
			wc_add_notice( $message, $notice_type );
		}
	}
	
	public static function wc_print_notice( $message, $notice_type = 'success' ) {
		if ( function_exists( 'wc_print_notice' ) ) {
			wc_print_notice( $message, $notice_type );
		}
	}
	
	/**
	* Проверяет активирован ли плагин Woocommerce
	*/
	
	public static function is_woocommerce_active() {

		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}

		return in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins );
	}
	
	/**
	* Возвращает текущую версию Woocommerce если он активирован
	*/
	
	public static function get_wc_version() {
		
		if( self::is_woocommerce_active() ) {
			if( defined( 'WC_VERSION' )          && WC_VERSION )          return WC_VERSION;
			if( defined( 'WOOCOMMERCE_VERSION' ) && WOOCOMMERCE_VERSION ) return WOOCOMMERCE_VERSION;
		}
		
		return null;
	}
	
	/**
	* Проверяет, является ли текущий запрос AJAX
	*/
	
	public static function is_ajax() {
		return function_exists( 'wp_doing_ajax' ) ? wp_doing_ajax() : defined( 'DOING_AJAX' );
	}
	
	public static function enqueue_js( $code ) {
		global $woodev_queued_js;

		if ( empty( $woodev_queued_js ) ) {
			$woodev_queued_js = '';
		}

		$woodev_queued_js .= "\n" . $code . "\n";
	}
	
	public static function print_js() {
		global $woodev_queued_js;

		if ( ! empty( $woodev_queued_js ) ) {
			
			$woodev_queued_js = wp_check_invalid_utf8( $woodev_queued_js );
			$woodev_queued_js = preg_replace( '/&#(x)?0*(?(1)27|39);?/i', "'", $woodev_queued_js );
			$woodev_queued_js = str_replace( "\r", '', $woodev_queued_js );

			$js = "<!-- Woodev JavaScript -->\n<script type=\"text/javascript\">\njQuery(function($) { $woodev_queued_js });\n</script>\n";
			
			echo apply_filters( 'woodev_queued_js', $js );

			unset( $woodev_queued_js );
		}
	}
	
	public static function let_to_num( $size ) {
		$l    = substr( $size, -1 );
		$ret  = substr( $size, 0, -1 );
		$byte = 1024;

		switch ( strtoupper( $l ) ) {
			case 'P': $ret *= 1024;
			case 'T': $ret *= 1024;
			case 'G': $ret *= 1024;
			case 'M': $ret *= 1024;
			case 'K': $ret *= 1024;
		}
		return $ret;
	}
	
	public static function trigger_error( $message, $type = E_USER_NOTICE ) {

		if ( is_callable( array( __CLASS__, 'is_ajax' ) ) && self::is_ajax() ) {

			switch ( $type ) {

				case E_USER_NOTICE:
					$prefix = 'Уведомление: ';
				break;

				case E_USER_WARNING:
					$prefix = 'Предупреждение: ';
				break;

				default:
					$prefix = '';
			}

			error_log( $prefix . $message );

		} else {
			trigger_error( $message, $type );
		}
	}
	
	public static function str_convert( $string = '', $context = '' ) {
		
		if( ! class_exists( 'Woodev_String_Conversion' ) ) {
			require_once( 'class-string-conversation.php' );
		}
		
		return Woodev_String_Conversion::sanitize_title( $string, $context );
	}
	
	public static function get_wc_log_file_url( $handle ) {
		return esc_url( add_query_arg( 'log_file', wc_get_log_file_name( $handle ), admin_url( 'admin.php?page=wc-status&tab=logs' ) ) );
	}
	
	public static function get_site_name() {

		return ( is_multisite() ) ? get_blog_details()->blogname : get_bloginfo( 'name' );
	}
	
	public static function list_array_items( array $items, $conjunction = null, $separator = '' ) {

		if ( ! is_string( $conjunction ) ) {
			$conjunction = _x( 'and', 'coordinating conjunction for a list of items: a, b, and c' );
		}
		
		if ( count( $items ) > 1 ) {

			$last_item = array_pop( $items );

			array_push( $items, trim( "{$conjunction} {$last_item}" ) );
			
			if ( count( $items ) < 3 ) {
				$separator = ' ';
			} elseif ( ! is_string( $separator ) || '' === $separator ) {
				$separator = ', ';
			}
		}

		return implode( $separator, $items );
	}
	
	public static function get_order_line_items( $order ) {

		$line_items = array();

		foreach ( $order->get_items() as $id => $item ) {

			$line_item = new \stdClass();
			$product   = $item->get_product();
			$name      = $item->get_name();
			$quantity  = $item->get_quantity();
			$sku       = $product instanceof WC_Product ? $product->get_sku() : '';
			$item_desc = array();
				
			if ( ! empty( $sku ) ) {
				$item_desc[] = sprintf( 'SKU: %s', $sku );
			}
				
			$item_meta = new WC_Order_Item_Meta( $item );

			$item_meta = $item_meta->get_formatted();

			if ( ! empty( $item_meta ) ) {

				foreach ( $item_meta as $meta ) {
					$item_desc[] = sprintf( '%s: %s', $meta['label'], $meta['value'] );
				}
			}

			$item_desc = implode( ', ', $item_desc );

			$line_item->id          = $id;
			$line_item->name        = htmlentities( $name, ENT_QUOTES, 'UTF-8', false );
			$line_item->description = htmlentities( $item_desc, ENT_QUOTES, 'UTF-8', false );
			$line_item->quantity    = $quantity;
			$line_item->item_total  = isset( $item['recurring_line_total'] ) ? $item['recurring_line_total'] : $order->get_item_total( $item );
			$line_item->line_total  = $order->get_line_total( $item );
			$line_item->meta        = $item_meta;
			$line_item->product     = is_object( $product ) ? $product : null;
			$line_item->item        = $item;

			$line_items[] = $line_item;
		}

		return $line_items;
	}
	
	public static function is_order_virtual( WC_Order $order ) {

		$is_virtual = true;
		
		foreach ( $order->get_items() as $item ) {

			$product = $item->get_product();
			
			if ( $product && ! $product->is_virtual() ) {

				$is_virtual = false;
				break;
			}
		}

		return $is_virtual;
	}
	
	/** JavaScript helper functions ***************************************/


	/**
	 * Enhanced search JavaScript (Select2)
	 *
	 * Enqueues JavaScript required for AJAX search with Select2.
	 *
	 * Example usage:
	 *    <input type="hidden" class="woodev-wc-enhanced-search" name="category_ids" data-multiple="true" style="min-width: 300px;"
	 *       data-action="wc_cart_notices_json_search_product_categories"
	 *       data-nonce="<?php echo wp_create_nonce( 'search-categories' ); ?>"
	 *       data-request_data = "<?php echo esc_attr( json_encode( array( 'field_name' => 'something_exciting', 'default' => 'default_label' ) ) ) ?>"
	 *       data-placeholder="<?php esc_attr_e( 'Search for a category&hellip;', 'wc-cart-notices' ) ?>"
	 *       data-allow_clear="true"
	 *       data-selected="<?php
	 *          $json_ids    = array();
	 *          if ( isset( $notice->data['categories'] ) ) {
	 *             foreach ( $notice->data['categories'] as $value => $title ) {
	 *                $json_ids[ esc_attr( $value ) ] = esc_html( $title );
	 *             }
	 *          }
	 *          echo esc_attr( json_encode( $json_ids ) );
	 *       ?>"
	 *       value="<?php echo implode( ',', array_keys( $json_ids ) ); ?>" />
	 *
	 * - `data-selected` can be a json encoded associative array like Array( 'key' => 'value' )
	 * - `value` should be a comma-separated list of selected keys
	 * - `data-request_data` can be used to pass any additional data to the AJAX request
	*/
	public static function render_select2_ajax() {

		if ( ! did_action( 'woodev_wc_select2_ajax_rendered' ) ) {

			$javascript = "( function(){
				if ( ! $().select2 ) return;
			";
			
			$javascript .= "

				function getEnhancedSelectFormatString() {

					if ( 'undefined' !== typeof wc_select_params ) {
						wc_enhanced_select_params = wc_select_params;
					}

					if ( 'undefined' === typeof wc_enhanced_select_params ) {
						return {};
					}

					var formatString = {
						formatMatches: function( matches ) {
							if ( 1 === matches ) {
								return wc_enhanced_select_params.i18n_matches_1;
							}

							return wc_enhanced_select_params.i18n_matches_n.replace( '%qty%', matches );
						},
						formatNoMatches: function() {
							return wc_enhanced_select_params.i18n_no_matches;
						},
						formatAjaxError: function( jqXHR, textStatus, errorThrown ) {
							return wc_enhanced_select_params.i18n_ajax_error;
						},
						formatInputTooShort: function( input, min ) {
							var number = min - input.length;

							if ( 1 === number ) {
								return wc_enhanced_select_params.i18n_input_too_short_1
							}

							return wc_enhanced_select_params.i18n_input_too_short_n.replace( '%qty%', number );
						},
						formatInputTooLong: function( input, max ) {
							var number = input.length - max;

							if ( 1 === number ) {
								return wc_enhanced_select_params.i18n_input_too_long_1
							}

							return wc_enhanced_select_params.i18n_input_too_long_n.replace( '%qty%', number );
						},
						formatSelectionTooBig: function( limit ) {
							if ( 1 === limit ) {
								return wc_enhanced_select_params.i18n_selection_too_long_1;
							}

							return wc_enhanced_select_params.i18n_selection_too_long_n.replace( '%qty%', number );
						},
						formatLoadMore: function( pageNumber ) {
							return wc_enhanced_select_params.i18n_load_more;
						},
						formatSearching: function() {
							return wc_enhanced_select_params.i18n_searching;
						}
					};

					return formatString;
				}
			";
			
			if ( version_compare( self::get_wc_version(), '3.0', '>=' ) ) {

				$javascript .= "

					$( 'select.woodev-wc-enhanced-search' ).filter( ':not(.enhanced)' ).each( function() {

						var select2_args = {
							allowClear:         $( this ).data( 'allow_clear' ) ? true : false,
							placeholder:        $( this ).data( 'placeholder' ),
							minimumInputLength: $( this ).data( 'minimum_input_length' ) ? $( this ).data( 'minimum_input_length' ) : '3',
							escapeMarkup:       function( m ) {
								return m;
							},
							ajax:               {
								url:            '" . esc_js( admin_url( 'admin-ajax.php' ) ) . "',
								dataType:       'json',
								cache:          true,
								delay:          250,
								data:           function( params ) {
									return {
										term:         params.term,
										request_data: $( this ).data( 'request_data' ) ? $( this ).data( 'request_data' ) : {},
										action:       $( this ).data( 'action' ) || 'woocommerce_json_search_products_and_variations',
										security:     $( this ).data( 'nonce' )
									};
								},
								processResults: function( data, params ) {
									var terms = [];
									if ( data ) {
										$.each( data, function( id, text ) {
											terms.push( { id: id, text: text } );
										});
									}
									return { results: terms };
								}
							}
						};

						select2_args = $.extend( select2_args, getEnhancedSelectFormatString() );

						$( this ).select2( select2_args ).addClass( 'enhanced' );
					} );
				";

			} else {

				$javascript .= "

					$( ':input.woodev-wc-enhanced-search' ).filter( ':not(.enhanced)' ).each( function() {

						var select2_args = {
							allowClear:         $( this ).data( 'allow_clear' ) ? true : false,
							placeholder:        $( this ).data( 'placeholder' ),
							minimumInputLength: $( this ).data( 'minimum_input_length' ) ? $( this ).data( 'minimum_input_length' ) : '3',
							escapeMarkup:       function( m ) {
								return m;
							},
							ajax:               {
								url:         '" . esc_js( admin_url( 'admin-ajax.php' ) ) . "',
								dataType:    'json',
								cache:       true,
								quietMillis: 250,
								data:        function( term, page ) {
									return {
										term:         term,
										request_data: $( this ).data( 'request_data' ) ? $( this ).data( 'request_data' ) : {},
										action:       $( this ).data( 'action' ) || 'woocommerce_json_search_products_and_variations',
										security:     $( this ).data( 'nonce' )
									};
								},
								results:     function( data, page ) {
									var terms = [];
									if ( data ) {
										$.each( data, function( id, text ) {
											terms.push( { id: id, text: text } );
										});
									}
									return { results: terms };
								}
							}
						};

						if ( $( this ).data( 'multiple' ) === true ) {

							select2_args.multiple        = true;
							select2_args.initSelection   = function( element, callback ) {
								var data     = $.parseJSON( element.attr( 'data-selected' ) );
								var selected = [];

								$( element.val().split( ',' ) ).each( function( i, val ) {
									selected.push( { id: val, text: data[ val ] } );
								} );
								return callback( selected );
							};
							select2_args.formatSelection = function( data ) {
								return '<div class=\"selected-option\" data-id=\"' + data.id + '\">' + data.text + '</div>';
							};

						} else {

							select2_args.multiple        = false;
							select2_args.initSelection   = function( element, callback ) {
								var data = {id: element.val(), text: element.attr( 'data-selected' )};
								return callback( data );
							};
						}

						select2_args = $.extend( select2_args, getEnhancedSelectFormatString() );

						$( this ).select2( select2_args ).addClass( 'enhanced' );
					} );
				";
			}

			$javascript .= "} )();";

			self::enqueue_js( $javascript );
				
			do_action( 'woodev_wc_select2_ajax_rendered' );
		}
	}
	
	public static function get_current_screen() {
		global $current_screen;

		return $current_screen ? $current_screen : null;
	}
	
	public static function is_current_screen( $id, $prop = 'id' ) {
		global $current_screen;

		return isset( $current_screen->$prop ) && $id === $current_screen->$prop;
	}
		
	public static function convert_country_code( $code ) {
		
		$countries = array(
			'AF' => 'AFG', 'AL' => 'ALB', 'DZ' => 'DZA', 'AD' => 'AND', 'AO' => 'AGO',
			'AG' => 'ATG', 'AR' => 'ARG', 'AM' => 'ARM', 'AU' => 'AUS', 'AT' => 'AUT',
			'AZ' => 'AZE', 'BS' => 'BHS', 'BH' => 'BHR', 'BD' => 'BGD', 'BB' => 'BRB',
			'BY' => 'BLR', 'BE' => 'BEL', 'BZ' => 'BLZ', 'BJ' => 'BEN', 'BT' => 'BTN',
			'BO' => 'BOL', 'BA' => 'BIH', 'BW' => 'BWA', 'BR' => 'BRA', 'BN' => 'BRN',
			'BG' => 'BGR', 'BF' => 'BFA', 'BI' => 'BDI', 'KH' => 'KHM', 'CM' => 'CMR',
			'CA' => 'CAN', 'CV' => 'CPV', 'CF' => 'CAF', 'TD' => 'TCD', 'CL' => 'CHL',
			'CN' => 'CHN', 'CO' => 'COL', 'KM' => 'COM', 'CD' => 'COD', 'CG' => 'COG',
			'CR' => 'CRI', 'CI' => 'CIV', 'HR' => 'HRV', 'CU' => 'CUB', 'CY' => 'CYP',
			'CZ' => 'CZE', 'DK' => 'DNK', 'DJ' => 'DJI', 'DM' => 'DMA', 'DO' => 'DOM',
			'EC' => 'ECU', 'EG' => 'EGY', 'SV' => 'SLV', 'GQ' => 'GNQ', 'ER' => 'ERI',
			'EE' => 'EST', 'ET' => 'ETH', 'FJ' => 'FJI', 'FI' => 'FIN', 'FR' => 'FRA',
			'GA' => 'GAB', 'GM' => 'GMB', 'GE' => 'GEO', 'DE' => 'DEU', 'GH' => 'GHA',
			'GR' => 'GRC', 'GD' => 'GRD', 'GT' => 'GTM', 'GN' => 'GIN', 'GW' => 'GNB',
			'GY' => 'GUY', 'HT' => 'HTI', 'HN' => 'HND', 'HU' => 'HUN', 'IS' => 'ISL',
			'IN' => 'IND', 'ID' => 'IDN', 'IR' => 'IRN', 'IQ' => 'IRQ', 'IE' => 'IRL',
			'IL' => 'ISR', 'IT' => 'ITA', 'JM' => 'JAM', 'JP' => 'JPN', 'JO' => 'JOR',
			'KZ' => 'KAZ', 'KE' => 'KEN', 'KI' => 'KIR', 'KP' => 'PRK', 'KR' => 'KOR',
			'KW' => 'KWT', 'KG' => 'KGZ', 'LA' => 'LAO', 'LV' => 'LVA', 'LB' => 'LBN',
			'LS' => 'LSO', 'LR' => 'LBR', 'LY' => 'LBY', 'LI' => 'LIE', 'LT' => 'LTU',
			'LU' => 'LUX', 'MK' => 'MKD', 'MG' => 'MDG', 'MW' => 'MWI', 'MY' => 'MYS',
			'MV' => 'MDV', 'ML' => 'MLI', 'MT' => 'MLT', 'MH' => 'MHL', 'MR' => 'MRT',
			'MU' => 'MUS', 'MX' => 'MEX', 'FM' => 'FSM', 'MD' => 'MDA', 'MC' => 'MCO',
			'MN' => 'MNG', 'ME' => 'MNE', 'MA' => 'MAR', 'MZ' => 'MOZ', 'MM' => 'MMR',
			'NA' => 'NAM', 'NR' => 'NRU', 'NP' => 'NPL', 'NL' => 'NLD', 'NZ' => 'NZL',
			'NI' => 'NIC', 'NE' => 'NER', 'NG' => 'NGA', 'NO' => 'NOR', 'OM' => 'OMN',
			'PK' => 'PAK', 'PW' => 'PLW', 'PA' => 'PAN', 'PG' => 'PNG', 'PY' => 'PRY',
			'PE' => 'PER', 'PH' => 'PHL', 'PL' => 'POL', 'PT' => 'PRT', 'QA' => 'QAT',
			'RO' => 'ROU', 'RU' => 'RUS', 'RW' => 'RWA', 'KN' => 'KNA', 'LC' => 'LCA',
			'VC' => 'VCT', 'WS' => 'WSM', 'SM' => 'SMR', 'ST' => 'STP', 'SA' => 'SAU',
			'SN' => 'SEN', 'RS' => 'SRB', 'SC' => 'SYC', 'SL' => 'SLE', 'SG' => 'SGP',
			'SK' => 'SVK', 'SI' => 'SVN', 'SB' => 'SLB', 'SO' => 'SOM', 'ZA' => 'ZAF',
			'ES' => 'ESP', 'LK' => 'LKA', 'SD' => 'SDN', 'SR' => 'SUR', 'SZ' => 'SWZ',
			'SE' => 'SWE', 'CH' => 'CHE', 'SY' => 'SYR', 'TJ' => 'TJK', 'TZ' => 'TZA',
			'TH' => 'THA', 'TL' => 'TLS', 'TG' => 'TGO', 'TO' => 'TON', 'TT' => 'TTO',
			'TN' => 'TUN', 'TR' => 'TUR', 'TM' => 'TKM', 'TV' => 'TUV', 'UG' => 'UGA',
			'UA' => 'UKR', 'AE' => 'ARE', 'GB' => 'GBR', 'US' => 'USA', 'UY' => 'URY',
			'UZ' => 'UZB', 'VU' => 'VUT', 'VA' => 'VAT', 'VE' => 'VEN', 'VN' => 'VNM',
			'YE' => 'YEM', 'ZM' => 'ZMB', 'ZW' => 'ZWE', 'TW' => 'TWN', 'CX' => 'CXR',
			'CC' => 'CCK', 'HM' => 'HMD', 'NF' => 'NFK', 'NC' => 'NCL', 'PF' => 'PYF',
			'YT' => 'MYT', 'GP' => 'GLP', 'PM' => 'SPM', 'WF' => 'WLF', 'TF' => 'ATF',
			'BV' => 'BVT', 'CK' => 'COK', 'NU' => 'NIU', 'TK' => 'TKL', 'GG' => 'GGY',
			'IM' => 'IMN', 'JE' => 'JEY', 'AI' => 'AIA', 'BM' => 'BMU', 'IO' => 'IOT',
			'VG' => 'VGB', 'KY' => 'CYM', 'FK' => 'FLK', 'GI' => 'GIB', 'MS' => 'MSR',
			'PN' => 'PCN', 'SH' => 'SHN', 'GS' => 'SGS', 'TC' => 'TCA', 'MP' => 'MNP',
			'PR' => 'PRI', 'AS' => 'ASM', 'UM' => 'UMI', 'GU' => 'GUM', 'VI' => 'VIR',
			'HK' => 'HKG', 'MO' => 'MAC', 'FO' => 'FRO', 'GL' => 'GRL', 'GF' => 'GUF',
			'MQ' => 'MTQ', 'RE' => 'REU', 'AX' => 'ALA', 'AW' => 'ABW', 'AN' => 'ANT',
			'SJ' => 'SJM', 'AC' => 'ASC', 'TA' => 'TAA', 'AQ' => 'ATA',
		);

		if ( 3 === strlen( $code ) ) {
			$countries = array_flip( $countries );
		}

		return isset( $countries[ $code ] ) ? $countries[ $code ] : $code;
	}
}

endif;
?>