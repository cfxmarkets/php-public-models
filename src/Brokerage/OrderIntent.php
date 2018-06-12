<?php
namespace CFX\Brokerage;

class OrderIntent extends \CFX\JsonApi\AbstractResource implements OrderIntentInterface {
    use \CFX\JsonApi\Rel2MTrait;
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'order-intents';
    protected $attributes = [
        'type' => null,
        'numShares' => null,
        'priceHigh' => null,
        'priceLow' => null,
        'referralKey' => null,
        'issuerAccountNum' => null,
        'referenceNum' => null,
        'paymentMethod' => null,
        'paid' => false,
        'status' => 'new',
        'createdOn' => null,
    ];
    protected $relationships = [
        'user' => null,
        'asset' => null,
        'assetIntent' => null,
        'assetOwner' => null,
        'order' => null,
        'bankAccount' => null,
        'agreement' => null,
        'ownershipDoc' => null,
        'tender' => null,
    ];

    protected static $validTypes = ['sell', 'buy'];
    protected static $validStatuses = [
        'new',
        'picked-up',
        'reviewing',
        'hold',
        'pending',
        'listed',
        'sold',
        'sold_closed',
        'expired',
        'cancelled',
        'expected',
        'sent',
        'sold_closed_paid',
    ];



    public static function getValidTypes()
    {
        return static::$validTypes;
    }

    public static function getValidStatuses()
    {
        return static::$validStatuses;
    }



    // Getters

    public function getType() { return $this->_getAttributeValue('type'); }
    public function getNumShares() { return $this->_getAttributeValue('numShares'); }
    public function getPriceHigh() { return $this->_getAttributeValue('priceHigh'); }
    public function getPriceLow() { return $this->_getAttributeValue('priceLow'); }

    public function getReferralKey()
    {
        return $this->_getAttributeValue('referralKey');
    }

    public function getIssuerAccountNum()
    {
        return $this->_getAttributeValue('issuerAccountNum');
    }

    public function getReferenceNum()
    {
        return $this->_getAttributeValue('referenceNum');
    }

    public function getPaymentMethod()
    {
        return $this->_getAttributeValue('paymentMethod');
    }

    public function getPaid()
    {
        return $this->_getAttributeValue('paid');
    }

    public function getCreatedOn()
    {
        return $this->_getAttributeValue('createdOn');
    }

    public function getStatus() { return $this->_getAttributeValue('status'); }
    public function getUser() { return $this->_getRelationshipValue('user'); }
    public function getAsset() { return $this->_getRelationshipValue('asset'); }
    public function getAssetIntent() { return $this->_getRelationshipValue('assetIntent'); }
    public function getAssetOwner()
    {
        return $this->_getRelationshipValue('assetOwner');
    }
    public function getOrder() { return $this->_getRelationshipValue('order'); }
    public function getBankAccount()
    {
        return $this->_getRelationshipValue('bankAccount');
    }

    public function getAgreement()
    {
        return $this->_getRelationshipValue('agreement');
    }

    public function getOwnershipDoc()
    {
        return $this->_getRelationshipValue('ownershipDoc');
    }

    public function getTender()
    {
        return $this->_getRelationshipValue('tender');
    }





    // Setters

    public function setType($val) {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired('type', $val)) {
            if ($this->validateStatusActive('type')) {
                $initial = $this->getInitial('type');
                if ($initial !== null && $val !== $initial) {
                    $this->setError('type', 'immutable', [
                        'title' => 'Immutable Attribute `type`',
                        'detail' => 'The `type` attribute can\'t be changed, once set. If you need to change the type of this intent, please delete this intent and create a new one.',
                    ]);
                } else {
                    $this->clearError('type', 'immutable');
                    $this->validateAmong('type', $val, $this::getValidTypes());
                }
            }
        }

