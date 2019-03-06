<?php
namespace CFX\Brokerage;

class Contract extends \CFX\JsonApi\AbstractResource implements ContractInterface
{
    use \CFX\ResourceValidationsTrait;
    protected $resourceType = "contracts";

    protected $attributes = [
        "audience" => null,
        "effectiveDate" => null,
        "contractType" => null,
        "url" => null,
        "changelog" => null,
    ];

    public static function getAvailableAudiences()
    {
        return [
            "users" => 1,
            "non-person-entities" => 2
        ];
    }

    public static function getAvailableContractTypes()
    {
        return [
            "ofn-tos",
            "ofn-dta",
        ];
    }





    public function getAudience()
    {
        return $this->_getAttributeValue("audience");
    }

    public function getEffectiveDate()
    {
        return $this->_getAttributeValue("effectiveDate");
    }

    public function getContractType()
    {
        return $this->_getAttributeValue("contractType");
    }

    public function getUrl()
    {
        return $this->_getAttributeValue("url");
    }

    public function getChangelog()
    {
        return $this->_getAttributeValue("changelog");
    }




    public function setAudience($val)
    {
        $field = "audience";
        if ($this->validateReadOnly($field, $val)) {
            $this->validateRequired($field, $val);
            $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setEffectiveDate($val)
    {
        $field = "effectiveDate";
        if ($this->validateReadOnly($field, $val)) {
            $this->validateRequired($field, $val);
            $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setContractType($val)
    {
        $field = "contractType";
        if ($this->validateReadOnly($field, $val)) {
            $this->validateRequired($field, $val);
            $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setUrl($val)
    {
        $field = "url";
        if ($this->validateReadOnly($field, $val)) {
            $this->validateRequired($field, $val);
            $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setChangelog($val)
    {
        $field = "changelog";
        if ($this->validateReadOnly($field, $val)) {
            $this->_setAttribute($field, $val);
        }
        return $this;
    }





    public function serializeAttribute($name)
    {
        if (strpos($name, "Date") !== false) {
            $get = "get".ucfirst($name);
            $val = $this->$get();
            if ($val instanceof \DateTimeInterface) {
                $val = $val->format("Y-m-d H:i:s");
            }
            return $val === null ? null : (string)$val;
        }
        return parent::serializeAttribute($name);
    }
}

