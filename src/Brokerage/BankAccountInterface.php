<?php
namespace CFX\Brokerage;

interface BankAccountInterface extends FundingSourceInterface
{
    /**
     * Get the account's informal, user-specified label
     *
     * @return string
     */
    public function getLabel();

    /**
     * Get the bank's name
     *
     * @return string
     */
    public function getBankName();

    /**
     * Get the account type
     *
     * @return string
     */
    public function getAccountType();

    /**
     * Get the official account holder's name
     *
     * @return string
     */
    public function getHolderName();

    /**
     * Get the bank's routing number
     *
     * @return string
     */
    public function getRoutingNum();

    /**
     * Get the account number (will usually be obfuscated)
     *
     * @return string
     */
    public function getAccountNum();

    /**
     * Get the bank's address
     *
     * @return string
     */
    public function getBankAddress();

    /**
     * Get the account's status
     *
     * @return bool
     */
    public function getStatus();


    /**
     * Set the account's informal, user-specified label
     *
     * @param string|null $val
     * @return static
     */
    public function setLabel($val);

    /**
     * Set the bank's name
     *
     * @param string|null $val
     * @return static
     */
    public function setBankName($val);

    /**
     * Set the account type
     *
     * Compound account types may be specified using colon notation like so: `checking:personal`, `checking:business`, etc...
     *
     * @param string|null $val
     * @return static
     */
    public function setAccountType($val);

    /**
     * Set the official account holder's name
     *
     * @param string|null $val
     * @return static
     */
    public function setHolderName($val);

    /**
     * Set the bank's routing number
     *
     * @param string|null $val
     * @return static
     */
    public function setRoutingNum($val);

    /**
     * Set the 
     *
     * @param string|null $val
     * @return static
     */
    public function setAccountNum($val);

    /**
     * Set the bank's address
     *
     * @param string|null $val
     * @return static
     */
    public function setBankAddress($val);

    /**
     * Set the account's status in the system
     *
     * @param bool|null $val
     * @return static
     */
    public function setStatus($val);
}

