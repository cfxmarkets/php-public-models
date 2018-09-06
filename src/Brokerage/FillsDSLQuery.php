<?php
namespace CFX\Brokerage;

class FillsDSLQuery extends \CFX\Persistence\GenericDSLQuery
{
    protected static function getAcceptableFields()
    {
        return array_merge(parent::getAcceptableFields(), [ "legalEntityId" ]);
    }

    public function setLegalEntityId($operator, $val)
    {
        return $this->setExpressionValue('legalEntityId', [
            "field" => "AccountKey",
            "operator" => $operator,
            "value" => $val,
        ]);
    }

    public function unsetLegalEntityId()
    {
        return $this->setExpressionValue('legalEntityId', null);
    }

    public function getLegalEntityId()
    {
        return $this->getExpressionValue('legalEntityId');
    }
}



