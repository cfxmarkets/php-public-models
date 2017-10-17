<?php
namespace CFX\Brokerage\Test;

class Factory extends \CFX\Brokerage\Factory {
    public function newDatasource($cnf, $original=false) {
        if (!$original) return $this->instantiate('\\CFX\\Brokerage\\Test\\Datasource', func_get_args());
        else return parent::newDatasource($cnf);
    }

    public function getdb() {
        return $this->db;
    }
}

