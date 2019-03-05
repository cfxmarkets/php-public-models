<?php
namespace CFX\Brokerage;

class BetaOptIn extends \CFX\JsonApi\AbstractResource implements BetaOptInInterface
{
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = "beta-opt-ins";

    protected $attributes = [
        "optIn" => null,
        "updatedOn" => null,
    ];

    protected $relationships = [
        "user" => null,
        "release" => null,
    ];

    public function getOptIn()
    {
        return $this->_getAttributeValue("optIn");
    }

    public function getUpdatedOn()
    {
        return $this->_getAttributeValue("updatedOn");
    }

    public function getUser()
    {
        return $this->_getRelationshipValue("user");
    }

    public function getRelease()
    {
        return $this->_getRelationshipValue("release");
    }






    public function setOptIn($val)
    {
        $field = "optIn";
        $val = $this->cleanBooleanValue($val);
        $this->validateType($field, $val, "boolean", false);
        return $this->_setAttribute($field, $val);
    }

    protected function setUpdatedOn($val)
    {
        $field = "updatedOn";
        $val = $this->cleanDateTimeValue($val);
        return $this->_setAttribute($field, $val);
    }

    public function setUser(?UserInterface $val)
    {
        $field = "user";
        $this->validateRequired($field, $val);
        return $this->_setRelationship($field, $val);
    }

    public function setRelease(?ReleaseInterface $val)
    {
        $field = "release";
        $this->validateRequired($field, $val);
        return $this->_setRelationship($field, $val);
    }






    public function serializeAttribute($name)
    {
        if ($name === "updatedOn") {
            $get = "get".ucfirst($name);
            $val = $this->$get();
            if ($val instanceof \DateTimeInterface) {
                $val = $val->format("Y-m-d H:i:s");
            }
            return (string)$val;
        }
        return parent::serializeAttribute($name);
    }
}

