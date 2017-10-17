<?php
namespace CFX\Brokerage;

interface DataContextConfigInterface extends \CFX\SDK\Exchange\DataContextConfigInterface {
    public function getPdo($name='default');
    public function getExchangeClient();
}

