<?php
namespace CFX\Brokerage;

interface BrokerageContextInterface extends \CFX\DataContextInterface {
    public function getAssetsDatasource();
    public function getAssetIntentsDatasource();
    public function getApiKeysDatasource();
    public function getPartnersDatasource();
    public function getOrdersDatasource();
    public function getOrderIntentsDatasource();
    public function getUsersDatasource();
}

