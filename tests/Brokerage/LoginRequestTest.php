<?php
namespace CFX\Brokerage;

class LoginRequestTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\LoginRequest";

    public function testResourceType()
    {
        $this->assertEquals('login-requests', $this->resource->getResourceType());
    }

    public function testEmail()
    {
        $field = 'email';
        $this->assertValid($field, [ "something@this.com", "me123@456.com" ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime(), 111423, [], true, false ]);
        $this->assertChanged($field, "cha@fah.com", "attributes");
        $this->assertChains($field);
    }

    public function testEmailIsImmutable()
    {
        $this->markTestIncomplete();
    }

    public function testExpirationIsReadOnly()
    {
        $r = new \CFX\Brokerage\LoginRequest($this->datasource, [
            'attributes' => [
                'expiration' => '12345667788',
            ]
        ]);
        $this->assertTrue($r->hasErrors('expiration'));
        $this->assertContains('readonly', array_keys($r->getErrors('expiration')));
    }
}




