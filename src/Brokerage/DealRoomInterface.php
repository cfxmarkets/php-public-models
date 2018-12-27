<?php
namespace CFX\Brokerage;

interface DealRoomInterface extends \CFX\JsonApi\ResourceInterface
{
    /**
     * Get the deal room title
     *
     * @return string
     */
     public function getTitle();

    /**
     * Get the deal room slug
     *
     * @return string
     */
     public function getSlug();

    /**
     * Get the deal room summary
     *
     * @return string
     */
     public function getSummary();

    /**
     * Get the deal room body text
     *
     * @return string
     */
     public function getBodyText();

    /**
     * Get the deal room restriction (whether this is an open room, a buy-only room, or a sell-only room)
     *
     * @return string
     */
     public function getRestriction();

    /**
     * Get the deal room open date
     *
     * @return DateTime
     */
     public function getOpenDate();

    /**
     * Get the deal room close date
     *
     * @return DateTime
     */
     public function getCloseDate();

    /**
     * Get the deal room access level (public or private)
     *
     * @return string
     */
     public function getAccess();

    /**
     * Get the deal room Access Key
     *
     * @return string
     */
     public function getAccessKey();

    /**
     * Get the deal room Admins collection
     *
     * @return \CFX\JsonApi\ResourceCollectionInterface<UserInterface>
     */
     public function getAdmins();

    /**
     * Get the deal room partners collection
     *
     * @return \CFX\JsonApi\ResourceCollectionInterface<PartnerInterface>
     */
     public function getPartners();

    /**
     * Get the deal room participants collection
     *
     * @return \CFX\JsonApi\ResourceCollectionInterface<UserInterface>
     */
     public function getParticipants();

    /**
     * Get the deal room orders collection
     *
     * @return \CFX\JsonApi\ResourceCollectionInterface<OrderIntentInterface>
     */
     public function getOrders();

    /**
     * Get the exchange this deal room uses (not yet implemented)
     *
     * @return null
     */
     public function getExchange();







    /**
     * Set the deal room title
     *
     * @param string $val
     * @return static
     */
     public function setTitle($val);

    /**
     * Set the deal room slug
     *
     * @param string $val
     * @return static
     */
     public function setSlug($val);

    /**
     * Set the deal room summary
     *
     * @param string $val
     * @return static
     */
     public function setSummary($val);

    /**
     * Set the deal room body text
     *
     * @param string $val
     * @return static
     */
     public function setBodyText($val);

    /**
     * Set the deal room restriction (whether this is an open room, a buy-only room, or a sell-only room)
     *
     * @param string $val
     * @return static
     */
     public function setRestriction($val);

    /**
     * Set the deal room open date
     *
     * @param DateTime $val
     * @return static
     */
     public function setOpenDate($val);

    /**
     * Set the deal room close date
     *
     * @param DateTime $val
     * @return static
     */
     public function setCloseDate($val);

    /**
     * Set the deal room access level (public or private)
     *
     * @param string $val
     * @return static
     */
     public function setAccess($val);

    /**
     * Set the deal room Access Key
     *
     * @param string $val
     * @return static
     */
     public function setAccessKey($val);

    /**
     * Set the deal room Admins collection
     *
     * @param \CFX\JsonApi\ResourceCollectionInterface<UserInterface> $val
     * @return static
     */
     public function setAdmins(\CFX\JsonApi\ResourceCollectionInterface $val = null);

    /**
     * Set the deal room partners collection
     *
     * @param \CFX\JsonApi\ResourceCollectionInterface<PartnerInterface> $val
     * @return static
     */
     public function setPartners(\CFX\JsonApi\ResourceCollectionInterface $val = null);

    /**
     * Set the deal room participants collection
     *
     * @param \CFX\JsonApi\ResourceCollectionInterface<UserInterface> $val
     * @return static
     */
     public function setParticipants(\CFX\JsonApi\ResourceCollectionInterface $val = null);

    /**
     * Set the deal room orders collection
     *
     * @param \CFX\JsonApi\ResourceCollectionInterface<OrderIntentInterface> $val
     * @return static
     */
     public function setOrders(\CFX\JsonApi\ResourceCollectionInterface $val = null);

    /**
     * Set the exchange this deal room uses (not yet implemented)
     *
     * @param null $val
     * @return static
     */
     public function setExchange($val);
}

