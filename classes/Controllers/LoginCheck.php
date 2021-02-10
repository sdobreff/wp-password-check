<?php
declare(strict_types=1);

/**
 * Plugin WP Password Check class.
 *
 * @package   sdobreff
 * @author    Stoil Dobreff
 * @copyright Copyright © 2021
 */

namespace sdobreff\Controllers;

use sdobreff\Helpers\{
    LoginAttempts,
    ValidatePassword,
    NotifyAdmin,
};

/**
 * Checks user input after user login
 */
class LoginCheck {

    /**
     * Checks the user password strength
     *
     * @param \WP_USER $user
     * @param string $username
     * @param string $password
     *
     * @return void
     */
    public static function check( $user, $username, $password ) {
        if ( null === $user || is_wp_error( $user ) ) {
            // not a valid user - nothing to do here
            return;
        }

        if ( false === ValidatePassword::validate( (string) $password ) ) {
            LoginAttempts::increaseLoginAttempts( $user );

            $score = ValidatePassword::checkPasswordStrengthScore( (string) $password );

            $error = new \WP_Error(
                'authentication_failed',
                sprintf(
                    __( '<strong>Error</strong>: Your password is not strong enough, it has a score of %d. Please change it to be allowed to log in again.', 'wp-password-check' ),
                    $score
                )
            );

            do_action( 'wp_login_failed', $username, $error );

            $attempts = LoginAttempts::getLoginAttempts( $user );

            if ( $attempts >= LoginAttempts::getAllowdAttempts() ) {
                NotifyAdmin::sendNotificationEmail( $user, $attempts );
            }

            return $error;
        } else {
            LoginAttempts::clearLoginAttempts( $user );
        }

        return $user;
    }
}
