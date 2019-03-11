<?php
namespace CFX\Brokerage;

class ReleasesDSLQuery extends \CFX\Persistence\GenericDSLQuery
{
    protected static function getAcceptableFields() {
        return array_merge(parent::getAcceptableFields(), [ "betaStartDate", "releaseDate" ]);
    }




    public function setBetaStartDate($operator, $val) {
        if (is_numeric($val)) {
            $val = new \DateTime("@$val");
        } else {
            try {
                $val = new \DateTime($val);
            } catch (\Exception $e) {
                throw new \CFX\Persistence\BadQueryException("You must pass a date-time value that is compatible with PHP's DateTime constructor.");
            }
        }

        $this->setExpressionValue("betaStartDate", [
            "field" => "betaStartDate",
            "operator" => $operator,
            "value" => $val->format("Y-m-d H:i:s")
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
        if (is_numeric($val)) {
            $val = new \DateTime("@$val");
        } else {
            try {
                $val = new \DateTime($val);
            } catch (\Exception $e) {
                throw new \CFX\Persistence\BadQueryException("You must pass a date-time value that is compatible with PHP's DateTime constructor.");
            }
        }

        $this->setExpressionValue("releaseDate", [
            "field" => "releaseDate",
            "operator" => $operator,
            "value" => $val->format("Y-m-d H:i:s")
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

