<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( !function_exists( 'flat_pm_block_geo_role_ip' ) ){
	function flat_pm_block_geo_role_ip( $method, $meta ){
		$ip = flat_pm_get_real_ip();

		$long_ip = sprintf( "%u", ip2long( $ip ) );

		$data = array(
			'ip'      => 'true',
			'city'    => '',
			'country' => '',
			'ccode'   => '',
			'role'    => '',
		);




		$file = ABSPATH . '/ip.txt';

		if( ! file_exists( $file ) ){
			file_put_contents( $file, '' );
		}

		$content = file_get_contents( $file, true );

		if( $content != false && $content != '' ){
			$ip_array = explode( PHP_EOL, $content );

			foreach( $ip_array as $ip_range ){
				if( mb_strpos( $ip_range, '-' ) === false ){
					if( $ip_range == $ip ){
						$data['ip'] = 'false';

						break;
					}
				}else{
					$range = explode( '-', $ip_range );

					$low_ip  = sprintf( "%u", ip2long( trim( $range[0] ) ) );
					$high_ip = sprintf( "%u", ip2long( trim( $range[1] ) ) );

					if( $long_ip <= $high_ip && $low_ip <= $long_ip ){
						$data['ip'] = 'false';

						break;
					}
				}
			}
		}



		$args = array(
			'sslverify' => false
		);

		$json = wp_remote_get( 'http://pro.ip-api.com/json/' . $ip . '?key=SduzT5O3D4IUq1z&lang=' . explode( '_', get_locale() )[0], $args );

		if ( ! is_wp_error( $json ) ) {
			$query = json_decode( $json['body'] );
		}else{
			$query->city = '';
			$query->country = '';
			$query->countryCode = '';
			$query->isp = '';
		}

		if( $query && $query->status == 'success' ){
			$data['city']    = $query->city;
			$data['country'] = $query->country;
			$data['ccode']   = $query->countryCode;
			$data['isp']     = $query->isp;
		}





		if( is_user_logged_in() ){
			$user = wp_get_current_user();
			$roles = (array)$user->roles;
			$role = $roles[0];
		}else{
			$role = 'not_logged_in';
		}

		$data['role'] = $role;




		$data = array_map( 'mb_strtolower', $data );

		die( json_encode( array(
			'method' => $method,
			'data' => $data
		) ) );
	}
}