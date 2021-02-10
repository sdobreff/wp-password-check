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

use ZxcvbnPhp\Zxcvbn;

/**
 * Responsible for proper Password Validation
 */
class ValidatePassword {

    /**
     * Valid password regular expression string
     *
     * @var string
     */
    private static $validRE = '/(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!\"#$%&\'\(\'\)* ,\-.\/\:;<=>\?@\[\\\\\]\^_`\{\|\}~])[A-Za-z\d!\"#$%&\'\(\)* ,\-.\/\:;<=>\?@\[\\\\\]\^_`\{\|\}~\"]{16,}/m';

    /**
     * Validates string against password validation expression
     *
     * @param string $password
     *
     * @return boolean
     */
    public static function validate( string $password ): bool {
        $retVal = false;

        if ( '' !== trim( $password ) ) {
            if ( 1 === \preg_match( self::$validRE, $password ) ) {
                $retVal = true;
            }
        }
        return $retVal;
    }

    /**
     * Gets password strength score
     *
     * @param string $password
     *
     * @return integer
     */
    public static function checkPasswordStrengthScore( $password ): int {
        $zxcvbn = new Zxcvbn();

        $score = $zxcvbn->passwordStrength( $password );

        return $score['score'];
    }
}
