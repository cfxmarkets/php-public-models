<?php
namespace CFX\Brokerage;

class BankAccount extends FundingSource implements BankAccountInterface
{
    use BankAccountTrait;

    protected $resourceType = 'bank-accounts';

    public function __construct(\CFX\JsonApi\DatasourceInterface $datasource, array $data = null)
    {
        $this->attributes += [
            'label' => null,
            'bankName' => null,
            'accountType' => null,
            'holderName' => null,
            'routingNum' => null,
            'accountNum' => null,
            'bankAddress' => null,
            'status' => false,
        ];
        parent::__construct($datasource, $data);
    }
}

