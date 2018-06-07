<?php
namespace CFX\Brokerage;

class FundingSource extends \CFX\JsonApi\AbstractResource implements FundingSourceInterface
{
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'funding-sources';

    protected $attributes = [
        'type' => null,
        'availableBalance' => null,
        'pendingBalance' => null,
    ];

    protected $relationships = [
        'ownerEntity' => null,
    ];

    public static function getValidTypes()
    {
        return [
            'bank-accounts',
        ];
    }

    public function getType()
    {
        return $this->_getAttributeValue("type");
    }

 	public function getAvailableBalance()
    {
        return $this->_getAttributeValue("availableBalance");
    }

 	public function getPendingBalance()
    {
        return $this->_getAttributeValue("pendingBalance");
    }

 	public function getOwnerEntity()
    {
        return $this->_getRelationshipValue("ownerEntity");
    }



    protected function setType($val)
    {
        if ($this->validateAmong("type", $val, static::getValidTypes())) {
            $this->_setAttribute("type", $val);
        }
        return $this;
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

    public function setOwnerEntity(?LegalEntityInterface $val)
    {
        return $this->_setRelationship("ownerEntity", $val);
    }
}

