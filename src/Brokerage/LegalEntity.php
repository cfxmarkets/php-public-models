<?php
namespace CFX\Brokerage;

class LegalEntity extends \CFX\JsonApi\AbstractResource implements LegalEntityInterface
{
    use \CFX\JsonApi\Rel2MTrait;

    protected $resourceType = 'legal-entities';

    protected $attributes = [
        'type' => null,
        'label' => null,
        'legalId' => null,
        'legalName' => null,
        'finraStatus' => null,
        'finraStatusText' => null,
    ];

    protected $relationships = [
        'primaryAddress' => null,
        'idDocuments' => null,
    ];


    public static function getValidTypes() {
        return [
            "person",
            "company",
        ];
    }

    public function getType()
    {
        return $this->_getAttributeValue('type');
    }

    public function getLabel()
    {
        return $this->_getAttributeValue('label');
    }

    public function getLegalId()
    {
        return $this->_getAttributeValue('legalId');
    }

    public function getLegalName()
    {
        return $this->_getAttributeValue('legalName');
    }

    public function getFinraStatus()
    {
        return $this->_getAttributeValue('finraStatus');
    }

    public function getFinraStatusText()
    {
        return $this->_getAttributeValue('finraStatusText');
    }

    public function getPrimaryAddress()
    {
        return $this->_getRelationshipValue('primaryAddress');
    }

    public function getIdDocuments()
    {
        return $this->_getRelationshipValue('idDocuments');
    }



    public function setType($val)
    {
        if ($val) {
            $val = strtolower(trim($val));
        }
        $this->validateRequired('type', $val);
        $this->_setAttribute('type', $val);

        if (!in_array($val, $this::getValidTypes())) {
            $this->setError('type', 'valid', [
                "title" => "Invalid Value for Field `type`",
                "detail" => "`$val` is not a valid type for this object. Valid types are `".implode("`, `", $this::getValidTypes())."`.",
            ]);
        } else {
            $this->clearError('type', 'valid');
        }

        return $this;
    }

    public function setLabel($val)
    {
        if ($val) {
            $val = trim($val);
            if ($val === '') {
                $val = null;
            }
        }
        $this->validateRequired('label', $val);
        return $this->_setAttribute('label', $val);
    }

    public function setLegalId($val)
    {
        if ($val) {
            $val = trim($val);
            if ($val === '') {
                $val = null;
            }
        }
        return $this->_setAttribute('legalId', $val);
    }

    public function setLegalName($val)
    {
        if ($val) {
            $val = trim($val);
            if ($val === '') {
                $val = null;
            }
        }
        return $this->_setAttribute('legalName', $val);
    }

    public function setFinraStatus($val)
    {
        if ($val == 1 || $val === '0' || $val === 0) {
            $val = (bool)$val;
        }

        $this->_setAttribute('finraStatus', $val);

        if ($val !== null && !is_bool($val)) {
            $this->setError('finraStatus', 'valid', [
                "title" => "Invalid Value for Field `finraStatus`",
                "detail" => "You must pass a boolean or boolean equivalent as value for field `finraStatus`",
            ]);
        } else {
            $this->clearError('finraStatus', 'valid');
        }
    }

    public function setFinraStatusText($val)
    {
        if ($val) {
            $val = trim($val);
            if ($val === '') {
                $val = null;
            }
        }
        return $this->_setAttribute('finraStatusText', $val);
    }

    public function setPrimaryAddress(AddressInterface $val = null)
    {
        return $this->_setRelationship('primaryAddress', $val);
    }

    public function setIdDocuments(\CFX\JsonApi\ResourceCollectionInterface $val = null)
    {
        return $this->_setRelationship('idDocuments', $val);
    }

    public function addIdDocument(DocumentInterface $val)
    {
        return $this->add2MRel('idDocuments', $val);
    }

    public function hasIdDocument(DocumentInterface $val)
    {
        return $this->has2MRel('idDocuments', $val);
    }

    public function removeIdDocument(DocumentInterface $val)
    {
        return $this->remove2MRel('idDocuments', $val);
    }




    public function getPermissionsCode(array $requestedPerms)
    {
        $perms = $this->getPermissions();
        $code = 0;
        foreach($requestedPerms as $p) {
            $key = array_search($p, $perms);
            if ($key === false) {
                throw new \RuntimeException(
                    "Programmer: Permission `$p` is not defined. If you'd like to add permissions to the model, you ".
                    "should extend the LegalEntity class and override the `getPermissions` method, making sure to merge ".
                    "permissions defined in the parent method with your new permissions."
                );
            }

            $code += pow(2, $key);
        }

        return $code;
    }

    protected function getPermissions()
    {
        return [
            'view',
            'edit',
            'delete',
        ];
    }
}

