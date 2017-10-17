<?php
namespace CFX\Brokerage;

interface OAuthTokenInterface extends BaseResourceInterface {
    // Getters
    public function getScopes();
    public function getExpires();
    public function getUser();
    public function getApiKey();


    // Setters
    public function setScopes($val);
    public function setExpires($val);
    public function setUser(SiteUserInterface $user=null);
    public function setApiKey(ApiKeyInterface $apiKey=null);
}

