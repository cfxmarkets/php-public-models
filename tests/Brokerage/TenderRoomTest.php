<?php
namespace CFX\Brokerage;

class TenderRoomTest extends DealRoomTest
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\TenderRoom";

    public function testResourceType()
    {
        $this->assertEquals('tender-rooms', $this->resource->getResourceType());
    }


    public function testPurchaser()
    {
        $field = 'purchaser';
        $this->assertValid($field, [ new LegalEntity($this->datasource) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, new LegalEntity($this->datasource, [ 'id' => '12345' ]), 'relationships');
        $this->assertChains($field, null);
    }

    public function testTenders()
    {
        $field = 'tenders';
        $this->assertValid($field, [ new \CFX\JsonApi\ResourceCollection() ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, new \CFX\JsonApi\ResourceCollection(), 'relationships');
        $this->assertChains($field, null);

        $this->markTestIncomplete("Need to add tests for 'addTender', 'removeTender' and 'hasTender'");
    }
}



