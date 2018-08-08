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
        ];
    }

    public static function getValidStatuses()
    {
        return [
            0 => "closed",
            1 => "open",
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
}

