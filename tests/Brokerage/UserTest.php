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
        $this->assertValid($field, [ null, '', '8882221111', '8888888888', '1234562323', 1234567890 ]);
        $this->assertInvalid($field, [ '888.230.0000', '+1 888-555-2233', '1234', 'nothing', true, false, new \DateTime(), [], 1234 ]);
        $this->assertChanged($field, "1112223333", "attributes");
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

    public function testSelfAccredited()
    {
        $field = 'selfAccredited';
        $this->assertValid($field, [ null, '', '1', 1, '0', 0, true, false ], function($expected, $actual) {
            if ($expected === '') {
                $expected = null;
            } elseif (is_numeric($expected)) {
                $expected = (bool)$expected;
            }
            $this->assertEquals($expected, $actual);
        });
        $this->assertInvalid($field, [ "true", "false", '12345', 12345, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, true, "attributes");
        $this->assertChains($field);

        // Test that it serializes to ints
        $this->resource->setSelfAccredited(true);
        $data = $this->resource->jsonSerialize();
        $this->assertTrue(is_int($data["attributes"]["selfAccredited"]), "Should have serialized to integer");
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

