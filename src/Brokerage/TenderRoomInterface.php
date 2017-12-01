<?php
namespace CFX\Brokerage;

interface TenderRoomInterface extends DealRoomInterface
{
    /**
     * Get the Purchaser LegalEntity that's sponsoring the tender room
     *
     * @return LegalEntityInterface
     */
    public function getPurchaser();

    /**
     * Get the room's list of tenders
     *
     * @return \CFX\JsonApi\ResourceCollection
     */
    public function getTenders();



    /**
     * Set the room's Purchaser
     *
     * @param LegalEntityInterface
     * @return static
     */
    public function setPurchaser(LegalEntityInterface $val = null);

    /**
     * Set the room's list of tenders
     *
     * @param \CFX\JsonApi\ResourceCollectionInterface
     * @return static
     */
    public function setTenders(\CFX\JsonApi\ResourceCollectionInterface $val = null);

    /**
     * Add a tender to the room
     *
     * @param TenderInterface
     * @return static
     */
    public function addTender(TenderInterface $val);

    /**
     * Check to see if the room already has this tender
     *
     * @param TenderInterface
     * @return bool
     */
    public function hasTender(TenderInterface $val);

    /**
     * Remove a tender from the room
     *
     * @param TenderInterface
     * @return static
     */
    public function removeTender(TenderInterface $val);
}

