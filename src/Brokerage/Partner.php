<?php
namespace CFX\Brokerage;

class Partner extends \KS\JsonApi\BaseResource implements PartnerInterface {
    use \KS\JsonApi\Rel2MTrait;

    protected $resourceType = 'partners';
    protected $attributes = [
        'name' => null,
        'logoUrl' => null,
    ];
    protected $relationships = [ 'apiKeys', 'oAuthTokens' ];
    protected $authenticated = false;


    // Getters

    public function getName() { return $this->attributes['name']; }
    public function getLogoUrl() { return $this->attributes['logoUrl']; }
    public function getApiKeys() { return $this->get2MRel('apiKeys'); }
    public function getOAuthTokens() { return $this->get2MRel('oAuthTokens'); }


    // Setters

    public function setName($val) {
        return $this->_setAttribute('name', $val);
    }
    public function setLogoUrl($val) {
        return $this->_setAttribute('logoUrl', $val);
    }
    public function setApiKeys(\KS\JsonApi\ResourceCollectionInterface $val=null) {
        return $this->_setRelationship('apiKeys', $val);
    }
    public function addApiKey(ApiKeyInterface $val) { return $this->add2MRel('apiKeys', $val); }
    public function hasApiKey(ApiKeyInterface $val=null) { return $this->has2MRel('apiKeys', $val); }
    public function removeApiKey(ApiKeyInterface $val) { return $this->remove2MRel('apiKeys', $val); }

    public function setOAuthTokens(\KS\JsonApi\ResourceCollectionInterface $val=null) {
        return $this->_setRelationship('oAuthTokens', $val);
    }
    public function addOAuthToken(OAuthTokenInterface $val) { return $this->add2MRel('oAuthTokens', $val); }
    public function hasOAuthToken(OAuthTokenInterface $val=null) { return $this->has2MRel('oAuthTokens', $val); }
    public function removeOAuthToken(OAuthTokenInterface $val) { return $this->remove2MRel('oAuthTokens', $val); }





    // Authentication

    public function isAuthenticated() { return $this->authenticated; }
    public function login($secret=null) {
        if (!$this->initialized) throw new UninitializedResourceException("You must initialize this Partner resource before attempting to log in.");
        if ($this->attributes['secret'] != $secret) throw new AuthnInvalidCredentialsException("The API Secret you've passed is not valid.");
        $this->authenticated = true;
    }
}

