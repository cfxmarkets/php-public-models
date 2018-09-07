<?php
namespace CFX\Brokerage;

class FundingSource extends \CFX\JsonApi\AbstractResource implements FundingSourceInterface
{
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'funding-sources';

    protected $attributes = [
        'availableBalance' => null,
        'pendingBalance' => null,
        'subnetRoutingNumberAch' => null,
        'subnetRoutingNumberWire' => null,
        'subnetAccountNumber' => null,
        'subnetEthAddress' => null,
        'subnetBtcAddress' => null,
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

    public function getSubnetRoutingNumberAch()
    {
        return $this->_getAttributeValue("subnetRoutingNumberAch");
    }

    public function getSubnetRoutingNumberWire()
    {
        return $this->_getAttributeValue("subnetRoutingNumberWire");
    }

    public function getSubnetAccountNumber()
    {
        return $this->_getAttributeValue("subnetAccountNumber");
    }

    public function getSubnetEthAddress()
    {
        return $this->_getAttributeValue("subnetEthAddress");
    }

    public function getSubnetBtcAddress()
    {
        return $this->_getAttributeValue("subnetBtcAddress");
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
        $this->validateRequired('owner', $val);
        return $this->_setRelationship('owner', $val);
    }
}

