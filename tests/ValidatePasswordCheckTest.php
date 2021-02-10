<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use sdobreff\Helpers\ValidatePassword;
/**
 * @coversDefaultClass sdobreff\Helpers\ValidatePassword
 */
class ValidatePasswordCheckTest extends TestCase {

    /**
     * Empty password
     */
    public function testEmpty() {
        $this->assertFalse( ValidatePassword::validate( '' ) );
    }

    /**
     * Less than 16 symbols
     */
    public function testUnder16() {
        $this->assertFalse( ValidatePassword::validate( '1234A"' ) );
    }

    /**
     * Valid password 16 characters
     */
    public function test16() {
        $this->assertTrue( ValidatePassword::validate( 'Ajkhkjk8lk-|lk)"' ) );
    }

    /**
     * Contains only digits
     */
    public function testOnlyDigits() {
        $this->assertFalse( ValidatePassword::validate( '2134543655465465' ) );
    }

    /**
     * Contains only special symbols
     */
    public function testOnlySpecialSymbols() {
        $this->assertFalse( ValidatePassword::validate( '-|^"#[]()"#[]("#[](' ) );
    }

    /**
     * No uppercase char
     */
    public function testNoUpperCase() {
        $this->assertFalse( ValidatePassword::validate( 'kjkhkjkjkjkjkjkjh8lk-|lk)' ) );
    }

    /**
     * No lower case char
     */
    public function testNoLowerCase() {
        $this->assertFalse( ValidatePassword::validate( 'ASADDGDSGHDSDGHDS8LK-|LK)' ) );
    }

    /**
     * No integer
     */
    public function testNoInt() {
        $this->assertFalse( ValidatePassword::validate( 'Ajkhkjkjkjkjkjkjhklk-|lk)' ) );
    }

    /**
     * Valid password more than 16 characters
     */
    public function testValid() {
        $this->assertTrue( ValidatePassword::validate( 'Ajkhkjkjkjkjkjkjhk8lk-|lk)' ) );
    }
}
