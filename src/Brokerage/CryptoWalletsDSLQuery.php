<?php
namespace CFX\Brokerage;

class CryptoWalletsDSLQuery extends \CFX\Persistence\GenericDSLQuery
{
    protected static function getAcceptableFields()
    {
        return array_merge(parent::getAcceptableFields(), [ "legalEntityId" ]);
    }

    public function setLegalEntityId($operator, $val)
    {
        return $this->setExpressionValue('legalEntityId', [
            "field" => "legalEntityId",
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

    // Override setId to use binary id format
    public function setId($operator, $val)
    {
        if ($operator !== "=") {
            throw new \CFX\Persistence\BadQueryException(
                "You may only use the 'equals' ('=') operator when querying crypto-wallet ids"
            );
        }

        return $this->setExpressionValue('id', [
            "string" => "id $operator $val",
            'raw' => "`$this->primaryKey` = UNHEX(?)",
            'value' => preg_replace("/^0x/", "", $val),
            "operator" => $operator,
        ]);
    }
}




