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

/**
 * Sends notification email to the site admin
 */
class NotifyAdmin {

    public static function sendNotificationEmail( \WP_User $user, int $attempts ): bool {
        $url = get_site_url( get_current_blog_id() );

        $to = get_option( 'admin_email' );

        $attemptsText = 'attempt';
        if ( 1 > $attempts ) {
            $attemptsText .= 's';
        }

        $subject = "Maximum number of unsuccessful login {$attemptsText} reached";

        $message = "User {$user->display_name} has tried to log in with an unsuitable password too many times to your site {$url}.\nThe system has identified {$attempts} unsuccessful login {$attemptsText}.";

        return wp_mail( $to, $subject, $message );
    }
}
