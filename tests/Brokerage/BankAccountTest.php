<?php 
namespace CFX\Brokerage;

class BankAccountTest extends FundingSourceTest
{
    protected $className = "\\CFX\\Brokerage\\BankAccount";

    public function testResourceType()
    {
        $this->assertEquals('bank-accounts', $this->resource->getResourceType());
    }

    public function testLabel()
    {
        $field = 'label';
        $this->assertValid($field, [ "Personal Account", "Account # 11555" ]);
        $this->assertInvalid($field, [ null, '', new \DateTime(), 2.5 ]);
        $this->assertChanged($field, "New Label", "attributes");
        $this->assertChains($field);
    }

    public function testBankName()
    {
        $field = 'bankName';
        $this->assertValid($field, [ "Chase", "Bank of America", "Podunk Bank #1" ]);
        $this->assertInvalid($field, [ null, '', new \DateTime(), 2.5 ]);
        $this->assertChanged($field, "New name", "attributes");
        $this->assertChains($field);
    }

    public function testAccountType()
    {
        $field = 'accountType';
        $this->assertValid($field, [ "checking:personal", "checking:business", "ira", "wire", "savings" ]);
        $this->assertInvalid($field, [ null, '', new \DateTime(), 2.5, "checking", "bunk" ]);
        $this->assertChanged($field, "ira", "attributes");
        $this->assertChains($field);
    }

    public function testHolderName()
    {
        $field = 'holderName';
        $this->assertValid($field, [ "Mr. Eric Holder", "Test Testerson", "Test" ]);
        $this->assertInvalid($field, [ null, '', new \DateTime(), 2.5 ]);
        $this->assertChanged($field, "New Holder", "attributes");
        $this->assertChains($field);
    }

    public function testRoutingNum()
    {
        $field = 'routingNum';
        $this->assertValid($field, [ null, '', 123456789, "123456789", "AB-DD1235" ]);
        $this->assertInvalid($field, [ new \DateTime(), 2.5 ]);
        $this->assertChanged($field, "new-111555", "attributes");
        $this->assertChains($field);
    }

    public function testAccountNum()
    {
        $field = 'accountNum';
        $this->assertValid($field, [ "55112233", 122345567, "AB-CC122345" ]);
        $this->assertInvalid($field, [ null, '', new \DateTime(), 2.5 ]);
        $this->assertChanged($field, "new-155223", "attributes");
        $this->assertChains($field);
    }

    public function testSwiftCode()
    {
        $field = "swiftCode";
        $this->assertValid($field, [ null, "", "DEUTDEFF", "NEDSZAJJXXX", "DEUTDEFF500" ]);
        $this->assertInvalid($field, [ "11112222", "111122223333", "D3UTDEFF5X0", "D3UTDEFF500", true, false, new \DateTime(), [ ] ]);
        $this->assertChanged($field, "DABADKKK", "attributes");
        $this->assertChains($field);

        // Should normalize input
        $this->resource->setSwiftCode("DeuTdEFFxxx");
        $this->assertEquals("DEUTDEFFXXX", $this->resource->getSwiftCode());
    }

    // Should accept routing number, Swift Code, or both, but NOT neither
    public function testSwiftCodeORRoutingNumber()
    {
        $this->assertTrue($this->resource->hasErrors("swiftOrRouting", "required"), "Should initialize with errors on swiftOrRouting");

        $this->resource->setSwiftCode("DEUTDEFF");
        $this->assertFalse($this->resource->hasErrors("swiftOrRouting", "required"), "Should no longer have errors when swift code is set");

        $this->resource->setSwiftCode(null);
        $this->assertTrue($this->resource->hasErrors("swiftOrRouting", "required"), "Should return to error condition when no swiftOrRouting");

        $this->resource->setRoutingNum("123456789");
        $this->assertFalse($this->resource->hasErrors("swiftOrRouting", "required"), "Should no longer have errors when routing num is set");

        $this->resource->setRoutingNum(null);
        $this->assertTrue($this->resource->hasErrors("swiftOrRouting", "required"), "Should return to error condition when no swiftOrRouting");

        $this->resource->setRoutingNum("123456789");
        $this->resource->setSwiftCode("DEUTDEFF");
        $this->assertFalse($this->resource->hasErrors("swiftOrRouting", "required"), "Should not have errors when swift and routing number are set.");
    }

    public function testBankAddress()
    {
        $field = 'bankAddress';
        $this->assertValid($field, [ "1234 S Main St, Southport, IN 55023" ]);
        $this->assertInvalid($field, [ null, '', new \DateTime(), 2.5 ]);
        $this->assertChanged($field, "1111 New Address, Chicago, IL", "attributes");
        $this->assertChains($field);
    }

    public function testStatus()
    {
        $field = 'status';
        $this->assertReadOnly($field, "approved");
    }
}

