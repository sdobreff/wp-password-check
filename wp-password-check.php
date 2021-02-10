<?php
/**
 * Plugin Name: WP Password Check
 * Plugin URI: https://github.com/sdobreff
 * Description: Checking strength of given password
 * Version: 0.0.1
 * Author: Stoil Dobreff
 * Author URI: https://github.com/sdobreff
 * Text Domain: wp-password-check
 * Domain Path: languages/
 * License: GPL2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

/** Prevent default call */
if ( ! function_exists( 'add_action' ) ) {
    exit;
}

define( 'REQUIRED_PHP_VERSION', '7.3' );
define( 'REQUIRED_WP_VERSION', '5.0' );
define( 'WPPCHCK__PLUGIN_VERSION', '0.0.1' );
define( 'WPPCHCK__PLUGIN_NAME', 'WP Password Check' );
define( 'WPPCHCK__PLUGIN_SLUG', 'wp-password-check' );
define( 'WPPCHCK__PLUGIN_NUMBER_ATTEMPTS', 'wppchck_attempts' );

require __DIR__ . '/vendor/autoload.php';

add_action( 'init', [ 'sdobreff\WPPasswordCheck', 'init' ] );
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), [ 'sdobreff\\WPPasswordCheck', 'addActionLinks' ] );

register_activation_hook( __FILE__, [ 'sdobreff\\WPPasswordCheck', 'pluginActivation' ] );
