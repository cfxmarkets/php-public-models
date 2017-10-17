<?php
namespace CFX\Brokerage;

class Datasource implements DatasourceInterface, AuthzDatasourceInterface, FactoryConsumerInterface {
    use DatasourceTrait;

    protected $cnf;

    public function __construct($cnf) {
        if (!array_key_exists('pdos', $cnf)) throw new \InvalidArgumentException("You must supply a configuration array with a 'pdos' key containing either a PDO instance or a closure that instantiates a PDO instance, or a string-indexed array contiaining values of the same.");

        if (!is_array($cnf['pdos'])) $pdos = array('default' => $cnf['pdos']);
        else $pdos = $cnf['pdos'];

        $this->cnf = $cnf;

        foreach($pdos as $k => $pdo) {
            if (!($pdo instanceof \Closure) && !($pdo instanceof \PDO)) throw new \InvalidArgumentException("Any PDO objects that you send must either be PDOs or closures that instantiate PDOs on demand.");
            $this->db[$k] = $pdo;
        }
    }
}

