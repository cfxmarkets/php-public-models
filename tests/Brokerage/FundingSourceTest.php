<?php
namespace CFX\Brokerage;

class FundingSourceTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\FundingSource";

    public function testResourceType()
    {
        $this->assertEquals('funding-sources', $this->resource->getResourceType());
    }

    public function testAvailableBalance()
    {
        $field = 'availableBalance';
        // Default is fine
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertReadOnly($field, 1122);
    }

    public function testPendingBalance()
    {
        $field = 'pendingBalance';
        // Default is fine
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertReadOnly($field, 1122);
    }

    public function testOwner()
    {
        $field = 'owner';
        $this->assertValid($field, [ new LegalEntity($this->datasource) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, (new LegalEntity($this->datasource))->setId("12345"), "relationships");
        $this->assertChains($field);
    }
}

