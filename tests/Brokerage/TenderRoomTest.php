<?php
namespace CFX\Brokerage;

class TenderRoomTest extends DealRoomTest
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\Test\\TenderRoom";

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
        $this->assertChanged($field, new \CFX\JsonApi\ResourceCollection([ new Tender($this->datasource, ['id' => '12345']) ]), 'relationships');
        $this->assertChains($field, null);
    }

    public function testTendersExtended()
    {
        $tender = new Tender($this->datasource, ['id'=>'12345']);
        $this->resource->addTender($tender);

        $this->assertInstanceOf("\\CFX\\JsonApi\\ResourceCollectionInterface", $this->resource->getTenders());
        $this->assertEquals(1, count($this->resource->getTenders()));
        $this->assertInstanceOf("\\CFX\\Brokerage\\TenderInterface", $this->resource->getTenders()[0]);

        $this->assertTrue($this->resource->hasTender($tender));
        $this->assertFalse($this->resource->hasTender(new Tender($this->datasource, ['id'=>'67890'])));

        $this->resource->removeTender($tender);

        $this->assertInstanceOf("\\CFX\\JsonApi\\ResourceCollectionInterface", $this->resource->getTenders());
        $this->assertFalse($this->resource->hasTender($tender));
        $this->assertEquals(0, count($this->resource->getTenders()));
    }
}



