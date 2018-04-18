<?php
namespace CFX\Brokerage;

class OrderIntentTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\Test\\OrderIntent";

    public function testResourceType()
    {
        $this->assertEquals('order-intents', $this->resource->getResourceType());
    }

    public function instantiatesWithoutErrors()
    {
        $this->assertFalse($this->resource->hasErrors(), 'Should not have errors on intantiation');
    }

    public function testType()
    {
        $field = 'type';
        $this->assertValid($field, OrderIntent::getValidTypes());
        $this->assertInvalid($field, [ null, '', new \DateTime(), 2.5 ]);
        $this->assertChanged($field, OrderIntent::getValidTypes()[0], "attributes");
        $this->assertChains($field);
    }

    public function testNumShares()
    {
        $field = 'numShares';
        $this->assertValid($field, [ "12345", 11111, 2222.51 ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime() ]);
        $this->assertChanged($field, 5522, "attributes");
        $this->assertChains($field);
        $this->assertImmutableOnFinalStatus($field, 5555);
    }

    public function testPriceHigh()
    {
        $field = 'priceHigh';
        $this->assertValid($field, [ 2.15, "2.22", 2 ]);
        $this->assertInvalid($field, [ null, '', new \DateTime(), "bunk" ]);
        $this->assertChanged($field, 2.10, "attributes");
        $this->assertChains($field);
        $this->assertImmutableOnFinalStatus($field, 5);
    }

    public function testPriceLow()
    {
        $field = 'priceLow';
        $this->assertValid($field, [ null, '', 2.15, "2.22", 2 ]);
        $this->assertInvalid($field, [ new \DateTime(), "bunk" ]);
        $this->assertChanged($field, 2.10, "attributes");
        $this->assertChains($field);
        $this->assertImmutableOnFinalStatus($field, 5);
    }

    public function testReferralKey()
    {
        $field = 'referralKey';
        $this->assertValid($field, [ null, '', '0123456789abcdeffedcba9876543210' ]);
        $this->assertInvalid($field, [ '12345', 12345, new \DateTime(), [], true, false ]);
        $this->assertChanged($field, '0123456789abcdeeeedcba9876543210', "attributes");
        $this->assertChains($field);
    }

    public function testIssuerAccountNum()
    {
        $field = 'issuerAccountNum';
        $this->assertValid($field, [ null, '', '0123456789abcdef', 12345, 'asbasd-asdf_t123' ]);
        $this->assertInvalid($field, [ new \DateTime(), [], true, false ]);
        $this->assertChanged($field, '0123456789abcdeeeedcba9876543210', "attributes");
        $this->assertChains($field);
    }

    public function testStatus()
    {
        $field = 'status';
        $this->assertReadOnly($field);
        $this->assertChains($field, null);
    }

    public function testReferenceNum()
    {
        $field = 'referenceNum';
        $this->assertReadOnly($field);
        $this->assertChains($field, null);
    }

    public function testPaymentMethod()
    {
        $field = 'paymentMethod';
        $this->assertValid($field, [ null, '', "credit-card", "ach", "wire", "arbitrary method" ]);
        $this->assertInvalid($field, [ new \DateTime(), 1234, true, false ]);
        $this->assertChanged($field, "ach", "attributes");
        $this->assertChains($field);
    }

    public function testPaid()
    {
        $field = 'paid';
        $this->assertValid($field, [ true, false ]);
        $this->assertInvalid($field, [ new \DateTime(), 1234, "paid" ]);
        $this->assertChanged($field, true, "attributes");
        $this->assertChains($field);
    }

    public function testUser()
    {
        $field = 'user';
        $this->assertValid($field, [ new User($this->datasource) ]);
        $this->assertChanged($field, (new User($this->datasource))->setId("12345"), "relationships");
        $this->assertChains($field);
        $this->assertImmutableOnFinalStatus($field, (new User($this->datasource))->setId("54321"));
    }

    public function testAsset()
    {
        $field = 'asset';
        $this->assertValid($field, [ new \CFX\Exchange\Asset($this->datasource) ]);
        $this->assertChanged($field, (new \CFX\Exchange\Asset($this->datasource))->setId("12345"), "relationships");
        $this->assertChains($field);
        $this->assertImmutableOnFinalStatus($field, (new \CFX\Exchange\Asset($this->datasource))->setId("54321"));
    }

    public function testAssetIntent()
    {
        $field = 'assetIntent';
        $this->assertValid($field, [ new AssetIntent($this->datasource) ]);
        $this->assertChanged($field, (new AssetIntent($this->datasource))->setId("12345"), "relationships");
        $this->assertChains($field);
        $this->assertImmutableOnFinalStatus($field, (new AssetIntent($this->datasource))->setId("54321"));
    }

    public function testOrder()
    {
        $field = 'order';
        $this->assertReadOnly($field, (new \CFX\Exchange\Order($this->datasource))->setId("12345"));
        $this->assertChains($field, null);
    }

    public function testBankAccount()
    {
        $field = 'bankAccount';
        $this->assertValid($field, [ new BankAccount($this->datasource) ]);
        $this->assertChanged($field, (new BankAccount($this->datasource))->setId("12345"), "relationships");
        $this->assertChains($field);
        $this->assertImmutableOnFinalStatus($field, (new BankAccount($this->datasource))->setId("54321"));
    }

    public function testAssetOwner()
    {
        $field = 'assetOwner';
        $this->assertValid($field, [ new LegalEntity($this->datasource) ]);
        $this->assertChanged($field, (new LegalEntity($this->datasource))->setId("12345"), "relationships");
        $this->assertChains($field);
        $this->assertImmutableOnFinalStatus($field, (new LegalEntity($this->datasource))->setId("54321"));
    }


    protected function assertImmutableOnFinalStatus($field, $val, $assertSame = null)
    {
        $set = 'set'.ucfirst($field);
        $get = 'get'.ucfirst($field);

        $finalStatus = [ 'listed', 'sold', 'sold_closed', 'expired', 'cancelled' ];

        foreach($finalStatus as $status) {
            $this->resource->forceSetStatus($status);
            $this->assertEquals($status, $this->resource->getStatus(), "Test not able to set status correctly.... Should be `$status`, but is actually `{$this->getStatus()}`. Please fix.");
            $this->resource->$set($val);
            $this->assertContains('immutableStatus', array_keys($this->resource->getErrors($field)), "Should not be able to set `$field` when status is `$status`.");
            if ($assertSame) {
                $assertSame($val, $this->resource->$get());
            } else {
                $this->assertSame($val, $this->resource->$get());
            }
        }

        $this->resource->forceSetStatus('new');
        $this->resource->$set($val);
        $this->assertFalse($this->resource->hasErrors($field));
        if ($assertSame) {
            $assertSame($val, $this->resource->$get());
        } else {
            $this->assertSame($val, $this->resource->$get());
        }
    }

    public function testSuccessfullyInitializesAfterListed()
    {
        $this->datasource->setCurrentData([
            'id' => '1234',
            'type' => 'order-intents',
            'attributes' => [
                'type' => 'buy',
                'numShares' => '12345',
                'priceHigh' => 2.50,
                'status' => 'listed',
            ],
            'relationships' => [
                'user' => [
                    'data' => [
                        'id' => '1',
                        'type' => 'users',
                    ]
                ],
                'asset' => [
                    'data' => [
                        'id' => 'INVT001',
                        'type' => 'assets',
                    ]
                ],
                'assetOwner' => [
                    'data' => [
                        'id' => '1',
                        'type' => 'legal-entities',
                    ],
                ],
                'order' => [
                    'data' => [
                        'id' => '1',
                        'type' => 'orders',
                    ],
                ],
                'bankAccount' => [
                    'data' => [
                        'id' => '1',
                        'type' => 'bank-accounts',
                    ],
                ],
            ]
        ]);
        $this->datasource
            ->addClassToCreate("\\CFX\\Brokerage\\User")
            ->addClassToCreate("\\CFX\\Exchange\\Asset")
            ->addClassToCreate("\\CFX\\Brokerage\\LegalEntity")
            ->addClassToCreate("\\CFX\\Exchange\\Order")
            ->addClassToCreate("\\CFX\\Brokerage\\BankAccount");
        $intent = new \CFX\Brokerage\OrderIntent($this->datasource);

        $this->assertEquals([], json_decode(json_encode($intent->getErrors()), true));
    }

    public function testAgreement()
    {
        $this->markTestIncomplete();
    }

    public function testOwnershipDoc()
    {
        $this->markTestIncomplete();
    }

    public function testTender()
    {
        $field = 'tender';
        $this->assertValid($field, [ null, new Tender($this->datasource, ['id'=>'12345']) ]);
        $this->assertChanged($field, new Tender($this->datasource, ['id'=>'67890']), 'relationships');
        $this->assertChains($field, null);
    }

    public function testCreatedOn()
    {
        $field = 'createdOn';
        $this->assertReadOnly($field);
        $this->assertChains($field, null);

        $mock= new \CFX\JsonApi\Test\MockDatasource();

        // Test that it can be successfully created without errors
        $intent = $mock
            ->addClassToCreate("\\CFX\\Brokerage\\OrderIntent")
            ->create();

        $this->assertFalse($intent->hasErrors('createdOn'));
        $this->assertNull($intent->getCreatedOn());

        // Test that it can be successfully inflated without errors
        $intent = $mock
            ->addClassToCreate("\\CFX\\Brokerage\\OrderIntent")
            ->setCurrentData([
                'id' => 12345,
                'type' => 'order-intents',
            ])
            ->get("id=12345")
        ;

        $this->assertFalse($intent->hasErrors('createdOn'));
        $this->assertNull($intent->getCreatedOn());
    }
}

