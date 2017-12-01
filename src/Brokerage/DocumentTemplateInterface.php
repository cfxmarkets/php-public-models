<?php
namespace CFX\Brokerage;

interface DocumentTemplateInterface extends \CFX\JsonApi\ResourceInterface
{
    /**
     * Get template's URL
     *
     * @return string
     */
    public function getUrl();

    /**
     * Get template's status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set template's url
     *
     * @param string $val
     * @return static
     */
    public function setUrl($val);

    /**
     * Set template's status
     *
     * @param string $val
     * @return static
     */
    public function setStatus($val);
}

