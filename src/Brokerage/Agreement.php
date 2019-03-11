<?php
namespace CFX\Brokerage;

class Agreement extends \CFX\JsonApi\AbstractResource implements AgreementInterface
{
    use \CFX\ResourceValidationsTrait;
    protected $resourceType = "agreements";

    protected $attributes = [
        "timestamp" => null,
    ];

    protected $relationships = [
        "contract" => null,
        "entity" => null,
        "signer" => null,
    ];




    public function getTimestamp()
    {
        return $this->_getAttributeValue("timestamp");
    }

    public function getContract()
    {
        return $this->_getRelationshipValue("contract");
    }

    public function getEntity()
    {
        return $this->_getRelationshipValue("entity");
    }

    public function getSigner()
    {
        return $this->_getRelationshipValue("signer");
    }



    protected function setTimestamp($val)
    {
        $field = "timestamp";
        $val = $this->cleanDateTimeValue($val);
        if ($this->validateReadonly($field, $val)) {
            $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setContract(?ContractInterface $val)
    {
        $field = "contract";
        if ($this->validateRequired($field, $val)) {
            $this->validateImmutable($field, $val);
        }
        return $this->_setRelationship($field, $val);
    }

    public function setEntity(?LegalEntityInterface $val)
    {
        $field = "entity";
        if ($this->validateRequired($field, $val)) {
            $this->validateImmutable($field, $val);
        }
        return $this->_setRelationship($field, $val);
    }

    public function setSigner(?UserInterface $val)
    {
        $field = "signer";
        if ($this->validateRequired($field, $val)) {
            $this->validateImmutable($field, $val);
        }
        return $this->_setRelationship($field, $val);
    }






    public function serializeAttribute($name)
    {
        if ($name === "timestamp") {
            $val = $this->getTimestamp();
            if ($val instanceof \DateTimeInterface) {
                $val = $val->format("Y-m-d H:i:s");
            }
            return $val === null ? null : (string)$val;
        }
        return parent::serializeAttribute($name);
    }
}


