<?php
namespace CFX\Exchange;

class Order extends \CFX\JsonApi\AbstractResource implements OrderInterface {
    
    protected $resourceType = 'orders';
    protected $attributes = [
        'type' => null,
        'numShares' => null,
        'priceHigh' => null,
        'priceLow' => null,
        'currentPrice' => null,
        'status' => null,
    ];

    protected $relationships = [
        'asset' => null,
        'user' => null,
    ];
    protected $validTypes = ['sell', 'buy'];



    public static function adaptFrom(FactoryInterface $f, $order) {
        if ($order instanceof \stdClass) {
            $data = [
                'id' => $order->asset_symbol,
                'attributes' => [
                    'issuer' => $asset->issuer_ident,
                    'name' => $asset->asset_name,
                    'type' => $asset->asset_type,
                    'statusCode' => $asset->asset_status,
                    'statusText' => $asset->asset_status_text,
                    'description' => $asset->asset_description,
                ]
            ];
            return new static($f, $data);
        }

        if (is_object($order)) $type = get_class($order);
        else $type = gettype($order);
        throw new UnknownResourceDataFormatException("Don't know how to adapt resources of type `$type`. To implement adapting of these resources, you should add a block for it in the definition for the `\CFX\Brokerage\Asset::adaptFrom` method.");
    }

    public function getData($format=null) {
        if (!$format) return $this->jsonSerialize();
        if ($format == 'compat') {
            return [
                'order_type' => $this->getType(),
                'order_numShares' => $this->getNumShares(),
                'order_priceHigh' => $this->getPriceHigh(),
                'order_priceLow' => $this->getPriceLow(),
                'order_currentPrice' => $this->getCurrentPrice(),
            ];
        } else {
            throw new UnknownResourceDataFormatException("Don't know how to cast this object to type `$format`. To implement this, simply add a block for this type in the definition for the `\CFX\Brokerage\Order::getData` function.");
        }
    }

    public function getType() { return $this->attributes['type']; }
    public function getNumShares() { return $this->attributes['numShares']; }
    public function getPriceHigh() { return $this->attributes['priceHigh']; }
    public function getPriceLow() { return $this->attributes['priceLow']; }
    public function getCurrentPrice() { return $this->attributes['currentPrice']; }
    public function getStatus() { return $this->attributes['status']; }
    public function getAsset() { return $this->relationships['asset']->getData(); }
    public function getUser() { return $this->relationships['user']->getData(); }



