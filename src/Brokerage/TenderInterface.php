<?php
namespace CFX\Brokerage;

interface TenderInterface extends \CFX\JsonApi\ResourceInterface
{
    /**
     * Get the Tender's share price
     *
     * @return float|null
     */
    public function getSharePrice();

    /**
     * Get the Tender's share limit (the maximum shares desired)
     *
     * @return float|null
     */
    public function getShareLimit();

    /**
     * Get the Tender's spend limit (the maximum amount of money the tenderer wishes to spend)
     *
     * @return float|null
     */
    public function getSpendLimit();

    /**
     * Get the share threshold that must be met before the tender goes forward
     *
     * @return int|null
     */
    public function getMinSharesThreshold();

    /**
     * Get the Tender's opening date
     *
     * @return \DateTime|null
     */
    public function getOpenDate();

    /**
     * Get the Tender's closing date
     *
     * @return \DateTime|null
     */
    public function getCloseDate();

    /**
     * Get the Tender purchaser's name
     *
     * @return string|null
     */
    public function getPurchaserName();

    /**
     * Get the Tender's status
     *
     * @return string|null
     */
    public function getStatus();

    /**
     * Get the asset being tendered
     *
     * @return \CFX\Exchange\AssetInterface|null
     */
    public function getAsset();

    /**
     * Get the purchaser of the tender
     *
     * @return LegalEntityInterface|null
     */
    public function getPurchaser();

    /**
     * Get the Tender's legal announcement document
     *
     * @return DocumentInterface|null
     */
    public function getAnnouncementDoc();

    /**
     * Get the Tender's agreement templates
     *
     * @return DocumentTemplateInterface|null
     */
    public function getAgreementTemplates();

    /**
     * Get the Tender's deal room 
     *
     * @return TenderRoomInterface|null
     */
    public function getTenderRoom();







    /**
     * Set the Tender's share price
     *
     * @param float|null $val
     * @return static
     */
    public function setSharePrice($val);

    /**
     * Set the Tender's share limit (the maximum shares desired)
     *
     * @param float|null $val
     * @return static
     */
    public function setShareLimit($val);

    /**
     * Set the Tender's spend limit (the maximum amount of money the tenderer wishes to spend)
     *
     * @param float|null $val
     * @return static
     */
    public function setSpendLimit($val);

    /**
     * Set the share threshold that must be met before the tender goes forward
     *
     * @param int|null $val
     * @return static
     */
    public function setMinSharesThreshold($val);

    /**
     * Set the Tender's opening date
     *
     * @param \DateTime|null $val
     * @return static
     */
    public function setOpenDate($val);

    /**
     * Set the Tender's closing date
     *
     * @param \DateTime|null $val
     * @return static
     */
    public function setCloseDate($val);

    /**
     * Set the Tender Purchaser's name
     *
     * @param string $val
     * @return static
     */
    public function setPurchaserName($val);

    /**
     * Set the Tender's status
     *
     * @param string|null $val
     * @return static
     */
    public function setStatus($val);

    /**
     * Set the asset being tendered
     *
     * @param \CFX\Exchange\AssetInterface|null $val
     * @return static
     */
    public function setAsset(\CFX\Exchange\AssetInterface $val = null);

    /**
     * Set the purchaser of the tender
     *
     * @param LegalEntityInterface|null $val
     * @return static
     */
    public function setPurchaser(LegalEntityInterface $val = null);

    /**
     * Set the Tender's legal announcement document
     *
     * @param DocumentInterface|null $val
     * @return static
     */
    public function setAnnouncementDoc(DocumentInterface $val = null);

    /**
     * Set the Tender's agreement templates
     *
     * @param DocumentTemplateInterface|null $val
     * @return static
     */
    public function setAgreementTemplates(DocumentTemplateInterface $val = null);

    /**
     * Add a document template for this tender
     *
     * @param DocumentTemplateInterface $val
     * @return static
     */
    public function addAgreementTemplate(DocumentTemplateInterface $val);

    /**
     * Remove a document template from this tender
     *
     * @param DocumentTemplateInterface $val
     * @return static
     */
    public function removeAgreementTemplate(DocumentTemplateInterface $val);

    /**
     * Check to see if this tender has the given document template
     *
     * @param DocumentTemplateInterface $val
     * @return bool
     */
    public function hasAgreementTemplate(DocumentTemplateInterface $val);

    /**
     * Set the Tender's deal room 
     *
     * @param TenderRoomInterface|null $val
     * @return static
     */
    public function setTenderRoom(TenderRoomInterface $val = null);
}

