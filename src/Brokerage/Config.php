<?php
namespace CFX\Brokerage;

class Config extends \CFX\Config implements ConfigInterface {
    protected $exchangeClient;

    public function getExchangeClient() {
        if (!$this->exchangeClient) $this->exchangeClient = new \CFX\SDK\Exchange\Client($this->getBaseApiUri(), $this->getExchangeApiKey(), $this->getExchangeApiKeySecret(), $this->getHttpClient());
        return $this->exchangeClient;
    }

    public function getBaseApiUri() {
        return $this->get('base-api-uri');
    }

    public function getExchangeApiKey() {
        return $this->get('exchange-api-key');
    }

    public function getExchangeApiKeySecret() {
        return $this->get('exchange-api-key-secret');
    }
}

