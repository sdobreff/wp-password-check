<?php
declare(strict_types=1);

/**
 * Plugin WP Password Check class.
 *
 * @package   sdobreff
 * @author    Stoil Dobreff
 * @copyright Copyright © 2021
 */

namespace sdobreff\Views;

use sdobreff\Helpers\LoginAttempts;

/**
 * Class responsible for showing the setting in the admin section
 */
class AdminSettingsView {

    /**
     * Shows the admin page
     *
     * @return void
     */
    public static function adminSettings(): void {
        ?>
            <div class="wrap">
                <div id="icon-themes" class="icon32"></div>
                <h2><?php echo WPPCHCK__PLUGIN_NAME; ?></h2>
                <form method="POST" action="options.php">
                    <?php
                        settings_fields( 'wppchck_general_settings' );

                        do_settings_sections( 'wppchck_general_settings' );

                        submit_button();
                    ?>
                </form>
            </div>
        <?php
    }

    /**
     * Registering the admin fields and renders them
     *
     * @return void
     */
    public static function registerAndBuildFields(): void {
        /**
         * First, we add_settings_section. This is necessary since all future settings must belong to one.
         * Second, add_settings_field
         * Third, register_setting
         */
        add_settings_section(
            'wppchck_general_section',
            '',
            [ 'sdobreff\\Views\\AdminSettingsView', 'getDescription' ],
            'wppchck_general_settings'
        );
        unset( $args );
        $args = [
            'type'     => 'input',
            'subtype'  => 'text',
            'id'       => WPPCHCK__PLUGIN_NUMBER_ATTEMPTS,
            'name'     => WPPCHCK__PLUGIN_NUMBER_ATTEMPTS,
            'required' => 'true',
        ];
        add_settings_field(
            WPPCHCK__PLUGIN_NUMBER_ATTEMPTS,
            'Number of attempts before notifying the admin',
            [ 'sdobreff\\Views\\AdminSettingsView', 'renderSettingsField' ],
            'wppchck_general_settings',
            'wppchck_general_section',
            $args
        );

        register_setting(
            'wppchck_general_settings',
            WPPCHCK__PLUGIN_NUMBER_ATTEMPTS,
            [ 'sdobreff\\Views\\AdminSettingsView', 'validateAttempts' ]
        );
    }

    /**
     * Shows admin page description
     *
     * @return void
     */
    public static function getDescription(): void {
        echo '<p>Settings for ' . WPPCHCK__PLUGIN_NAME . ' functionality.</p>';
    }

    /**
     * Renders input field for the admin menu
     *
     * @param array $args
     *
     * @return void
     */
    public static function renderSettingsField( array $args ): void {
        $attempts = LoginAttempts::getAllowdAttempts();

        echo "<input name='{$args['name']}' id='{$args['id']}' type='{$args['id']}' value='{$attempts}' />";
    }

    /**
     * Validation for the Attempts field
     *
     * @param various $input
     *
     * @return integer
     */
    public static function validateAttempts( $input ): int {
        $options = [
            'options' => [
                'default'   => LoginAttempts::getAllowdAttempts(),
                'min_range' => 1,
            ],
        ];

        $var = filter_var( $input, FILTER_VALIDATE_INT, $options );

        if ( ! $var ) {
            $input = LoginAttempts::getAllowdAttempts();
        }

        return (int) $input;
    }
}
