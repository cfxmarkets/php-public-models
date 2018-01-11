<?php
namespace CFX\Brokerage\Test;

class OrderIntent extends \CFX\Brokerage\OrderIntent
{
    public function forceSetStatus($val)
    {
        return $this->readOnlyOverride(function() use ($val) {
            return parent::setStatus($val);
        });
    }
}

