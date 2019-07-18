<?php
namespace CFX\Exchange;

class Asset extends \CFX\JsonApi\AbstractResource implements AssetInterface {
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'assets';
    protected $attributes = [
        'issuer' => null,
        'name' => null,
        'type' => null,
        'statusCode' => 0,
        'statusText' => "closed",
        'description' => null,
        "platform" => null,
        "platformVersion" => null,
        "resolutionUri" => null,
        "exemptionType" => null,
        "isFund" => false,
        "issuanceCloseDate" => null,
        "commonName" => null,
        "infoUrl" => null,
        "usTradable" => false,
        "accreditedOnly" => true,
    ];
    protected $relationships = [];

    public static function getValidTypes()
    {
        return [
            "real_estate",
            "realestate",
            "private",
            "private_equity",
            "venture",
            "reit",
            "crypto",
            "hedgefund",
        ];
    }

    public static function getValidStatuses()
    {
        return [
            0 => "closed",
            1 => "open",
        ];
    }

    public static function getValidExemptionTypes()
    {
        return [
            "regd",
            "regds",
            "rega",
            "rega+",
            "regcf",
            "regs",
        ];
    }

    public function getIssuer()
    {
        return $this->_getAttributeValue('issuer');
    }
    public function getName()
    {
        return $this->_getAttributeValue('name');
    }
    public function getType()
    {
        return $this->_getAttributeValue('type');
    }
    public function getStatusCode()
    {
        return $this->_getAttributeValue('statusCode');
    }
    public function getStatusText()
    {
        return $this->_getAttributeValue('statusText');
    }
    public function getDescription()
    {
        return $this->_getAttributeValue('description');
    }
    public function getPlatform()
    {
        return $this->_getAttributeValue("platform");
    }
    public function getPlatformVersion()
    {
        return $this->_getAttributeValue("platformVersion");
    }
    public function getResolutionUri()
    {
        return $this->_getAttributeValue("resolutionUri");
    }
    public function getExemptionType()
    {
        return $this->_getAttributeValue("exemptionType");
    }
    public function getIsFund()
    {
        return $this->_getAttributeValue("isFund");
    }
    public function getIssuanceCloseDate()
    {
        return $this->_getAttributeValue("issuanceCloseDate");
    }
    public function getCommonName()
    {
        return $this->_getAttributeValue("commonName");
    }
    public function getInfoUrl()
    {
        return $this->_getAttributeValue("infoUrl");
    }
    public function getUSTradable()
    {
        return $this->_getAttributeValue("usTradable");
    }
    public function getAccreditedOnly()
    {
        return $this->_getAttributeValue("accreditedOnly");
    }



    public function setIssuer($val) {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired("issuer", $val)) {
            $this->validateType("issuer", $val, "non-numeric string", false);
        }
        return $this->_setAttribute('issuer', $val);
    }
    public function setName($val) {
        $val = $this->cleanStringValue($val);
        $this->validateType("name", $val, "non-numeric string", false);
        return $this->_setAttribute('name', $val);
    }
    public function setType($val) {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired("type", $val)) {
            $this->validateAmong("type", $val, self::getValidTypes());
        }
        return $this->_setAttribute('type', $val);
    }
    public function setStatusCode($val) {
        $val = $this->cleanNumberValue($val);
        if ($this->validateReadOnly("statusCode", $val)) {
            if ($this->validateRequired("statusCode", $val)) {
                $this->validateAmong("statusCode", $val, array_keys(self::getValidStatuses()));
            }
            return $this->_setAttribute('statusCode', $val);
        }
        return $this;
    }
    public function setStatusText($val) {
        $val = $this->cleanStringValue($val);
        if ($this->validateReadOnly("statusText", $val)) {
            if ($this->validateRequired("statusText", $val)) {
                $this->validateAmong("statusText", $val, array_values(self::getValidStatuses()));
            }
            return $this->_setAttribute('statusText', $val);
        }
        return $this;
    }
    public function setDescription($val) {
        $val = $this->cleanStringValue($val);
        $this->validateType("description", $val, "non-numeric string", false);
        return $this->_setAttribute('description', $val);
    }

    public function setPlatform($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType("platform", $val, "non-numeric string", false);
        return $this->_setAttribute("platform", $val);
    }

    public function setPlatformVersion($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType("platformVersion", $val, "string", false);
        return $this->_setAttribute("platformVersion", $val);
    }

    public function setResolutionUri($val)
    {
        $val = $this->cleanStringValue($val);
        $clear = false;
        if ($val) {
            if ($this->validateType("resolutionUri", $val, "string")) {
                $regex = "^[a-z0-9_+-]{3,20}:[^ ]+$";
                if (!preg_match("/$regex/", $val)) {
                    $this->setError("resolutionUri", "format", [
                        "title" => "Invalid URI Format",
                        "detail" => "URIs must be formatted according to this regular expression: '$regex'"
                    ]);
                } else {
                    $clear = true;
                }
            } else {
                $clear = true;
            }
        } else {
            $clear = true;
        }

        if ($clear) {
            $this->clearError("resolutionUri", "format");
        }

        return $this->_setAttribute("resolutionUri", $val);
    }

    public function setExemptionType($val) {
        $field = "exemptionType";
        $val = $this->cleanStringValue($val);
        if ($this->validateReadOnly($field, $val)) {
            return $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setIsFund($val) {
        $field = "isFund";
        $val = $this->cleanBooleanValue($val);
        if ($this->validateReadOnly($field, $val)) {
            return $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setIssuanceCloseDate($val)
    {
        $field = "issuanceCloseDate";
        $val = $this->cleanDateTimeValue($val);
        $this->validateReadOnly($field, $val);
        return $this->_setAttribute($field, $val);
    }

    public function setCommonName($val) {
        $field = "commonName";
        $val = $this->cleanStringValue($val);
        if ($this->validateReadOnly($field, $val)) {
            return $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setInfoUrl($val) {
        $field = "infoUrl";
        $val = $this->cleanStringValue($val);
        if ($this->validateReadOnly($field, $val)) {
            return $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setUSTradable($val) {
        $field = "usTradable";
        $val = $this->cleanBooleanValue($val);
        if ($this->validateReadOnly($field, $val)) {
            return $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setAccreditedOnly($val) {
        $field = "accreditedOnly";
        $val = $this->cleanBooleanValue($val);
        if ($this->validateReadOnly($field, $val)) {
            return $this->_setAttribute($field, $val);
        }
        return $this;
    }



    /**
     * Serialize issuanceCloseDate field to a value that SQL understands
     *
     * We have to do this here because when order intents are serialized that already have a issuanceCloseDate date
     * set, they end up sending malformed data to the API. This is because \DateTime actually does implement
     * jsonSerialize, but in a way that breaks our implementation.
     */
    public function serializeAttribute($name)
    {
        if ($name === 'issuanceCloseDate') {
            $val = $this->getIssuanceCloseDate();
            if ($val instanceof \DateTimeInterface) {
                $val = $val->format(\DateTime::RFC3339);
            }
            return (string)$val;
        } elseif ($name === "isFund") {
            $val = $this->getIsFund();
            if (is_bool($val)) {
                return (int)$val;
            }
            return $val;
        } elseif ($name === "usTradable") {
            $val = $this->getUSTradable();
            if (is_bool($val)) {
                return (int)$val;
            }
            return $val;
        } elseif ($name === "accreditedOnly") {
            $val = $this->getAccreditedOnly();
            if (is_bool($val)) {
                return (int)$val;
            }
            return $val;
        }
        return parent::serializeAttribute($name);
    }
}

