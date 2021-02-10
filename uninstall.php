<?php

use sdobreff\Helpers\LoginAttempts;
/**
 * Fired when the plugin is uninstalled.
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

define( 'WPPCHCK__PLUGIN_NUMBER_ATTEMPTS', 'wppchck_attempts' );
require __DIR__ . '/vendor/autoload.php';

/**
 * Removes the plugin option
 * Removes meta from all the users
 *
 * @return void
 */
function uninstallWPPasswordCheck() {
    delete_option( WPPCHCK__PLUGIN_NUMBER_ATTEMPTS );

    $users = get_users();

    foreach ( $users as $user ) {
        delete_user_meta( $user->ID, LoginAttempts::META_KEY );
    }
}
uninstallWPPasswordCheck();
