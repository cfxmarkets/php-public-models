<?php
namespace CFX\Brokerage;

class LegalEntityTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;
    protected $className = '\\CFX\\Brokerage\\LegalEntity';

    public function testResourceType() {
        $this->assertEquals('legal-entities', $this->resource->getResourceType());
    }

    public function testType() {
        $field = 'type';

        $this->assertInvalid($field, [ null, '', 'bunk' ]);
        $this->assertValid($field, LegalEntity::getValidTypes());
        $this->assertChanged($field, LegalEntity::getValidTypes()[1], 'attributes');
        $this->assertChains($field);
    }

    public function testLegalId() {
        $field = 'legalId';

        $this->assertInvalid($field, [ [], new \DateTime() ]);
        $this->assertValid($field, [ null, '', "555-11-2233", "555112233", "12345", 12345, "AB23GG3298" ]);
        $this->assertChanged($field, "111111111", 'attributes');
        $this->assertChains($field);
    }

    public function testLegalName() {
        $field = 'legalName';

        $this->assertInvalid($field, [ [], new \DateTime() ]);
        $this->assertValid($field, [ null, '', "OneWordName", "Some Name" ]);
        $this->assertChanged($field, "Tester Name", 'attributes');
        $this->assertChains($field);
    }

    public function testDateOfBirth() {
        $field = 'dateOfBirth';

        $this->assertInvalid($field, [ 'invalid' ]);
        $this->assertValid(
            $field,
            [ new \DateTime(), '01/01/99', '01/01/1999', (time() - (60*60*24*365*20)), (time() - (60*60*24*365*80)), (string)(time() - (60*60*24*365*80)) ],
            function($expected, $actual) {
                if (is_int($expected) || is_numeric($expected)) {
                    $expected = new \DateTime("@$expected");
                } elseif (is_string($expected)) {
                    $expected = new \DateTime($expected);
                }

                if ($actual === null) {
                    $this->assertEquals($expected, $actual);
                } else {
                    $this->assertInstanceOf("\\DateTime", $actual);
                    $this->assertEquals($expected->format("Ymd"), $actual->format("Ymd"));
                }
            }
        );
        $this->assertChanged($field, "01/01/2001", 'attributes', function($expected, $actual) {
            if (!$actual) {
                $this->assertEquals($expected, $actual);
            } else {
                if (is_string($expected)) {
                    $expected = new \DateTime($expected);
                }
                $this->assertEquals($expected->format("U"), $actual);
            }
        });
        $this->assertChains($field);
    }

    public function testPlaceOfOrigin() {
        $field = 'placeOfOrigin';

        $this->assertInvalid($field, [ [], new \DateTime(), 12345 ]);
        $this->assertValid($field, [ null, '', "US", "US:AL", "Abu Dhabi", "UK:London" ]);
        $this->assertChanged($field, "India", 'attributes');
        $this->assertChains($field);
    }

    public function testFinraStatus()
    {
        $field = 'finraStatus';

        $this->assertInvalid($field, [ 15, 'good', 'bad', 'true', 'false' ]);
        $this->assertValid($field, [ 1, '1', true, 0, '0', false, null ], function($expected, $actual) {
            if ($expected === null) {
                $this->assertNull($actual);
            } else {
                $this->assertEquals((bool)$expected, $actual);
            }
        });
        $this->assertChanged($field, true, 'attributes');
        $this->assertChains($field);
    }

    public function testFinraStatusText()
    {
        $field = 'finraStatusText';

        $this->assertInvalid($field, [ 15, true, false, new \DateTime() ]);
        $this->assertValid($field, [ null, '', 'All good', 'Nothing to see here' ]);
        $this->assertChanged($field, 'Some new finra status text', 'attributes');
        $this->assertChains($field);
    }

    public function testCorporateStatus()
    {
        $field = 'corporateStatus';

        $this->assertInvalid($field, [ 15, 'good', 'bad', 'true', 'false' ]);
        $this->assertValid($field, [ 1, '1', true, 0, '0', false, null ], function($expected, $actual) {
            if ($expected === null) {
                $this->assertNull($actual);
            } else {
                $this->assertEquals((bool)$expected, $actual);
            }
        });
        $this->assertChanged($field, true, 'attributes');
        $this->assertChains($field);
    }

    public function testCorporateStatusText()
    {
        $field = 'corporateStatusText';

        $this->assertInvalid($field, [ 15, true, false, new \DateTime() ]);
        $this->assertValid($field, [ null, '', 'All good', 'Nothing to see here' ]);
        $this->assertChanged($field, 'Some new corporate status text', 'attributes');
        $this->assertChains($field);
    }

    public function testCustodianName()
    {
        $field = 'custodianName';

        $this->assertInvalid($field, [ 15, true, false, new \DateTime() ]);
        $this->assertValid($field, [ null, '', 'Custodian One' ]);
        $this->assertChanged($field, 'Custodian Two', 'attributes');
        $this->assertChains($field);
    }

    public function testCustodianAccountNum()
    {
        $field = 'custodianAccountNum';

        $this->assertInvalid($field, [ true, false, new \DateTime() ]);
        $this->assertValid($field, [ null, '', 12345567, '1234567', 'ABC123-333.551' ]);
        $this->assertChanged($field, '111111111111111', 'attributes');
        $this->assertChains($field);
    }

    public function testPrimaryAddress() {
        // Assert field NOT required
        $this->assertFalse($this->resource->hasErrors('primaryAddress'));

        $val = (new Address($this->datasource))
            ->setId('12345');
        $this->resource->setPrimaryAddress($val);
        $this->assertFalse($this->resource->hasErrors('primaryAddress'));
        $this->assertEquals($val, $this->resource->getPrimaryAddress());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains('relationships', array_keys($changes));
        $this->assertContains('primaryAddress', array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships']['primaryAddress']->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->setPrimaryAddress($val));
    }

    public function testIdDocuments() {
        // Assert field NOT required
        $this->assertFalse($this->resource->hasErrors('idDocuments'));

        $val = new \CFX\JsonApi\ResourceCollection();
        $this->resource->setIdDocuments($val);
        $this->assertFalse($this->resource->hasErrors('idDocuments'));
        $this->assertEquals($val, $this->resource->getIdDocuments());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains('idDocuments', array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships']['idDocuments']->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->setIdDocuments($val));

        // AddIdDocument
        $this->markTestIncomplete();
        /*
         * NOT possible with generic MockDatasource
        $doc = new Document($this->datasource);
        $this->resource->addIdDocument($doc);
        $this->assertFalse($this->resource->hasErrors('idDocuments'));
        $this->assertEquals(1, count($this->resource->getIdDocuments()));

        // HasIdDocument
        $this->assertTrue($this->resource->hasIdDocument($doc));

        // RemoveIdDocument
        $this->resource->removeIdDocument($doc);
        $this->assertFalse($this->resource->hasErrors('idDocuments'));
        $this->assertEquals(0, count($this->resource->getIdDocuments()));
         */
    }


    public function testIntegration() {
        $this->markTestIncomplete();
        $data = [
            "type" => "legal-entities",
            "attributes" => [
                "label" => "Me",
                "type" => "person",
                "legalId" => "111223333",
                "legalName" => "My Person",
            ],
                /*
            "relationships" => [
                "primaryAddress" => [
                    "data" => [
                        "type" => "addresses",
                        "id" => "12345",
                    ],
                ],
                "idDocuments" => [
                    "data" => [
                        [
                            "type" => 'documents',
                            "id" => "12345",
                        ],
                    ],
                ],
            ],
                 */
        ];

        $document = new LegalEntity($this->datasource, $data);
        $this->assertFalse($document->hasErrors());
        $this->assertEquals($data, $document->getChanges());
    }
}

