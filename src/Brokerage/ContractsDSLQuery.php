<?php
namespace CFX\Brokerage;

class ContractsDSLQuery extends \CFX\Persistence\GenericDSLQuery
{
    protected $gettingLatest = false;

    protected static function getAcceptableFields() {
        return array_merge(parent::getAcceptableFields(), [ "contractType", "audience", "effectiveDate" ]);
    }

    protected static function getComparisonOperators() {
        return array_merge(parent::getComparisonOperators(), [ "&", "|" ]);
    }

    public function includes($name)
    {
        return
            array_key_exists($name, $this->expressions) &&
            in_array($this->expressions[$name]['operator'], [ '=', "&", "in", "like", ">", ">=", "<", "<=" ], true);
    }

    public function requestingCollection()
    {
        return parent::requestingCollection() && !($this->gettingLatest && $this->includes("contractType"));
    }






    public function setContractType($operator, $val) {
        $acceptableOperators = [ "=", "!=", "like", "not like", "in", "not in" ];
        if (!in_array($operator, $acceptableOperators)) {
            throw new \CFX\Persistence\BadQueryException("You cannot use the '$operator' operator with field 'contractType'. This field only accepts operators '".implode("', '", $acceptableOperators)."'");
        }

        $this->setExpressionValue('contractType', [
            'field' => 'contractType',
            'operator' => $operator,
            'value' => $val
        ]);
        return $this;
    }

    public function unsetContractType() {
        $this->setExpressionValue('contractType', null);
        return $this;
    }

    public function getContractType() {
        return $this->getExpressionValue('contractType');
    }






    public function setAudience($operator, $val) {
        $acceptableOperators = [ "=", "!=", "&", "|", "<", ">", "<=", ">=" ];
        if (!in_array($operator, $acceptableOperators)) {
            throw new \CFX\Persistence\BadQueryException("You cannot use the '$operator' operator with field 'contractType'. This field only accepts operators '".implode("', '", $acceptableOperators)."'");
        }

        $this->setExpressionValue('audience', [
            'field' => 'audience',
            'operator' => $operator,
            'value' => $val
        ]);
        return $this;
    }

    public function unsetAudience() {
        $this->setExpressionValue('audience', null);
        return $this;
    }

    public function getAudience() {
        return $this->getExpressionValue('audience');
    }







    public function setEffectiveDate($operator, $val) {
        $acceptableOperators = [ "=", "!=", "<", ">", "<=", ">=", "in", "not in", "between" ];
        if (!in_array($operator, $acceptableOperators)) {
            throw new \CFX\Persistence\BadQueryException("You cannot use the '$operator' operator with field 'contractType'. This field only accepts operators '".implode("', '", $acceptableOperators)."'");
        }

        if ($val === "latest" && $operator !== "=") {
            throw new \CFX\Persistence\BadInputException("When specifying 'latest' as effectiveDate, you MUST use the '=' operator. (You passed '$operator'.)");
        }

        if ($val === "latest") {
            $this->gettingLatest = true;
        } else {
            $this->gettingLatest = false;
            $this->setExpressionValue('effectiveDate', [
                'field' => 'effectiveDate',
                'operator' => $operator,
                'value' => $val
            ]);
        }

        return $this;
    }

    public function unsetEffectiveDate() {
        $this->setExpressionValue('effectiveDate', null);
        return $this;
    }

    public function getEffectiveDate() {
        return $this->getExpressionValue('effectiveDate');
    }
}


