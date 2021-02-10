<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use sdobreff\Helpers\NotifyAdmin;

class NotifyAdminTest extends TestCase {

    public $testUserId;

    protected function setUp(): void {
        $this->testUserId = wp_create_user(
            'testingMeta',
            'testingMetaPAssword'
        );
    }

    /**
     * @covers NotifyAdmin::sendNotificationEmail
     */
    public function testSendAdminMail() {
        $user = new \WP_User( $this->testUserId );
        $this->assertTrue( NotifyAdmin::sendNotificationEmail( $user, 1 ) );
    }

    protected function tearDown(): void {
        require_once( ABSPATH . 'wp-admin/includes/user.php' );
        \wp_delete_user( $this->testUserId );
    }
}
