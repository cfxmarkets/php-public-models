<?php
namespace CFX\Brokerage;

class ContractTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\Contract";

    public function testResourceType()
    {
        $this->assertEquals("contracts", $this->resource->getResourceType());
    }

    public function testAudience()
    {
        $field = "audience";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertReadOnly($field);
    }

    public function testEffectiveDate()
    {
        $field = "effectiveDate";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertReadOnly($field);
    }

    public function testContractType()
    {
        $field = "contractType";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertReadOnly($field);
    }

    public function testUrl()
    {
        $field = "url";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertReadOnly($field);
    }

    public function testChangelog()
    {
        $field = "changelog";
        $this->assertInstantiatesValidly($field);
        $this->assertReadOnly($field);
    }
}

