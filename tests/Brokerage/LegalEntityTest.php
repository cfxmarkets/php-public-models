<?php
namespace CFX\Brokerage;

class LegalEntityTest extends \PHPUnit\Framework\TestCase
{
    protected $datasource;
    protected $entity;

    public function setUp() {
        $this->datasource = new \CFX\JsonApi\Test\MockDatasource();
        $this->entity = new LegalEntity($this->datasource);
    }

    public function testResourceType() {
        $this->assertEquals('legal-entities', $this->entity->getResourceType());
    }

    public function testType() {
        $field = 'type';
        $set = 'setType';
        $get = 'getType';

        $this->assertInvalid($field, $set, $get, [ null, '', 'bunk' ]);
        $this->assertValid($field, $set, $get, LegalEntity::getValidTypes());
        $this->assertChanged($field, $set, $get, LegalEntity::getValidTypes()[1], 'attributes');
        $this->assertChains($set);
    }

    public function testLegalId() {
        $field = 'legalId';
        $set = 'setLegalId';
        $get = 'getLegalId';

        $this->assertInvalid($field, $set, $get, [ [], new \DateTime() ]);
        $this->assertValid($field, $set, $get, [ null, '', "555-11-2233", "555112233", "12345", 12345, "AB23GG3298" ]);
        $this->assertChanged($field, $set, $get, "111111111", 'attributes');
        $this->assertChains($set);
    }

    public function testLegalName() {
        $field = 'legalName';
        $set = 'setLegalName';
        $get = 'getLegalName';

        $this->assertInvalid($field, $set, $get, [ [], new \DateTime() ]);
        $this->assertValid($field, $set, $get, [ null, '', "OneWordName", "Some Name" ]);
        $this->assertChanged($field, $set, $get, "Tester Name", 'attributes');
        $this->assertChains($set);
    }

