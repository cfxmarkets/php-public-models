<?php
namespace CFX\Brokerage;

class TendersDSLQuery extends \CFX\Persistence\GenericDSLQuery
{
    public function setTenderRoomId($operator, $val) {
        $this->setExpressionValue('tenderRoomId', [
            'field' => 'tenderRoomId',
            'operator' => $operator,
            'value' => $val,
        ]);
        return $this;
    }

    public function unsetTenderRoomId() {
        $this->setExpressionValue('tenderRoomId', null);
    }

    public function getTenderRoomId() {
        return $this->getExpressionValue('tenderRoomId');
    }

    protected static function getAcceptableFields() {
        return array_merge(parent::getAcceptableFields(), [ 'tenderRoomId' ]);
    }
}

