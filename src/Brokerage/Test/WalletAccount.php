<?php
namespace CFX\Brokerage\Test;

class WalletAccount extends \CFX\Brokerage\WalletAccount
{
    public function forceSetFundingInterfaces(\CFX\JsonApi\ResourceCollectionInterface $val)
    {
        return $this->setFundingInterfaces($val);
    }
}





