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
        $this->assertValid($field, [ null, '', '8882221111', '8888888888', '+1234562323', 1234567890, "+493083050", '888.230.0000', '+1 888-555-2233' ], function($expected, $actual) {
            $expected = preg_replace("/[ .-]/", "", $expected);
            $this->assertEquals($expected, $actual);
        });
        $this->assertInvalid($field, [ '1234', 'nothing', true, false, new \DateTime(), [], 1234 ]);
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

    public function testAuthId()
    {
        $field = 'authId';
        $this->assertReadOnly($field, 'aaaa-bbbccccddd-ee111-22223333444-55');
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

    public function testYearsExpAlts()
    {
        $field = "yearsExpAlts";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, 0, 1, 10, 50 ]);
        $this->assertInvalid($field, [ "true", "false", true, false, '12345', 12345, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, 1, "attributes");
        $this->assertChains($field);
    }

    public function testYearsExpReits()
    {
        $field = "yearsExpReits";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, 0, 1, 10, 50 ]);
        $this->assertInvalid($field, [ "true", "false", true, false, '12345', 12345, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, 1, "attributes");
        $this->assertChains($field);
    }

    public function testYearsExpStocks()
    {
        $field = "yearsExpStocks";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, 0, 1, 10, 50 ]);
        $this->assertInvalid($field, [ "true", "false", true, false, '12345', 12345, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, 1, "attributes");
        $this->assertChains($field);
    }

    public function testYearsExpLp()
    {
        $field = "yearsExpLp";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, 0, 1, 10, 50 ]);
        $this->assertInvalid($field, [ "true", "false", true, false, '12345', 12345, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, 1, "attributes");
        $this->assertChains($field);
    }

    public function testEmploymentStatus()
    {
        $field = "employmentStatus";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "self-employed", "Self Employed", "Employed", "student" ]);
        $this->assertInvalid($field, [ true, false, '12345', 12345, new \DateTime(), [ "array of values" ], "This is an extremely long string that is hopefully longer than the maximum length of the field that is allowed by the code and accepted and validated and everything else, though I can't quite be sure that it's the longest string possible because that there is always the possibility of l + 1." ]);
        $this->assertChanged($field, "military", "attributes");
        $this->assertChains($field);
    }

    public function testEmploymentSector()
    {
        $field = "employmentSector";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "Non-Profit", "Metalurgy", "Web Design" ]);
        $this->assertInvalid($field, [ true, false, '12345', 12345, new \DateTime(), [ "array of values" ], "This is an extremely long string that is hopefully longer than the maximum length of the field that is allowed by the code and accepted and validated and everything else, though I can't quite be sure that it's the longest string possible because that there is always the possibility of l + 1." ]);
        $this->assertChanged($field, "military", "attributes");
        $this->assertChains($field);
    }

    public function testEmploymentPosition()
    {
        $field = "employmentPosition";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", "Business Consultant", "Web Application Developer", "CEO" ]);
        $this->assertInvalid($field, [ true, false, '12345', 12345, new \DateTime(), [ "array of values" ], "This is an extremely long string that is hopefully longer than the maximum length of the field that is allowed by the code and accepted and validated and everything else, though I can't quite be sure that it's the longest string possible because that there is always the possibility of l + 1." ]);
        $this->assertChanged($field, "Administrative Assistant", "attributes");
        $this->assertChains($field);
    }

    public function testEmployerName()
    {
        $field = "employerName";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "CFX Markets, LLC", "1&1.com", "Google+" ]);
        $this->assertInvalid($field, [ true, false, '12345', 12345, new \DateTime(), [ "array of values" ], "This is an extremely long string that is hopefully longer than the maximum length of the field that is allowed by the code and accepted and validated and everything else, though I can't quite be sure that it's the longest string possible because that there is always the possibility of l + 1." ]);
        $this->assertChanged($field, "Jewel Osco", "attributes");
        $this->assertChains($field);
    }

    public function testConsultsAdvisor()
    {
        $field = "consultsAdvisor";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", true, false ]);
        $this->assertInvalid($field, [ "true", "false", '12345', 12345, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, true, "attributes");
        $this->assertChains($field);
    }

    public function testConsultsAccountant()
    {
        $field = "consultsAccountant";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", true, false ]);
        $this->assertInvalid($field, [ "true", "false", '12345', 12345, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, true, "attributes");
        $this->assertChains($field);
    }

    public function testAgreedTOS()
    {
        $field = "agreedTOS";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", true, false ]);
        $this->assertInvalid($field, [ "true", "false", '12345', 12345, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, true, "attributes");
        $this->assertChains($field);
    }

    public function testAgreedDTA()
    {
        $field = "agreedDTA";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", true, false ]);
        $this->assertInvalid($field, [ "true", "false", '12345', 12345, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, true, "attributes");
        $this->assertChains($field);
    }

    public function testAgreedDTAArbitration()
    {
        $field = "agreedDTAArbitration";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, [ null, "", true, false ]);
        $this->assertInvalid($field, [ "true", "false", '12345', 12345, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, true, "attributes");
        $this->assertChains($field);
    }

    public function testInvestmentProfile()
    {
        $field = "investmentProfile";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, array_merge([ null, "" ], $this->resource::getValidInvestmentProfiles()));
        $this->assertInvalid($field, [ "true", "false", "not-a-profile", '12345', 12345, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, $this->resource::getValidInvestmentProfiles()[0], "attributes");
        $this->assertChains($field);
    }

    public function testRiskTolerance()
    {
        $field = "riskTolerance";
        $this->assertInstantiatesValidly($field);
        $this->assertValid($field, array_merge([ null, "" ], $this->resource::getValidRiskTolerances()));
        $this->assertInvalid($field, [ "true", "false", "nope", '12345', 12345, new \DateTime(), [ "array of values" ] ]);
        $this->assertChanged($field, $this->resource::getValidRiskTolerances()[0], "attributes");
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

