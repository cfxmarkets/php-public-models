<?php
namespace CFX\Brokerage;

class FundingInterfaceTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\FundingInterface";

    public function testResourceType()
    {
        $this->assertEquals('funding-interfaces', $this->resource->getResourceType());
    }

    public function testLabel()
    {
        $field = 'label';
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "0", 1234, "my label", "wire" ]);
        $this->assertInvalid($field, [ true, false, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, "ach", "attributes");
        $this->assertChains($field);
    }

    public function testUri()
    {
        $field = 'uri';
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ "ach://synapse/123456789/1222233", "wire://synapse/1111111111/22222223", "p2p://ethereum/0x123444444444444444444444444444" ]);
        $this->assertInvalid($field, [ null, "", 0, 2345, true, false, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, "p2p://bitcoin/0x3123444444444444", "attributes");
        $this->assertChains($field);
    }

    public function testFundingSource()
    {
        $field = 'fundingSource';
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ new FundingSource($this->datasource, [ "id" => "abcde12345" ]) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, new FundingSource($this->datasource, [ "id" => "12345abcde" ]), "relationships");
        $this->assertChains($field);
    }
}


