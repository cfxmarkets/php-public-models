<?php
namespace CFX\Brokerage;

interface FundingInterfaceInterface  extends \CFX\JsonApi\ResourceInterface
{

    /**
     * Get the label associated with this interface
     *
     * @return string | null
     */
     public function getLabel();

    /**
     * Get the URI describing the interface
     *
     * @return string | null
     */
     public function getUri();

    /**
     * Get the Funding Source to which this interface is attached
     *
     * @return \CFX\Brokerage\FundingSource
     */
     public function getFundingSource();




    /**
     * Set the label of the interface
     *
     * @param string | null $val
     * @return static
     */
     public function setLabel($val);

    /**
     * Set the URI describing this interface
     *
     * @param string | null $val
     * @return static
     */
     public function setUri($val);

    /**
     * Set the Funding Source to which this interface is attached
     *
     * @param \CFX\Brokerage\FundingSource $val
     * @return static
     */
     public function setFundingSource(?FundingSource $val);
}


