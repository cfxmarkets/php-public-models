<?php
namespace CFX\Brokerage;

class Address extends \CFX\JsonApi\AbstractResource implements AddressInterface {
    protected $resourceType = 'addresses';
    protected $attributes = [
        'label' => null,
        'street1' => null,
        'street2' => null,
        'city' => null,
        'state' => null,
        'zip' => null,
        'country' => null,
        'meta' => null,
    ];


    // Getters

    public function getLabel() { return $this->_getAttributeValue('label'); }
    public function getStreet1() { return $this->_getAttributeValue('street1'); }
    public function getStreet2() { return $this->_getAttributeValue('street2'); }
    public function getCity() { return $this->_getAttributeValue('city'); }
    public function getState() { return $this->_getAttributeValue('state'); }
    public function getZip() { return $this->_getAttributeValue('zip'); }
    public function getCountry() { return $this->_getAttributeValue('country'); }
    public function getMeta() { return $this->_getAttributeValue('meta'); }



    // Setters

    public function setLabel($val=null)
    {
        $this->_setAttribute('label', $val);
        $this->validateRequired('label', $val);
        return $this;
    }

    public function setStreet1($val)
    {
        $this->_setAttribute('street1', $val);
        $this->validateRequired('street1', $val);
        return $this;
    }

    public function setStreet2($val=null)
    {
        $this->_setAttribute('street2', $val);
        return $this;
    }

    public function setCity($val)
    {
        $this->_setAttribute('city', $val);
        $this->validateRequired('city', $val);
        return $this;
    }

    public function setState($val)
    {
        $this->_setAttribute('state', $val);
        $this->validateRequired('state', $val);
        return $this;
    }

    public function setZip($val)
    {
        $this->_setAttribute('zip', $val);
        $this->validateRequired('zip', $val);
        return $this;
    }

    public function setCountry($val)
    {
        $this->_setAttribute('country', $val);
        $this->validateRequired('country', $val);
        return $this;
    }

    public function setMeta($val)
    {
        $valid = false;
        if (is_string($val)) {
            $inflated = json_decode($val, true);
            if ($inflated !== null || $val === 'null') {
                $val = $inflated;
                $valid = true;
            }
        } elseif (is_array($val) || $val === null) {
            $valid = true;
        }

        $this->_setAttribute('meta', $val);

        if (!$valid) {
            $this->setError('meta', 'format', [
                'title' => 'Invalid Format for `meta`',
                'detail' => "The `meta` field is meant for miscellaneous data stored in json format. It ".
                "should be something intelligible to the PHP `json_decode` function."
            ]);
        } else {
            $this->clearError('meta', 'format');
        }

        return $this;
    }

    protected function serializeAttribute($name)
    {
        if ($name === 'meta') {
            return json_encode($this->attributes[$name]);
        }
        return parent::serializeAttribute($name);
    }
}

