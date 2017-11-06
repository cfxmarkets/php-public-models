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

    public function testLabel() {
        // Assert field required
        $this->assertTrue($this->entity->hasErrors('label'));

        // Assert required again
        $val = "";
        $this->entity->setLabel($val);
        $this->assertTrue($this->entity->hasErrors('label'));
        $this->assertEquals($val, $this->entity->getLabel());

        $val = "Me";
        $this->entity->setLabel($val);
        $this->assertFalse($this->entity->hasErrors('label'));
        $this->assertEquals($val, $this->entity->getLabel());

        // Assert changed
        $changes = $this->entity->getChanges();
        $this->assertContains('label', array_keys($changes['attributes']));
        $this->assertEquals($val, $changes['attributes']['label']);

        // Assert chaining
        $this->assertSame($this->entity, $this->entity->setLabel('Test'));
    }

    public function testType() {
        // Assert required
        $this->assertTrue($this->entity->hasErrors('type'));

        // Assert required again
        $val = "";
        $this->entity->setType($val);
        $this->assertTrue($this->entity->hasErrors('type'));
        $this->assertEquals($val, $this->entity->getType());

        // Throws errors for bad type
        $val = "bunk";
        $this->entity->setType($val);
        $this->assertTrue($this->entity->hasErrors('type'));
        $this->assertEquals($val, $this->entity->getType());

        // No errors for good types
        foreach(LegalEntity::getValidTypes() as $t) {
            $this->entity->setType($t);
            $this->assertFalse($this->entity->hasErrors('type'));
            $this->assertEquals($t, $this->entity->getType());
        }

        // Assert changed
        $changes = $this->entity->getChanges();
        $this->assertContains('type', array_keys($changes['attributes']));
        $this->assertEquals($t, $changes['attributes']['type']);

        // Assert chaining
        $this->assertSame($this->entity, $this->entity->setType($t));
    }

    public function testLegalId() {
        // Assert field NOT required
        $this->assertFalse($this->entity->hasErrors('legalId'));

        foreach ([ "555-11-2233", "5551112233", "12345", "AB23GG3298" ] as $val) {
            $this->entity->setLegalId($val);
            $this->assertFalse($this->entity->hasErrors('legalId'));
            $this->assertEquals($val, $this->entity->getLegalId());
        }

        // Assert changed
        $changes = $this->entity->getChanges();
        $this->assertContains('legalId', array_keys($changes['attributes']));
        $this->assertEquals($val, $changes['attributes']['legalId']);

        // Assert chaining
        $this->assertSame($this->entity, $this->entity->setLegalId('111223344'));
    }

    public function testLegalName() {
        // Assert field NOT required
        $this->assertFalse($this->entity->hasErrors('legalName'));

        $val = "OneWordName";
        $this->entity->setLegalName($val);
        $this->assertFalse($this->entity->hasErrors('legalName'));
        $this->assertEquals($val, $this->entity->getLegalName());

        $val = "Some Name";
        $this->entity->setLegalName($val);
        $this->assertFalse($this->entity->hasErrors('legalName'));
        $this->assertEquals($val, $this->entity->getLegalName());

        // Assert changed
        $changes = $this->entity->getChanges();
        $this->assertContains('legalName', array_keys($changes['attributes']));
        $this->assertEquals($val, $changes['attributes']['legalName']);

        // Assert chaining
        $this->assertSame($this->entity, $this->entity->setLegalName('Some Name'));
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
}

