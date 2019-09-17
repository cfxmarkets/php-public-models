<?php
namespace CFX\Brokerage;

class CryptoWallet extends \CFX\JsonApi\AbstractResource implements CryptoWalletInterface {
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'crypto-wallets';
    protected $attributes = [
        "protocol" => "p2p",
        "network" => "ethereum",
        "priority" => null,
        "status" => "reviewing",
    ];
    protected $relationships = [
        "ownerEntity" => null,
    ];




    public static function getValidProtocols()
    {
        return [ "p2p" ];
    }

    public static function getValidNetworks()
    {
        return [ "ethereum" ];
    }

    public static function getValidStatuses()
    {
        return [ "reviewing", "confirmed", "rejected" ];
    }





    public function getProtocol()
    {
        return $this->_getAttributeValue("protocol");
    }

    public function getNetwork()
    {
        return $this->_getAttributeValue("network");
    }

    public function getPriority()
    {
        return $this->_getAttributeValue('priority');
    }

    public function getStatus()
    {
        return $this->_getAttributeValue('status');
    }

    public function getOwnerEntity()
    {
        return $this->_getRelationshipValue("ownerEntity");
    }




    public function setProtocol($val)
    {
        $field = "protocol";
        $val = $this->cleanStringValue($val);
        if ($val) {
            $this->validateAmong($field, $val, static::getValidProtocols());
        }
        return $this->_setAttribute($field, $val);
    }

    public function setNetwork($val)
    {
        $field = "network";
        $val = $this->cleanStringValue($val);
        if ($val) {
            $this->validateAmong($field, $val, static::getValidNetworks());
        }
        return $this->_setAttribute($field, $val);
    }

    public function setPriority($val)
    {
        $field = "priority";
        $val = $this->cleanNumberValue($val);
        if ($val !== null) {
            $this->validateType($field, $val, "integer", false);
        }
        return $this->_setAttribute($field, $val);
    }

    public function setStatus($val) {
        $field = "status";
        if ($this->validateReadOnly($field, $val)) {
            $this->_setAttribute($field, $val);
        }
        return $this;
    }

    public function setOwnerEntity(?\CFX\Brokerage\LegalEntityInterface $val)
    {
        $field = "ownerEntity";
        if ($this->validateReadOnly($field, $val)) {
            $this->_setRelationship($field, $val);
        }
        return $this;
    }
}

