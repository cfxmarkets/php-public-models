<?php
namespace CFX\Exchange;

/**
 * OrderInterface
 *
 * An interface describing a modern CFX Exchange Order object
 */
interface OrderInterface extends \CFX\JsonApi\ResourceInterface {
    /**
     * Get which side the order is on (buy or sell)
     *
     * @return string
     */
    public function getSide();

    /**
     * Get the lot size of the order
     *
     * @return float
     */
    public function getLotSize();

    /**
     * Get the limit price of the order
     *
     * @return float
     */
    public function getPriceHigh();

    /**
     * Get the stop price of the order
     *
     * @return float
     */
    public function getPriceLow();

    /**
     * Get the current price of the order
     *
     * @return float
     */
    public function getCurrentPrice();

    /**
     * Get the status of the order
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get details about the status of the order
     *
     * @return string|null
     */
    public function getStatusDetail();

    /**
     * Get the document key associated with the order
     *
     * @return string|null
     */
    public function getDocumentKey();

    /**
     * Get the brokerage reference key associated with the order
     *
     * @return string
     */
    public function getReferenceKey();

    /**
     * Get the bank account id for the order
     *
     * @return string
     */
    public function getBankAccountId();

    /**
     * Get the asset for the order
     *
     * @return AssetInterface
     */
    public function getAsset();



    /**
     * Set which side the order is on (buy or sell)
     *
     * @param 'buy'|'sell'|null $val
     * @return static
     */
    public function setSide($val);

    /**
     * Set the lot size of the order
     *
     * @param float|int|null $val
     * @return static
     */
    public function setLotSize($val);

    /**
     * Set the limit price of the order
     *
     * For buy orders, this is the most the user wants to pay per share. For sell orders, it's user's "ask price", i.e., what the user
     * would actually like to get for their shares.
     *
     * @param float|int|null $val
     * @return static
     */
    public function setPriceHigh($val);

    /**
     * Set the stop price of the order
     *
     * Not applicable for buy orders. For sell orders, this is the lowest price at which the seller will sell.
     *
     * @param float|int|null $val
     * @return static
     */
    public function setPriceLow($val);

    /**
     * Set the brokerage reference key associated with the order
     *
     * This value is a required arbitrary key passed in by the brokerage to associate the order with a user on their end
     *
     * @param string|null $val
     * @return static
     */
    public function setReferenceKey($val);

    /**
     * Set the bank account id for the order
     *
     * Note: This is an id and not a relationship because the Exchange should not deal directly with bank accounts,
     * and therefore doesn't have a BankAccount model. (This will be resolved in future system versions.)
     *
     * @param string|null $val
     * @return static
     */
    public function setBankAccountId($val);

    /**
     * Set the asset for the order
     *
     * @param AssetInterface|null $val
     * @return static
     */
    public function setAsset(AssetInterface $val = null);
}


