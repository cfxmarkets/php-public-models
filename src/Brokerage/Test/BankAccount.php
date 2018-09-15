<?php
namespace CFX\Brokerage\Test;

class BankAccount extends \CFX\Brokerage\BankAccount
{
    public function forceSetFundingInterfaces(\CFX\JsonApi\ResourceCollectionInterface $val)
    {
        return $this->setFundingInterfaces($val);
    }
}




