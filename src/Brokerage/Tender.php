<?php
namespace CFX\Brokerage;

class Tender extends \CFX\JsonApi\AbstractResource implements TenderInterface
{
    use \CFX\ResourceValidationsTrait;
    use \CFX\JsonApi\Rel2MTrait;

    protected $resourceType = 'tenders';
    protected $attributes = [
        'sharePrice' => null,
        'shareLimit' => null,
        'spendLimit' => null,
        'minSharesThreshold' => null,
        'openDate' => null,
        'closeDate' => null,
        'purchaserName' => null,
        'status' => 'new',
    ];
    protected $relationships = [
        'asset' => null,
        'purchaser' => null,
        'announcementDoc' => null,
        'agreementTemplates' => null,
        'tenderRoom' => null,
    ];

    public static function getValidStatuses()
    {
        return [
            0 => 'new',
            1 => 'reviewing',
            2 => 'active',
            3 => 'closed',
        ];
    }





    public function getSharePrice()
    {
        return $this->_getAttributeValue('sharePrice');
    }

    public function getShareLimit()
    {
        return $this->_getAttributeValue('shareLimit');
    }

    public function getSpendLimit()
    {
        return $this->_getAttributeValue('spendLimit');
    }

    public function getMinSharesThreshold()
    {
        return $this->_getAttributeValue('minSharesThreshold');
    }

    public function getOpenDate()
    {
        return $this->_getAttributeValue('openDate');
    }

    public function getCloseDate()
    {
        return $this->_getAttributeValue('closeDate');
    }

    public function getPurchaserName()
    {
        return $this->_getAttributeValue('purchaserName');
    }

    public function getStatus()
    {
        return $this->_getAttributeValue('status');
    }

    public function getAsset()
    {
        return $this->_getRelationshipValue('asset');
    }

    public function getPurchaser()
    {
        return $this->_getRelationshipValue('purchaser');
    }

    public function getAnnouncementDoc()
    {
        return $this->_getRelationshipValue('announcementDoc');
    }

    public function getAgreementTemplates()
    {
        return $this->_getRelationshipValue('agreementTemplates');
    }

    public function getTenderRoom()
    {
        return $this->_getRelationshipValue('tenderRoom');
    }







    public function setSharePrice($val)
    {
        $val = $this->cleanNumberValue($val);
        if ($this->validateRequired('sharePrice', $val)) {
            if ($this->validateType('sharePrice', $val, 'non-string numeric')) {
                if ($val <= 0 || $val >= 99999.99955) {
                    $this->setError('sharePrice', 'range', [
                        'title' => 'Invalid Share Price',
                        'detail' => 'Share prices must be between $0 and $99999.99',
                    ]);
                } else {
                    $this->clearError('sharePrice', 'range');
                }
            }
        }
        return $this->_setAttribute('sharePrice', $val);
    }

    public function setShareLimit($val)
    {
        $val = $this->cleanNumberValue($val);
        if ($this->validateRequired('shareLimit', $val)) {
            if ($this->validateType('shareLimit', $val, 'non-string numeric')) {
                if ($val < 1 || $val >= 999999999.995) {
                    $this->setError('shareLimit', 'range', [
                        'title' => 'Invalid Share Limit',
                        'detail' => 'Share limits must be between 1 and 999999999.99. This is a technical limitation, and it IS possible to change it. If you need us to raise this limit, please call customer support.',
                    ]);
                } else {
                    $this->clearError('shareLimit', 'range');
                }
            }
        }
        return $this->_setAttribute('shareLimit', $val);
    }

    public function setSpendLimit($val)
    {
        $val = $this->cleanNumberValue($val);
        if ($this->validateRequired('spendLimit', $val)) {
            if ($this->validateType('spendLimit', $val, 'non-string numeric')) {
                if ($val < 1 || $val >= 999999999.5) {
                    $this->setError('spendLimit', 'range', [
                        'title' => 'Invalid Spend Limit',
                        'detail' => 'Spend limits must be between 1 and 999999999. This is a technical limitation, and it IS possible to change it. If you need us to raise this limit, please call customer support.',
                    ]);
                } else {
                    $this->clearError('spendLimit', 'range');
                }
            }
        }
        return $this->_setAttribute('spendLimit', $val);
    }

    public function setMinSharesThreshold($val)
    {
        $val = $this->cleanNumberValue($val);
        if ($val !== null) {
            if ($this->validateType('minSharesThreshold', $val, 'int')) {
                if ($val < 0 || $val > 4294967295) {
                    $this->setError('minSharesThreshold', 'range', [
                        'title' => "Invalid Minimum Shares Threshold",
                        "detail" => "If you set a minimum share limit for your tender, it must be between 0 and 4294967295 shares. This is a technical limitation, and it IS possible to change it. If you need us to raise this limit, please call customer support."
                    ]);
                } else {
                    $this->clearError('minSharesThreshold', 'range');
                }
            }
        } else {
            $this->clearError('minSharesThreshold');
        }
        return $this->_setAttribute('minSharesThreshold', $val);
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

    public function setPurchaserName($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired('purchaserName', $val)) {
            $this->validateType('purchaserName', $val, 'non-numeric string');
        }
        return $this->_setAttribute('purchaserName', $val);
    }

    public function setStatus($val)
    {
        if ($this->validateReadOnly('status', $val)) {
            $this->_setAttribute('status', $val);
        }
        return $this;
    }

    public function setAsset(\CFX\Exchange\AssetInterface $val = null)
    {
        $this->validateRequired('asset', $val);
        return $this->_setRelationship('asset', $val);
    }

    public function setPurchaser(LegalEntityInterface $val = null)
    {
        $this->validateRequired('purchaser', $val);
        return $this->_setRelationship('purchaser', $val);
    }

    public function setAnnouncementDoc(DocumentInterface $val = null)
    {
        return $this->_setRelationship('announcementDoc', $val);
    }

    public function setAgreementTemplates(DocumentTemplateInterface $val = null)
    {
        return $this->_setRelationship('agreementTemplates', $val);
    }

    public function addAgreementTemplate(DocumentTemplateInterface $val)
    {
        return $this->add2MRel('agreementTemplates', $val);
    }

    public function removeAgreementTemplate(DocumentTemplateInterface $val)
    {
        return $this->remove2MRel('agreeementTemplates', $val);
    }

    public function hasAgreementTemplate(DocumentTemplateInterface $val)
    {
        return $this->has2MRel('agreeementTemplates', $val);
    }

    public function setTenderRoom(TenderRoomInterface $val = null)
    {
        $this->validateRequired('tenderRoom', $val);
        return $this->_setRelationship('tenderRoom', $val);
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


