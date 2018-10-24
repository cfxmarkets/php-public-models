<?php
namespace CFX\Brokerage;

class FundingSourceTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\Test\\FundingSource";

    public function testResourceType()
    {
        $this->assertEquals('funding-sources', $this->resource->getResourceType());
    }

    public function testStatus()
    {
        $field = "status";
        $this->assertInstantiatesValidly($field);
        $this->assertReadOnly($field, 2);
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

    public function testFundingInterfaces() {
        $field = "fundingInterfaces";

        // Assert field NOT required
        $this->assertFalse($this->resource->hasErrors("fundingInterfaces"));

        $val = new \CFX\JsonApi\ResourceCollection();
        $this->datasource->setRelated("fundingInterfaces", $val);

        $this->resource->forceSetFundingInterfaces($val);
        $this->assertFalse($this->resource->hasErrors("fundingInterfaces"));
        $this->assertEquals($val, $this->resource->getFundingInterfaces());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains("fundingInterfaces", array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships']["fundingInterfaces"]->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->forceSetFundingInterfaces($val));

        // AddFundingInterface
        $fundingInterface = new FundingInterface($this->datasource);
        $this->resource->addFundingInterface($fundingInterface);
        $this->assertFalse($this->resource->hasErrors("fundingInterfaces"));
        $this->assertEquals(1, count($this->resource->getFundingInterfaces()));

        // HasFundingInterface
        $this->assertTrue($this->resource->hasFundingInterface($fundingInterface));

        // RemoveFundingInterface
        $this->resource->removeFundingInterface($fundingInterface);
        $this->assertFalse($this->resource->hasErrors("fundingInterfaces"));
        $this->assertEquals(0, count($this->resource->getFundingInterfaces()));
    }

}

