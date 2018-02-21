<?php
namespace CFX\Brokerage;

interface LoginRequestInterface extends \CFX\JsonApi\ResourceInterface
{
    /**
     * Gets the email for this login request
     *
     * @return string
     */
    public function getEmail();

    /**
     * Gets the expiration date of this request
     *
     * @return \DateTime|null
     */
    public function getExpiration();

    /**
     * Sets the email for the login request
     *
     * @param string|null $val The api key
     * @return static
     */
    public function setEmail($val = null): LoginRequestInterface;
}


