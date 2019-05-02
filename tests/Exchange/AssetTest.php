<?php
namespace CFX\Exchange;

class AssetTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Exchange\\Asset";

    public function testResourceType()
    {
        $this->assertEquals('assets', $this->resource->getResourceType());
    }

    public function testIssuer()
    {
        $field = 'issuer';
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ "Inventrust Properties", "Some Other Issuer" ]);
        $this->assertInvalid($field, [ null, "", 12345, new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "Highlands REIT", "attributes");
        $this->assertChains($field);
    }

    public function testName()
    {
        $field = 'name';
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "Inventrust REIT", "Some othe REIT" ]);
        $this->assertInvalid($field, [ 12345, new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "Highlands REIT", "attributes");
        $this->assertChains($field);
    }

    public function testType()
    {
        $field = 'type';
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, $this->resource->getValidTypes());
        $this->assertInvalid($field, [ null, "", 12345, new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "reit", "attributes");
        $this->assertChains($field);
    }

    public function testStatusCode()
    {
        $field = 'statusCode';
        $this->assertInstantiatesValidly($field);
        $this->assertReadOnly($field);
    }

    public function testStatusText()
    {
        $field = 'statusText';
        $this->assertInstantiatesValidly($field);
        $this->assertReadOnly($field);
    }

    public function testDescription()
    {
        $field = 'description';
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "This is a big long description of the asset...." ]);
        $this->assertInvalid($field, [ 12345, new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "Highlands REIT", "attributes");
        $this->assertChains($field);
    }

    public function testPlatform()
    {
        $field = 'platform';
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "ethereum", "bitcoin" ]);
        $this->assertInvalid($field, [ 12345, new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "litecoin", "attributes");
        $this->assertChains($field);
    }

    public function testPlatformVersion()
    {
        $field = 'platformVersion';
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "2.0.2", "5.22.1a", 123456 ]);
        $this->assertInvalid($field, [ new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "Highlands REIT", "attributes");
        $this->assertChains($field);
    }

    public function testResolutionUri()
    {
        $field = 'resolutionUri';
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "https://inventrust.com/some/url", "p2p://ethereum/0x1234556666623423423", "p2p:ethereum/0x1111122222233333344444" ]);
        $this->assertInvalid($field, [ 12345, new \DateTime(), [ ], true, false ]);
        $this->assertChanged($field, "p2p://bitcoin/200300", "attributes");
        $this->assertChains($field);
    }

    public function testExemptionType()
    {
        $field = 'exemptionType';
        $this->assertInstantiatesValidly($field);
        $this->assertReadOnly($field);
        $this->assertChains($field);
    }

    public function testIsFund()
    {
        $field = 'isFund';
        $this->assertInstantiatesValidly($field);
        $this->assertReadOnly($field);
        $this->assertChains($field);
    }

    public function testIssuanceCloseDate()
    {
        $field = 'issuanceCloseDate';
        $this->assertChains($field, null);

        $mock= new \CFX\JsonApi\Test\MockDatasource();

        // Test that it can be successfully created without errors
        $asset = $mock
            ->addClassToCreate("\\CFX\\Exchange\\Asset")
            ->create();

        $this->assertFalse($asset->hasErrors($field));
        $this->assertNull($asset->getIssuanceCloseDate());

        // Test that it can be successfully inflated with null value without errors
        $asset = $mock
            ->addClassToCreate("\\CFX\\Exchange\\Asset")
            ->setCurrentData([
                'id' => "BCAP",
                'type' => 'assets',
            ])
            ->get("id=BCAP")
        ;

        $this->assertFalse($asset->hasErrors($field));
        $this->assertNull($asset->getIssuanceCloseDate());

        // Test that it can be successfully inflated with non-null value without errors
        $asset = $mock
            ->addClassToCreate("\\CFX\\Exchange\\Asset")
            ->setCurrentData([
                'id' => "BCAP",
                'type' => 'assets',
                'attributes' => [
                    $field => '2018-01-01 00:00:00',
                ],
            ])
            ->get("id=BCAP")
        ;

        $this->assertFalse($asset->hasErrors($field));
        $this->assertInstanceOf("\\DateTimeInterface", $asset->getIssuanceCloseDate());
        $this->assertEquals('2018-01-01 00:00:00', $asset->getIssuanceCloseDate()->format('Y-m-d H:i:s'));
    }

    public function testCommonName()
    {
        $field = 'commonName';
        $this->assertInstantiatesValidly($field);
        $this->assertReadOnly($field);
        $this->assertChains($field);
    }

    public function testInfoUrl()
    {
        $field = 'infoUrl';
        $this->assertInstantiatesValidly($field);
        $this->assertReadOnly($field);
        $this->assertChains($field);
    }
}

