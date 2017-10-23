<?php
namespace CFX\Exchange;

/**
 * OrderInterface
 *
 * An interface describing a modern CFX Brokerage Order object
 */
interface OrderInterface extends \CFX\JsonApi\ResourceInterface {

    // Getters

    public function getType();
    public function getNumShares();
    public function getPriceHigh();
    public function getPriceLow();
    public function getCurrentPrice();
    public function getAsset();

    // Setters

    public function setType($val);
    public function setNumShares($val);
    public function setPriceHigh($val);
    public function setPriceLow($val);
    public function setCurrentPrice($val);
    public function setAsset(\CFX\AssetInterface $val=null);
}


