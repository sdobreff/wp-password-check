<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use sdobreff\Helpers\LoginAttempts;

class UserMetaTest extends TestCase {

    public $testUserId;

    protected function setUp(): void {
        $this->testUserId = wp_create_user(
            'testingMeta',
            'testingMetaPAssword'
        );
    }

    /**
     * @covers LoginAttempts::getLoginAttempts
     */
    public function testInsert() {
        $user = new \WP_User( $this->testUserId );
        LoginAttempts::increaseLoginAttempts( $user );
        $this->assertTrue( 1 === LoginAttempts::getLoginAttempts( $user ) );
    }

    /**
     * @covers LoginAttempts::clearLoginAttempts
     */
    public function testRemove() {
        LoginAttempts::clearLoginAttempts( new \WP_User( $this->testUserId ) );
        $this->assertTrue( '' === \get_user_meta( $this->testUserId, LoginAttempts::META_KEY, true ) );
    }

    protected function tearDown(): void {
        require_once( ABSPATH . 'wp-admin/includes/user.php' );
        \wp_delete_user( $this->testUserId );
    }
}
