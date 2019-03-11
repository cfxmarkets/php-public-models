<?php
namespace CFX\Brokerage;

class AgreementsDSLQuery extends \CFX\Persistence\GenericDSLQuery
{
    protected static function getAcceptableFields() {
        return array_merge(parent::getAcceptableFields(), [ "contractId", "entityId", "signerId" ]);
    }




    public function setContractId($operator, $val) {
        $this->setExpressionValue('contractId', [
            'field' => 'contractId',
            'operator' => $operator,
            'value' => $val
        ]);
        return $this;
    }

    public function unsetContractId() {
        $this->setExpressionValue('contractId', null);
        return $this;
    }

    public function getContractId() {
        return $this->getExpressionValue('contractId');
    }






    public function setEntityId($operator, $val) {
        $this->setExpressionValue('entityId', [
            'field' => 'entityId',
            'operator' => $operator,
            'value' => $val
        ]);
        return $this;
    }

    public function unsetEntityId() {
        $this->setExpressionValue('entityId', null);
        return $this;
    }

    public function getEntityId() {
        return $this->getExpressionValue('entityId');
    }







    public function setSignerId($operator, $val) {
        $this->setExpressionValue('signerId', [
            'field' => 'signerId',
            'operator' => $operator,
            'value' => $val
        ]);
        return $this;
    }

    public function unsetSignerId() {
        $this->setExpressionValue('signerId', null);
        return $this;
    }

    public function getSignerId() {
        return $this->getExpressionValue('signerId');
    }





    public function requestingCollection()
    {
        return parent::requestingCollection() &&
            ! ($this->includes("entityId") && $this->includes("contractId") && $this->includes("signerId"));
    }
}


