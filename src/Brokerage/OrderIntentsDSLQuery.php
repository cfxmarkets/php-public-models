<?php
namespace CFX\Brokerage;

class OrderIntentsDSLQuery extends \CFX\Persistence\GenericDSLQuery {
    public function setUserId($operator, $val) {
        $this->setExpressionValue('userId', [
            'field' => 'user_guid',
            'operator' => $operator,
            'value' => $val,
        ]);
        return $this;
    }

    public function unsetUserId() {
        $this->setExpressionValue('userId', null);
    }

    public function getUserId() {
        return $this->getExpressionValue('userId');
    }

    protected static function getAcceptableFields() {
        return array_merge(parent::getAcceptableFields(), [ 'userId' ]);
    }
}