    public function testDateOfBirth() {
        $field = 'dateOfBirth';
        $set = 'setDateOfBirth';
        $get = 'getDateOfBirth';

        $this->assertInvalid($field, $set, $get, [ 'invalid' ]);
        $this->assertValid(
            $field,
            $set,
            $get,
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
        $this->assertChanged($field, $set, $get, "01/01/2001", 'attributes', function($expected, $actual) {
            if (!$actual) {
                $this->assertEquals($expected, $actual);
            } else {
                if (is_string($expected)) {
                    $expected = new \DateTime($expected);
                }
                $this->assertEquals($expected->format("U"), $actual);
            }
        });
        $this->assertChains($set);
    }

    public function testPlaceOfOrigin() {
        $field = 'placeOfOrigin';
        $set = 'setPlaceOfOrigin';
        $get = 'getPlaceOfOrigin';

        $this->assertInvalid($field, $set, $get, [ [], new \DateTime(), 12345 ]);
        $this->assertValid($field, $set, $get, [ null, '', "US", "US:AL", "Abu Dhabi", "UK:London" ]);
        $this->assertChanged($field, $set, $get, "India", 'attributes');
        $this->assertChains($set);
    }

    public function testFinraStatus()
    {
        $field = 'finraStatus';
        $set = 'setFinraStatus';
        $get = 'getFinraStatus';

        $this->assertInvalid($field, $set, $get, [ 15, 'good', 'bad', 'true', 'false' ]);
        $this->assertValid($field, $set, $get, [ 1, '1', true, 0, '0', false, null ], function($expected, $actual) {
            if ($expected === null) {
                $this->assertNull($actual);
            } else {
                $this->assertEquals((bool)$expected, $actual);
            }
        });
        $this->assertChanged($field, $set, $get, true, 'attributes');
        $this->assertChains($set);
    }

    public function testFinraStatusText()
    {
        $field = 'finraStatusText';
        $set = 'setFinraStatusText';
        $get = 'getFinraStatusText';

        $this->assertInvalid($field, $set, $get, [ 15, true, false, new \DateTime() ]);
        $this->assertValid($field, $set, $get, [ null, '', 'All good', 'Nothing to see here' ]);
        $this->assertChanged($field, $set, $get, 'Some new finra status text', 'attributes');
        $this->assertChains($set);
    }

    public function testCorporateStatus()
    {
        $field = 'corporateStatus';
        $set = 'setCorporateStatus';
        $get = 'getCorporateStatus';

        $this->assertInvalid($field, $set, $get, [ 15, 'good', 'bad', 'true', 'false' ]);
        $this->assertValid($field, $set, $get, [ 1, '1', true, 0, '0', false, null ], function($expected, $actual) {
            if ($expected === null) {
                $this->assertNull($actual);
            } else {
                $this->assertEquals((bool)$expected, $actual);
            }
        });
        $this->assertChanged($field, $set, $get, true, 'attributes');
        $this->assertChains($set);
    }

    public function testCorporateStatusText()
    {
        $field = 'corporateStatusText';
        $set = 'setCorporateStatusText';
        $get = 'getCorporateStatusText';

        $this->assertInvalid($field, $set, $get, [ 15, true, false, new \DateTime() ]);
        $this->assertValid($field, $set, $get, [ null, '', 'All good', 'Nothing to see here' ]);
        $this->assertChanged($field, $set, $get, 'Some new corporate status text', 'attributes');
        $this->assertChains($set);
    }

    public function testCustodianName()
    {
        $field = 'custodianName';
        $set = 'setCustodianName';
        $get = 'getCustodianName';

        $this->assertInvalid($field, $set, $get, [ 15, true, false, new \DateTime() ]);
        $this->assertValid($field, $set, $get, [ null, '', 'Custodian One' ]);
        $this->assertChanged($field, $set, $get, 'Custodian Two', 'attributes');
        $this->assertChains($set);
    }

    public function testCustodianAccountNum()
    {
        $field = 'custodianAccountNum';
        $set = 'setCustodianAccountNum';
        $get = 'getCustodianAccountNum';

        $this->assertInvalid($field, $set, $get, [ true, false, new \DateTime() ]);
        $this->assertValid($field, $set, $get, [ null, '', 12345567, '1234567', 'ABC123-333.551' ]);
        $this->assertChanged($field, $set, $get, '111111111111111', 'attributes');
        $this->assertChains($set);
    }

    public function testPrimaryAddress() {
        // Assert field NOT required
        $this->assertFalse($this->entity->hasErrors('primaryAddress'));

        $val = (new Address($this->datasource))
            ->setId('12345');
        $this->entity->setPrimaryAddress($val);
        $this->assertFalse($this->entity->hasErrors('primaryAddress'));
        $this->assertEquals($val, $this->entity->getPrimaryAddress());

        // Assert changed
        $changes = $this->entity->getChanges();
        $this->assertContains('relationships', array_keys($changes));
        $this->assertContains('primaryAddress', array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships']['primaryAddress']->getData());

        // Assert chaining
        $this->assertSame($this->entity, $this->entity->setPrimaryAddress($val));
    }

    public function testIdDocuments() {
        // Assert field NOT required
        $this->assertFalse($this->entity->hasErrors('idDocuments'));

        $val = new \CFX\JsonApi\ResourceCollection();
        $this->entity->setIdDocuments($val);
        $this->assertFalse($this->entity->hasErrors('idDocuments'));
        $this->assertEquals($val, $this->entity->getIdDocuments());

        // Assert changed
        $changes = $this->entity->getChanges();
        $this->assertContains('idDocuments', array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships']['idDocuments']->getData());

        // Assert chaining
        $this->assertSame($this->entity, $this->entity->setIdDocuments($val));

        // AddIdDocument
        $this->markTestIncomplete();
        /*
         * NOT possible with generic MockDatasource
        $doc = new Document($this->datasource);
        $this->entity->addIdDocument($doc);
        $this->assertFalse($this->entity->hasErrors('idDocuments'));
        $this->assertEquals(1, count($this->entity->getIdDocuments()));

        // HasIdDocument
        $this->assertTrue($this->entity->hasIdDocument($doc));

        // RemoveIdDocument
        $this->entity->removeIdDocument($doc);
        $this->assertFalse($this->entity->hasErrors('idDocuments'));
        $this->assertEquals(0, count($this->entity->getIdDocuments()));
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


    protected function assertInvalid($field, $set, $get, $invalids, $assertSame = null)
    {
        foreach ($invalids as $val) {
            $this->assertErrors($field, $set, $get, $val, true, $assertSame);
        }
    }

    protected function assertValid($field, $set, $get, $valids, $assertSame = null)
    {
        foreach ($valids as $val) {
            $this->assertErrors($field, $set, $get, $val, false, $assertSame);
        }
    }

    protected function assertErrors($field, $set, $get, $val, $has, $assertSame = null)
    {
        $this->entity->$set($val);
        if ($has) {
            $this->assertTrue($this->entity->hasErrors($field));
        } else {
            $this->assertFalse($this->entity->hasErrors($field));
        }

        if ($assertSame) {
            $assertSame($val, $this->entity->$get());
        } else {
            $this->assertEquals($val, $this->entity->$get());
        }
    }

    protected function assertChanged($field, $set, $get, $val, $type, $assertSame = null)
    {
        if (!in_array($type, ['attributes','relationships'])) {
            throw new \RuntimeException("`\$type` must be either `attributes` or `relationships`");
        }

        $this->entity->$set($val);
        $changes = $this->entity->getChanges();
        $this->assertContains($field, array_keys($changes[$type]));
        if ($assertSame) {
            $assertSame($val, $changes[$type][$field]);
        } else {
            $this->assertSame($val, $changes[$type][$field]);
        }
    }

    protected function assertChains($set)
    {
        $this->assertSame($this->entity, $this->entity->$set(null));
    }
}

