<?php
namespace CFX\Brokerage;

interface UserInterface extends \CFX\JsonApi\ResourceInterface {
    // Getters

    public function getEmail();
    public function getPhoneNumber();
    public function getDisplayName();
    public function getTimezone();
    public function getLanguage();
    public function getReferralKey();
    public function getSelfAccredited();
    public function getOauthTokens();
    public function getPersonEntity();

    // Setters

    public function setEmail($val);
    public function setPhoneNumber($val);
    public function setDisplayName($val);
    public function setTimezone($val);
    public function setLanguage($val);
    public function setReferralKey($val);
    public function setSelfAccredited($val);
    public function setOAuthTokens(\CFX\JsonApi\ResourceCollectionInterface $tokens=null);
    public function setPersonEntity(LegalEntityInterface $val = null);
}

