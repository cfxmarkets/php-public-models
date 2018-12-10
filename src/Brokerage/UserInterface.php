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
    public function getAuthId();
    public function getSelfAccredited();
    public function getYearsExpAlts();
    public function getYearsExpReits();
    public function getYearsExpStocks();
    public function getYearsExpLp();
    public function getEmploymentStatus();
    public function getEmploymentSector();
    public function getEmploymentPosition();
    public function getEmployerName();
    public function getConsultsAdvisor();
    public function getConsultsAccountant();
    public function getAgreedTOS();
    public function getAgreedDTA();
    public function getAgreedDTAArbitration();
    public function getInvestmentProfile();
    public function getRiskTolerance();
    public function getOauthTokens();
    public function getPersonEntity();
    public function getOtherEntities();

    // Setters

    public function setEmail($val);
    public function setPhoneNumber($val);
    public function setDisplayName($val);
    public function setTimezone($val);
    public function setLanguage($val);
    public function setReferralKey($val);
    public function setAuthId($val);
    public function setSelfAccredited($val);
    public function setYearsExpAlts($val);
    public function setYearsExpReits($val);
    public function setYearsExpStocks($val);
    public function setYearsExpLp($val);
    public function setEmploymentStatus($val);
    public function setEmploymentSector($val);
    public function setEmploymentPosition($val);
    public function setEmployerName($val);
    public function setConsultsAdvisor($val);
    public function setConsultsAccountant($val);
    public function setAgreedTOS($val);
    public function setAgreedDTA($val);
    public function setAgreedDTAArbitration($val);
    public function setInvestmentProfile($val);
    public function setRiskTolerance($val);
    public function setOAuthTokens(?\CFX\JsonApi\ResourceCollectionInterface $tokens);
    public function setPersonEntity(?LegalEntityInterface $val);
    public function setOtherEntities(?\CFX\JsonApi\ResourceCollectionInterface $val);
}

