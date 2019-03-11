<?php
namespace CFX\Brokerage;

class BetaOptInsDSLQuery extends \CFX\Persistence\GenericDSLQuery
{
    protected static function getAcceptableFields() {
        return array_merge(parent::getAcceptableFields(), [ "releaseId", "userId" ]);
    }




    public function setReleaseId($operator, $val) {
        $this->setExpressionValue("releaseId", [
            "field" => "releaseId",
            "operator" => $operator,
            "value" => $val
        ]);
        return $this;
    }

    public function unsetReleaseId() {
        $this->setExpressionValue("releaseId", null);
        return $this;
    }

    public function getReleaseId() {
        return $this->getExpressionValue("releaseId");
    }





    public function setUserId($operator, $val) {
        $this->setExpressionValue("userId", [
            "field" => "userId",
            "operator" => $operator,
            "value" => $val
        ]);
        return $this;
    }

    public function unsetUserId() {
        $this->setExpressionValue("userId", null);
        return $this;
    }

    public function getUserId() {
        return $this->getExpressionValue("userId");
    }




    public function requestingCollection()
    {
        return parent::requestingCollection() && (!$this->includes("userId") || !$this->includes("releaseId"));
    }
}

