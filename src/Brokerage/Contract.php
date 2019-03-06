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
        $val = $this->cleanNumberValue($val);
        if ($this->validateRequired($field, $val)) {
            if ($this->validateType($field, $val, "integer")) {
                $maxAud = 0;
                $audOptions = [];
                foreach(self::getAvailableAudiences() as $name => $aud) {
                    $maxAud += $aud;
                    $audOptions[] = "$aud: $name";
                }
                if ($val <= 0 || $val > $maxAud) {
                    $this->setError($field, "range", [
                        "title" => "Unacceptable Value",
                        "detail" => "Audience is a bitmask that must be greater than 0 ".
                            "and less than $maxAud. Available options are the following:\n\n * ".implode("\n * ", $audOptions),
                    ]);
                } else {
                    $this->clearError($field, "range");
                }
            }
        }
        return $this->_setAttribute($field, $val);
    }

    public function setEffectiveDate($val)
    {
        $field = "effectiveDate";
        $val = $this->cleanDateTimeValue($val);
        if ($this->validateRequired($field, $val)) {
            $this->validateType($field, $val, "datetime");
        }
        return $this->_setAttribute($field, $val);
    }

    public function setContractType($val)
    {
        $field = "contractType";
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired($field, $val)) {
            $this->validateAmong($field, $val, self::getAvailableContractTypes());
        }
        return $this->_setAttribute($field, $val);
    }

    public function setUrl($val)
    {
        $field = "url";
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired($field, $val)) {
            $this->validateType($field, $val, "url");
        }
        return $this->_setAttribute($field, $val);
    }

    public function setChangelog($val)
    {
        $field = "changelog";
        if ($val === "") {
            $val = null;
        }

        if ($val === null) {
            $this->clearError($field, "json-object");
        } else {
            $err = false;
            if (is_string($val)) {
                $decoded = json_decode($val, true);
                if ($decoded === null) {
                    $err = true;
                    $this->setError($field, "json-object", [
                        "title" => "Invalid JSON",
                        "detail" => "The object you've passed is not valid JSON"
                    ]);
                } else {
                    $val = $decoded;
                    $this->clearError($field, "json-object");
                }
            }

            if (!$err) {
                if (!is_array($val)) {
                    $this->setError($field, "json-object", [
                        "title" => "Invalid Object",
                        "detail" => "Changelog must be a JSON string or an array that serializes to JSON"
                    ]);
                } else {
                    $this->clearError($field, "json-object");
                }
            }
        }
        return $this->_setAttribute($field, $val);
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

