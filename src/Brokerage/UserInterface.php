<?php
namespace CFX\Brokerage;

interface SiteUserInterface extends BaseResourceInterface {
    // Getters

    public function getEmail();
    public function getPhoneNumber();
    public function getDisplayName();
    public function getFirstName();
    public function getLastName();
    public function getTimezone();
    public function getLanguage();
    public function getOauthTokens();

    public function getUsername();
    public function getRole();
    public function getPasswordHash();
    public function getPasswordIterations();
    public function getActive();
    public function getForcePasswordReset();


    // Setters

    public function setEmail($val);
    public function setPhoneNumber($val);
    public function setDisplayName($val);
    public function setFirstName($val);
    public function setLastName($val);
    public function setTimezone($val);
    public function setLanguage($val);
    public function setOAuthTokens(ResourceCollectionInterface $tokens=null);
    public function setPassword($word);
    public function setUsername($val);
    public function setRole($val);
    public function setActive($val);
    public function setForcePasswordReset($val);


    // Relationship manipulators
    public function addOAuthToken(OAuthTokenInterface $token);
    public function hasOAuthToken(OAuthTokenInterface $token=null);
    public function removeOAuthToken(OAuthTokenInterface $token);
}

