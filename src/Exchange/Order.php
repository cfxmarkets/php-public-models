<?php
namespace CFX\Exchange;

/**
 * Class representing an Exchange Order object
 *
 * An Order object has the following public fields:
 *
 * `side` - buy or sell
 * `lotSize` - how many shares this order represents
 * `asset` - the security being bought or sold
 * `priceHigh` - the ask price (in the case of a sell order) or limit price (in the case of a buy order)
 * `priceLow` - the "reserve" price (lowest acceptable price) in the case of a sell order. (Not pertinent to buy orders)
 * `currentPrice` - the current price of the order according to the matching algorithm (this will change as the order book changes)
 * `status` - one of the defined status strings
 * `statusDetail` - an arbitrary text explanation of the status
 * `documentKey` - the key representing the signed agreement document
 * `referenceKey` - an arbitrary Broker-supplied reference key used by the broker to associate the order with a client
 * `bankAccountId` - the ID of the bank account being used for the transaction
 */
class Order extends \CFX\JsonApi\AbstractResource implements OrderInterface {
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'orders';
    protected $attributes = [
        'side' => null,
        'lotSize' => null,
        'priceHigh' => null,
        'priceLow' => null,
        'currentPrice' => null,
        'status' => null,
        'statusDetail' => null,
        'documentKey' => null,
        'referenceKey' => null,
        'bankAccountId' => null
    ];
    protected $relationships = [
        'asset' => null,
    ];
    protected static $validStatuses = [
        'new',
        'active',
        'cancelled',
        'expired',
        'matched',
    ];

    public static function getValidStatuses()
    {
        return static::$validStatuses;
    }



    public function getSide()
    {
        return $this->_getAttributeValue('side');
    }

    public function getLotSize()
    {
        return $this->_getAttributeValue('lotSize');
    }

    public function getPriceHigh()
    {
        return $this->_getAttributeValue('priceHigh');
    }

    public function getPriceLow()
    {
        return $this->_getAttributeValue('priceLow');
    }

    public function getCurrentPrice()
    {
        return $this->_getAttributeValue('currentPrice');
    }

    public function getStatus()
    {
        return $this->_getAttributeValue('status');
    }

    public function getStatusDetail()
    {
        return $this->_getAttributeValue('statusDetail');
    }

    public function getDocumentKey()
    {
        return $this->_getAttributeValue('documentKey');
    }

    public function getReferenceKey()
    {
        return $this->_getAttributeValue('referenceKey');
    }

    public function getBankAccountId()
    {
        return $this->_getAttributeValue('bankAccountId');
    }

    public function getAsset()
    {
        return $this->_getRelationshipValue('asset');
    }




    public function setSide($val) {
        if ($this->validateStatusActive('side')) {
            $val = $this->cleanStringValue($val);

            $initial = $this->getInitial('side');
            if ($initial !== null && $val !== $initial) {
                $this->setError('side', 'immutable', [
                    'title' => 'Immutable Attribute `side`',
                    'detail' => 'The `side` attribute can\'t be changed, once set. If you need to change which side this order is on, please cancel the order and create a new one.',
                ]);
            } else {
                $this->clearError('side', 'immutable');

                if ($this->validateRequired('side', $val)) {
                    $this->validateAmong('side', $val, [ 'buy', 'sell' ]);
                }
            }
        }

        return $this->_setAttribute('side', $val);
    }


    public function setLotSize($val) {
        if ($this->validateStatusActive('lotSize')) {
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
        }

        return $this->_setAttribute('lotSize', $val);
    }


    public function setPriceHigh($val) {
        if ($this->validateStatusActive('priceHigh')) {
            $val = $this->cleanNumberValue($val);
            $this->validatePrice('priceHigh', $val, true);
        }

        return $this->_setAttribute('priceHigh', $val);
    }


    public function setPriceLow($val) {
        if ($this->validateStatusActive('priceLow')) {
            $val = $this->cleanNumberValue($val);
            $this->validatePrice('priceLow', $val, false);
        }

        return $this->_setAttribute('priceLow', $val);
    }

    public function setCurrentPrice($val) {
        if ($this->validateReadOnly('priceLow', $val)) {
            $val = $this->cleanNumberValue($val);
            $this->validatePrice('currentPrice', $val, false);
        }

        return $this->_setAttribute('priceLow', $val);
    }


    public function setStatus($val) {
        if ($this->validateReadOnly('status', $val)) {
            $this->validateAmong('status', $val, $this::getValidStatuses());
            $this->_setAttribute('status', $val);
        }
        return $this;
    }


    public function setStatusDetail($val)
    {
        if ($this->validateReadOnly('statusDetail', $val)) {
            $val = $this->cleanStringValue($val);
            $this->validateType('statusDetail', $val, 'string', false);
            $this->_setAttribute('statusDetail', $val);
        }
        return $this;
    }


    public function setDocumentKey($val)
    {
        if ($this->validateStatusActive('documentKey')) {
            $val = $this->cleanStringValue($val);
            if ($this->validateRequired('documentKey', $val)) {
                $this->validateType('documentKey', $val, 'string');
            }
        }

        return $this->_setAttribute('documentKey', $val);
    }

    public function setReferenceKey($val)
    {
        if ($this->validateStatusActive('referenceKey')) {
            $val = $this->cleanStringValue($val);
            if ($this->validateRequired('referenceKey', $val)) {
                $this->validateType('referenceKey', $val, 'string');
            }
        }

        return $this->_setAttribute('referenceKey', $val);
    }

    public function setBankAccountId($val)
    {
        if ($this->validateStatusActive('bankAccountId')) {
            $val = $this->cleanStringValue($val);
            if ($this->validateRequired('bankAccountId', $val)) {
                $this->validateType('bankAccountId', $val, 'string');
            }
        }

        return $this->_setAttribute('bankAccountId', $val);
    }

    public function setAsset(AssetInterface $val = null)
    {
        if ($this->validateStatusActive('asset')) {
            $this->validateRequired('asset', $val);
        }
        return $this->_setRelationship('asset', $val);
    }




    // Custom validators

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


    protected function validateStatusActive($field) {
        $passedStates = [
            'active' => ["Order Active", "This order is currently active and cannot be altered"],
            'cancelled' => ["Item Cancelled", "This order has been cancelled and cannot be altered"],
            'matched' => ["Item Sold", "This order has already been successfully executed and sold and cannot be altered"],
            'expired' => ["Item Expired", "This intent has expired and cannot be altered"],
        ];

        if (in_array($this->getStatus(), array_keys($passedStates))) {
            $this->setError($field, 'immutableStatus', [
                "title" => "Order Not Alterable",
                "detail" => $passedStates[$this->getStatus()],
            ]);
            return false;
        } else {
            $this->clearError($field, 'immutableStatus');
            return true;
        }
    }
}

