<?php
namespace CFX\Brokerage;

class User extends \CFX\JsonApi\AbstractResource implements UserInterface {
    use \CFX\JsonApi\Rel2MTrait;

    protected $resourceType = 'users';
    protected $attributes = [
        'email' => null,
        'phoneNumber' => null,
        'displayName' => null,
        'timezone' => 'UM12',
        'language' => 'English',
    ];
    protected $relationships = [
        'oAuthTokens' => null,
    ];



    // Getters

    public function getEmail() { return $this->attributes['email']; }
    public function getPhoneNumber() { return $this->attributes['phoneNumber']; }
    public function getDisplayName() { return $this->attributes['displayName']; }
    public function getTimezone() { return $this->attributes['timezone']; }
    public function getLanguage() { return $this->attributes['language']; }
    public function getOauthTokens() { return $this->relationships['oAuthTokens']->getData(); }




    // Setters

    public function setEmail($val) {
        $this->_setAttribute('email', $val);

        // Validate

        if (!$this->getEmail()) {
            $this->setError('email', 'required', $this->getFactory()->newError([
                "status" => 400,
                "title" => "Required Attribute `email` Missing",
                "detail" => "No email found. New users require a valid email to be passed via the `email` field."
            ]));
        } else {
            $this->clearError('email','required');

            if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $this->getEmail())) {
                $this->setError('email', "valid", $this->getFactory()->newError([
                    "status" => 400,
                    "title" => "Invalid Attribute Value for `email`",
                    "detail" => "The email address you've entered doesn't appear to be valid."
                ]));
            } else {
                $this->clearError('email', "valid");
            }
        }

        return $this;
    }
    public function setPhoneNumber($val) {
        $this->_setAttribute('phoneNumber', $val);

        // Validations
        if (!$this->getPhoneNumber()) {
            $this->setError('phoneNumber', "required", $this->getFactory()->newError([
                "status" => 400,
                "title" => "Required Attribute `phoneNumber` Missing",
                "detail" => "No phone number found. New users require a valid phone number to be passed via the `phoneNumber` field."
            ]));
        } else {
            $this->clearError('phoneNumber', "required");

            if (!preg_match("/^\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{4}$/", $this->getPhoneNumber())) {
                $this->setError('phoneNumber', "valid", $this->getFactory()->newError([
                    "status" => 400,
                    "title" => "Invalid Attribute Value for `phoneNumber`",
                    "detail" => "The phone number you've passed is invalid"
                ]));
            } else {
                $this->clearError('phoneNumber', "valid");
            }
        }

        return $this;
    }
    public function setDisplayName($val) {
        $this->_setAttribute('displayName', $val);

        // Validations
        if (!$this->getDisplayName()) {
            $this->setError('displayName', "required", $this->getFactory()->newError([
                "status" => 400,
                "title" => "Required Attribute `displayName` Missing",
                "detail" => "No name. You must supply a full name via the `displayName` field to create a user."
            ]));
        } else {
            $this->clearError('displayName', "required");
        }

        return $this;
    }
    public function setTimezone($val) {
        $this->_setAttribute('timezone', $val);
        return $this;
    }
    public function setLanguage($val) {
        $this->_setAttribute('language', $val);
        return $this;
    }
    public function setOAuthTokens(ResourceCollectionInterface $tokens=null) {
        if (!$tokens) $tokens = $this->getFactory()->newResourceCollection();
        $this->_setRelationship('oAuthTokens', $tokens);
        return $this;
    }

}


