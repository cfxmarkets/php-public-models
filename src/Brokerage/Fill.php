<?php
namespace CFX\Brokerage;

class Fill extends \CFX\JsonApi\AbstractResource implements FillInterface {
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'fills';
    protected $attributes = [
        "side" => null,
        "lotSize" => null,
        "price" => null,
        "fees" => null,
        /**
         * Currently available statuses:
         *
         * 0 = created
         * 8 = cleared
         * 32 = settled
         * 128 = complete
         */
        "status" => 0,
        "timestamp" => null,
    ];
    protected $relationships = [
        'order' => null,
        'security' => null,
    ];

    public function __construct(\CFX\JsonApi\DatasourceInterface $datasource, $data=null) {
        $this->attributes["timestamp"] = time();
        parent::__construct($datasource, $data);
    }

    public function getSide()
    {
        return $this->_getAttributeValue('side');
    }

    public function getLotSize()
    {
        return $this->_getAttributeValue('lotSize');
    }

    public function getPrice()
    {
        return $this->_getAttributeValue('price');
    }

    public function getFees()
    {
        return $this->_getAttributeValue('fees');
    }

    public function getStatus()
    {
        return $this->_getAttributeValue("status");
    }

    public function getTimestamp()
    {
        return $this->_getAttributeValue('timestamp');
    }

    public function getOrder()
    {
        return $this->_getRelationshipValue('order');
    }

    public function getSecurity()
    {
        return $this->_getRelationshipValue('security');
    }




    public function setSide($val) {
        $val = $this->cleanStringValue($val);

        if ($this->validateRequired('side', $val)) {
            if ($this->validateImmutable("side", $val)) {
                $this->validateAmong('side', $val, [ 'buy', 'sell' ]);
            }
        }

        return $this->_setAttribute('side', $val);
    }


    public function setLotSize($val) {
        $val = $this->cleanNumberValue($val);

        if ($this->validateRequired('lotSize', $val)) {
            if ($this->validateNumeric('lotSize', $val)) {
                if ($val < 1) {
                    $this->setError('lotSize', 'qty', [
                        "title" => "Invalid Attribute Value for `lotSize`",
                        "detail" => "You can't enter orders for less than a single share on our system."
                    ]);
                } else {
                    $this->clearError('lotSize', 'qty');
                }
            }
        }

        return $this->_setAttribute('lotSize', $val);
    }


    public function setPrice($val) {
        $val = $this->cleanNumberValue($val);
        $this->validatePrice('price', $val, true);
        return $this->_setAttribute('price', $val);
    }


    public function setFees($val) {
        $field = "fees";
        if ($this->validateReadOnly($field, $val)) {
            $this->_setAttribute($field, $val);
        }
        return $this;
    }


    public function setStatus($val) {
        $field = "status";
        if ($this->validateReadOnly($field, $val)) {
            $this->_setAttribute($field, $val);
        }
        return $this;
    }


    public function setTimestamp($val)
    {
        $field = "timestamp";
        if ($val instanceof \DateTime) {
            $val = $val->format("U");
        }
        $val = $this->cleanNumberValue($val);

        if ($this->validateRequired($field, $val)) {
            if ($this->validateType($field, $val, "int")) {
                if ($val < time()-(60*60*24*365*100)) {
                    $this->setError($field, "out-of-range", [
                        "title" => "Timestamp Out of Range",
                        "detail" => "Timestamp must be within 100 years",
                    ]);
                } elseif ($val > time()+120) {
                    $this->setError($field, "out-of-range", [
                        "title" => "Timestamp Too Far Into Future",
                        "detail" => "Your timestamp may not be more than 2 minutes into the future (please fix your clock)"
                    ]);
                } else {
                    $this->clearError($field, "out-of-range");
                }
            }
        }

        return $this->_setAttribute($field, $val);
    }


    public function setOrder(?\CFX\Exchange\OrderInterface $val)
    {
        $field = "order";
        $this->validateRequired($field, $val);
        return $this->_setRelationship($field, $val);
    }


    public function setSecurity(?\CFX\Exchange\AssetInterface $val)
    {
        $field = "security";
        $this->validateRequired($field, $val);
        return $this->_setRelationship($field, $val);
    }




    // Custom validators

    /**
     * Validate a price (high, low, or current)
     *
     * Ensures that the given value is numeric and greater than 0
     *
     * @param string $field The name of the field being validated
     * @param mixed $val The value to validate
     * @param bool $required Whether or not the value is required (this affects how `null` is handled)
     * @return bool Whether or not the validation has passed
     */
    protected function validatePrice($field, $val, $required) {
        if ($required) {
            if (!$this->validateRequired($field, $val)) {
                return false;
            }
        }

        if ($val !== null && $val !== '') {
            if (!$this->validateNumeric($field, $val)) {
                return false;
            }

            if ($val <= 0) {
                $this->setError($field, 'gtzero', [
                    "title" => "Invalid Attribute Value for `$field`",
                    "detail" => 'Price must be greater than 0'
                ]);
                return false;
            } else {
                $this->clearError($field, 'gtzero');
            }
        }

        return true;
    }
}


