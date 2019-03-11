<?php
namespace CFX\Brokerage;

class ReleasesDSLQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testCanQueryBetaStartAndReleaseDates()
    {
        $now = date("U");
        $nowDate = (new \DateTime("@$now"))->format("Y-m-d H:i:s");
        $q = ReleasesDSLQuery::parse("betaStartDate <= $now and releaseDate > $now");
        $this->assertEquals("`betaStartDate` <= ? and `releaseDate` > ?", $q->getWhere());
        $this->assertEquals([ $nowDate, $nowDate ], $q->getParams());
    }
}



