<?php
namespace CFX\Brokerage;

class FundingSource extends \CFX\JsonApi\AbstractResource implements FundingSourceInterface
{
    use \CFX\ResourceValidationsTrait;
    use \CFX\JsonApi\Rel2MTrait;

    protected $resourceType = 'funding-sources';

    protected $attributes = [
        'availableBalance' => null,
        'pendingBalance' => null,
    ];

    protected $relationships = [
        'owner' => null,
        "fundingInterfaces" => null,
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

 	public function getFundingInterfaces()
    {
        return $this->get2MRel("fundingInterfaces");
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
        $this->validateRequired('owner', $val);
        return $this->_setRelationship('owner', $val);
    }

    protected function setFundingInterfaces(\CFX\JsonApi\ResourceCollectionInterface $val = null)
    {
        return $this->_setRelationship('fundingInterfaces', $val);
    }

    public function addFundingInterface(FundingInterfaceInterface $val)
    {
        return $this->add2MRel("fundingInterfaces", $val);
    }

    public function hasFundingInterface(FundingInterfaceInterface $val)
    {
        return $this->has2MRel("fundingInterfaces", $val);
    }

    public function removeFundingInterface(FundingInterfaceInterface $val)
    {
        return $this->remove2MRel("fundingInterfaces", $val);
    }
}

