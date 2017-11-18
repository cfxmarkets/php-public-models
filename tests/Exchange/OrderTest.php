<?php
namespace CFX\Exchange;

class OrderTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Exchange\\Test\\Order";

    public function testResourceType()
    {
        $this->assertEquals('orders', $this->resource->getResourceType());
    }

    public function testSide()
    {
        $field = 'side';
        $this->assertValid($field, [ 'buy', 'sell' ]);
        $this->assertInvalid($field, [ null, '', new \DateTime(), 2.5 ]);
        $this->assertChanged($field, 'buy', "attributes");
        $this->assertChains($field);

        $this->markTestIncomplete("Should test that `side` is immutable after save.");
    }

    public function testLotSize()
    {
        $field = 'lotSize';
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

    public function testStatus()
    {
        $field = 'status';
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertReadOnly($field);
        $this->assertChains($field, null);
    }

    public function testStatusDetail()
    {
        $field = 'statusDetail';
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertReadOnly($field);
        $this->assertChains($field, null);
    }

    public function testDocumentKey()
    {
        $field = 'documentKey';
        $this->assertValid($field, [ null, '', "abcde12345" ]);
        $this->assertInvalid($field, [ new \DateTime(), 2.15 ]);
        $this->assertChanged($field, "12345abcde", "attributes");
        $this->assertChains($field);
    }

    public function testReferenceKey()
    {
        $field = 'referenceKey';
        $this->assertValid($field, [ "abcde12345" ]);
        $this->assertInvalid($field, [ null, '', new \DateTime(), 2.15 ]);
        $this->assertChanged($field, "12345abcde", "attributes");
        $this->assertChains($field);
        $this->assertImmutableOnFinalStatus($field, "54321edcba");
    }

    public function testBankAccountId()
    {
        $field = 'bankAccountId';
        $this->assertValid($field, [ null, '', 'abcde', '12345', 'abcde-12345' ]);
        $this->assertInvalid($field, [ new \DateTime(), 2.15 ]);
        $this->assertChanged($field, "12345abcde", "attributes");
        $this->assertChains($field);
    }

    public function testAsset()
    {
        $field = 'asset';
        $this->assertValid($field, [ new \CFX\Exchange\Asset($this->datasource) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, (new \CFX\Exchange\Asset($this->datasource))->setId("12345"), "relationships");
        $this->assertChains($field);
        $this->assertImmutableOnFinalStatus($field, (new \CFX\Exchange\Asset($this->datasource))->setId("54321"));
    }

    protected function assertImmutableOnFinalStatus($field, $val, $assertSame = null)
    {
        $set = 'set'.ucfirst($field);
        $get = 'get'.ucfirst($field);

        $finalStatus = [ 'active', 'matched', 'expired', 'cancelled' ];

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
}