        return $this->_setAttribute('type', $val);
    }


    public function setNumShares($val) {
        $val = $this->cleanNumberValue($val);
        if ($this->validateRequired('numShares', $val)) {
            if ($this->validateStatusActive('numShares')) {
                if ($this->validateNumeric('numShares', $val)) {
                    if ($val <= 0) {
                        $this->setError('numShares', 'qty', [
                            "title" => "Invalid Attribute Value for `numShares`",
                            "detail" => "You can't enter orders for less than a single share on our system."
                        ]);
                    } else {
                        $this->clearError('numShares', 'qty');
                    }
                }
            }
        }

        return $this->_setAttribute('numShares', $val);
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


    public function setReferralKey($val)
    {
        $val = $this->cleanStringValue($val);
        if ($val !== null) {
            if ($this->validateType('referralKey', $val, 'string')) {
                if (!preg_match('/^[a-z0-9]{32}$/', $val)) {
                    $this->setError('referralKey', 'format', [
                        'title' => "Bad Referral Key Format",
                        "detail" => "Referral keys are generated by the CFX system and should be the standard format output by the system.",
                    ]);
                } else {
                    $this->clearError("referralKey", "format");
                }
            }
        } else {
            $this->clearError('referralKey');
        }
        return $this->_setAttribute('referralKey', $val);
    }


    public function setIssuerAccountNum($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType('issuerAccountNum', $val, 'string', false);
        return $this->_setAttribute('issuerAccountNum', $val);
    }


    public function setReferenceNum($val)
    {
        $val = $this->cleanNumberValue($val);
        if ($this->validateReadOnly('referenceNum', $val)) {
            $this->validateType('referenceNum', $val, 'non-string numeric', false);
            $this->_setAttribute('referenceNum', $val);
        }
        return $this;
    }

    public function setPaymentMethod($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType('paymentMethod', $val, 'non-numeric string', false);
        return $this->_setAttribute('paymentMethod', $val);
    }

    public function setPaid($val)
    {
        $val = $this->cleanBooleanValue($val);
        $this->validateType('paid', $val, 'bool', true);
        return $this->_setAttribute('paid', $val);
    }

    public function setStatus($val) {
        if ($this->validateReadOnly('status', $val)) {
            $this->validateAmong('status', $val, $this::getValidStatuses());
            $this->_setAttribute('status', $val);
        }
        return $this;
    }

    public function setCreatedOn($val)
    {
        $val = $this->cleanDateTimeValue($val);
        $this->validateReadOnly('createdOn', $val);
        return $this->_setAttribute('createdOn', $val);
    }


    public function setUser(UserInterface $user=null) {
        if ($this->validateRequired('user', $user)) {
            if ($this->validateStatusActive('user')) {
                // User is immutable
                if ($this->getInitial('user') && $this->valueDiffersFromInitial('user', $user)) {
                    $this->setError('user', 'immutable', [
                        "title" => "Immutable Relationship `user`",
                        "detail" => "You cannot edit the `user` relationship of an order intent. If you'd like to change the user, you should delete this intent using the DELETE /exchange/api/v2/order-intents/".$this->getId()." endpoint and then create a new one",
                    ]);
                } else {
                    $this->clearError('user', 'immutable');

                    try {
                        $user->initialize();
                        $this->clearError('user', 'valid');
                    } catch (\CFX\Persistence\ResourceNotFoundException $e) {
                        $this->setError('user', 'valid', [
                            "title" => "Invalid Relationship `user`",
                            "detail" => "The user you've specified doesn't appear to be in our database."
                        ]); 
                    }
                }
            }
        }

        return $this->_setRelationship('user', $user);
    }




    public function setAsset(\CFX\Exchange\AssetInterface $asset=null) {
        if (!$asset) {
            if (!$this->getAssetIntent()) {
                $this->setError('assetOrAssetIntent', 'required', [
                    'title' => 'Asset or AssetIntent Required',
                    'detail' => 'You must set either and Asset or an AssetIntent for this order intent to be valid.',
                ]);
            } else {
                $this->clearError('assetOrAssetIntent', 'required');
            }
        } else {
            $this->clearError('assetOrAssetIntent', 'required');

            if ($this->getAssetIntent()) {
                $this->setError('assetOrAssetIntent', 'duplicate', [
                    'title' => "Conflicting Asset and AssetIntent",
                    "detail" => "You can't have both an asset and an asset intent for this order intent to be valid.",
                ]);
            } else {
                $this->clearError('assetOrAssetIntent', 'duplicate');
                // Should add considerations for asset status (non-tradable assets shouldn't be valid)
            }
        }

        if ($this->validateStatusActive('asset')) {
            if ($this->getInitial('asset') && $this->valueDiffersFromInitial('asset', $asset)) {
                $this->setError('asset', 'immutable', [
                    'title' => 'Immutable Relationship `asset`',
                    'detail' => "You can only set `asset` once. If you made a mistake and would like to change the asset, you should delete this ".
                        "order intent and create a new one.",
                ]);
            } else {
                $this->clearError('asset','immutable');
            }
        }

        return $this->_setRelationship('asset', $asset);
    }


    public function setAssetIntent(\CFX\Brokerage\AssetIntentInterface $assetIntent=null) {
        if (!$assetIntent) {
            if (!$this->getAsset()) {
                $this->setError('assetOrAssetIntent', 'required', [
                    'title' => 'Asset or AssetIntent Required',
                    'detail' => 'You must set either and Asset or an AssetIntent for this order intent to be valid.',
                ]);
            } else {
                $this->clearError('assetOrAssetIntent', 'required');
            }
        } else {
            $this->clearError('assetOrAssetIntent', 'required');

            if ($this->getAsset()) {
                $this->setError('assetOrAssetIntent', 'duplicate', [
                    'title' => "Conflicting Asset and AssetIntent",
                    "detail" => "You can't have both an assetIntent and an assetIntent intent for this order intent to be valid.",
                ]);
            } else {
                $this->clearError('assetOrAssetIntent', 'duplicate');
            }
        }

        if ($this->validateStatusActive('assetIntent')) {
            if ($this->getInitial('assetIntent') !== null && $this->valueDiffersFromInitial('assetIntent', $assetIntent)) {
                $this->setError('assetIntent', 'immutable', [
                    'title' => 'Immutable Relationship `assetIntent`',
                    'detail' => "You can only set `assetIntent` once. If you made a mistake and would like to change the assetIntent, you should delete this ".
                        "order intent and create a new one.",
                ]);
            } else {
                $this->clearError('assetIntent','immutable');
            }
        }

        return $this->_setRelationship('assetIntent', $assetIntent);
    }


    public function setAssetOwner(\CFX\Brokerage\LegalEntityInterface $owner = null)
    {
        $this->validateStatusActive('assetOwner');
        return $this->_setRelationship('assetOwner', $owner);
    }


    public function setOrder(\CFX\Exchange\OrderInterface $order=null) {
        if ($this->validateReadOnly('order', $order)) {
            $this->validateStatusActive('order');
        }
        return $this->_setRelationship('order', $order);
    }

    public function setBankAccount(\CFX\Brokerage\BankAccountInterface $bankAccount = null)
    {
        $this->validateStatusActive('bankAccount');
        return $this->_setRelationship('bankAccount', $bankAccount);
    }

    public function setAgreement(DocumentInterface $val = null)
    {
        return $this->_setRelationship('agreement', $val);
    }

    public function setOwnershipDoc(DocumentInterface $val = null)
    {
        return $this->_setRelationship('ownershipDoc', $val);
    }

    public function setTender(TenderInterface $val = null)
    {
        return $this->_setRelationship('tender', $val);
    }





    /**
     * Serialize createdOn field to a value that SQL understands
     *
     * We have to do this here because when order intents are serialized that already have a createdOn date
     * set, they end up sending malformed data to the API. This is because \DateTime actually does implement
     * jsonSerialize, but in a way that breaks our implementation.
     */
    public function serializeAttribute($name)
    {
        if ($name === 'createdOn') {
            $val = $this->getCreatedOn();
            if ($val instanceof \DateTimeInterface) {
                $val = $val->format("Y-m-d H:i:s");
            }
            return (string)$val;
        }
        return parent::serializeAttribute($name);
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
        if (!$this->initializing) {
            $passedStates = [
                'listed' => "Sale In Progress: This intent has already passed to listing phase and cannot be altered",
                'sold' => "Item Already Sold: This intent has already been successfully executed and sold and cannot be altered",
                'sold_closed' => "Item Closed: This intent has been closed and cannot be altered",
                'expired' => "Item Expired: This intent has expired and cannot be altered",
                'cancelled' => "Item Cancelled: This intent has been cancelled and cannot be altered",
            ];

            if (in_array($this->getStatus(), array_keys($passedStates))) {
                $this->setError($field, 'immutableStatus', [
                    "title" => "Order Intent Not Alterable",
                    "detail" => $passedStates[$this->getStatus()],
                ]);
                return false;
            } else {
                $this->clearError($field, 'immutableStatus');
                return true;
            }
        }
    }
}

