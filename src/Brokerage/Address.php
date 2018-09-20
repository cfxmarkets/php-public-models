<?php
namespace CFX\Brokerage;

class Address extends \CFX\JsonApi\AbstractResource implements AddressInterface {
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'addresses';
    protected $attributes = [
        'label' => null,
        'street1' => null,
        'street2' => null,
        'city' => null,
        'state' => null,
        'zip' => null,
        'country' => null,
        'metaData' => null,
    ];


    // Getters

    public function getLabel() { return $this->_getAttributeValue('label'); }
    public function getStreet1() { return $this->_getAttributeValue('street1'); }
    public function getStreet2() { return $this->_getAttributeValue('street2'); }
    public function getCity() { return $this->_getAttributeValue('city'); }
    public function getState() { return $this->_getAttributeValue('state'); }
    public function getZip() { return $this->_getAttributeValue('zip'); }
    public function getCountry() { return $this->_getAttributeValue('country'); }
    public function getMetaData() { return $this->_getAttributeValue('metaData'); }



    // Setters

    public function setLabel($val=null)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType("label", $val, "non-numeric string", false);
        return $this->_setAttribute('label', $val);
    }

    public function setStreet1($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired("street1", $val)) {
            $this->validateType("street1", $val, "non-numeric string");
        }
        return $this->_setAttribute('street1', $val);
    }

    public function setStreet2($val=null)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType("street2", $val, "string or int", false);
        return $this->_setAttribute('street2', $val);
    }

    public function setCity($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired("city", $val)) {
            $this->validateType("city", $val, "non-numeric string");
        }
        return $this->_setAttribute('city', $val);
    }

    public function setState($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType("state", $val, "non-numeric string", false);
        return $this->_setAttribute('state', $val);
    }

    public function setZip($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired("zip", $val)) {
            $this->validateType("zip", $val, "string or int");
        }
        return $this->_setAttribute('zip', $val);
    }

    public function setCountry($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired("country", $val)) {
            if ($this->validateType("country", $val, "non-numeric string")) {
                if (!preg_match("/^[A-Z]{2}$/", $val)) {
                    $this->setError("country", "iso", [
                        "title" => "Invalid Country Code",
                        "detail" => "Country must be a valid 2-digit ISO country code."
                    ]);
                } else {
                    $this->clearError("country", "iso");
                }
            } else {
                $this->clearError("country", "iso");
            }
        } else {
            $this->clearError("country", "iso");
            $this->clearError("country", "validType");
        }
        return $this->_setAttribute('country', $val);
    }

    public function setMetaData($val)
    {
        $valid = false;
        if (is_string($val)) {
            if ($val === "") {
                $val = null;
                $valid = true;
            } else {
                $inflated = json_decode($val, true);
                if ($inflated !== null || $val === 'null') {
                    $val = $inflated;
                    $valid = true;
                }
            }
        } elseif (is_array($val) || $val === null) {
            $valid = true;
        }

        $this->_setAttribute('metaData', $val);

        if (!$valid) {
            $this->setError('metaData', 'format', [
                'title' => 'Invalid Format for `metaData`',
                'detail' => "The `metaData` field is meant for miscellaneous data stored in json format. It ".
                "should be something intelligible to the PHP `json_decode` function."
            ]);
        } else {
            $this->clearError('metaData', 'format');
        }

        return $this;
    }

    protected function serializeAttribute($name)
    {
        if ($name === 'metaData' && $this->attributes[$name] !== null) {
            return json_encode($this->attributes[$name]);
        }
        return parent::serializeAttribute($name);
    }
}

