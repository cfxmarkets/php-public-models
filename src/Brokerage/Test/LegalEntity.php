<?php
namespace CFX\Brokerage\Test;

class LegalEntity extends \CFX\Brokerage\LegalEntity
{
    public function setAccreditationStatus($val)
    {
        return $this->readOnlyOverride(function() use ($val) {
            return parent::setAccreditationStatus($val);
        });
    }
    public function setVerificationStatus($val)
    {
        return $this->readOnlyOverride(function() use ($val) {
            return parent::setVerificationStatus($val);
        });
    }
}


