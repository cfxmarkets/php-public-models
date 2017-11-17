<?php
namespace CFX\Exchange\Test;

class Order extends \CFX\Exchange\Order
{
    public function forceSetStatus($val)
    {
        $this->honorReadOnly = false;
        parent::setStatus($val);
        $this->honorReadOnly = true;
    }
}

