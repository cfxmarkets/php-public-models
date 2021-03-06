<?php
namespace CFX\Brokerage;

class LegalEntityTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;
    protected $className = '\\CFX\\Brokerage\\LegalEntity';

    public function testResourceType() {
        $this->assertEquals('legal-entities', $this->resource->getResourceType());
    }

    public function testGetAmlKycStatus()
    {
        $this->assertEquals(0, $this->resource->getAmlKycStatus());
        $this->datasource->setRelated('idDocs', new \CFX\JsonApi\ResourceCollection());
        $this->resource
            ->setLegalId("123456789")
            ->setDateOfBirth(time() - (18400*365*50))
            ->setPrimaryAddress(new Address($this->datasource))
            ->addIdDoc(new Document($this->datasource))
        ;
        $this->assertEquals(1, $this->resource->getAmlKycStatus());
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
        $this->_testDateField($field, false);
        $this->assertChains($field);
    }

    public function testDateOfBirthSerializesCorrectly()
    {
        $date = new \DateTime();
        $this->resource->setDateOfBirth($date);
        $data = json_decode(json_encode($this->resource), true);
        $this->assertEquals($date->format("Y-m-d"), $data['attributes']['dateOfBirth']);

        // Shouldn't choke when serializing bad values
        $this->resource->setDateOfBirth("excalibur!!");
        $data = json_decode(json_encode($this->resource), true);
        $this->assertEquals("excalibur!!", $data['attributes']['dateOfBirth']);
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

    public function testNetWorth()
    {
        $field = "netWorth";
        $this->assertValid($field, [ 1234555, "500000", 0, null, '' ]);
        $this->assertInvalid($field, [ "cool", true, false, [ "array-of-things" ], new \DateTime() ]);
        $this->assertChanged($field, 300000, "attributes");
        $this->assertChains($field);
    }

    public function testAnnualIncome()
    {
        $field = "annualIncome";
        $this->assertValid($field, [ 1234555, "500000", 0, null, '' ]);
        $this->assertInvalid($field, [ "cool", true, false, [ "array-of-things" ], new \DateTime() ]);
        $this->assertChanged($field, 300000, "attributes");
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

    public function testInvestmentAccountUri()
    {
        $field = 'investmentAccountUri';

        $this->assertValid($field, [ null, '', "p2p://ethereum/0x1383838383AAbcdeEef", 'trad://inventrust/123456' ]);
        $this->assertInvalid($field, [ true, false, new \DateTime(), [], "https://not-valid.com/not-valid" ]);
        $this->assertChanged($field, 'p2p://ethereum/0x12344444', 'attributes');
        $this->assertChains($field);
    }

    public function testVerificationStatus()
    {
        $field = "verificationStatus";
        $this->assertFalse($this->resource->hasErrors($field), "Should instantiate cleanly");
        $this->assertReadOnly($field, 2);
    }

    public function testProcessingStatus()
    {
        $field = "processingStatus";
        $this->assertFalse($this->resource->hasErrors($field), "Should instantiate cleanly");
        $this->assertReadOnly($field, 2);
    }

    public function testResidencyStatus()
    {
        $field = "residencyStatus";
        $this->assertFalse($this->resource->hasErrors($field), "Should instantiate cleanly");
        $this->assertReadOnly($field, 2);
    }

    public function testAccreditationStatus()
    {
        $field = "accreditationStatus";
        $this->assertFalse($this->resource->hasErrors($field), "Should instantiate cleanly");
        $this->assertReadOnly($field, 2);
    }

    public function testIdentityStatus()
    {
        $field = "identityStatus";
        $this->assertFalse($this->resource->hasErrors($field), "Should instantiate cleanly");
        $this->assertReadOnly($field, 2);
    }

    public function testGenesisStatus()
    {
        $field = "genesisStatus";
        $this->assertFalse($this->resource->hasErrors($field), "Should instantiate cleanly");
        $this->assertReadOnly($field, 2);
    }

    public function genesisStatusDate()
    {
        $field = "genesisStatusDate";
        $this->assertFalse($this->resource->hasErrors($field), "Should instantiate cleanly");
        $this->assertReadOnly($field, new \DateTime());
    }

    public function testPrimaryEmail()
    {
        $field = 'primaryEmail';
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ 'test@testerson.com', 't@v.co.uk', 't@v.us', "bill@sundance.capital" ]);
        $this->assertInvalid($field, [ null, '', 'not an email' ]);
        $this->assertChanged($field, 'tester@email.com', "attributes");
        $this->assertChains($field);
    }

    public function testCreatedOn()
    {
        $field = 'createdOn';
        $this->assertReadOnly($field);
        $this->assertChains($field, null);

        $mock= new \CFX\JsonApi\Test\MockDatasource();

        // Test that it can be successfully created without errors
        $intent = $mock
            ->addClassToCreate("\\CFX\\Brokerage\\LegalEntity")
            ->create();

        $this->assertFalse($intent->hasErrors('createdOn'));
        $this->assertNull($intent->getCreatedOn());

        // Test that it can be successfully inflated with null value without errors
        $intent = $mock
            ->addClassToCreate("\\CFX\\Brokerage\\LegalEntity")
            ->setCurrentData([
                'id' => 12345,
                'type' => 'legal-entities',
            ])
            ->get("id=12345")
        ;

        $this->assertFalse($intent->hasErrors('createdOn'));
        $this->assertNull($intent->getCreatedOn());

        // Test that it can be successfully inflated with non-null value without errors
        $intent = $mock
            ->addClassToCreate("\\CFX\\Brokerage\\LegalEntity")
            ->setCurrentData([
                'id' => 12345,
                'type' => 'legal-entities',
                'attributes' => [
                    'createdOn' => '2018-01-01 00:00:00',
                ],
            ])
            ->get("id=12345")
        ;

        $this->assertFalse($intent->hasErrors('createdOn'));
        $this->assertInstanceOf("\\DateTimeInterface", $intent->getCreatedOn());
        $this->assertEquals('2018-01-01 00:00:00', $intent->getCreatedOn()->format('Y-m-d H:i:s'));
    }

    public function testWalletAccount()
    {
        $field = "walletAccount";
        $this->assertReadOnly($field, (new WalletAccount($this->datasource))->setId("12345"));
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

    public function testIdDocs() {
        // Assert field NOT required
        $this->assertFalse($this->resource->hasErrors('idDocs'));

        $val = new \CFX\JsonApi\ResourceCollection();
        $this->datasource->setRelated('idDocs', $val);

        $this->resource->setIdDocs($val);
        $this->assertFalse($this->resource->hasErrors('idDocs'));
        $this->assertEquals($val, $this->resource->getIdDocs());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains('idDocs', array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships']['idDocs']->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->setIdDocs($val));

        // AddIdDoc
        $doc = new Document($this->datasource);
        $this->resource->addIdDoc($doc);
        $this->assertFalse($this->resource->hasErrors('idDocs'));
        $this->assertEquals(1, count($this->resource->getIdDocs()));

        // HasIdDoc
        $this->assertTrue($this->resource->hasIdDoc($doc));

        // RemoveIdDoc
        $this->resource->removeIdDoc($doc);
        $this->assertFalse($this->resource->hasErrors('idDocs'));
        $this->assertEquals(0, count($this->resource->getIdDocs()));
    }

    public function testAccreditationDocs() {
        $field = "accreditationDocs";

        // Assert field NOT required
        $this->assertFalse($this->resource->hasErrors($field));

        $val = new \CFX\JsonApi\ResourceCollection();
        $this->datasource->setRelated($field, $val);

        $this->resource->setAccreditationDocs($val);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals($val, $this->resource->getAccreditationDocs());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains($field, array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships'][$field]->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->setAccreditationDocs($val));

        // AddDoc
        $doc = new Document($this->datasource);
        $this->resource->addAccreditationDoc($doc);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals(1, count($this->resource->getAccreditationDocs()));

        // HasDoc
        $this->assertTrue($this->resource->hasAccreditationDoc($doc));

        // RemoveDoc
        $this->resource->removeAccreditationDoc($doc);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals(0, count($this->resource->getAccreditationDocs()));
    }

    public function testResidencyDocs() {
        $field = "residencyDocs";

        // Assert field NOT required
        $this->assertFalse($this->resource->hasErrors($field));

        $val = new \CFX\JsonApi\ResourceCollection();
        $this->datasource->setRelated($field, $val);

        $this->resource->setResidencyDocs($val);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals($val, $this->resource->getResidencyDocs());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains($field, array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships'][$field]->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->setResidencyDocs($val));

        // AddDoc
        $doc = new Document($this->datasource);
        $this->resource->addResidencyDoc($doc);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals(1, count($this->resource->getResidencyDocs()));

        // HasDoc
        $this->assertTrue($this->resource->hasResidencyDoc($doc));

        // RemoveDoc
        $this->resource->removeResidencyDoc($doc);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals(0, count($this->resource->getResidencyDocs()));
    }

    public function testProofOfFundsDocs() {
        $field = "proofOfFundsDocs";

        // Assert field NOT required
        $this->assertFalse($this->resource->hasErrors($field));

        $val = new \CFX\JsonApi\ResourceCollection();
        $this->datasource->setRelated($field, $val);

        $this->resource->setProofOfFundsDocs($val);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals($val, $this->resource->getProofOfFundsDocs());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains($field, array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships'][$field]->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->setProofOfFundsDocs($val));

        // AddDoc
        $doc = new Document($this->datasource);
        $this->resource->addProofOfFundsDoc($doc);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals(1, count($this->resource->getProofOfFundsDocs()));

        // HasDoc
        $this->assertTrue($this->resource->hasProofOfFundsDoc($doc));

        // RemoveDoc
        $this->resource->removeProofOfFundsDoc($doc);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals(0, count($this->resource->getProofOfFundsDocs()));
    }

    public function testProofOfAccountDocs() {
        $field = "proofOfAccountDocs";

        // Assert field NOT required
        $this->assertFalse($this->resource->hasErrors($field));

        $val = new \CFX\JsonApi\ResourceCollection();
        $this->datasource->setRelated($field, $val);

        $this->resource->setProofOfAccountDocs($val);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals($val, $this->resource->getProofOfAccountDocs());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains($field, array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships'][$field]->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->setProofOfAccountDocs($val));

        // AddDoc
        $doc = new Document($this->datasource);
        $this->resource->addProofOfAccountDoc($doc);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals(1, count($this->resource->getProofOfAccountDocs()));

        // HasDoc
        $this->assertTrue($this->resource->hasProofOfAccountDoc($doc));

        // RemoveDoc
        $this->resource->removeProofOfAccountDoc($doc);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals(0, count($this->resource->getProofOfAccountDocs()));
    }

    public function testAgreements() {
        $field = "agreements";
        $this->assertInstantiatesValidly($field);

        $val = new \CFX\JsonApi\ResourceCollection();
        $this->datasource->setRelated('agreements', $val);

        $this->resource->setAgreements($val);
        $this->assertFalse($this->resource->hasErrors('agreements'));
        $this->assertEquals($val, $this->resource->getAgreements());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains('agreements', array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships']['agreements']->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->setAgreements($val));

        // AddAgreement
        $agreement = new Agreement($this->datasource);
        $this->resource->addAgreement($agreement);
        $this->assertFalse($this->resource->hasErrors('agreements'));
        $this->assertEquals(1, count($this->resource->getAgreements()));

        // HasAgreement
        $this->assertTrue($this->resource->hasAgreement($agreement));

        // RemoveIdDoc
        $this->resource->removeAgreement($agreement);
        $this->assertFalse($this->resource->hasErrors("agreements"));
        $this->assertEquals(0, count($this->resource->getAgreements()));
    }


    public function testIntegration() {
        $data = [
            "type" => "legal-entities",
            "attributes" => [
                "type" => "person",
                "legalId" => "111223333",
                "legalName" => "My Person",
                "accreditationStatus" => 0,
                "primaryEmail" => "my.person@humans.org",
                "processingStatus" => "new",
                "identityStatus" => 0,
                "residencyStatus" => 0,
                "genesisStatus" => 0,
            ],
            "relationships" => [
                "primaryAddress" => [
                    "data" => [
                        "type" => "addresses",
                        "id" => "12345",
                    ],
                ],
                "idDocs" => [
                    "data" => [
                        [
                            "type" => 'documents',
                            "id" => "12345",
                        ],
                    ],
                ],
                "agreements" => [
                    "data" => [
                        [
                            "type" => "agreements",
                            "id" => "abcde",
                        ],
                        [
                            "type" => "agreements",
                            "id" => "edcba",
                        ],
                    ]
                ]
            ],
        ];


        // Test creating new

        $entity = $this->datasource
            ->addClassToCreate("\\CFX\\Brokerage\\LegalEntity")
            ->addClassToCreate("\\CFX\\Brokerage\\Address")
            ->addClassToCreate("\\CFX\\Brokerage\\Document")
            ->addClassToCreate("\\CFX\\Brokerage\\Agreement")
            ->addClassToCreate("\\CFX\\Brokerage\\Agreement")
            ->create($data)
        ;

        $this->assertFalse($entity->hasErrors());

        $data["attributes"]["accreditationStatus"] = 0;
        $data["attributes"]["verificationStatus"] = 0;
        $this->assertEquals($data, json_decode(json_encode($entity->getChanges()), true));


        // Test inflating
        $data["id"] = "abcde12345";
        $data["attributes"]["accreditationStatus"] = LegalEntity::getValidAccreditationStatuses()[1];
        $entity = $this->datasource
            ->addClassToCreate("\\CFX\\Brokerage\\LegalEntity")
            ->addClassToCreate("\\CFX\\Brokerage\\Address")
            ->addClassToCreate("\\CFX\\Brokerage\\Document")
            ->addClassToCreate("\\CFX\\Brokerage\\Agreement")
            ->addClassToCreate("\\CFX\\Brokerage\\Agreement")
            ->setCurrentData($data)
            ->get("id=abcde12345")
        ;

        $this->assertFalse($entity->hasErrors());
        $this->assertFalse($entity->hasChanges());
    }
}

