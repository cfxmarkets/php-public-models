<?php 
namespace CFX\Brokerage;

class DocumentTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\Document";

    public function testResourceType() {
        $this->assertEquals('documents', $this->resource->getResourceType());
    }

    /**
     * This is to remind us to handle type changes gracefully, since mismatches between what's in the
     * database and what's defined in the application can cause unexpected errors.
     */
    public function testValidTypes()
    {
        $types = [
            'id' => "Proof of Identity",
            'ownership' => "Proof of Ownership",
            'agreement' => "Signed Contract",
            "accreditation" => "Proof of Accreditation",
            "residency" => "Proof of Residency",
            "genesis" => "Certificate of Incorporation, Trust Agreement, Birth Certificate, etc.",
            "operating-agreement" => "The operating agreement and/or bylaws for a non-person entity",
            "proof-of-income" => "A document demonstrating proof that the user has the income they say they do",
            "other" => "Uncategorized Document",
        ];

        $appTypes = Document::getValidTypes();
        $appKeys = array_keys($appTypes);
        $appVals = array_values($appTypes);

        $i = 0;
        foreach($types as $k => $v) {
            $this->assertEquals($k, $appKeys[$i]);
            $this->assertEquals($v, $appVals[$i]);
            $i++;
        }
    }

    /**
     * This is to remind us to handle status changes gracefully, since mismatches between what's in the
     * database and what's defined in the application can cause unexpected errors.
     */
    public function testValidStatuses()
    {
        $statuses = [
            -1 => "rejected",
            0 => 'not-submitted',
            1 => 'reviewing',
            2 => 'approved',
        ];

        $appStatuses = Document::getValidStatuses();
        $appKeys = array_keys($appStatuses);
        $appVals = array_values($appStatuses);

        $i = 0;
        foreach($statuses as $k => $v) {
            $this->assertEquals($appKeys[$i], $k);
            $this->assertEquals($appVals[$i], $v);
            $i++;
        }
    }

    public function testLabel() {
        $this->assertValid('label', [ null, '', 'My Document' ]);
    }

    public function testType() {
        $this->assertValid("type", array_keys(Document::getValidTypes()));
        $this->assertInvalid("type", [ null, '', 'bunk', new \DateTime(), 2.5, [] ]);
        $this->assertChanged("type", array_keys(Document::getValidTypes())[1], 'attributes');
        $this->assertChains("type", null);
    }

    public function testUrl() {
        $this->assertValid("url", [ "/valid/absolute/path.pdf", "https://somehost.com/valid/path.jpg", "https://somehost.com/my/photo/12344", "hellosign:1123453234123412341234" ]);
        $this->assertInvalid("url", [ null, '', 'bunk' ]);
        $this->assertChanged("url", "/my/photo.pdf", "attributes");
        $this->assertChains("url");
    }

    public function testStatus() {
        // Default is fine
        $this->assertFalse($this->resource->hasErrors('status'));
        $this->assertReadOnly("status", "approved");
    }

    public function testNotes() {
        $this->assertValid("notes", [ null, '', "These are some notes" ]);
        $this->assertInvalid("notes", [ new \DateTime(), 2.5, [] ]);
        $this->assertChanged("notes", "notes", "attributes");
        $this->assertChains("notes");
    }

    public function testLegalEntity()
    {
        $this->assertValid("legalEntity", [ null, new LegalEntity($this->datasource) ]);
        $this->assertChanged("legalEntity", (new LegalEntity($this->datasource))->setId("12345"), "relationships");
        $this->assertChains("legalEntity", null);

        $entity = (new LegalEntity($this->datasource))->setId("67890");
        $this->resource->setLegalEntity($entity);
        $this->assertFalse($this->resource->hasErrors("legalEntity"));
        $this->assertTrue($this->resource->hasErrors("type"));

        // Agreement docs can't have legal entities
        $this->resource->setType('agreement');
        $this->assertTrue($this->resource->hasErrors('legalEntity'));
        $this->assertContains("invalidForType", array_keys($this->resource->getErrors('legalEntity')));

        // Ownership docs can't have legal entities
        $this->resource->setType("ownership");
        $this->assertTrue($this->resource->hasErrors('legalEntity'));
        $this->assertContains("invalidForType", array_keys($this->resource->getErrors('legalEntity')));

        // These doc types MUST have LegalEntity
        foreach ([ "id", "accreditation", "residency", "genesis", "operating-agreement", "proof-of-income", "other" ] as $type) {
            $this->resource->setLegalEntity($entity);
            $this->resource->setType($type);
            $this->assertFalse($this->resource->hasErrors('legalEntity'), "$type documents should be valid with LegalEntities");

            $this->resource->setLegalEntity(null);
            $this->assertTrue($this->resource->hasErrors('legalEntity'), "$type documents should REQUIRE a LegalEntity");
            $this->assertContains("required", array_keys($this->resource->getErrors('legalEntity')), "$type documents should REQUIRE a LegalEntity");
        }
    }

    public function testOrderIntent()
    {
        $this->assertValid("orderIntent", [ null, new OrderIntent($this->datasource) ]);
        $this->assertChanged("orderIntent", (new OrderIntent($this->datasource))->setId("12345"), "relationships");
        $this->assertChains("orderIntent", null);

        $intent = (new OrderIntent($this->datasource))->setId("67890");
        $this->resource->setOrderIntent($intent);
        $this->assertFalse($this->resource->hasErrors("orderIntent"));
        $this->assertTrue($this->resource->hasErrors("type"));

        // agreement docs must have order intents
        $this->resource->setType('agreement');
        $this->assertFalse($this->resource->hasErrors('orderIntent'));

        // ownership docs must have order intents
        $this->resource->setType("ownership");
        $this->assertFalse($this->resource->hasErrors('orderIntent'));

        // ownership and agreement docs REQUIRE an OrderIntent
        $this->resource->setOrderIntent(null);
        foreach (["ownership", "agreement" ] as $type) {
            $this->resource->setType($type);
            $this->assertTrue($this->resource->hasErrors('orderIntent'));
            $this->assertContains("required", array_keys($this->resource->getErrors('orderIntent')), "$type documents should require an OrderIntent");
        }

        // ID, Accreditation, Residency, Genesis and Other docs can't have orderIntent
        foreach ([ "id", "accreditation", "residency", "genesis", "other" ] as $type) {
            $this->resource->setOrderIntent($intent);

            $this->resource->setType($type);
            $this->assertTrue($this->resource->hasErrors('orderIntent'), "$type documents MUST NOT have OrderIntents");
            $this->assertContains("invalidForType", array_keys($this->resource->getErrors('orderIntent')), "$type documents should register and orderIntent error indicating invalid for type.");

            $this->resource->setOrderIntent(null);
            $this->assertFalse($this->resource->hasErrors('orderIntent'), "$type documents should be valid without an OrderIntent");
        }
    }

    public function testIntegration() {
        $data = [
            "type" => "documents",
            "attributes" => [
                "label" => "My Document",
                "type" => 'id',
                "url" => "/our-server/doc.pdf",
                "notes" => "Here's a quick note about the doc.",
            ],
            "relationships" => [
                "legalEntity" => [
                    "data" => [
                        "type" => "legal-entities",
                        "id" => "12345",
                    ]
                ]
            ]
        ];

        $this->datasource->addClassToCreate("\\CFX\\Brokerage\\LegalEntity");
        $document = new Document($this->datasource, $data);
        $this->assertFalse($document->hasErrors());

        $data['attributes']['status'] = 1;
        $this->assertEquals($data, json_decode(json_encode($document->getChanges()), true));
    }
}

