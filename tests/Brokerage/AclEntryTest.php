<?php
namespace CFX\Brokerage;

class AclEntryTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\AclEntry";

    public function testResourceType()
    {
        $this->assertEquals('acl-entries', $this->resource->getResourceType());
    }

    public function testPermissions()
    {
        $field = 'permissions';
        $this->assertInstantiatesInvalidly($field, 'required');
        $this->assertReadOnly($field);
        $this->assertChains($field);
    }

    public function testActor()
    {
        $field = 'actor';
        $this->assertInstantiatesInvalidly($field, 'required');
        $this->assertReadOnly($field, new AclEntry($this->datasource, [ "id" => "abcde12345" ]));
        $this->assertChains($field, null);
    }

    public function testTarget()
    {
        $field = 'target';
        $this->assertInstantiatesInvalidly($field, 'required');
        $this->assertReadOnly($field, new AclEntry($this->datasource, [ "id" => "abcde12345" ]));
        $this->assertChains($field, null);
    }
}


