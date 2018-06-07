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
     * Get the legal entity that owns this funding source
     *
     * @return \CFX\Brokerage\LegalEntityInterface
     */
 	public function getOwnerEntity();




    /**
     * Set the legal entity that owns this funding source
     *
     * @param \CFX\Brokerage\LegalEntityInterface $val
     * @return static
     */
 	public function setOwnerEntity(?LegalEntityInterface $val);
}

