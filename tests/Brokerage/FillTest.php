<?php
namespace CFX\Brokerage;

class FillTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\Fill";

    public function testResourceType()
    {
        $this->assertEquals('fills', $this->resource->getResourceType());
    }

    public function testSide() {
        $field = 'side';
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ 'buy', 'sell' ]);
        $this->assertInvalid($field, [ null, '', "not-buy", new \DateTime(), 2.5, [ "array of values" ] ]);
        $this->assertChanged($field, 'buy', "attributes");
        $this->assertChains($field);
    }

    public function testLotSize()
    {
        $field = 'lotSize';
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ "12345", 11111, 2222.51 ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, 5522, "attributes");
        $this->assertChains($field);
    }

    public function testPrice()
    {
        $field = 'price';
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ 2.15, "2.22", 2 ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime(), "bunk", [ "array of values" ] ]);
        $this->assertChanged($field, 2.10, "attributes");
        $this->assertChains($field);
    }

    public function testFees()
    {
        $field = 'fees';
        $this->assertReadOnly($field);
        $this->assertChains($field);
    }

    public function testStatus()
    {
        $field = "status";
        $this->assertReadOnly($field);
        $this->assertChains($field);
    }

    public function testTimestamp()
    {
        $field = "timestamp";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ time()+60, time()-3600, (string)(time()-5), new \DateTime() ], function($expected, $actual) {
            if ($expected instanceof \DateTime) {
                $expected = $expected->format("U");
            }
            $this->assertEquals($expected, $actual);
        });
        $this->assertInvalid($field, [ null, '', time()-(60*60*24*365*101), time()+3600, "bunk", [ "array of values" ] ]);
        $this->assertChanged($field, time()-15, "attributes");
        $this->assertChains($field);
    }

    public function testOrder()
    {
        $field = "order";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ (new \CFX\Exchange\Order($this->datasource))->setId("12345") ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, (new \CFX\Exchange\Order($this->datasource))->setId("65432"), "relationships");
        $this->assertChains($field, null);
    }

    public function testSecurity()
    {
        $field = "security";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ (new \CFX\Exchange\Asset($this->datasource))->setId("INVT001") ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, (new \CFX\Exchange\Asset($this->datasource))->setId("BCAP"), "relationships");
        $this->assertChains($field, null);
    }
}

