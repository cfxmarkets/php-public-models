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

    public function setStatus($operator, $val) {
        // If it's not "=" or "!=", then we have to do some processing
        if ($operator !== "=" && $operator !== "!=") {
            // If it's an order operator, we have to do lots of processing
            if (preg_match("/[<>]/", $operator)) {
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

    protected static function getAcceptableFields() {
        return array_merge(parent::getAcceptableFields(), [ 'userId', "status" ]);
    }

    protected static function getComparisonOperators() {
        return ['=', '!=', 'like', '>', '<', '>=', '<=', 'in'];
    }
}

