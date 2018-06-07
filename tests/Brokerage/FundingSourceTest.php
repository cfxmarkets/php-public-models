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

    public function testType()
    {
        // Can only test type on _receipt_ of resource from datasource
        $fundingSources = new \CFX\JsonApi\Test\MockDatasource();
        $fundingSources
            ->addClassToCreate("\\CFX\\Brokerage\\FundingSource")
            ->addClassToCreate("\\CFX\\Brokerage\\LegalEntity")
            ->setCurrentData([
                "type" => "funding-sources",
                "id" => "12345",
                "attributes" => [
                    "type" => "bank-accounts",
                    "availableBalance" => 50000,
                    "pendingBalance" => 3000,
                ],
                "relationships" => [
                    "ownerEntity" => [
                        "data" => [
                            "type" => "legal-entities",
                            "id" => "abcde",
                        ]
                    ]
                ]
            ])
        ;

        $fundingSource = $fundingSources->get("id=12345");
        $this->assertEquals("bank-accounts", $fundingSource->getType());
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

