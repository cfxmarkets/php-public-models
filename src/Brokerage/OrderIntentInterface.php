<?php
namespace CFX\Brokerage;

interface OrderIntentInterface extends BaseResourceInterface {
    // Getters
    public function getType();
    public function getNumShares();
    public function getPriceHigh();
    public function getPriceLow();
    public function getStatus();
    public function getUser();
    public function getAsset();

    // Setters
    public function setType($val);
    public function setNumShares($val);
    public function setPriceHigh($val);
    public function setPriceLow($val);
    public function setStatus($val);
    public function setUser(SiteUserInterface $user=null);
    public function setAsset(\CFX\AssetInterface $asset=null);
}


