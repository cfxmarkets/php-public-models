<?php
namespace CFX\Brokerage;

/**
 * CryptoWalletInterface
 *
 * An interface describing a modern CFX CryptoWallet object
 */
interface CryptoWalletInterface extends \CFX\JsonApi\ResourceInterface {
    /**
     * Get the protocol of the crypto-wallet
     *
     * @return string
     */
    public function getProtocol();

    /**
     * Get the nethwork of the crypto-wallet
     *
     * @return string
     */
    public function getNetwork();

    /**
     * Get the priority for the crypto-wallet
     *
     * @return int
     */
    public function getPriority();

    /**
     * Get the status for the crypto-wallet
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get the owner entity of the crypto-wallet
     *
     * @return \CFX\Brokerage\LegalEntityInterface
     */
    public function getOwnerEntity();





    /**
     * Set the protocol of the crypto-wallet
     *
     * @param string
     * @return static
     */
    public function setProtocol($val);

    /**
     * Set the nethwork of the crypto-wallet
     *
     * @param string
     * @return static
     */
    public function setNetwork($val);

    /**
     * Set the priority for the crypto-wallet
     *
     * @param int
     * @return static
     */
    public function setPriority($val);

    /**
     * Set the status for the crypto-wallet
     *
     * @param string
     * @return static
     */
    public function setStatus($val);

    /**
     * Set the owner entity of the crypto-wallet
     *
     * @param \CFX\Brokerage\LegalEntityInterface
     * @return static
     */
    public function setOwnerEntity(?LegalEntityInterface $val);
}
