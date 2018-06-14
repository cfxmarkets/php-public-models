<?php
namespace CFX\Brokerage;

trait BankAccountTrait {
    protected static $validAccountTypes = [
        "checking:personal",
        "checking:business",
        "savings",
        "ira",
        "wire",
    ];

    public static function getValidAccountTypes()
    {
        return self::$validAccountTypes;
    }

    public function getLabel()
    {
        return $this->_getAttributeValue('label');
    }

    public function getBankName()
    {
        return $this->_getAttributeValue('bankName');
    }

    public function getAccountType()
    {
        return $this->_getAttributeValue('accountType');
    }

    public function getHolderName()
    {
        return $this->_getAttributeValue('holderName');
    }

    public function getRoutingNum()
    {
        return $this->_getAttributeValue('routingNum');
    }

    public function getAccountNum()
    {
        return $this->_getAttributeValue('accountNum');
    }

    public function getBankAddress()
    {
        return $this->_getAttributeValue('bankAddress');
    }

    public function getStatus()
    {
        return $this->_getAttributeValue('status');
    }

    public function getOwner()
    {
        return $this->_getRelationshipValue('owner');
    }





    public function setLabel($val)
    {
        $val = $this->cleanStringValue($val);

        if ($this->validateRequired('label', $val)) {
            $this->validateType('label', $val, 'string');
        }

        return $this->_setAttribute('label', $val);
    }

    public function setBankName($val)
    {
        $val = $this->cleanStringValue($val);

        if ($this->validateRequired('bankName', $val)) {
            $this->validateType('bankName', $val, 'string');
        }

        return $this->_setAttribute('bankName', $val);
    }

    public function setAccountType($val)
    {
        $val = $this->cleanStringValue($val);

        if ($this->validateRequired('accountType', $val)) {
            $this->validateAmong('accountType', $val, $this::getValidAccountTypes());
        }

        return $this->_setAttribute('accountType', $val);
    }

    public function setHolderName($val)
    {
        $val = $this->cleanStringValue($val);

        if ($this->validateRequired('holderName', $val)) {
            $this->validateType('holderName', $val, 'string');
        }

        return $this->_setAttribute('holderName', $val);
    }

    public function setRoutingNum($val)
    {
        $val = $this->cleanStringValue($val);

        if ($this->validateRequired('routingNum', $val)) {
            $this->validateType('routingNum', $val, 'string or int');
        }

        return $this->_setAttribute('routingNum', $val);
    }

    public function setAccountNum($val)
    {
        $val = $this->cleanStringValue($val);

        if ($this->validateRequired('accountNum', $val)) {
            $this->validateType('accountNum', $val, 'string or int');
        }

        return $this->_setAttribute('accountNum', $val);
    }

    public function setBankAddress($val)
    {
        $val = $this->cleanStringValue($val);

        if ($this->validateRequired('bankAddress', $val)) {
            $this->validateType('bankAddress', $val, 'string');
        }

        return $this->_setAttribute('bankAddress', $val);
    }

    public function setStatus($val)
    {
        $val = $this->cleanBooleanValue($val);
        if ($this->validateReadOnly('status', $val)) {
            $this->_setAttribute('status', $val);
        }
        return $this;
    }


    protected function serializeAttribute($name)
    {
        if ($name === 'status') {
            if ($this->getStatus() !== null) {
                return (int)$this->getStatus();
            } else {
                return $this->getStatus();
            }
        }
        return parent::serializeAttribute($name);
    }
}
