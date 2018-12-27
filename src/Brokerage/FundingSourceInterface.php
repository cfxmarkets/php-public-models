<?php
namespace CFX\Brokerage;

interface FundingSourceInterface  extends \CFX\JsonApi\ResourceInterface
{
    /**
     * Get this source's status
     *
     * @return int
     */
    public function getStatus();

    /**
     * Get the available balance
     *
     * @return int | null
     */
     public function getAvailableBalance();

    /**
     * Get the pending balance
     *
     * @return int | null
     */
     public function getPendingBalance();

    /**
     * Get the legal entity that owns this funding source
     *
     * @return \CFX\Brokerage\LegalEntityInterface
     */
     public function getOwner();

    /**
     * Get the collection of funding interfaces for this funding source
     *
     * @return \CFX\JsonApi\ResourceCollectionInterface
     */
     public function getFundingInterfaces();




    /**
     * Set this source's status
     *
     * @param int
     * @return static
     */
    public function setStatus($val);

    /**
     * Set the legal entity that owns this funding source
     *
     * @param \CFX\Brokerage\LegalEntityInterface $val
     * @return static
     */
     public function setOwner(?LegalEntityInterface $val);

    /**
     * Add a funding interface
     *
     * @param \CFX\Brokerage\FundingInterfaceInterface $val
     * @return static
     */
    public function addFundingInterface(FundingInterfaceInterface $val);

    /**
     * Check to see if this funding source has the given funding interface
     *
     * @param \CFX\Brokerage\FundingInterfaceInterface $val
     * @return static
     */
    public function hasFundingInterface(FundingInterfaceInterface $val);

    /**
     * Add a funding interface
     *
     * @param \CFX\Brokerage\FundingInterfaceInterface $val
     * @return static
     */
    public function removeFundingInterface(FundingInterfaceInterface $val);
}

