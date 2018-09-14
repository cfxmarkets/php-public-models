<?php
namespace CFX\Brokerage;

class FundingInterfacesDSLQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testFundingSourceId()
    {
        $q = FundingInterfacesDSLQuery::parse("fundingSourceId=abcde12345");
        $this->assertTrue($q->requestingCollection());
        $this->assertEquals("abcde12345", $q->getFundingSourceId());
        $this->assertTrue($q->includes("fundingSourceId"));
    }
}
