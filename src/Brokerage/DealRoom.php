<?php
namespace CFX\Brokerage;

class DealRoom extends \CFX\JsonApi\AbstractResource implements DealRoomInterface
{
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'deal-rooms';

    protected $attributes = [
        'title' => null,
        'slug' => null,
        'summary' => null,
        'bodyText' => null,
        'restriction' => null,
        'openDate' => null,
        'closeDate' => null,
        'access' => 'public',
        'accessKey' => null,
    ];

    protected $relationships = [
        'admins' => null,
        'partners' => null,
        'participants' => null,
        'orders' => null,
        'exchange' => null,
    ];

    public static function getValidRestrictionTypes()
    {
        return [
            'buy',
            'sell',
        ];
    }

    public static function getValidAccessTypes()
    {
        return [
            'public',
            'private',
        ];
    }




     public function getTitle()
    {
        return $this->_getAttributeValue('title');
    }

     public function getSlug()
    {
        return $this->_getAttributeValue('slug');
    }

     public function getSummary()
    {
        return $this->_getAttributeValue('summary');
    }

     public function getBodyText()
    {
        return $this->_getAttributeValue('bodyText');
    }

     public function getRestriction()
    {
        return $this->_getAttributeValue('restriction');
    }

     public function getOpenDate()
    {
        return $this->_getAttributeValue('openDate');
    }

     public function getCloseDate()
    {
        return $this->_getAttributeValue('closeDate');
    }

     public function getAccess()
    {
        return $this->_getAttributeValue('access');
    }

     public function getAccessKey()
    {
        return $this->_getAttributeValue('accessKey');
    }

     public function getAdmins()
    {
        return $this->_getRelationshipValue('admins');
    }

     public function getPartners()
    {
        return $this->_getRelationshipValue('partners');
    }

     public function getParticipants()
    {
        return $this->_getRelationshipValue('participants');
    }

     public function getOrders()
    {
        return $this->_getRelationshipValue('orders');
    }

     public function getExchange()
    {
        return $this->_getRelationshipValue('exchange');
    }







     public function setTitle($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired('title', $val)) {
            $this->validateType('title', $val, 'non-numeric string');
        }
        return $this->_setAttribute('title', $val);
    }

     public function setSlug($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired('slug', $val)) {
            $this->validateType('slug', $val, 'non-numeric string');
        }
        return $this->_setAttribute('slug', $val);
    }

     public function setSummary($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired('summary', $val)) {
            $this->validateType('summary', $val, 'non-numeric string');
        }
        return $this->_setAttribute('summary', $val);
    }

     public function setBodyText($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired('bodyText', $val)) {
            $this->validateType('bodyText', $val, 'non-numeric string');
        }
        return $this->_setAttribute('bodyText', $val);
    }

     public function setRestriction($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateAmong('restriction', $val, static::getValidRestrictionTypes(), false);
        return $this->_setAttribute('restriction', $val);
    }

     public function setOpenDate($val)
    {
        $val = $this->cleanDateTimeValue($val);
        if ($this->validateRequired('openDate', $val)) {
            $this->validateType('openDate', $val, 'datetime');
        }
        return $this->_setAttribute('openDate', $val);
    }

     public function setCloseDate($val)
    {
        $val = $this->cleanDateTimeValue($val);
        if ($this->validateRequired('closeDate', $val)) {
            $this->validateType('closeDate', $val, 'datetime');
        }
        return $this->_setAttribute('closeDate', $val);
    }

     public function setAccess($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired('access', $val)) {
            $this->validateAmong('access', $val, static::getValidAccessTypes());
        }
        return $this->_setAttribute('access', $val);
    }

     public function setAccessKey($val)
    {
        if ($this->validateReadOnly('accessKey', $val)) {
            $this->_setAttribute('accessKey', $val);
        }
        return $this;
    }

     public function setAdmins(\CFX\JsonApi\ResourceCollectionInterface $val = null)
    {
        return $this->_setRelationship('admins', $val);
    }

     public function setPartners(\CFX\JsonApi\ResourceCollectionInterface $val = null)
    {
        return $this->_setRelationship('partners', $val);
    }

     public function setParticipants(\CFX\JsonApi\ResourceCollectionInterface $val = null)
    {
        return $this->_setRelationship('participants', $val);
    }

     public function setOrders(\CFX\JsonApi\ResourceCollectionInterface $val = null)
    {
        return $this->_setRelationship('orders', $val);
    }

     public function setExchange($val)
    {
        return $this->_setRelationship('exchange', $val);
    }




    protected function serializeAttribute($name)
    {
        if (
            ($name === 'openDate' || $name === 'closeDate') &&
            $this->attributes[$name] &&
            $this->attributes[$name] instanceof \DateTime
        ) {
            return $this->attributes[$name]->format('Y-m-d H:i:s');
        }

        return parent::serializeAttribute($name);
    }
}

