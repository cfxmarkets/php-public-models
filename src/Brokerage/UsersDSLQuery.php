<?php
namespace CFX\Brokerage;

class UsersDSLQuery extends \CFX\Persistence\GenericDSLQuery {
    protected $primaryKey = 'guid';

    protected static function getAcceptableFields() {
        return array_merge(parent::getAcceptableFields(), [ 'email' ]);
    }

    public function setEmail($operator, $val) {
        return $this->setExpressionValue('email', [
            'field' => 'email',
            'operator' => $operator,
            'value' => $val,
        ]);
    }

    public function unsetEmail() {
        return $this->setExpressionValue('email', null);
    }

    public function getEmail() {
        return $this->getExpressionValue('email');
    }

    public function requestingCollection() {
        return parent::requestingCollection() && !$this->includes('email');
    }
}


