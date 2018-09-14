<?php
namespace CFX\Brokerage;

class FundingInterfacesDSLQuery extends \CFX\Persistence\GenericDSLQuery
{
    protected static function getAcceptableFields()
    {
        return array_merge(parent::getAcceptableFields(), [ "fundingSourceId" ]);
    }

    public function setFundingSourceId($operator, $val)
    {
        return $this->setExpressionValue('fundingSourceId', [
            "field" => $this->primaryKey,
            "operator" => $operator,
            "value" => $val,
        ]);
    }

    public function unsetFundingSourceId()
    {
        return $this->setExpressionValue('fundingSourceId', null);
    }

    public function getFundingSourceId()
    {
        return $this->getExpressionValue('fundingSourceId');
    }
}




