<?php
namespace CFX\Brokerage;

interface AgreementInterface {
    public function getTimestamp();
    public function getContract();
    public function getEntity();
    public function getSigner();

    public function setContract(?ContractInterface $val);
    public function setEntity(?LegalEntityInterface $val);
    public function setSigner(?UserInterface $val);
}

