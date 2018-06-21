<?php
namespace CFX\Brokerage;

class UsersDSLQuery extends \CFX\Persistence\GenericDSLQuery {
    protected $primaryKey = 'guid';

    protected static function getAcceptableFields() {
        return array_merge(parent::getAcceptableFields(), [ 'email', "authId" ]);
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




    public function setAuthId($operator, $val) {
        return $this->setExpressionValue('authId', [
            'field' => 'authId',
            'operator' => $operator,
            'value' => $val,
        ]);
    }

    public function unsetAuthId() {
        return $this->setExpressionValue('authId', null);
    }

    public function getAuthId() {
        return $this->getExpressionValue('authId');
    }



    public function requestingCollection() {
        return parent::requestingCollection() && !$this->includes('email') && !$this->includes("authId");
    }

    public static function getLogicalOperators()
    {
        return [ "and", "or" ];
    }
}


