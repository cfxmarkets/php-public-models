<?php
namespace CFX\Brokerage;

interface FundsTransferInterface extends \CFX\JsonApi\ResourceInterface
{
    /**
     * Returns the type of this transfer. Null is invalid, though still a possible value.
     *
     * @return 'credit'|'debit'|null
     */
    public function getType();

    /**
     * Returns the amount to transfer
     *
     * @return int|null
     */
    public function getAmount();

    /**
     * Returns the Idempotency Key, i.e., an arbitrary, consumer-defined key used to prevent
     * duplicate transfers.
     *
     * @return string
     */
    public function getIdpKey();

    /**
     * Returns the status of this request (read-only).
     *
     * @return 'pending'|'cleared'|'rejected'
     */
    public function getStatus();

    /**
     * Returns the date the transfer was created (read-only).
     *
     * @return \DateTimeInterface
     */
    public function getCreatedOn();

    /**
     * Returns the LegalEntity whose wallet account is the source or target of this transfer.
     *
     * @return \CFX\Brokerage\LegalEntityInterface|null
     */
    public function getLegalEntity();

    /**
     * Returns the funding source selected for this transfer.
     *
     * @return \CFX\Brokerage\FundingSourceInterface
     */
    public function getFundingSource();




    /**
     * Sets the type of transfer. "Credit" indicates that the `amount` will be transfered FROM
     * `source` TO the given LegalEntity's `WalletAccount`. "Debit" indicates the opposite.
     *
     * @param 'credit'|'debit'
     * @return static
     */
    public function setType($val);

    /**
     * Sets the amount of the transfer in USD
     *
     * @param double
     * @return static
     */
    public function setAmount($val);

    /**
     * Sets the idempotency key. This key should be a consumer-generated key between 20 and 36
     * characters in length. It should be used for every attempt to complete the same transaction.
     *
     * @param string
     * @return static
     */
    public function setIdpKey($val);

    /**
     * Sets the LegalEntity whose wallet account is the source or target of this transfer.
     *
     * @param \CFX\Brokerage\LegalEntityInterface
     * @return static
     */
    public function setLegalEntity(\CFX\Brokerage\LegalEntityInterface $val = null);

    /**
     * Returns the funding source selected for this transfer.
     *
     * @param \CFX\Brokerage\FundingSourceInterface
     * @return static
     */
    public function setFundingSource(\CFX\Brokerage\FundingSourceInterface $val = null);
}

