<?php
namespace CFX\Brokerage;

class OAuthToken extends \KS\JsonApi\BaseResource implements OAuthTokenInterface {
    protected $resourceType = 'oauth-tokens';
    protected $attributes = [
        'scopes' => 0,
        'expires' => null,
    ];
    protected $relationships = [ 'user', 'apiKey' ];

    public static function adaptFrom(FactoryInterface $f, $oldObj) {
        throw new \RuntimeException("`adaptFrom` is not yet implemented");
    }

    public function getData($format=null) {
        throw new \RuntimeException("`getData` is not yet implemented");
    }



    // Getters

    public function getScopes() { return $this->attributes['scopes']; }
    public function getExpires() { return $this->attributes['expires']; }
    public function getUser() { return $this->relationships['user']->getData(); }
    public function getApiKey() { return $this->relationships['apiKey']->getData(); }




    // Setters

    public function setScopes($val) {
        $this->attributes['scopes'] = $val;

        if (!$this->getScopes()) {
            $this->setError('scopes', 'required', $this->f->newJsonApiError([
                'status' => 400,
                'title' => 'Required Attribute `scopes` Missing',
                'detail' => 'You must provide the scopes that this OAuth token requests.',
            ]));
        } else {
            $this->clearError('scopes', 'required');
        }

        return $this;
    }

    public function setExpires($val) {
        if ($val === null) {
            $this->attributes['expires'] = $val;
            $this->setError('expires', 'required', $this->f->newJsonApiError([
                'status' => 400,
                'title' => 'Required Attribute `expires` Missing',
                'detail' => 'You must indicate a valid date at which this token expires',
            ]));
            return $this;
        }

        $this->clearError('expires','required');

        if ($val instanceof \DateTime) $date = $val;
        else {
            if (is_numeric($val)) $date = new \DateTime("@$val");
            else {
                try {
                    $date = new \DateTime($val);
                } catch (\Exception $e) {
                    $date = null;
                }
            }
        }

        if (!$date) {
            $this->attributes['expires'] = $val;
            $this->setError('expires', 'format', $this->f->newJsonApiError([
                "status" => 400,
                "title" => "Invalid Attribute Value for `dateCreated`",
                "detail" => 'You must pass a dateCreated that is either a valid DateTime object or something that DateTime can parse.'
            ]));
        } else {
            $this->clearError('expires', 'format');
            $this->attributes['expires'] = $date;
        }
        return $this;
    }

    public function setUser(SiteUserInterface $user=null) {
        $this->relationships['user']->setData($user);
        return $this;
    }

    public function setApiKey(ApiKeyInterface $apiKey=null) {
        $this->relationships['apiKey']->setData($apiKey);
        return $this;
    }

    public function jsonSerialize($fullResource=true) {
        $obj = parent::jsonSerialize($fullResource);
        if ($obj['attributes']['expires'] instanceof \DateTime) $obj['attributes']['expires'] = $obj['attributes']['expires']->format('U');
        return $obj;
    }
    





    // Interface implementations

    public function fetch(DatasourceInterface $db) {
        throw new UnimplementedFeatureException("`fetch` is not yet implemented for OAuthTokens.");
    }
}

