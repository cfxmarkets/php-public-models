<?php
namespace CFX\Brokerage;

class ContractTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\Contract";

    public function testResourceType()
    {
        $this->assertEquals("contracts", $this->resource->getResourceType());
    }

    public function testAudience()
    {
        $field = "audience";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ 1, 2, 3 ]);
        $this->assertInvalid($field, [ null, "", 0, 4, 8, 16, 32, 64, 1000000, true, false, "some string", new \DateTime(), [] ]);
        $this->assertChanged($field, 1, "attributes");
        $this->assertChains($field);
    }

    public function testEffectiveDate()
    {
        $field = "effectiveDate";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->_testDateField($field, true);
    }

    public function testContractType()
    {
        $field = "contractType";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, Contract::getAvailableContractTypes());
        $this->assertInvalid($field, [ 4, 1000000, true, false, "some string", new \DateTime(), [] ]);
        $this->assertChanged($field, "ofn-tos", "attributes");
        $this->assertChains($field);
    }

    public function testUrl()
    {
        $field = "url";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ "/some-place", "//openfinance.io/terms-of-service", "https://s3.amazon.com/12345534343/baddd334234343" ]);
        $this->assertInvalid($field, [ 1, true, false, "some string", new \DateTime(), [] ]);
        $this->assertChanged($field, "/terms-of-service", "attributes");
        $this->assertChains($field);
    }

    public function testChangelog()
    {
        $field = "changelog";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "{}", '{"some":"changes"}', ["some" => "changes"] ], function($expected, $actual) {
            if ($expected === "") {
                $this->assertNull($actual, "Inputting blank string should produce null value");
            } elseif (is_string($expected)) {
                $this->assertEquals(json_decode($expected, true), $actual, "Should decode strings and store as array");
            } else {
                $this->assertEquals($expected, $actual, "Should store arrays natively");
            }
        });
        $this->assertInvalid($field, [ 4, true, false, "some string", new \DateTime() ]);
        $this->assertChanged($field, ["more" => "changes"], "attributes");
        $this->assertChains($field);
    }
}

