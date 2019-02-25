<?php
namespace CFX\Brokerage;

class OrderIntentsDSLQuery extends \CFX\Persistence\GenericDSLQuery {
    protected static function getAcceptableFields() {
        return array_merge(parent::getAcceptableFields(), [ 'userId', "status", "assetOwnerId" ]);
    }

    protected static function getComparisonOperators() {
        return array_merge(parent::getComparisonOperators(), [ "in" ]);
    }

    protected static function getFieldValueSpecification()
    {   
        return "(\(?['\"]?.+?['\"]?(?:, ?)?\)?)";
    }

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

    public function setAssetOwnerId($operator, $val)
    {
        $this->setExpressionValue("assetOwnerId", [
            "field" => "assetOwner",
            "operator" => $operator,
            "value" => $val,
        ]);
        return $this;
    }

    public function unsetAssetOwnerId()
    {
        $this->setExpressionValue("assetOwnerId", null);
    }

    public function getAssetOwnerId()
    {
        return $this->getExpressionValue("assetOwnerId");
    }

    public function setStatus($operator, $val) {
        $statuses = [
            'new',
            'picked-up',
            'reviewing',
            'hold',
            'pending',
            'listed',
            'sold',
            'sold_closed',
            'sold_closed_paid',
            'expired',
            'cancelled',
            'expected',
            'sent',
        ];

        // If it's not "=" or "!=", then we have to do some processing
        if ($operator !== "=" && $operator !== "!=") {

            // If it's an order operator, we have to do lots of processing
            if (preg_match("/[<>]/", $operator)) {

                if (!array_search($val, $statuses, true)) {
                    throw new \CFX\Persistence\BadQueryException("You've submitted a status (`$val`) that isn't among the known statuses (`".implode("`, `", $statuses)."`).");
                }

                $values = [];
                $capture = strpos($operator, "<") !== false;
                foreach($statuses as $s) {
                    if ($s === $val) {
                        if (strpos($operator, "=") !== false) {
                            $values[] = $s;
                        }
                        $capture = !$capture;
                    } elseif ($capture) {
                        $values[] = $s;
                    }
                }

                $val = $values;
                $operator = "in";

            // If it's 'in' or 'not in', just parse out the value (if it hasn't already been done)
            } elseif (($operator === "in" || $operator === "not in") && !is_array($val)) {
                $val = array_map(
                    function($v) { return trim($v, "'\""); },
                    preg_split(
                        "/, ?/",
                        trim($val, " ()")
                    )
                );
            }
        }

        $this->setExpressionValue('status', [
            'field' => 'lead_status',
            'operator' => $operator,
            'value' => $val,
        ]);
        return $this;
    }

    public function unsetStatus() {
        $this->setExpressionValue('status', null);
    }

    public function getStatus() {
        return $this->getExpressionValue('status');
    }
}

