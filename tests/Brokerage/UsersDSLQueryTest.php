<?php
namespace CFX\Brokerage;

class UsersDSLQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testCanQueryEmailOrAuthId()
    {
        $q = UsersDSLQuery::parse("email=test-user.me+you12345@cfxtrading.com or authId=aaa-bbbbcccc-dddee111-2222333-444455");
        $this->assertEquals("`bf_users`.`email` = ? or `authId` = ?", $q->getWhere());
        $this->assertEquals([ "test-user.me+you12345@cfxtrading.com", "aaa-bbbbcccc-dddee111-2222333-444455" ], $q->getParams());
    }
}


