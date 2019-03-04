<?php
namespace CFX\Brokerage;

class ReleasesDSLQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testCanQueryBetaStartAndReleaseDates()
    {
        $now = date("%U");
        $q = ReleasesDSLQuery::parse("betaStartDate <= $now and releaseDate > $now");
        $this->assertEquals("`betaStartDate` <= ? and `releaseDate` > ?", $q->getWhere());
        $this->assertEquals([ $now, $now ], $q->getParams());
    }
}



