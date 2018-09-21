<?php
namespace CFX\Brokerage;

class FundsTransferTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\FundsTransfer";

    public function testResourceType()
    {
        $this->assertEquals('funds-transfers', $this->resource->getResourceType());
    }

    public function testType() {
        $field = 'type';

        $this->assertInvalid($field, [ null, '', 'bunk' ]);
        $this->assertValid($field, $this->resource::getValidTypes());
        $this->assertChanged($field, $this->resource::getValidTypes()[1], 'attributes');
        $this->assertChains($field);
    }

    public function testAmount()
    {
        $field = 'amount';
        $this->assertValid($field, [ "5", "50000", 34000, .01 ]);
        $this->assertInvalid($field, [ null, '', 'bunk', -1000, 0, 0.005, false, true, [ "array of values" ], new \DateTime() ]);
        $this->assertChanged($field, 12345, 'attributes');
        $this->assertChains($field);
    }

    public function testStatus()
    {
        $field = "status";
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertReadOnly($field);
    }

    public function testCreatedOn()
    {
        $field = 'createdOn';
        $this->assertReadOnly($field);
        $this->assertChains($field, null);

        // Test that it can be successfully created without errors
        $transfer = $this->datasource
            ->addClassToCreate($this->className)
            ->create();

        $this->assertFalse($transfer->hasErrors('createdOn'));
        $this->assertNull($transfer->getCreatedOn());

        // Test that it can be successfully inflated without errors
        $transfer = $this->datasource
            ->addClassToCreate($this->className)
            ->setCurrentData([
                'id' => 12345,
                'type' => 'funds-transfers',
            ])
            ->get("id=12345")
        ;

        $this->assertFalse($transfer->hasErrors('createdOn'));
        $this->assertNull($transfer->getCreatedOn());
    }

    public function testIdpKey()
    {
        $field = "idpKey";
        $this->assertValid($field, [ "11112222333344445555", "abcdefghijklmnopqrstuv", "111122223333444455556666777788889999" ]);
        $this->assertInvalid($field, [ "abcde", "aaaabbbbccccdddd111", "1111222233334444555566667777888899990000" ]);
        $this->assertChanged($field, "kdkkd3j3j383iekkdkdkdkdkddkdkdkdk", "attributes");
        $this->assertChains($field);
    }

    public function testMemo()
    {
        $field = "memo";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "11112222333344445555", "Transfer to account xxxxx-3823" ]);
        $this->assertInvalid($field, [ true, false, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, "My new transfer", "attributes");
        $this->assertChains($field);
    }

    public function testLegalEntity()
    {
        $field = 'legalEntity';
        $this->assertValid($field, [ (new LegalEntity($this->datasource))->setId("12345") ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, (new LegalEntity($this->datasource))->setId("65432"), "relationships");
        $this->assertChains($field, null);
    }

    public function testFundingSource()
    {
        $field = "fundingSource";
        $this->assertValid($field, [ (new FundingSource($this->datasource))->setId("12345") ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, (new FundingSource($this->datasource))->setId("65432"), "relationships");
        $this->assertChains($field, null);
    }
}

