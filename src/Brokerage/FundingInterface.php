<?php
namespace CFX\Brokerage;

class FundingInterface extends \CFX\JsonApi\AbstractResource implements FundingInterfaceInterface
{
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'funding-interfaces';

    protected $attributes = [
        "label" => null,
        "uri" => null,
    ];

    protected $relationships = [
        "fundingSource" => null,
    ];

    /**
     * @inheritDoc
     */
 	public function getLabel()
    {
        return $this->_getAttributeValue("label");
    }

    /**
     * @inheritDoc
     */
    public function getUri()
    {
        return $this->_getAttributeValue("uri");
    }

    /**
     * @inheritDoc
     */
    public function getFundingSource()
    {
        return $this->_getRelationshipValue("fundingSource");
    }




    /**
     * @inheritDoc
     */
    public function setLabel($val)
    {
        $field = "label";
        $val = $this->cleanStringValue($val);
        $this->validateType($field, $val, "string", false);
        return $this->_setAttribute($field, $val);
    }

    /**
     * @inheritDoc
     */
    public function setUri($val)
    {
        $field = "uri";
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired($field, $val)) {
            // Validating for URL, even though we're calling this a URI, since currently we don't accept anything
            // other than URLs
            if ($this->validateType($field, $val, "url")) {
                $scheme = substr($val, 0, strpos($val, ":"));
                $knownSchemes = [ "wire", "ach", "p2p" ];
                if (!in_array($scheme, $knownSchemes, true)) {
                    $this->setError($field, "unknown-scheme", [
                        "title" => "Unknown Scheme",
                        "detail" => "The scheme of your URL must be one of '".implode("', '", $knownSchemes)."'",
                    ]);
                } else {
                    $this->clearError($field, "unknown-scheme");
                }
            }
        }
        return $this->_setAttribute($field, $val);
    }

    /**
     * @inheritDoc
     */
    public function setFundingSource(?FundingSource $val)
    {
        $field = "fundingSource";
        $this->validateRequired($field, $val);
        return $this->_setRelationship($field, $val);
    }

}


