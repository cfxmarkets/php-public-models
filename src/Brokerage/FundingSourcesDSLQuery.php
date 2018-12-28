<?php
namespace CFX\Brokerage;

class FundingSourcesDSLQuery extends \CFX\Persistence\GenericDSLQuery
{
    protected static function getAcceptableFields()
    {
        return array_merge(parent::getAcceptableFields(), [ "ownerId" ]);
    }

    public function setOwnerId($operator, $val)
    {
        return $this->setExpressionValue('ownerId', [
            "field" => "ReferenceKey",
            "operator" => $operator,
            "value" => $val,
        ]);
    }

    public function unsetOwnerId()
    {
        return $this->setExpressionValue('ownerId', null);
    }

    public function getOwnerId()
    {
        return $this->getExpressionValue('ownerId');
    }
}

