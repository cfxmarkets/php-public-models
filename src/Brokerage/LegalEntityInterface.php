<?php
namespace CFX\Brokerage;

interface LegalEntityInterface extends \CFX\JsonApi\ResourceInterface {
    public static function getValidTypes();

    /**
     * Bitmask
     *
     * 0 = Not enough data
     * 1 = Data sufficient, but not submitted
     * 2 = Submitted
     * 4 = Approved
     * 8 = Rejected
     */
    public function getAmlKycStatus();

    public function getType();
    public function getLegalId();
    public function getLegalName();
    public function getFinraStatus();
    public function getFinraStatusText();
    public function getNetWorth();
    public function getAnnualIncome();
    public function getAccreditationStatus();
    public function getDateOfBirth();
    public function getPlaceOfOrigin();
    public function getCorporateStatus();
    public function getCorporateStatusText();
    public function getCustodianName();
    public function getCustodianAccountNum();
    public function getInvestmentAccountUri();
    public function getPrimaryAddress();
    public function getIdDocs();
    public function getAccreditationDocs();
    public function getResidencyDocs();
    public function getWalletAccount();


    public function setType($val);
    public function setLegalId($val);
    public function setLegalName($val);
    public function setFinraStatus($val);
    public function setFinraStatusText($val);
    public function setNetWorth($val);
    public function setAnnualIncome($val);
    public function setAccreditationStatus($val);
    public function setDateOfBirth($val);
    public function setPlaceOfOrigin($val);
    public function setCorporateStatus($val);
    public function setCorporateStatusText($val);
    public function setCustodianName($val);
    public function setCustodianAccountNum($val);
    public function setInvestmentAccountUri($val);
    public function setPrimaryAddress(AddressInterface $val = null);
    public function setWalletAccount(WalletAccountInterface $val = null);
    public function setIdDocs(\CFX\JsonApi\ResourceCollectionInterface $val = null);
    public function addIdDoc(DocumentInterface $val);
    public function hasIdDoc(DocumentInterface $val);
    public function removeIdDoc(DocumentInterface $val);
    public function setAccreditationDocs(\CFX\JsonApi\ResourceCollectionInterface $val = null);
    public function addAccreditationDoc(DocumentInterface $val);
    public function hasAccreditationDoc(DocumentInterface $val);
    public function removeAccreditationDoc(DocumentInterface $val);
    public function setResidencyDocs(\CFX\JsonApi\ResourceCollectionInterface $val = null);
    public function addResidencyDoc(DocumentInterface $val);
    public function hasResidencyDoc(DocumentInterface $val);
    public function removeResidencyDoc(DocumentInterface $val);

    /**
     * getPermissionsCode -- Gets an integer representing a bitmask of the requested permissions
     *
     * @param array $requestedPerms An array of the permissions requested (e.g., [ 'read', 'delete' ])
     * @return int An integer representing a bitmask of the requested permissions
     * @throws \RuntimeException
     */
    public function getPermissionsCode(array $requestedPerms);
}

