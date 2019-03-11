<?php
namespace CFX\Brokerage;

class ContractsDSLQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testNormalParse()
    {
        $q = ContractsDSLQuery::parse("contractType=ofn-tos and audience & 1 and effectiveDate < 1552058773");
        $this->assertEquals("ofn-tos", $q->getContractType());
        $this->assertEquals("1", $q->getAudience());
        $this->assertEquals("1552058773", $q->getEffectiveDate());
        $this->assertTrue($q->includes("contractType"));
        $this->assertTrue($q->includes("audience"));
        $this->assertTrue($q->includes("effectiveDate"));
    }

    public function testCollectionDetection()
    {
        $q = ContractsDSLQuery::parse("contractType=ofn-tos");
        $this->assertTrue($q->requestingCollection());

        $q = ContractsDSLQuery::parse("audience & 1");
        $this->assertTrue($q->requestingCollection());

        $q = ContractsDSLQuery::parse("effectiveDate < 1552058773");
        $this->assertTrue($q->requestingCollection());

        $q = ContractsDSLQuery::parse("contractType=ofn-tos and audience & 1");
        $this->assertTrue($q->requestingCollection());

        $q = ContractsDSLQuery::parse("contractType=ofn-tos and effectiveDate < 1552058773");
        $this->assertTrue($q->requestingCollection());

        $q = ContractsDSLQuery::parse("audience & 1 and effectiveDate < 1552058773");
        $this->assertTrue($q->requestingCollection());

        $q = ContractsDSLQuery::parse("contractType=ofn-tos and audience & 1 and effectiveDate < 1552058773");
        $this->assertTrue($q->requestingCollection());

        $q = ContractsDSLQuery::parse("id=aaaabbbbccccdddd");
        $this->assertFalse($q->requestingCollection());
    }

    public function testLatest()
    {
        $q = ContractsDSLQuery::parse("contractType=ofn-tos and effectiveDate = latest");
        $this->assertFalse($q->requestingCollection());

        $q = ContractsDSLQuery::parse("audience & 1 and effectiveDate = latest");
        $this->assertTrue($q->requestingCollection());

        $q = ContractsDSLQuery::parse("effectiveDate = latest");
        $this->assertTrue($q->requestingCollection());
    }
}


