<?php
namespace CFX\Brokerage;

class AclEntry extends \CFX\JsonApi\AbstractResource implements AclEntryInterface
{
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'acl-entries';
    protected $attributes = [
        "permissions" => null,
    ];
    protected $relationships = [
        "actor" => null,
        "target" => null,
    ];

    public function getPermissions()
    {
        return $this->_getAttributeValue('permissions');
    }

    public function getActor()
    {
        return $this->_getRelationshipValue('actor');
    }

    public function getTarget()
    {
        return $this->_getRelationshipValue('target');
    }




    public function setPermissions($bitmask)
    {
        $field = "permissions";
        $bitmask = $this->cleanNumberValue($bitmask);
        if ($this->validateReadOnly($field, $bitmask)) {
            if ($this->validateRequired($field, $bitmask)) {
                $this->validateType($field, $bitmask, "int");
            }
            $this->_setAttribute('permissions', $bitmask);
        }
        return $this;
    }

    public function addPermissions($bitmask)
    {
        if (!is_int($bitmask)) {
            throw new \InvalidArgumentException("`Permissions` must be an integer bitmask corresponding to 1 or more of the defined permissions for this acl.");
        }
        $this->getPermissions() | $bitmask;
        if ($this->validateReadOnly($field, $bitmask)) {
            $this->_setAttribute('permissions', $bitmask);
        }
        return $this;
    }

    public function removePermissions($bitmask)
    {
        if (!is_int($bitmask)) {
            throw new \InvalidArgumentException("`Permissions` must be an integer bitmask corresponding to 1 or more of the defined permissions for this acl.");
        }
        $bitmask = $this->getPermissions() & ~$bitmask;
        if ($this->validateReadOnly($field, $bitmask)) {
            $this->_setAttribute('permissions', $bitmask);
        }
        return $this;
    }

    public function hasPermissions($bitmask)
    {
        if (!is_int($bitmask)) {
            throw new \InvalidArgumentException("`Permissions` must be an integer bitmask corresponding to 1 or more of the defined permissions for this acl.");
        }
        return ($this->getPermissions() & $bitmask) === $bitmask;
    }

    public function setActor(?\CFX\JsonApi\ResourceInterface $r)
    {
        $field = "actor";
        if ($this->validateReadOnly($field, $r)) {
            $this->validateRequired($field, $r);
            $this->_setRelationship($field, $r);
        }
        return $this;
    }

    public function setTarget(?\CFX\JsonApi\ResourceInterface $r)
    {
        $field = "target";
        if ($this->validateReadOnly($field, $r)) {
            $this->validateRequired($field, $r);
            $this->_setRelationship($field, $r);
        }
        return $this;
    }
}

