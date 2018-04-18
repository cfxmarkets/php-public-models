<?php
namespace CFX\Brokerage;

class LegalEntity extends \CFX\JsonApi\AbstractResource implements LegalEntityInterface
{
    use \CFX\ResourceValidationsTrait;
    use \CFX\JsonApi\Rel2MTrait;

    protected $resourceType = 'legal-entities';

    protected $attributes = [
        'type' => null,
        'legalId' => null,
        'legalName' => null,
        'finraStatus' => null,
        'finraStatusText' => null,
        'dateOfBirth' => null,
        'placeOfOrigin' => null,
        'corporateStatus' => null,
        'corporateStatusText' => null,
        'custodianName' => null,
        'custodianAccountNum' => null,
    ];

    protected $relationships = [
        'primaryAddress' => null,
        'idDocs' => null,
    ];


    public static function getValidTypes() {
        return [
            "person",
            "company",
            "company:ira",
            "company:trust",
        ];
    }

    public function getType()
    {
        return $this->_getAttributeValue('type');
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

    public function getDateOfBirth()
    {
        return $this->_getAttributeValue('dateOfBirth');
    }

    public function getCitizenship()
    {
        return $this->_getAttributeValue('citizenship');
    }

    public function getPlaceOfOrigin()
    {
        return $this->_getAttributeValue('placeOfOrigin');
    }

    public function getCorporateStatus()
    {
        return $this->_getAttributeValue('corporateStatus');
    }

    public function getCorporateStatusText()
    {
        return $this->_getAttributeValue('corporateStatusText');
    }

    public function getCustodianName()
    {
        return $this->_getAttributeValue('custodianName');
    }

    public function getCustodianAccountNum()
    {
        return $this->_getAttributeValue('custodianAccountNum');
    }

    public function getPrimaryAddress()
    {
        return $this->_getRelationshipValue('primaryAddress');
    }

    public function getIdDocs()
    {
        return $this->get2MRel('idDocs');
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

    public function setLegalId($val)
    {
        if ($val !== null) {
            if (!is_string($val) && !is_int($val)) {
                $this->setError("legalId", "valid", [
                    "title" => "Invalid Value for Field `legalId`",
                    "detail" => "`legalId` must be either a string or an integer or null"
                ]);
            } else {
                $this->clearError("legalId", "valid");
                if (is_string($val)) {
                    $val = trim($val);
                    if ($val === '') {
                        $val = null;
                    }
                }
            }
        } else {
            $this->clearError("legalId", "valid");
        }

        return $this->_setAttribute('legalId', $val);
    }

    public function setLegalName($val)
    {
        if ($val !== null) {
            if (!is_string($val) && !is_int($val)) {
                $this->setError("legalName", "valid", [
                    "title" => "Invalid Value for Field `legalName`",
                    "detail" => "`legalName` must be either a string or an integer or null"
                ]);
            } else {
                $this->clearError("legalName", "valid");
                if (is_string($val)) {
                    $val = trim($val);
                    if ($val === '') {
                        $val = null;
                    }
                }
            }
        } else {
            $this->clearError("legalName", "valid");
        }

        return $this->_setAttribute('legalName', $val);
    }

    public function setFinraStatus($val)
    {
        if ($val == 1 || $val === '0' || $val === 0) {
            $val = (bool)$val;
        }

        if ($val !== null && !is_bool($val)) {
            $this->setError('finraStatus', 'valid', [
                "title" => "Invalid Value for Field `finraStatus`",
                "detail" => "You must pass a boolean or boolean equivalent as value for field `finraStatus`",
            ]);
        } else {
            $this->clearError('finraStatus', 'valid');
        }

        return $this->_setAttribute('finraStatus', $val);
    }

    public function setFinraStatusText($val)
    {
        if ($val !== null) {
            if (!is_string($val)) {
                $this->setError("finraStatusText", "valid", [
                    "title" => "Invalid Value for Field `finraStatusText`",
                    "detail" => "`finraStatusText` must be either a string or null"
                ]);
            } else {
                $this->clearError("finraStatusText", "valid");
                $val = trim($val);
                if ($val === '') {
                    $val = null;
                }
            }
        } else {
            $this->clearError("finraStatusText", "valid");
        }

        return $this->_setAttribute('finraStatusText', $val);
    }

    public function setDateOfBirth($val)
    {
        $val = $this->cleanDateTimeValue($val);
        $this->validateType('dateOfBirth', $val, 'datetime', false);
        return $this->_setAttribute('dateOfBirth', $val);
    }

    public function setPlaceOfOrigin($val)
    {
        if ($val !== null) {
            if (!is_string($val)) {
                $this->setError("placeOfOrigin", "valid", [
                    "title" => "Invalid Value for Field `placeOfOrigin`",
                    "detail" => "`placeOfOrigin` must be either a string or null"
                ]);
            } else {
                $this->clearError("placeOfOrigin", "valid");
                $val = trim($val);
                if ($val === '') {
                    $val = null;
                }
            }
        } else {
            $this->clearError("placeOfOrigin", "valid");
        }

        return $this->_setAttribute('placeOfOrigin', $val);
    }

    public function setCorporateStatus($val)
    {
        if ($val == 1 || $val === '0' || $val === 0) {
            $val = (bool)$val;
        }

        if ($val !== null && !is_bool($val)) {
            $this->setError('corporateStatus', 'valid', [
                "title" => "Invalid Value for Field `corporateStatus`",
                "detail" => "You must pass a boolean or boolean equivalent as value for field `corporateStatus`",
            ]);
        } else {
            $this->clearError('corporateStatus', 'valid');
        }

        return $this->_setAttribute('corporateStatus', $val);
    }

    public function setCorporateStatusText($val)
    {
        if ($val && is_string($val)) {
            $val = trim($val);
            if ($val === '') {
                $val = null;
            }
        }

        if ($val !== null && !is_string($val)) {
            $this->setError("corporateStatusText", "valid", [
                "title" => "Invalid Value for Field `corporateStatusText`",
                "detail" => "This field must be a string",
            ]);
        } else {
            $this->clearError("corporateStatusText", "valid");
        }

        return $this->_setAttribute('corporateStatusText', $val);
    }

    public function setCustodianName($val)
    {
        if ($val && is_string($val)) {
            $val = trim($val);
            if ($val === '') {
                $val = null;
            }
        }

        if ($val !== null && !is_string($val)) {
            $this->setError("custodianName", "valid", [
                "title" => "Invalid Value for Field `custodianName`",
                "detail" => "This field must be a string (or null)",
            ]);
        } else {
            $this->clearError("custodianName", "valid");
        }

        return $this->_setAttribute("custodianName", $val);
    }

    public function setCustodianAccountNum($val)
    {
        if ($val !== null) {
            if (!is_string($val) && !is_int($val)) {
                $this->setError("custodianAccountNum", "valid", [
                    "title" => "Invalid Value for Field `custodianAccountNum`",
                    "detail" => "`custodianAccountNum` must be either a string or an integer or null"
                ]);
            } else {
                $this->clearError("custodianAccountNum", "valid");
                if (is_string($val)) {
                    $val = trim($val);
                    if ($val === '') {
                        $val = null;
                    }
                }
            }
        } else {
            $this->clearError("custodianAccountNum", "valid");
        }

        return $this->_setAttribute("custodianAccountNum", $val);
    }

    public function setPrimaryAddress(AddressInterface $val = null)
    {
        return $this->_setRelationship('primaryAddress', $val);
    }

    public function setIdDocs(\CFX\JsonApi\ResourceCollectionInterface $val = null)
    {
        return $this->_setRelationship('idDocs', $val);
    }

    public function addIdDoc(DocumentInterface $val)
    {
        return $this->add2MRel('idDocs', $val);
    }

    public function hasIdDoc(DocumentInterface $val)
    {
        return $this->has2MRel('idDocs', $val);
    }

    public function removeIdDoc(DocumentInterface $val)
    {
        return $this->remove2MRel('idDocs', $val);
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
            'sign',
        ];
    }

    protected function serializeAttribute($name)
    {
        if ($name === 'dateOfBirth') {
            $val = $this->getDateOfBirth();
            if ($val instanceof \DateTime) {
                return $val->format("Y-m-d");
            } else {
                return $val;
            }
        }

        return parent::serializeAttribute($name);
    }
}

