<?php 
namespace CFX\Brokerage;


class AddressTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;
    protected $className = "\\CFX\\Brokerage\\Address";

    public function testResourceType() {
        $this->assertEquals('addresses', $this->resource->getResourceType());
    }

    public function testLabel() {
        $this->assertValid("label", [null, '', "My Address"]);
    }

    public function testStreet1() {
        // Assert required
        $val = "";
        $this->resource->setStreet1($val);
        $this->assertTrue($this->resource->hasErrors('street1'));
        $this->assertEquals($val, $this->resource->getStreet1());

        $val = "555 N Address Pt.";
        $this->resource->setStreet1($val);
        $this->assertFalse($this->resource->hasErrors('street1'));
        $this->assertEquals($val, $this->resource->getStreet1());
    }

    public function testStreet2() {
        // Assert not required
        $val = "";
        $this->resource->setStreet2($val);
        $this->assertFalse($this->resource->hasErrors('street2'));
        $this->assertEquals($val, $this->resource->getStreet2());

        $val = "#5523";
        $this->resource->setStreet2($val);
        $this->assertFalse($this->resource->hasErrors('street2'));
        $this->assertEquals($val, $this->resource->getStreet2());
    }

    public function testCity() {
        // Assert required
        $val = "";
        $this->resource->setCity($val);
        $this->assertTrue($this->resource->hasErrors('city'));
        $this->assertEquals($val, $this->resource->getCity());

        $val = "Philadelphia";
        $this->resource->setCity($val);
        $this->assertFalse($this->resource->hasErrors('city'));
        $this->assertEquals($val, $this->resource->getCity());
    }

    public function testState() {
        // Assert required
        $val = "";
        $this->resource->setState($val);
        $this->assertTrue($this->resource->hasErrors('state'));
        $this->assertEquals($val, $this->resource->getState());

        $val = "PA";
        $this->resource->setState($val);
        $this->assertFalse($this->resource->hasErrors('state'));
        $this->assertEquals($val, $this->resource->getState());
    }

    public function testZip() {
        // Assert required
        $val = "";
        $this->resource->setZip($val);
        $this->assertTrue($this->resource->hasErrors('zip'));
        $this->assertEquals($val, $this->resource->getZip());

        $val = "6622ZD0";
        $this->resource->setZip($val);
        $this->assertFalse($this->resource->hasErrors('zip'));
        $this->assertEquals($val, $this->resource->getZip());
    }

    public function testCountry() {
        // Assert required
        $val = "";
        $this->resource->setCountry($val);
        $this->assertTrue($this->resource->hasErrors('country'));
        $this->assertEquals($val, $this->resource->getCountry());

        $val = "US";
        $this->resource->setCountry($val);
        $this->assertFalse($this->resource->hasErrors('country'));
        $this->assertEquals($val, $this->resource->getCountry());
    }

    public function testMeta() {
        $this->assertFalse($this->resource->hasErrors('meta'));
        $this->assertEquals(null, $this->resource->getMeta());

        $val = ["extra" => "some extra data"];
        $this->resource->setMeta($val);
        $this->assertFalse($this->resource->hasErrors('meta'));
        $this->assertEquals($val, $this->resource->getMeta());

        $val = "some extra data";
        $this->resource->setMeta($val);
        $this->assertTrue($this->resource->hasErrors('meta'));
        $this->assertEquals($val, $this->resource->getMeta());

        $val = '{"extra":"some extra data"}';
        $this->resource->setMeta($val);
        $this->assertFalse($this->resource->hasErrors('meta'));
        $this->assertEquals(["extra" => "some extra data"], $this->resource->getMeta());

        // Messed up json
        $val = '{"extra":some extra data"}';
        $this->resource->setMeta($val);
        $this->assertTrue($this->resource->hasErrors('meta'));
    }

    public function testIntegration() {
        $data = [
            "type" => "addresses",
            "attributes" => [
                "label" => "My Address",
                "street1" => "555 North Place",
                "street2" => "#2255",
                "city" => "Chicago",
                "state" => "IL",
                "zip" => "6622Z88",
                "country" => "US",
                "meta" => '{"extra":"some extra data"}',
            ],
        ];

        $address = new Address($this->datasource, $data);
        $this->assertFalse($address->hasErrors());
        $this->assertEquals(["extra" => "some extra data"], $address->getMeta());
        $this->assertEquals($data, $address->getChanges());
    }

    public function testMethodChaining() {
        $json = $this->resource
            ->setLabel('My Address')
            ->setStreet1('12345')
            ->setStreet2('#223')
            ->setCity('Philly')
            ->setState('CA')
            ->setZip('22222')
            ->setCountry('US')
            ->setMeta(['test' => 'value'])
            ->jsonSerialize();

        $this->assertEquals('12345', $json['attributes']['street1']);
    }
}

