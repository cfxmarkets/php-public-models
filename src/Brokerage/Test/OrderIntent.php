<?php
namespace CFX\Brokerage\Test;

class OrderIntent extends \CFX\Brokerage\OrderIntent
{
    public function forceSetStatus($val)
    {
        $this->honorReadOnly = false;
        parent::setStatus($val);
        $this->honorReadOnly = true;
    }
}

