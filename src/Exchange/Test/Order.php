<?php
namespace CFX\Exchange\Test;

class Order extends \CFX\Exchange\Order
{
    public function forceSetStatus($val)
    {
        return $this->readOnlyOverride(function() use ($val) {
            return parent::setStatus($val);
        });
    }
}

