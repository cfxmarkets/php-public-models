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

    public function testOwnerEntity()
    {
        $field = 'ownerEntity';
        $this->assertValid($field, [ null ]);
        $this->assertChains($field, null);
    }
}

