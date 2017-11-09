<?php
namespace CFX\Brokerage;

class OrderIntent extends \CFX\JsonApi\AbstractResource implements OrderIntentInterface {
    protected $resourceType = 'order-intents';
    protected $attributes = [
        'type' => null,
        'numShares' => null,
        'priceHigh' => null,
        'priceLow' => null,
        'status' => null,
    ];
    protected $relationships = [
        'user' => null,
        'asset' => null,
        'assetIntent' => null,
        'order' => null,
    ];
    protected $validTypes = ['sell', 'buy'];



    // Getters

    public function getType() { return $this->_getAttributeValue('type'); }
    public function getNumShares() { return $this->_getAttributeValue('numShares'); }
    public function getPriceHigh() { return $this->_getAttributeValue('priceHigh'); }
    public function getPriceLow() { return $this->_getAttributeValue('priceLow'); }
    public function getStatus() { return $this->_getAttributeValue('status'); }
    public function getUser() { return $this->_getRelationshipValue('user'); }
    public function getAsset() { return $this->_getRelationshipValue('asset'); }
    public function getAssetIntent() { return $this->_getRelationshipValue('assetIntent'); }
    public function getOrder() { return $this->_getRelationshipValue('order'); }





    // Setters

    public function setType($val) {
        if ($val && $this->attributes['type'] == $val) return $this;
        if (!$this->validateStatusActive()) return $this;

        $prevVal = $this->attributes['type'];
        $this->_setAttribute('type', $val);

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
        if ($val && $this->attributes['numShares'] == $val) return $this;
        if (!$this->validateStatusActive()) return $this;

        $this->_setAttribute('numShares', $val);

        if ($val === null || $val === '') {
            $this->setError('numShares', 'required', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Required Attribute `numShares` Missing",
                "detail" => "You must indicated a quantity for this order."
            ]));
        } else {
            $this->clearError('numShares', 'required');

            if (!is_numeric($this->getNumShares())) {
                $this->setError('numShares', 'numeric', $this->getFactory()->newError([
                    "status" => 400,
                    "title" => "Invalid Attribute Value for `numShares`",
                    "detail" => "The quanity you indicate for this order must be numeric"
                ]));
            } else {
                $this->clearError('numShares', 'numeric');

                if ($this->getNumShares() < 1) {
                    $this->setError('numShares', 'qty', $this->getFactory()->newError([
                        "status" => 400,
                        "title" => "Invalid Attribute Value for `numShares`",
                        "detail" => "You can't enter orders for less than a single share on our system."
                    ]));
                } else {
                    $this->clearError('numShares', 'qty');
                }
            }
        }

        return $this;
    }


    public function setPriceHigh($val) {
        if ($val && $this->attributes['priceHigh'] == $val) return $this;
        if (!$this->validateStatusActive()) return $this;

        $this->_setAttribute('priceHigh', $val);

        if ($this->getType() == 'sell') $this->validatePrice('priceHigh', true);
        else $this->validatePrice('priceHigh', false);
        return $this;
    }


    public function setPriceLow($val) {
        if ($val && $this->attributes['priceLow'] == $val) return $this;
        if (!$this->validateStatusActive()) return $this;

        $this->_setAttribute('priceLow', $val);

        if ($this->getType() == 'buy') $this->validatePrice('priceLow', true);
        else $this->validatePrice('priceLow', false);
        return $this;
    }


    public function setStatus($val) {
        if (!$this->validateStatusActive()) return $this;
        $this->validateReadOnly('status', $val);

        $this->_setAttribute('status', $val);

        return $this;
    }


    public function setUser(UserInterface $user=null) {
        if ($user && $this->getUser() && $this->getUser()->getId() == $user->getId()) return $this;
        if (!$this->validateStatusActive()) return $this;
           
        // User is immutable
        if ($this->getUser()) {
            if (!$user || $this->getUser()->getId() != $user->getId()) {
                $this->setError('user', 'immutable', $this->getFactory()->newError([
                    "title" => "Immutable Relationship `user`",
                    "detail" => "You cannot edit the `user` relationship of an order intent. If you'd like to change the user, you should delete this intent using the DELETE /exchange/api/v2/order-intents/".$this->getId()." endpoint and then create a new one",
                    "status" => 400
                ]));
                return $this;
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

            try {
                if (!$user->isInitialized()) {
                    $user = $this->datasource->getRelated($user->getResourceType(), $user->getId());
                }

                $this->clearError('user', 'valid');
            } catch (\CFX\Persistence\ResourceNotFoundException $e) {
                $this->setError('user', 'valid', $this->getFactory()->newError([
                    "status" => 400,
                    "title" => "Invalid Relationship `user`",
                    "detail" => "The user you've specified doesn't appear to be in our database."
                ])); 
            }
        }

        return $this;
    }




    public function setAsset(\CFX\Exchange\AssetInterface $asset=null) {
        if (!$this->validateStatusActive()) return $this;

        if ($this->getInitial('asset') && $this->valueDiffersFromInitial('asset', $asset)) {
            $this->setError('asset', 'immutable', $this->getFactory()->newError([
                'status' => 400,
                'title' => 'Immutable Relationship `asset`',
                'detail' => "You can only set `asset` once. If you made a mistake and would like to change the asset, you should delete this ".
                    "order intent and create a new one.",
            ]));
        } else {
            $this->clearError('asset','immutable');

            if (!$asset) {
                if (!$this->getAssetIntent()) {
                    $this->setError('assetOrAssetIntent', 'required', $this->getFactory()->newError([
                        'status' => 400,
                        'title' => 'Asset or AssetIntent Required',
                        'detail' => 'You must set either and Asset or an AssetIntent for this order intent to be valid.',
                    ]));
                } else {
                    $this->clearError('assetOrAssetIntent', 'required');
                }
            } else {
                $this->clearError('assetOrAssetIntent', 'required');

                if ($this->getAssetIntent()) {
                    $this->setError('assetOrAssetIntent', 'duplicate', $this->getFactory()->newError([
                        'status' => 400,
                        'title' => "Conflicting Asset and AssetIntent",
                        "detail" => "You can't have both an asset and an asset intent for this order intent to be valid.",
                    ]));
                } else {
                    $this->clearError('assetOrAssetIntent', 'duplicate');

                    // Now validate that the asset exists
                    try {
                        // Will throw error if asset is invalid
                        if (!$asset->isInitialized()) {
                            $this->datasource->getRelated($asset->getResourceType(), $asset->getId());
                        }
                        $this->clearError('asset', 'valid');

                        // Should add considerations for asset status (non-tradable assets shouldn't be valid)
                    } catch (ResourceNotFoundException $e) {
                        $this->setError('asset', 'valid', $this->getFactory()->newError([
                            "status" => 400,
                            "title" => "Invalid Relationship `asset`",
                            "detail" => "The asset you've indicated for this order is not currently in our system. If you've submitted this asset via an Asset Intent, it may not be fully processed yet. Check the intent's status and try again. Alternatively, you can create a new Asset Intent to request that we create this asset for you by POSTing to `/exchange/api/asset-intents`."
                        ]));
                    }
                }
            }
        }

        $this->_setRelationship('asset', $asset);

        return $this;
    }


    public function setAssetIntent(\CFX\Brokerage\AssetIntentInterface $assetIntent=null) {
        if (!$this->validateStatusActive()) return $this;

        if ($this->getInitial('assetIntent') !== null && $this->valueDiffersFromInitial('assetIntent', $assetIntent)) {
            $this->setError('assetIntent', 'immutable', $this->getFactory()->newError([
                'status' => 400,
                'title' => 'Immutable Relationship `assetIntent`',
                'detail' => "You can only set `assetIntent` once. If you made a mistake and would like to change the assetIntent, you should delete this ".
                    "order intent and create a new one.",
            ]));
        } else {
            $this->clearError('assetIntent','immutable');

            if (!$assetIntent) {
                if (!$this->getAsset()) {
                    $this->setError('assetOrAssetIntent', 'required', $this->getFactory()->newError([
                        'status' => 400,
                        'title' => 'Asset or AssetIntent Required',
                        'detail' => 'You must set either and Asset or an AssetIntent for this order intent to be valid.',
                    ]));
                } else {
                    $this->clearError('assetOrAssetIntent', 'required');
                }
            } else {
                $this->clearError('assetOrAssetIntent', 'required');

                if ($this->getAsset()) {
                    $this->setError('assetOrAssetIntent', 'duplicate', $this->getFactory()->newError([
                        'status' => 400,
                        'title' => "Conflicting Asset and AssetIntent",
                        "detail" => "You can't have both an assetIntent and an assetIntent intent for this order intent to be valid.",
                    ]));
                } else {
                    $this->clearError('assetOrAssetIntent', 'duplicate');

                    // Now validate that the assetIntent exists
                    try {
                        // Will throw error if assetIntent is invalid
                        if (!$assetIntent->isInitialized()) {
                            $this->datasource->getRelated($assetIntent->getResourceType(), $assetIntent->getId());
                        }
                        $this->clearError('assetIntent', 'valid');

                        // Should add considerations for assetIntent status (non-tradable assetIntents shouldn't be valid)
                    } catch (ResourceNotFoundException $e) {
                        $this->setError('assetIntent', 'valid', $this->getFactory()->newError([
                            "status" => 400,
                            "title" => "Invalid Relationship `assetIntent`",
                            "detail" => "The assetIntent you've indicated for this order is not currently in our system.",
                        ]));
                    }
                }
            }
        }

        $this->_setRelationship('assetIntent', $assetIntent);

        return $this;
    }



    public function setOrder(\CFX\Exchange\OrderInterface $order=null) {
        $this->validateReadOnly('order', $order);
        $this->relationships['order']->setData($order);
        return $this;
    }







    // Custom validators

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


    protected function validateStatusActive() {
        $passedStates = [
            'listed' => ["Sale In Progress", "This intent has already passed to listing phase and cannot be altered"],
            'sold' => ["Item Already Sold", "This intent has already been successfully executed and sold and cannot be altered"],
            'closed' => ["Item Closed", "This intent has been closed and cannot be altered"],
            'expired' => ["Item Expired", "This intent has expired and cannot be altered"],
            'cancelled' => ["Item Cancelled", "This intent has been cancelled and cannot be altered"],
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
}