    public function setType($val) {
        if ($val && $this->attributes['type'] == $val) return;
        if (!$this->validateStatusActive()) return false;

        $prevVal = $this->attributes['type'];
        $this->attributes['type'] = $val;

        if ($prevVal !== null && $val != $prevVal) {
            $this->setError('type', 'immutable', $this->getFactory()->newError([
                'status' => 400,
                'title' => 'Immutable Attribute `type`',
                'detail' => 'The `type` attribute can\'t be changed, once set. If you need to change the type of this intent, please delete this intent and create a new one.',
            ]));
        } else {
            $this->clearError('type', 'immutable');

            if (!$val) {
                $this->setError('type', 'required', $this->getFactory()->newError([
                    "status" => 400,
                    "title" => "Required Attribute `type` Missing",
                    "detail" => "You must indicate the type of order this is. Valid order types are '".implode("', '", $this->validTypes)."'."
                ]));
            } else {
                $this->clearError('type', 'required');

                if (!in_array($val, $this->validTypes)) {
                    $this->setError('type', 'valid', $this->getFactory()->newError([
                        "status" => 400,
                        "title" => "Invalid Attribute Value for `type`",
                        "detail" => "Valid order types are '".implode("', '", $this->validTypes)."'. The type you've indicated is '{$val}'."
                    ]));
                } else {
                    $this->clearError('type', 'valid');
                }
            }
        }
        return $this;
    }
    public function setNumShares($val) {
        if (is_numeric($val)) $val = (int)$val;
        $this->attributes['numShares'] = $val;

        if ($val && !is_int($val)) {
            $this->setError('numShares', 'integer', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Invalid Attribute Value for `numShares`",
                "detail" => "`numShares` must be an integer or null."
            ]));
        } else {
            $this->clearError('numShares', 'integer');
        }
        return $this;
    }
    public function setPriceHigh($val) {
        if (is_numeric($val)) $val = (int)$val;
        $this->attributes['priceHigh'] = $val;

        if ($val && !is_int($val)) {
            $this->setError('priceHigh', 'integer', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Invalid Attribute Value for `priceHigh`",
                "detail" => "`priceHigh` must be an integer or null."
            ]));
        } else {
            $this->clearError('priceHigh', 'integer');
        }
        return $this;
    }
    public function setPriceLow($val) {
        if (is_numeric($val)) $val = (int)$val;
        $this->attributes['priceLow'] = $val;

        if ($val && !is_int($val)) {
            $this->setError('priceLow', 'integer', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Invalid Attribute Value for `priceLow`",
                "detail" => "`priceLow` must be an integer or null."
            ]));
        } else {
            $this->clearError('priceLow', 'integer');
        }
        return $this;
    }
    public function setCurrentPrice($val) {
        if (is_numeric($val)) $val = (int)$val;
        $this->attributes['currentPrice'] = $val;

        if ($val && !is_int($val)) {
            $this->setError('currentPrice', 'integer', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Invalid Attribute Value for `currentPrice`",
                "detail" => "`currentPrice` must be an integer or null."
            ]));
        } else {
            $this->clearError('currentPrice', 'integer');
        }
        return $this;
    }
   
    public function setAsset(\CFX\AssetInterface $val=null) {
        $this->relationships['asset']->setData($val);
        return $this;
    }

     public function setUser(SiteUserInterface $user=null) {
        if ($user && $this->getUser() && $this->getUser()->getId() == $user->getId()) return;
        if (!$this->validateStatusActive()) return false;
           
        // User is immutable
        if ($this->getUser()) {
            if (!$user || $this->getUser()->getId() != $user->getId()) {
                $this->setError('user', 'immutable', $this->getFactory()->newError([
                    "title" => "Immutable Relationship `user`",
                    "detail" => "You cannot edit the `user` relationship of an order intent. If you'd like to change the user, you should delete this intent using the DELETE /exchange/api/v2/order-intents/".$this->getId()." endpoint and then create a new one",
                    "status" => 400
                ]));
                return;
            } else {
                $this->clearError('user', 'immutable');
            }
        }

        $this->relationships['user']->setData($user);

        if (!$user) {
            $this->setError('user', 'required', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Required Relationship `user` Missing",
                "detail" => "You must associate this Order Intent with a user"
            ]));
        } else {
            $this->clearError('user', 'required');

            if (!$this->db) $this->queueRelationshipValidation('user', 'db');
            else {
                $user = $this->db->getSiteUserById($user->getId());
                if (!$user) {
                    $this->setError('user', 'valid', $this->getFactory()->newError([
                        "status" => 400,
                        "title" => "Invalid Relationship `user`",
                        "detail" => "The user you've specified doesn't appear to be in our database."
                    ])); 
                } else {
                    $this->clearError('user', 'valid');
                }
            }
        }

        return $this;
    }

    public function setStatus($val) {
        $this->_setAttribute('status', $val);
    }



    // Custom Vaildators


    protected function validateStatusActive() {
        $passedStates = [
            'complete' => ["Order Is Complete", "This order has already passed to CH and cannot be altered"],
            'pending' => ["Order Is Pending", "This order is pending for review and cann be alterd"],
            'reviewed' => ["Order Reviewed", "This order has been reviewed and cannot be altered"],
            'initiated' => ["Order Initiated", "This order has been intiated and can be altered"],
            'cancelled' => ["Order Cancelled", "This order has been cancelled and cannot be altered"],
        ];

        if (in_array($this->getStatus(), array_keys($passedStates))) {
            $this->setError('object', 'immutable', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Order Intent Not Alterable",
                "detail" => $passedStatus[$this->getStatus()],
            ]));
            return false;
        } else {
            $this->clearError('object', 'immutable');
            return true;
        }
    }

    protected function validatePrice($which, $required) {
        $price = $this->attributes[$which];
        if ($required) {
            if ($price === null || $price === '') {
                $this->setError($which, 'required', $this->getFactory()->newError([
                    "status" => 400,
                    "title" => "Required Attribute `$which` Missing",
                    "detail" => "You must indicate a high price for this order. (If this is a sell order, this would be the *asking price*; if it's a buy order, this would be the *maximum bid*.)"
                ]));
            } else {
                $this->clearError($which, 'required');
            }
        }

        if ($price !== null && $price !== '') {
            if (!is_numeric($price)) {
                $this->setError($which, 'numeric', $this->getFactory()->newError([
                    "status" => 400,
                    "title" => "Invalid Attribute Value for `$which`",
                    "detail" => "Price must be numeric"
                ]));
            } else {
                $this->clearError($which, 'numeric');

                if ($price <= 0) {
                    $this->setError($which, 'gtzero', $this->getFactory()->newError([
                        "status" => 400,
                        "title" => "Invalid Attribute Value for `$which`",
                        "detail" => 'Price must be greater than 0'
                    ]));
                } else {
                    $this->clearError($which, 'gtzero');
                }
            }
        }
    }
    // Interface implementations

    public function fetch(DatasourceInterface $db) {
        throw new UnimplementedFeatureException("`fetch` is not yet implemented for Orders.");
    }
}

