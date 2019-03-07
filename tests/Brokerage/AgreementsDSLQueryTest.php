<?php
namespace CFX\Brokerage;

class AgreementsDSLQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testNormalParse()
    {
        $q = AgreementsDSLQuery::parse("entityId=abcde12345 and contractId=aaaaaaaa and signerId=bbbbbbbb");
        $this->assertFalse($q->requestingCollection());
        $this->assertEquals("abcde12345", $q->getEntityId());
        $this->assertEquals("aaaaaaaa", $q->getContractId());
        $this->assertEquals("bbbbbbbb", $q->getSignerId());
        $this->assertTrue($q->includes("entityId"));
        $this->assertTrue($q->includes("contractId"));
        $this->assertTrue($q->includes("signerId"));
    }

    public function testCollectionDetection()
    {
        $q = AgreementsDSLQuery::parse("entityId=abcde12345");
        $this->assertTrue($q->requestingCollection());

        $q = AgreementsDSLQuery::parse("contractId=abcde12345");
        $this->assertTrue($q->requestingCollection());

        $q = AgreementsDSLQuery::parse("signerId=abcde12345");
        $this->assertTrue($q->requestingCollection());

        $q = AgreementsDSLQuery::parse("signerId=abcde12345 and contractId=aaaaaaaaa");
        $this->assertTrue($q->requestingCollection());

        $q = AgreementsDSLQuery::parse("signerId=abcde12345 and entityId=aaaaaa");
        $this->assertTrue($q->requestingCollection());

        $q = AgreementsDSLQuery::parse("entityId=abcde12345 and contractId=aaaaaaaa");
        $this->assertTrue($q->requestingCollection());

        $q = AgreementsDSLQuery::parse("entityId=abcde12345 and signerId=aaaaaaa and contractId=aaaaaaaa");
        $this->assertFalse($q->requestingCollection());
    }
}

