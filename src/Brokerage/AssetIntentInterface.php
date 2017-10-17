<?php
namespace CFX\Brokerage;

interface AssetIntentInterface extends BaseResourceInterface {
    // Getters

    public function getSymbol();
    public function getName();
    public function getDescription();
    public function getAssetType();
    public function getFinanceType();
    public function getExemptionType();
    public function getEdgarNum();
    public function getCusipNum();
    public function getSharesOutstanding();
    public function getOfferAmount();
    public function getDateOpened();
    public function getDateClosed();
    public function getInitialSharePrice();
    public function getHoldingPeriod();
    public function getComments();
    public function getStatus();
    public function getAsset();
    public function getPartner();



    // Setters

    public function setSymbol($val);
    public function setName($val);
    public function setDescription($val);
    public function setAssetType($val);
    public function setFinanceType($val);
    public function setExemptionType($val);
    public function setEdgarNum($val);
    public function setCusipNum($val);
    public function setSharesOutstanding($val);
    public function setOfferAmount($val);
    public function setDateOpened($val);
    public function setDateClosed($val);
    public function setInitialSharePrice($val);
    public function setHoldingPeriod($val);
    public function setComments($val);
    public function setStatus($val);
    public function setAsset(\CFX\AssetInterface $val=null);
    public function setPartner(\KS\JsonApi\BaseResourceInterface $val=null);
}


