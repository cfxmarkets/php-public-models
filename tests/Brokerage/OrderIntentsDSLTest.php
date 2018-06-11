<?php
namespace CFX\Brokerage;

class OrderIntentsDSLTest extends \PHPUnit\Framework\TestCase
{
    public function testStatusQueries()
    {
        $q = OrderIntentsDSLQuery::parse("userId=abcde12345 and status < listed");
        $this->assertEquals("`user_guid` = ? and `lead_status` in (?, ?, ?, ?, ?)", $q->getWhere());
        $this->assertEquals([ "abcde12345", "new", "picked-up", "reviewing", "hold", "pending" ], $q->getParams());

        $q = OrderIntentsDSLQuery::parse("userId=abcde12345 and status <= listed");
        $this->assertEquals("`user_guid` = ? and `lead_status` in (?, ?, ?, ?, ?, ?)", $q->getWhere());
        $this->assertEquals([ "abcde12345", "new", "picked-up", "reviewing", "hold", "pending", "listed" ], $q->getParams());

        $q = OrderIntentsDSLQuery::parse("userId=abcde12345 and status > listed");
        $this->assertEquals("`user_guid` = ? and `lead_status` in (?, ?, ?, ?, ?, ?, ?)", $q->getWhere());
        $this->assertEquals([ "abcde12345", "sold", "sold_closed", "sold_closed_paid", "expired", "cancelled", "expected", "sent" ], $q->getParams());

        $q = OrderIntentsDSLQuery::parse("userId=abcde12345 and status >= listed");
        $this->assertEquals("`user_guid` = ? and `lead_status` in (?, ?, ?, ?, ?, ?, ?, ?)", $q->getWhere());
        $this->assertEquals([ "abcde12345", "listed", "sold", "sold_closed", "sold_closed_paid", "expired", "cancelled", "expected", "sent" ], $q->getParams());

        $q = OrderIntentsDSLQuery::parse("userId=abcde12345 and status = listed");
        $this->assertEquals("`user_guid` = ? and `lead_status` = ?", $q->getWhere());
        $this->assertEquals([ "abcde12345", "listed" ], $q->getParams());

    }
}

