<?php
namespace CFX\Brokerage;

class WalletAccountTest extends FundingSourceTest
{
    protected $className = "\\CFX\\Brokerage\\Test\\WalletAccount";

    public function testResourceType()
    {
        $this->assertEquals('wallet-accounts', $this->resource->getResourceType());
    }
}

