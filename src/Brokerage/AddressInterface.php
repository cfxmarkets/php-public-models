<?php
namespace CFX\Brokerage;

interface AddressInterface extends \CFX\JsonApi\ResourceInterface {
    /**
     * Get the address label
     *
     * @return string
     */
 	public function getLabel();

    /**
     * Get the main street address
     *
     * @return string
     */
    public function getStreet1();

    /**
     * Get the secondary street address
     *
     * @return string
     */
    public function getStreet2();

    /**
     * Get the city
     *
     * @return string
     */
    public function getCity();

    /**
     * Get the state
     *
     * @return string
     */
    public function getState();

    /**
     * Get the postal code
     *
     * @return string
     */
    public function getZip();

    /**
     * Get the country
     *
     * @return string
     */
    public function getCountry();

    /**
     * Get any meta data that might be supplied with the address
     *
     * @return array
     */
    public function getMetaData();






    /**
     * Set the address label
     *
     * @param string $val
     * @return static
     */
 	public function setLabel($val);

    /**
     * Set the main street address
     *
     * @param string $val
     * @return static
     */
    public function setStreet1($val);

    /**
     * Set the secondary street address
     *
     * @param string $val
     * @return static
     */
    public function setStreet2($val);

    /**
     * Set the city
     *
     * Note that this does not validate that the city exists
     *
     * @param string $val
     * @return static
     */
    public function setCity($val);

    /**
     * Set the state
     *
     * Note that this does not validate that the state exists
     *
     * @param string $val
     * @return static
     */
    public function setState($val);

    /**
     * Set the postal code
     *
     * Note that this does not validate that the postal code exists
     *
     * @param string $val
     * @return static
     */
    public function setZip($val);

    /**
     * Set the country
     *
     * Note that this does not validate that the country exists
     *
     * @param string $val
     * @return static
     */
    public function setCountry($val);

    /**
     * Set any meta data that might be supplied with the address
     *
     * @param array|string $val May be either an inflated (array) or serialized (string) json object
     * @return static
     */
    public function setMetaData($val);

}
