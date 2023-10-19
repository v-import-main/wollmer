<?php
/**
 * Plugin Name:       Disable Flamingo Addressbook
 * Plugin URI:        https://wordpress.org/plugins/disable-flamingo-addressbook/
 * Description:       With this plugin activated, Flamingo will not add any data to its address book.
 * Version:           1.0
 * Requires at least: 5.2
 * Author:            Christian Sabo
 * Author URI:        https://profiles.wordpress.org/pixelverbieger
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dfa
 * Domain Path:       /languages
 *
 * Props to Christoph Schuessler,
 * https://wordpress.org/support/users/herrschuessler/
 *
 *
 * Disable Flamingo Addressbook is free software:
 * you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Disable Flamingo Addressbook is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * To get a copy of the GNU General Public License
 * see http://www.gnu.org/licenses/gpl-2.0.txt.
 */

/*
 * If this file is called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) {
	die( 'Direct access is not allowed.' );
}

/*
 * When activating the plugin, nothing has to be done
 */

/*
 * When deactivating the plugin, nothing has to be done.
 */

/*
 * When deleting the plugin, nothing has to be done.
 */

/*
 * Main purpose: suppress entries to the Flamingo Addressbook
 */

function dfa_flamingo_add_contact( $args ) {
  return array(
    'email' => '',
    'name' => '',
    'props' => array(),
  );
}

remove_action( 'profile_update', 'flamingo_user_profile_update' );
remove_action( 'user_register', 'flamingo_user_profile_update' );
remove_action( 'wp_insert_comment', 'flamingo_insert_comment' );
remove_action( 'transition_comment_status', 'flamingo_transition_comment_status', 10 );

add_filter( 'flamingo_add_contact', 'dfa_flamingo_add_contact' );

?>