<?php
namespace CFX\Brokerage;

class ReleasesDSLQuery extends \CFX\Persistence\GenericDSLQuery
{
    protected static function getAcceptableFields() {
        return array_merge(parent::getAcceptableFields(), [ "betaStartDate", "releaseDate" ]);
    }




    public function setBetaStartDate($operator, $val) {
        $this->setExpressionValue("betaStartDate", [
            "field" => "betaStartDate",
            "operator" => $operator,
            "value" => $val
        ]);
        return $this;
    }

    public function unsetBetaStartDate() {
        $this->setExpressionValue("betaStartDate", null);
        return $this;
    }

    public function getBetaStartDate() {
        return $this->getExpressionValue("betaStartDate");
    }





    public function setReleaseDate($operator, $val) {
        $this->setExpressionValue("releaseDate", [
            "field" => "releaseDate",
            "operator" => $operator,
            "value" => $val
        ]);
        return $this;
    }

    public function unsetReleaseDate() {
        $this->setExpressionValue("releaseDate", null);
        return $this;
    }

    public function getReleaseDate() {
        return $this->getExpressionValue("releaseDate");
    }
}

