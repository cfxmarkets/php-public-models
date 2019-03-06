<?php
namespace CFX\Brokerage;

interface ContractInterface {
    public static function getAvailableContractTypes();
    public static function getAvailableAudiences();

    public function getAudience();
    public function getEffectiveDate();
    public function getContractType();
    public function getUrl();
    public function getChangeLog();

    public function setAudience($val);
    public function setEffectiveDate($val);
    public function setContractType($val);
    public function setUrl($val);
    public function setChangeLog($val);
}
