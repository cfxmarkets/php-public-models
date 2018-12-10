<?php
namespace CFX\Brokerage;

class AclEntriesDSLQuery extends \CFX\Persistence\GenericDSLQuery
{
    protected static function getAcceptableFields() {
        return array_merge(parent::getAcceptableFields(), [ "actorType", "actorId", "targetType", "targetId" ]);
    }

    public function setActorType($operator, $val) {
        $this->setExpressionValue('actorType', [
            'field' => 'actorType',
            'operator' => $operator,
            'value' => $val
        ]);
        return $this;
    }

    public function unsetActorType() {
        $this->setExpressionValue('actorType', null);
        return $this;
    }

    public function getActorType() {
        return $this->getExpressionValue('actorType');
    }






    public function setActorId($operator, $val) {
        $this->setExpressionValue('actorId', [
            'field' => 'actorId',
            'operator' => $operator,
            'value' => $val
        ]);
        return $this;
    }

    public function unsetActorId() {
        $this->setExpressionValue('actorId', null);
        return $this;
    }

    public function getActorId() {
        return $this->getExpressionValue('actorId');
    }







    public function setTargetType($operator, $val) {
        $this->setExpressionValue('targetType', [
            'field' => 'targetType',
            'operator' => $operator,
            'value' => $val
        ]);
        return $this;
    }

    public function unsetTargetType() {
        $this->setExpressionValue('targetType', null);
        return $this;
    }

    public function getTargetType() {
        return $this->getExpressionValue('targetType');
    }







    public function setTargetId($operator, $val) {
        $this->setExpressionValue('targetId', [
            'field' => 'targetId',
            'operator' => $operator,
            'value' => $val
        ]);
        return $this;
    }

    public function unsetTargetId() {
        $this->setExpressionValue('targetId', null);
        return $this;
    }

    public function getTargetId() {
        return $this->getExpressionValue('targetId');
    }





    public function requestingCollection()
    {
        return parent::requestingCollection() &&
            ! ($this->includes("actorId") && $this->includes("targetId"));
    }
}

