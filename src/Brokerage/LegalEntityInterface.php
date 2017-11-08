<?php
namespace CFX\Brokerage;

interface LegalEntityInterface extends \CFX\JsonApi\ResourceInterface {
    public static function getValidTypes();

    public function getType();
    public function getLegalId();
    public function getLegalName();
    public function getFinraStatus();
    public function getFinraStatusText();
    public function getDateOfBirth();
    public function getPlaceOfOrigin();
    public function getCorporateStatus();
    public function getCorporateStatusText();
    public function getCustodianName();
    public function getCustodianAccountNum();
    public function getPrimaryAddress();
    public function getIdDocuments();


    public function setType($val);
    public function setLegalId($val);
    public function setLegalName($val);
    public function setFinraStatus($val);
    public function setFinraStatusText($val);
    public function setDateOfBirth($val);
    public function setPlaceOfOrigin($val);
    public function setCorporateStatus($val);
    public function setCorporateStatusText($val);
    public function setCustodianName($val);
    public function setCustodianAccountNum($val);
    public function setPrimaryAddress(AddressInterface $val = null);
    public function setIdDocuments(\CFX\JsonApi\ResourceCollectionInterface $val = null);
    public function addIdDocument(DocumentInterface $val);
    public function hasIdDocument(DocumentInterface $val);
    public function removeIdDocument(DocumentInterface $val);

    /**
     * getPermissionsCode -- Gets an integer representing a bitmask of the requested permissions
     *
     * @param array $requestedPerms An array of the permissions requested (e.g., [ 'read', 'delete' ])
     * @return int An integer representing a bitmask of the requested permissions
     * @throws \RuntimeException
     */
    public function getPermissionsCode(array $requestedPerms);
}

