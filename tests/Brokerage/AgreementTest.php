<?php
namespace CFX\Brokerage;

class AgreementTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\Agreement";

    public function testResourceType()
    {
        $this->assertEquals("agreements", $this->resource->getResourceType());
    }

    public function testTimestamp()
    {
        $field = "timestamp";
        $this->assertInstantiatesValidly($field);
    }

    public function testContract()
    {
        $field = "contract";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ new Contract($this->datasource) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, (new Contract($this->datasource))->setId("abcde12345"), "relationships");
        $this->assertChains($field);
    }

    public function testEntity()
    {
        $field = "entity";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ new LegalEntity($this->datasource) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, (new LegalEntity($this->datasource))->setId("abcde12345"), "relationships");
        $this->assertChains($field);
    }

    public function testSigner()
    {
        $field = "signer";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ new User($this->datasource) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, (new User($this->datasource))->setId("abcde12345"), "relationships");
        $this->assertChains($field);
    }
}


