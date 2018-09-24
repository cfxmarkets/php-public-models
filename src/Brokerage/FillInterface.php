<?php
namespace CFX\Brokerage;

/**
 * FillInterface
 *
 * An interface describing a modern CFX Fill object
 */
interface FillInterface extends \CFX\JsonApi\ResourceInterface {
    /**
     * Get which side the fill is on (buy or sell)
     *
     * @return string
     */
    public function getSide();

    /**
     * Get the lot size of the fill
     *
     * @return float
     */
    public function getLotSize();

    /**
     * Get the price of the fill
     *
     * @return float
     */
    public function getPrice();

    /**
     * Get the fees for the fill
     *
     * @return float
     */
    public function getFees();

    /**
     * Get the status for the fill
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get the timestamp of the fill
     *
     * @return float
     */
    public function getTimestamp();

    /**
     * Get the order to which the fill pertains
     *
     * @return OrderIntent
     */
    public function getOrder();

    /**
     * Get the security for the fill
     *
     * @return \CFX\Exchange\AssetInterface
     */
    public function getSecurity();



    /**
     * Set which side the fill is on (buy or sell)
     *
     * @param 'buy'|'sell'|null $val
     * @return static
     */
    public function setSide($val);

    /**
     * Set the lot size of the fill
     *
     * @param float|int|null $val
     * @return static
     */
    public function setLotSize($val);

    /**
     * Set the price of the fill
     *
     * @param float|int|null $val
     * @return static
     */
    public function setPrice($val);

    /**
     * Set the fees for the fill
     *
     * @param float|int|null $val
     * @return static
     */
    public function setFees($val);

    /**
     * Set the timestamp for the fill
     *
     * @param int|\DateTime|null $val
     * @return static
     */
    public function setTimestamp($val);

    /**
     * Set the order for the fill
     *
     * @param \CFX\Exchange\OrderInterface|null $val
     * @return static
     */
    public function setOrder(?\CFX\Exchange\OrderInterface $val);

    /**
     * Set the security for the fill
     *
     * @param \CFX\Exchange\AssetInterface|null $val
     * @return static
     */
    public function setSecurity(?\CFX\Exchange\AssetInterface $val);
}



