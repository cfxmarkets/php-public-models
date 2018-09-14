<?php
namespace CFX\Brokerage\Test;

class FundingSource extends \CFX\Brokerage\FundingSource
{
    public function forceSetFundingInterfaces(\CFX\JsonApi\ResourceCollectionInterface $val)
    {
        return $this->setFundingInterfaces($val);
    }
}



