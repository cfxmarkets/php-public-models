<?php
namespace CFX\Brokerage;

interface FundingSourceInterface  extends \CFX\JsonApi\ResourceInterface
{

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
     * Get the subnet routing number (ach)
     *
     * @return string | null
     */
    public function getSubnetRoutingNumberAch();

    /**
     * Get the subnet routing number (wire)
     *
     * @return string | null
     */
    public function getSubnetRoutingNumberWire();

    /**
     * Get the subnet account number
     *
     * @return string | null
     */
    public function getSubnetAccountNumber();

    /**
     * Get the subnet eth address
     *
     * @return string | null
     */
    public function getSubnetEthAddress();

    /**
     * Get the subnet btc address
     *
     * @return string | null
     */
    public function getSubnetBtcAddress();

    /**
     * Get the legal entity that owns this funding source
     *
     * @return \CFX\Brokerage\LegalEntityInterface
     */
 	public function getOwner();




    /**
     * Set the legal entity that owns this funding source
     *
     * @param \CFX\Brokerage\LegalEntityInterface $val
     * @return static
     */
 	public function setOwner(?LegalEntityInterface $val);
}

