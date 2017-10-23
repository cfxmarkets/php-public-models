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
        'order' => null,
    ];
    protected $validTypes = ['sell', 'buy'];



    // Getters

    public function getType() { return $this->attributes['type']; }
    public function getNumShares() { return $this->attributes['numShares']; }
    public function getPriceHigh() { return $this->attributes['priceHigh']; }
    public function getPriceLow() { return $this->attributes['priceLow']; }
    public function getStatus() { return $this->attributes['status']; }
    public function getUser() { return $this->relationships['user']->getData(); }
    public function getAsset() { return $this->relationships['asset']->getData(); }
    public function getOrder() { return $this->relationships['order']->getData(); }





    // Setters

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
        if ($val && $this->attributes['numShares'] == $val) return;
        if (!$this->validateStatusActive()) return false;

        $this->attributes['numShares'] = $val;

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
        if ($val && $this->attributes['priceHigh'] == $val) return;
        if (!$this->validateStatusActive()) return false;

        $this->attributes['priceHigh'] = $val;
        if ($this->getType() == 'sell') $this->validatePrice('priceHigh', true);
        else $this->validatePrice('priceHigh', false);
        return $this;
    }


    public function setPriceLow($val) {
        if ($val && $this->attributes['priceLow'] == $val) return;
        if (!$this->validateStatusActive()) return false;

        $this->attributes['priceLow'] = $val;
        if ($this->getType() == 'buy') $this->validatePrice('priceLow', true);
        else $this->validatePrice('priceLow', false);
        return $this;
    }


    public function setStatus($val) {
        if ($val && $this->attributes['status'] == $val) return;
        if (!$this->validateStatusActive()) return false;

        if ($this->getStatus()) {
            if (!$val || $this->getAsset()->getId() != $asset->getId()) {
                $this->setError('asset', 'immutable', $this->getFactory()->newError([
                    "title" => "Immutable Relationship `asset`",
                    "detail" => "You cannot edit the `asset` relationship of an intent. If you'd like to change the asset, you should delete this intent using the DELETE /exchange/api/v2/order-intents/".$this->getId()." endpoint and then create a new one",
                    "status" => 400
                ]));
                return;
            } else {
                $this->clearError('asset', 'immutable');
            }
        }

        $this->attributes['status'] = $val;

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

            $user = $this->datasource->getRelatedUser($user->getId());
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

        return $this;
    }




    public function setAsset(\CFX\AssetInterface $asset=null) {
        if (!$this->validateStatusActive()) return false;

        if ($this->getAsset()) {
            if (!$asset || $this->getAsset()->getId() != $asset->getId()) {
                $this->setError('asset', 'immutable', $this->getFactory()->newError([
                    "title" => "Immutable Relationship `asset`",
                    "detail" => "You cannot edit the `asset` relationship of an intent. If you'd like to change the asset, you should delete this intent using the DELETE /exchange/api/v2/order-intents/".$this->getId()." endpoint and then create a new one",
                    "status" => 400
                ]));
                return;
            } else {
                $this->clearError('asset', 'immutable');
            }
        }

        $this->relationships['asset']->setData($asset);

        if (!$asset) {
            $this->setError('asset', "required", $this->getFactory()->newError([
                "status" => 400,
                "title" => "Required Relationship `asset` Missing",
                "detail" => "You must indicate an asset for this order."
            ]));
        } else {
            $this->clearError('asset', 'required');

            try {
                // Will throw error if asset is invalid
                $this->datasource->getRelatedAsset($asset->getId());
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

        return $this;
    }



    public function setOrder(\CFX\Brokerage\OrderInterface $order=null) {
        //TODO: Flesh this out
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

