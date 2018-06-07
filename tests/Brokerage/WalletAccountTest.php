<?php
namespace CFX\Brokerage;

class WalletAccountTest extends FundingSourceTest
{
    protected $className = "\\CFX\\Brokerage\\WalletAccount";

    public function testResourceType()
    {
        $this->assertEquals('wallet-accounts', $this->resource->getResourceType());
    }
}

