<?php
namespace CFX\Brokerage;

interface AssetIntentInterface extends \CFX\JsonApi\ResourceInterface {
    /**
     * Get the proposed asset symbol
     *
     * @return string
     */
    public function getSymbol();

    /**
     * Get the proposed asset name
     *
     * @return string
     */
    public function getName();

    /**
     * Get the proposed asset description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the proposed asset type
     *
     * @return string
     */
    public function getAssetType();

    /**
     * Get the proposed asset finance type
     *
     * @return string
     */
    public function getFinanceType();

    /**
     * Get the proposed asset exemption type
     *
     * @return string
     */
    public function getExemptionType();

    /**
     * Get the proposed asset edgar number
     *
     * @return string
     */
    public function getEdgarNum();

    /**
     * Get the proposed asset cusip
     *
     * @return string
     */
    public function getCusipNum();

    /**
     * Get the proposed asset's outstanding shares
     *
     * @return string
     */
    public function getSharesOutstanding();

    /**
     * Get the proposed asset's offer amount
     *
     * @return string
     */
    public function getOfferAmount();

    /**
     * Get the proposed asset opening date
     *
     * @return string
     */
    public function getDateOpened();

    /**
     * Get the proposed asset's closing date
     *
     * @return string
     */
    public function getDateClosed();

    /**
     * Get the proposed asset's initial share price
     *
     * @return string
     */
    public function getInitialSharePrice();

    /**
     * Get the proposed asset's holding period
     *
     * @return string
     */
    public function getHoldingPeriod();

    /**
     * Get comments about the proposed asset
     *
     * @return string
     */
    public function getComments();

    /**
     * Get the status of the asset proposal
     *
     * @return string
     */
    public function getStatus();

    /**
     * If the proposed asset has been successfully converted to a real asset, get that Asset
     *
     * @return \CFX\Exchange\AssetInterface
     */
    public function getAsset();



    /**
     * Set the proposed asset symbol
     *
     * @param string $val
     * @return static
     */
    public function setSymbol($val);

    /**
     * Set the proposed asset name
     *
     * @param string $val
     * @return static
     */
    public function setName($val);

    /**
     * Set the proposed asset description
     *
     * @param string $val
     * @return static
     */
    public function setDescription($val);

    /**
     * Set the proposed asset type
     *
     * @param string $val
     * @return static
     */
    public function setAssetType($val);

    /**
     * Set the proposed asset finance type
     *
     * @param string $val
     * @return static
     */
    public function setFinanceType($val);

    /**
     * Set the proposed asset exemption type
     *
     * This would be RegA, RegA+, RegD, etc...
     *
     * @param string $val
     * @return static
     */
    public function setExemptionType($val);

    /**
     * Set the proposed asset edgar number
     *
     * @param string $val
     * @return static
     */
    public function setEdgarNum($val);

    /**
     * Set the proposed asset cusip
     *
     * @param string $val
     * @return static
     */
    public function setCusipNum($val);

    /**
     * Set the proposed asset's outstanding shares
     *
     * @param string $val
     * @return static
     */
    public function setSharesOutstanding($val);

    /**
     * Set the proposed asset's offer amount
     *
     * @param string $val
     * @return static
     */
    public function setOfferAmount($val);

    /**
     * Set the proposed asset opening date
     *
     * @param string $val
     * @return static
     */
    public function setDateOpened($val);

    /**
     * Set the proposed asset's closing date
     *
     * @param string $val
     * @return static
     */
    public function setDateClosed($val);

    /**
     * Set the proposed asset's initial share price
     *
     * @param string $val
     * @return static
     */
    public function setInitialSharePrice($val);

    /**
     * Set the proposed asset's holding period
     *
     * @param string $val
     * @return static
     */
    public function setHoldingPeriod($val);

    /**
     * Set comments about the proposed asset
     *
     * @param string $val
     * @return static
     */
    public function setComments($val);

    /**
     * Set the status of the asset proposal
     *
     * @readonly
     * @param string $val
     * @return static
     */
    public function setStatus($val);

    /**
     * If the proposed asset has been successfully converted to a real asset, set that Asset
     *
     * @param \CFX\Exchange\AssetInterface $val
     * @return static
     */
    public function setAsset(\CFX\Exchange\AssetInterface $val = null);
}


