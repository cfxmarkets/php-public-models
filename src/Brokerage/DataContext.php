<?php
namespace CFX\Brokerage;

class BrokerageContext extends \CFX\AbstractDataContext implements BrokerageContextInterface {
    protected $cnf;

    public function __construct(DataContextConfigInterface $cnf) {
        $this->cnf = $cnf;
    }

    /**
     * Instantiate a client on demand
     */
    protected function instantiateClient($name) {
        if ($name == 'apiKeys') return new \CFX\ApiKeysDatasource($this);
        if ($name == 'partners') return new \CFX\PartnersDatasource($this);
        if ($name == 'assetIntents') return new AssetIntentsDatasource($this);
        if ($name == 'orderIntents') return new OrderIntentsDatasource($this);
        if ($name == 'users') return new OrderIntentsDatasource($this);
        if ($name == 'assets' || $name == 'orders') {
            $exchangeClient = $this->cnf->getExchangeClient();
            if ($name == 'assets') return $exchangeClient->assets;
            if ($name == 'orders') return $exchangeClient->orders;
        }

        throw new \CFX\UnknownDatasourceException("Programmer: Don't know how to handle datasources of type `$name`. If you'd like to handle this, you should either add this datasource to the `instantiateClient` method in this class or create a derivative class to which to add it.");
    }

    public function getPdo($name) {
        return $this->cnf->getPdo($name);
    }




    /***
     * Methods to fulfill the interface (these are not really supposed to be used, since it's generally
     * considered easier to use the properties instead)
     ***/

    public function getAssetsDatasource() { return $this->assets; }
    public function getAssetIntentsDatasource() { return $this->assetIntents; }
    public function getApiKeysDatasource() { return $this->apiKeys; }
    public function getPartnersDatasource() { return $this->partners; }
    public function getOrdersDatasource() { return $this->orders; }
    public function getOrderIntentsDatasource() { return $this->orderIntents; }
    public function getUsersDatasource() { return $this->users; }


    public function newJsonApiResource($data=null, $type=null, $validAttrs=null, $validRels=null, \CFX\DatasourceInterface $datasource=null) {
        if ($type == 'partners') return new Partner($datasource, $data);
        return parent::newJsonApiResource($data, $type, $validAttrs, $validRels, $datasource);
    }
}

