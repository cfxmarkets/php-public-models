<?php
namespace CFX\Brokerage;

class FundingSource extends \CFX\JsonApi\AbstractResource implements FundingSourceInterface
{
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'funding-sources';

    protected $attributes = [
        'availableBalance' => null,
        'pendingBalance' => null,
    ];

    protected $relationships = [
        'owner' => null,
    ];


 	public function getAvailableBalance()
    {
        return $this->_getAttributeValue("availableBalance");
    }

 	public function getPendingBalance()
    {
        return $this->_getAttributeValue("pendingBalance");
    }

 	public function getOwner()
    {
        return $this->_getRelationshipValue("owner");
    }



    public function setAvailableBalance($val = null)
    {
        if ($this->validateReadOnly("availableBalance", $val)) {
            $this->_setAttribute("availableBalance", $val);
        }
        return $this;
    }

    public function setPendingBalance($val = null)
    {
        if ($this->validateReadOnly("pendingBalance", $val)) {
            $this->_setAttribute("pendingBalance", $val);
        }
        return $this;
    }

    public function setOwner(?LegalEntityInterface $val)
    {
        return $this->_setRelationship("owner", $val);
    }
}
