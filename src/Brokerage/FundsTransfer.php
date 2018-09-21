<?php
namespace CFX\Brokerage;

class FundsTransfer extends \CFX\JsonApi\AbstractResource implements FundsTransferInterface
{
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = "funds-transfers";
    protected $attributes = [
        "type" => null,
        "amount" => null,
        "idpKey" => null,
        "memo" => null,
        "status" => 1,
        "createdOn" => null,
    ];
    protected $relationships = [
        "legalEntity" => null,
        "fundingSource" => null,
    ];

    public static function getValidTypes()
    {
        return [
            'credit',
            'debit',
        ];
    }

    public function getType()
    {
        return $this->_getAttributeValue("type");
    }

    public function getAmount()
    {
        return $this->_getAttributeValue("amount");
    }

    public function getIdpKey()
    {
        return $this->_getAttributeValue("idpKey");
    }

    public function getMemo()
    {
        return $this->_getAttributeValue("memo");
    }

    public function getStatus()
    {
        return $this->_getAttributeValue("status");
    }

    public function getCreatedOn()
    {
        return $this->_getAttributeValue("createdOn");
    }

    public function getLegalEntity()
    {
        return $this->_getRelationshipValue("legalEntity");
    }

    public function getFundingSource()
    {
        return $this->_getRelationshipValue("fundingSource");
    }




    public function setType($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateAmong("type", $val, static::getValidTypes(), true);
        return $this->_setAttribute("type", $val);
    }

    public function setAmount($val)
    {
        $val = $this->cleanNumberValue($val);
        if ($this->validateType("amount", $val, "non-string numeric", true)) {
            if ($val*100 < 1) {
                $this->setError("amount", "range", [
                    "title" => "Invalid value for field `amount`",
                    "detail" => "Sorry, we can't do transfers of less than $0.01 USD"
                ]);
            } else {
                $this->clearError("amount", "range");
            }
        } else {
            $this->clearError("amount", "range");
        }
        return $this->_setAttribute("amount", $val);
    }

    public function setIdpKey($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateType("idpKey", $val, "string", true)) {
            if (strlen($val) < 20 || strlen($val) > 36) {
                $this->setError("idpKey", "range", [
                    "title" => "Invalid idempotency key (`idpKey`)",
                    "detail" => "The idempotency key you generate must be between 20 and 36 characters in length.",
                ]);
            } else {
                $this->clearError("idpKey", "range");
            }
        } else {
            $this->clearError("idpKey", "range");
        }
        return $this->_setAttribute("idpKey", $val);
    }

    public function setMemo($val)
    {
        $field = "memo";
        $val = $this->cleanStringValue($val);
        if ($this->validateType($field, $val, "string", false)) {
            $this->validateStrlen($field, $val, 0, 1000, false);
        }
        return $this->_setAttribute($field, $val);
    }

    public function setStatus($val)
    {
        if ($this->validateReadOnly("status", $val)) {
            $this->_setAttribute("status", $val);
        }
        return $this;
    }

    public function setCreatedOn($val)
    {
        if ($this->validateReadOnly("createdOn", $val)) {
            $this->_setAttribute("createdOn", $val);
        }
        return $this;
    }

    public function setLegalEntity(\CFX\Brokerage\LegalEntityInterface $val = null)
    {
        $this->validateRequired("legalEntity", $val);
        return $this->_setRelationship("legalEntity", $val);
    }

    public function setFundingSource(\CFX\Brokerage\FundingSourceInterface $val = null)
    {
        $this->validateRequired("fundingSource", $val);
        return $this->_setRelationship("fundingSource", $val);
    }
}


