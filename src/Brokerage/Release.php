<?php
namespace CFX\Brokerage;

class Release extends \CFX\JsonApi\AbstractResource implements ReleaseInterface
{
    use \CFX\ResourceValidationsTrait;
    protected $resourceType = "releases";

    protected $attributes = [
        "betaStartDate" => null,
        "releaseDate" => null,
        "currentUserOptIn" => null,
    ];

    public function getBetaStartDate()
    {
        return $this->_getAttributeValue("betaStartDate");
    }

    public function getReleaseDate()
    {
        return $this->_getAttributeValue("releaseDate");
    }

    public function getCurrentUserOptIn()
    {
        return $this->_getAttributeValue("currentUserOptIn");
    }




    public function setBetaStartDate($val)
    {
        $field = "betaStartDate";
        $val = $this->cleanDateTimeValue($val);
        if ($this->validateReadOnly($field, $val)) {
            $this->validateType($field, $val, "datetime");
            $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setReleaseDate($val)
    {
        $field = "releaseDate";
        $val = $this->cleanDateTimeValue($val);
        if ($this->validateReadOnly($field, $val)) {
            $this->validateType($field, $val, "datetime");
            $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setCurrentUserOptIn($val)
    {
        $field = "currentUserOptIn";
        if ($this->validateReadOnly($field, $val)) {
            $this->_setAttribute($field, $val);
        }
        return $this;
    }






    public function serializeAttribute($name)
    {
        if (strpos($name, "Date") !== false) {
            $get = "get".ucfirst($name);
            $val = $this->$get();
            if ($val instanceof \DateTimeInterface) {
                $val = $val->format("Y-m-d H:i:s");
            }
            return $val === null ? null : (string)$val;
        }
        return parent::serializeAttribute($name);
    }
}

