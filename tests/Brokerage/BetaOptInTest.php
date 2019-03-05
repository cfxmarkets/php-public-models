<?php
namespace CFX\Brokerage;

class BetaOptInTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\BetaOptIn";

    public function testResourceType()
    {
        $this->assertEquals("beta-opt-ins", $this->resource->getResourceType());
    }

    public function testOptIn()
    {
        $field = "optIn";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ true, false, null, "", 1, 0 ]);
        $this->assertInvalid($field, [ new \DateTime(), 111423, [], "True" ]);
        $this->assertChains($field);
    }

    public function testUpdatedOn()
    {
        $field = "updatedOn";
        $this->assertInstantiatesValidly($field);
    }

    public function testUser()
    {
        $field = 'user';
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ new User($this->datasource) ]);
        $this->assertChanged($field, (new User($this->datasource))->setId("12345"), "relationships");
        $this->assertChains($field);
    }

    public function testRelease()
    {
        $field = 'release';
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ new Release($this->datasource) ]);
        $this->assertChanged($field, (new Release($this->datasource))->setId("12345"), "relationships");
        $this->assertChains($field);
    }
}




