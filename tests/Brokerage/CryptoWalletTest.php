<?php
namespace CFX\Brokerage;

class CryptoWalletTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\CryptoWallet";

    public function testResourceType()
    {
        $this->assertEquals('crypto-wallets', $this->resource->getResourceType());
    }

    public function testProtocol() {
        $field = "protocol";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "p2p" ]);
        $this->assertInvalid($field, [ "not-buy", "trad", new \DateTime(), 2.5, [ "array of values" ] ]);
        $this->assertChanged($field, "new-val", "attributes");
        $this->assertChains($field);
    }

    public function testNetwork()
    {
        $field = 'network';
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "ethereum" ]);
        $this->assertInvalid($field, [ "bitcoin", 0, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, "new-val", "attributes");
        $this->assertChains($field);
    }

    public function testPriority()
    {
        $field = 'priority';
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, 0, 10, 20, 100, 1000, -100 ]);
        $this->assertInvalid($field, [ "top", new \DateTime(), "bunk", [ "array of values" ] ]);
        $this->assertChanged($field, 30, "attributes");
        $this->assertChains($field);
    }

    public function testStatus()
    {
        $field = "status";
        $this->assertInstantiatesValidly($field);
        $this->assertReadOnly($field);
        $this->assertChains($field, null);
    }

    public function testOwnerEntity()
    {
        $field = "ownerEntity";
        $this->assertInstantiatesValidly($field);
        $this->assertReadOnly($field, (new \CFX\Brokerage\LegalEntity($this->datasource))->setId("abcde"));
        $this->assertChains($field, null);
    }
}

