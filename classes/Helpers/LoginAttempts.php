<?php
declare(strict_types=1);

/**
 * Plugin WP Password Check class.
 *
 * @package   sdobreff
 * @author    Stoil Dobreff
 * @copyright Copyright © 2021
 */

namespace sdobreff\Helpers;

class LoginAttempts {

    /**
     * Meta key name
     */
    const META_KEY = 'LoginAttempts';

    /**
     * How many times the user is allowed to try to login before sending email to admin
     *
     * @var integer
     */
    private static $allowedAttempts = 3;

    /**
     * Increasing login attempts
     *
     * @param \WP_User $user
     *
     * @return void
     */
    public static function increaseLoginAttempts( \WP_User $user ): void {
        $attempts = \get_user_meta( $user->ID, self::META_KEY, true );
        if ( '' === $attempts ) {
            $attempts = 0;
        }
        \update_user_meta( $user->ID, self::META_KEY, ++$attempts );
    }

    /**
     * Returns the number of unsuccessful attempts for the customer
     *
     * @param \WP_User $user
     *
     * @return integer
     */
    public static function getLoginAttempts( \WP_User $user ): int {
        $attempts = \get_user_meta( $user->ID, self::META_KEY, true );

        return (int) $attempts;
    }

    /**
     * Clearing login attempts
     *
     * @param \WP_User $user
     *
     * @return void
     */
    public static function clearLoginAttempts( \WP_User $user ): void {
        \delete_user_meta( $user->ID, self::META_KEY );
    }

    /**
     * Returns the number of the allowed attempts
     *
     * @return integer
     */
    public static function getAllowdAttempts(): int {
        $attempts = get_option( WPPCHCK__PLUGIN_NUMBER_ATTEMPTS, false );

        if ( ! $attempts ) {
            $attempts = self::$allowedAttempts;
        }

        return (int) $attempts;
    }
}
