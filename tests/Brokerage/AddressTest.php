<?php 
namespace CFX\Brokerage;


class AddressTest extends \PHPUnit\Framework\TestCase
{
    protected $datasource;
    protected $address;

    public function setUp() {
        $this->datasource = new \CFX\JsonApi\Test\MockDatasource();
        $this->address = new Address($this->datasource);
    }

    public function testResourceType() {
        $this->assertEquals('addresses', $this->address->getResourceType());
    }

    public function testLabel() {
        // Assert field required
        $this->assertTrue($this->address->hasErrors('label'));

        $val = "My Address";
        $this->address->setLabel($val);
        $this->assertFalse($this->address->hasErrors('label'));
        $this->assertEquals($val, $this->address->getLabel());
    }

    public function testStreet1() {
        // Assert required
        $val = "";
        $this->address->setStreet1($val);
        $this->assertTrue($this->address->hasErrors('street1'));
        $this->assertEquals($val, $this->address->getStreet1());

        $val = "555 N Address Pt.";
        $this->address->setStreet1($val);
        $this->assertFalse($this->address->hasErrors('street1'));
        $this->assertEquals($val, $this->address->getStreet1());
    }

    public function testStreet2() {
        // Assert not required
        $val = "";
        $this->address->setStreet1($val);
        $this->assertFalse($this->address->hasErrors('street2'));
        $this->assertEquals($val, $this->address->getStreet1());

        $val = "#5523";
        $this->address->setStreet2($val);
        $this->assertFalse($this->address->hasErrors('street2'));
        $this->assertEquals($val, $this->address->getStreet2());
    }

    public function testCity() {
        // Assert required
        $val = "";
        $this->address->setCity($val);
        $this->assertTrue($this->address->hasErrors('city'));
        $this->assertEquals($val, $this->address->getCity());

        $val = "Philadelphia";
        $this->address->setCity($val);
        $this->assertFalse($this->address->hasErrors('city'));
        $this->assertEquals($val, $this->address->getCity());
    }

    public function testState() {
        // Assert required
        $val = "";
        $this->address->setState($val);
        $this->assertTrue($this->address->hasErrors('state'));
        $this->assertEquals($val, $this->address->getState());

        $val = "PA";
        $this->address->setState($val);
        $this->assertFalse($this->address->hasErrors('state'));
        $this->assertEquals($val, $this->address->getState());
    }

    public function testZip() {
        // Assert required
        $val = "";
        $this->address->setZip($val);
        $this->assertTrue($this->address->hasErrors('zip'));
        $this->assertEquals($val, $this->address->getZip());

        $val = "6622ZD0";
        $this->address->setZip($val);
        $this->assertFalse($this->address->hasErrors('zip'));
        $this->assertEquals($val, $this->address->getZip());
    }

    public function testCountry() {
        // Assert required
        $val = "";
        $this->address->setCountry($val);
        $this->assertTrue($this->address->hasErrors('country'));
        $this->assertEquals($val, $this->address->getCountry());

        $val = "US";
        $this->address->setCountry($val);
        $this->assertFalse($this->address->hasErrors('country'));
        $this->assertEquals($val, $this->address->getCountry());
    }

    public function testMeta() {
        $this->assertFalse($this->address->hasErrors('meta'));
        $this->assertEquals(null, $this->address->getMeta());

        $val = ["extra" => "some extra data"];
        $this->address->setMeta($val);
        $this->assertFalse($this->address->hasErrors('meta'));
        $this->assertEquals($val, $this->address->getMeta());

        $val = "some extra data";
        $this->address->setMeta($val);
        $this->assertTrue($this->address->hasErrors('meta'));
        $this->assertEquals($val, $this->address->getMeta());

        $val = '{"extra":"some extra data"}';
        $this->address->setMeta($val);
        $this->assertFalse($this->address->hasErrors('meta'));
        $this->assertEquals(["extra" => "some extra data"], $this->address->getMeta());

        // Messed up json
        $val = '{"extra":some extra data"}';
        $this->address->setMeta($val);
        $this->assertTrue($this->address->hasErrors('meta'));
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
        $json = $this->address
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

