<?php
namespace CFX\Brokerage;

class CryptoWallet extends \CFX\JsonApi\AbstractResource implements CryptoWalletInterface {
    use \CFX\ResourceValidationsTrait;

    protected $isNew = null;
    protected $resourceType = 'crypto-wallets';
    protected $attributes = [
        "protocol" => "p2p",
        "network" => "ethereum",
        "priority" => 10,
        "status" => "reviewing",
    ];
    protected $relationships = [
        "legalEntity" => null,
    ];

    public function __construct(\CFX\JsonApi\DatasourceInterface $datasource, $data=null)
    {
        // Preset ID can cause problems on post, so we're doing a little juggling here.
        if ($data && isset($data["id"])) {
            $this->isNew = true;
        }

        parent::__construct($datasource, $data);

        // Trigger validation
        if ($this->getId() === null) {
            $this->setId(null);
        }
    }

    public function isNew()
    {
        return $this->isNew;
    }




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

    public function getLegalEntity()
    {
        return $this->_getRelationshipValue("legalEntity");
    }



    public function setId($id) {
        if ($this->id !== null && $id != $this->id && !$this->initializing) {
            throw new \CFX\JsonApi\DuplicateIdException("This resource already has an id (`$this->id`). You cannot set a new ID for it (`$id`).");
        }
        $id = $this->cleanStringValue($id);
        if ($id === null) {
            $this->setError("id", "required", $this->getFactory()->newError([
                "status" => 400,
                "title" => "`id` is required",
                "detail" => "`id` must be the Ethereum public key hash."
            ]));
        } else {
            $this->clearError("id", "required");
        }
        $this->id = $id;
        return $this;
    }

    public function setProtocol($val)
    {
        $field = "protocol";
        $val = $this->cleanStringValue($val);
        if ($this->validateImmutable($field, $val)) {
            if ($val) {
                $this->validateAmong($field, $val, static::getValidProtocols());
            }
        }
        return $this->_setAttribute($field, $val);
    }

    public function setNetwork($val)
    {
        $field = "network";
        $val = $this->cleanStringValue($val);
        if ($this->validateImmutable($field, $val)) {
            if ($val) {
                $this->validateAmong($field, $val, static::getValidNetworks());
            }
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

    public function setLegalEntity(?\CFX\Brokerage\LegalEntityInterface $val)
    {
        $field = "legalEntity";
        $this->validateImmutable($field, $val);
        return $this->_setRelationship($field, $val);
    }








    /**
     * Overriding initialize function so we can better juggle whether an object is new or not
     */
    public function initialize() {
        if (!$this->initialized && !$this->initializing && $this->getId() && !$this->isNew()) {
            try {
                $this->datasource->initializeResource($this);
                $this->setInitialState();
            } catch (\CFX\Persistence\ResourceNotFoundException $e) {
                throw new \CFX\CorruptDataException(
                    "Programmer: Your system has corrupt data. You've attempted to initialize a resource of ".
                    "type `{$this->getResourceType()}` with id `{$this->getId()}`, but that resources doesn't exist ".
                    "in the specified database."
                );
            }
        }
        return $this;
    }
}

