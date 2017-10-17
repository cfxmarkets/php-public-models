<?php
namespace CFX\Brokerage;

interface PartnerInterface extends \CFX\BaseResourceInterface {
    // Getters
    public function getName();
    public function getLogoUrl();
    public function getApiKeys();

    // Setters

    public function setName($val);
    public function setLogoUrl($val);
    public function setApiKeys(\KS\JsonApi\ResourceCollectionInterface $val=null);
    public function addApiKey(ApiKeyInterface $val);
    public function hasApiKey(ApiKeyInterface $val=null);
    public function removeApiKey(ApiKeyInterface $val);
}

