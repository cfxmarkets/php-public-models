<?php
namespace CFX\Brokerage;

class UserTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\User";

    public function testEmail()
    {
        $field = 'email';
        $this->assertValid($field, [ 'test@testerson.com', 't@v.co.uk', 't@v.us' ]);
        $this->assertInvalid($field, [ null, '', 'not an email' ]);
        $this->assertChanged($field, 'tester@email.com', "attributes");
        $this->assertChains($field);
    }

    public function testPhoneNumber()
    {
        $field = 'phoneNumber';
        $this->assertValid($field, [ '888.222.1111', '8888888888', '123-456-2323', 1234567890 ]);
        $this->assertInvalid($field, [ '1234', 'nothing', true, false, new \DateTime(), [], 12345 ]);
        $this->assertChanged($field, "111.222.3333", "attributes");
        $this->assertChains($field);
    }

    public function testDisplayName()
    {
        $field = 'displayName';
        $this->assertValid($field, [ 'Modu Chalaco' ]);
        $this->assertInvalid($field, [ true, false, new \DateTime(), [], 12345 ]);
        $this->assertChanged($field, 'Chalfant Hall', "attributes");
        $this->assertChains($field);
    }

    public function testTimezone()
    {
        $this->markTestIncomplete();
        $field = 'timezone';
        $this->assertValid($field, [  ]);
        $this->assertInvalid($field, [  ]);
        $this->assertChanged($field, "", "attributes");
        $this->assertChains($field);
    }

    public function testLanguage()
    {
        $this->markTestIncomplete();
        $field = 'language';
        $this->assertValid($field, [  ]);
        $this->assertInvalid($field, [  ]);
        $this->assertChanged($field, "", "attributes");
        $this->assertChains($field);
    }

    public function testReferralKey()
    {
        $field = 'referralKey';
        $this->assertValid($field, [ null, '', '0123456789abcdeffedcba9876543210' ]);
        $this->assertInvalid($field, [ '12345', 12345, new \DateTime(), [], true, false ]);
        $this->assertChanged($field, '0123456789abcdeeeedcba9876543210', "attributes");
        $this->assertChains($field);
    }

    public function testOAuthTokens()
    {
        $field = 'oAuthTokens';
        $this->assertReadOnly($field, new \CFX\JsonApi\ResourceCollection());
    }

    public function testPersonEntity()
    {
        $field = 'personEntity';
        $this->assertReadOnly($field, new LegalEntity($this->datasource, ['id'=>'12345']));
    }
}

