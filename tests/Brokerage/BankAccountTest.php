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
        $this->assertValid($field, [ 123456789, "123456789", "AB-DD1235" ]);
        $this->assertInvalid($field, [ null, '', new \DateTime(), 2.5 ]);
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

