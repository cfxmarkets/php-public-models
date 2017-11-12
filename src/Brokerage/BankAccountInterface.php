<?php
namespace CFX\Brokerage;

interface BankAccountInterface extends \CFX\JsonApi\ResourceInterface
{
    public function getLabel();
    public function getBankName();
    public function getAccountType();
    public function getHolderName();
    public function getRoutingNum();
    public function getAccountNum();
    public function getBankAddress();
    public function getStatus();
    public function getOwner();

    public function setLabel($val);
    public function setBankName($val);
    public function setAccountType($val);
    public function setHolderName($val);
    public function setRoutingNum($val);
    public function setAccountNum($val);
    public function setBankAddress($val);
    public function setStatus($val);
    public function setOwner(LegalEntityInterface $owner = null);
}

