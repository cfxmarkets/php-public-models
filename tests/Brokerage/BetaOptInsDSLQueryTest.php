<?php
namespace CFX\Brokerage;

class BetaOptInsDSLQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testCanQueryReleases()
    {
        $q = BetaOptInsDSLQuery::parse("releaseId = 'test-release-1234' and userId = '1234'");
        $this->assertEquals("`releaseId` = ? and `userId` = ?", $q->getWhere());
        $this->assertEquals([ "test-release-1234", "1234" ], $q->getParams());
    }
}




