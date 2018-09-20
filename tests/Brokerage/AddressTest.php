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
        $field = "street1";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ "555 N Address Pt.", "5 N. Main St." ]);
        $this->assertInvalid($field, [ null, "", 12345, new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "123 W Kinzie St", "attributes");
        $this->assertChains($field);
    }

    public function testStreet2() {
        $field = "street2";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "123", "#4242", "Apt. 55" ]);
        $this->assertInvalid($field, [ new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "Atp. 110", "attributes");
        $this->assertChains($field);
    }

    public function testCity() {
        $field = "city";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ "Philadelphia", "Potosí" ]);
        $this->assertInvalid($field, [ null, "", new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "Guadalajara", "attributes");
        $this->assertChains($field);
    }

    public function testState() {
        $field = "state";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "AL", "Berlin" ]);
        $this->assertInvalid($field, [ 12345, new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "IL", "attributes");
        $this->assertChains($field);
    }

    public function testZip() {
        $field = "zip";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ "1123", "60654", "60654-1234", "6622ZD0" ]);
        $this->assertInvalid($field, [ null, "", new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "1234", "attributes");
        $this->assertChains($field);
    }

    public function testCountry() {
        $field = "country";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ "US", "AU", "GB" ]);
        $this->assertInvalid($field, [ null, "", "United States", "Australia", "USA", "AU8", 12345, new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "CN", "attributes");
        $this->assertChains($field);
    }

    public function testMeta() {
        $assertSame = function($expected, $actual) {
            if (is_string($expected)) {
                $expected = json_decode($expected, true);
            }
            $this->assertEquals($expected, $actual, "Expecting value `".json_encode($expected)."`, but got `".json_encode($actual)."`");
        };

        $field = "metaData";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", ["extra" => "some extra data"], '{"extra":"some extra data"}' ], $assertSame);
        $this->assertInvalid($field, [ "some extra data", '{"extra":some extra data"}' ]);
        $this->assertChanged($field, '{"new":"value"}', "attributes", $assertSame);
        $this->assertChains($field);
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
                "metaData" => '{"extra":"some extra data"}',
            ],
        ];

        $address = new Address($this->datasource, $data);
        $this->assertFalse($address->hasErrors());
        $this->assertEquals(["extra" => "some extra data"], $address->getMetaData());
        $this->assertEquals($data, $address->getChanges());
    }
}

