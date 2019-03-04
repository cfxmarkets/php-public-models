<?php
namespace CFX\Brokerage;

class ReleaseTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\Release";

    public function testResourceType()
    {
        $this->assertEquals("releases", $this->resource->getResourceType());
    }

    public function testBetaStartDate()
    {
        $field = "betaStartDate";
        $this->assertInstantiatesInvalidly($field, "must be a(n) datetime");
        $this->assertReadOnly($field);
    }

    public function testReleaseDate()
    {
        $field = "releaseDate";
        $this->assertInstantiatesInvalidly($field, "must be a(n) datetime");
        $this->assertReadOnly($field);
    }

    public function testCurrentUserOptIn()
    {
        $field = "currentUserOptIn";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ true, false, null, "", 1, 0 ]);
        $this->assertInvalid($field, [ new \DateTime(), 111423, [] ]);
        $this->assertChains($field);
    }
}



