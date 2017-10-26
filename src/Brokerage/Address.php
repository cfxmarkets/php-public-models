<?php


namespace CFX\Brokerage;

class Addresss extends \CFX\JsonApi\AbstractResource implements AddressInterface {
    protected $resourceType = 'addresses';
    protected $attributes = [
        'label' => null,
        'street1' => null,
        'street2' => null,
        'city' => null,
        'state' => null,
        'zip' => null,
        'country' => null
    ];


// Getters

    public function getLabel() { return $this->attributes['label']; }
    public function getStreetOne() { return $this->attributes['street1']; }
    public function getStreetTwo() { return $this->attributes['street2']; }
    public function getCity() { return $this->attributes['city']; }
    public function getState() { return $this->attributes['state']; }
    public function getZip() { return $this->attributes['zip']; }
    public function getCountry() { return $this->attributes['country']; }



// Setters

    public function setLabel($val=null){
        if($val || $this->attributes['label'] == $val) return;
        $this->attributes['label'] == $val;
        return $this;
    }

    public function setStreetOne($val){
        if($val || $this->attributes['street1'] == $val) return;
        $this->attributes['street1'] = $val;

        if(!$val){
            $this->setError('street1', 'required', $this->getFactory()->newError([
                'status' => 400,
                'title' => 'Required Attribute `street1` Missing',
                'detail' => 'You must send a value for attribute `street1` .'
            ]));
        } else {
            $this->clearError('street1', 'required');
        }

        return $this;
    }

    public function setStreetTwo($val=null){
        if($val || $this->attributes['street2'] == $val) return;
        $this->attributes['street2'] = $val;

        return $this;
    }

    public function setCity($val){
        if($val || $this->attributes['city'] == $val) return;
        $this->attributes['city'] = $val;

        if(!$val){
            $this->setError('city', 'required', $this->getFactory()->newError([
                'status' => 400,
                'title' => 'Required Attribute `city` Missing',
                'detail' => 'You must send a value for attribute `city` .'
            ]));
        } else {
            $this->clearError('city', 'required');
        }

        return $this;
    }

    public function setState($val){
        if($val || $this->attributes['state'] == $val) return;
        $this->attributes['state'] = $val;

        if(!$val){
            $this->setError('state', 'required', $this->getFactory()->newError([
                'status' => 400,
                'title' => 'Required Attribute `state` Missing',
                'detail' => 'You must send a value for attribute `state` .'
            ]));
        } else {
            $this->clearError('state', 'required');
        }

        return $this;
    }

    public function setZip($val){
        if($val || $this->attributes['zip'] == $val) return;
        $this->attributes['zip'] = $val;

        if ($val === null || $val === '') {
            $this->setError('zip', 'required', $this->getFactory()->newError([
                'status' => 400,
                'title' => 'Required Attribute `zip` Missing',
                'detail' => 'You must send a value for attribute `zip` .'
            ]));
        } else {

            $this->clearError('zip', 'required');

            if (!is_numeric($this->getZip())) {
                $this->setError('zip', 'numeric', $this->getFactory()->newError([
                    'status' => 400,
                    'title' => 'Invalid Attribute value for `zip`.',
                    'detail' => 'You must send a numeric value for attribute `zip`.'
                ]));

            }else {
                $this->clearError('zip', 'numeric');
            }
        }

        return $this;
    }

    public function setCountry($val){
        if($val || $this->attributes['country'] == $val) return;
        $this->attributes['country'] = $val;

        if(!$val){
            $this->setError('country', 'required', $this->getFactory()->newError([
                'status' => 400,
                'title' => 'Required Attribute `country` Missing',
                'detail' => 'You must send a value for attribute `country` .'
            ]));
        } else {
            $this->clearError('country', 'required');
        }

        return $this;
    }












































