<?php
declare(strict_types=1);

/**
 * Plugin WP Password Check class.
 *
 * @package   sdobreff
 * @author    Stoil Dobreff
 * @copyright Copyright © 2021
 */

namespace sdobreff;

use sdobreff\{
            Views\AdminSettingsView,
        };

class WPPasswordCheck {

    /**
     * Sets all the necessary hooks and creates the tables if needed
     *
     * @since 0.0.1
     *
     * @return void
     */
    public static function init() {
        self::initHooks();
    }

    /**
     * Adds settings link
     *
     * @since 0.0.1
     *
     * @param [type] $links
     *
     * @return array
     */
    public static function addActionLinks( array $links ): array {
        $newLinks = [
            '<a href="' . admin_url( 'options-general.php?page=' . WPPCHCK__PLUGIN_SLUG ) . '">' . 'Settings' . '</a>',
        ];
        return array_merge( $links, $newLinks );
    }

    /**
     * Checks for the minimum requirements and bails if they are not met
     *
     * @since 0.0.1
     *
     * @return void
     */
    public static function pluginActivation() {
        global $wpdb;

        // Minimum PHP version check
        if ( version_compare( phpversion(), REQUIRED_PHP_VERSION, '<' ) ) {

            // Plugin not activated info message.
            ?>
                <div class="update-nag">
                    <?php echo 'You need to update your PHP version to ' . REQUIRED_PHP_VERSION . '.'; ?> <br />
                    <?php echo 'Actual version is:'; ?> <strong><?php echo phpversion(); ?></strong>
                </div>
            <?php

            exit;
        }

        // Minimum WP version check
        if ( version_compare( $GLOBALS['wp_version'], REQUIRED_WP_VERSION, '<' ) ) {

            // Plugin not activated info message.
            ?>
                <div class="update-nag">
                    <?php echo 'You need to update your WP version to ' . REQUIRED_WP_VERSION . '.'; ?> <br />
                    <?php echo 'Actual version is:'; ?> <strong><?php echo $GLOBALS['wp_version']; ?></strong>
                </div>
            <?php

            exit;
        }
    }

    /**
     * Adds settings page to the admin menu
     *
     * @since 0.0.1
     *
     * @return void
     */
    public static function settingsPage() {
        add_options_page( WPPCHCK__PLUGIN_NAME . ' settings', WPPCHCK__PLUGIN_NAME, 'manage_options', WPPCHCK__PLUGIN_SLUG, [ 'sdobreff\\WPPasswordCheck', 'renderPluginSettingsPage' ] );
    }

    /**
     * Responsible for rendering the admin settings page
     *
     * @since 0.0.1
     *
     * @return void
     */
    public static function renderPluginSettingsPage() {
        AdminSettingsView::adminSettings();
    }

    /**
     * Print Admin Notices
     *
     * @since    1.0.0
     *
     * @return string
     */
    public static function printPluginAdminNotices(): string {
        if ( isset( $_REQUEST['wppchck_admin_add_notice'] ) ) {
            if ( 'success' === $_REQUEST['wppchck_admin_add_notice'] ) {
                $html = '<div class="notice notice-success is-dismissible">
                            <p><strong>The request was successful. </strong></p><br>';
                echo $html;
            }
        } else {
            return '';
        }
    }

    /**
     * Inits all the hooks the plugin will use
     *
     * @since    1.0.0
     *
     * @return void
     */
    private static function initHooks() {
        // Settings Related actions
        add_action( 'admin_menu', [ 'sdobreff\\WPPasswordCheck', 'settingsPage' ] );
        add_action( 'admin_init', [ 'sdobreff\\Views\\AdminSettingsView', 'registerAndBuildFields' ] );

        // Register admin notices
        add_action( 'admin_notices', [ 'sdobreff\\WPPasswordCheck', 'printPluginAdminNotices' ] );

        // Checking customer after successfull login
        add_filter( 'authenticate', [ 'sdobreff\\Controllers\\LoginCheck', 'check' ], 21, 3 );
    }
}
