<?php
namespace CFX\Exchange;

/**
 * AssetInterface
 *
 * An interface describing a modern CFX Brokerage Asset object
 */
interface AssetInterface extends \CFX\JsonApi\ResourceInterface {
    /**
     * Get the asset's issuer
     *
     * @return string
     */
    public function getIssuer();

    /**
     * Get the asset's name
     *
     * @return string
     */
    public function getName();

    /**
     * Get the asset's type
     *
     * @return string
     */
    public function getType();

    /**
     * Get the asset's status code
     *
     * @return string
     */
    public function getStatusCode();

    /**
     * Get the asset's status text
     *
     * @return string
     */
    public function getStatusText();

    /**
     * Get the asset's description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the asset's platform (for p2p assets)
     *
     * @return string|null
     */
    public function getPlatform();

    /**
     * Get platform version (for p2p assets)
     *
     * @return string|null
     */
    public function getPlatformVersion();

    /**
     * Get the URI where the asset can be resolved to (usually for p2p)
     *
     * @return string|null
     */
    public function getResolutionUri();




    /**
     * Set the asset's Issuer
     *
     * @param string $val
     * @return static
     */
    public function setIssuer($val);

    /**
     * Set the asset's name
     *
     * @param string $val
     * @return static
     */
    public function setName($val);

    /**
     * Set the asset's type
     *
     * @param string $val
     * @return static
     */
    public function setType($val);

    /**
     * Set the asset's status code
     *
     * @param string $val
     * @return static
     */
    public function setStatusCode($val);

    /**
     * Set the asset's status text
     *
     * @param string $val
     * @return static
     */
    public function setStatusText($val);

    /**
     * Set the asset's description
     *
     * @param string $val
     * @return static
     */
    public function setDescription($val);

    /**
     * Set the asset's platform (for p2p assets)
     *
     * @param mixed $val
     * @return static
     */
    public function setPlatform($val);

    /**
     * Set platform version (for p2p assets)
     *
     * @param mixed $val
     * @return static
     */
    public function setPlatformVersion($val);

    /**
     * Set the URI where the asset can be resolved to (usually for p2p)
     *
     * @param mixed $val
     * @return static
     */
    public function setResolutionUri($val);
}


