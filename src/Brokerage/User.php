<?php
namespace CFX\Brokerage;

class SiteUser extends \KS\JsonApi\BaseResource implements SiteUserInterface {
    use \KS\JsonApi\Rel2MTrait;

    protected $resourceType = 'users';
    protected $attributes = [
        'email' => null,
        'phoneNumber' => null,
        'displayName' => null,
        'timezone' => 'UM12',
        'language' => 'English',
    ];
    protected $privateAttributes = [
        'username' => null,
        'active' => false,
        'role' => '4',
        'forcePasswordReset' => false,
        'passwordHash' => null,
        'passwordIterations' => 8,
        'firstName' => null,
        'lastName' => null,
    ];
    protected $relationships = [ 'oAuthTokens' ];

    public static function adaptFrom(FactoryInterface $f, $user) {
        if (is_array($user)) {
            if (array_key_exists('phoneNumber', $user)) return new static($f, $user);
            else {
                $data = [
                    'id' => $user['guid'],
                    'attributes' => [
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'phoneNumber' => $user['phone_number'],
                        'displayName' => $user['display_name'],
                        'firstName' => $user['first_name'],
                        'lastName' => $user['last_name'],
                        'role' => $user['role'],
                        'timezone' => $user['timezone'],
                        'language' => $user['language'],
                    ]
                ];
                return new static($f, $data);
            }
        }

        if (is_object($user)) $type = get_class($user);
        else $type = gettype($user);
        throw new UnknownResourceDataFormatException("Don't know how to adapt resources of type `".get_class($asset)."`. To implement adapting of these resources, you should add a block for it in the definition for the `\CFX\Brokerage\Asset::adaptFrom` method.");
    }

    public function getData($format=null) {
        if (!$format) return $this->jsonSerialize();
        if ($format == 'compat') {
            return [
                'username' => $this->getAttribute('username'),
                'email' => $this->getAttribute('email'),
                'phone_umber' => $this->getAttribute('phoneNumber'),
                'display_name' => $this->getAttribute('displayName'),
                'first_name' => $this->getAttribute('firstName'),
                'last_name' => $this->getAttribute('lastName'),
                'role' => $this->getAttribute('role'),
                'timezone' => $this->getAttribute('timezone'),
                'language' => $this->getAttribute('language'),
            ];
        } else {
            throw new UnknownResourceDataFormatException("Don't know how to cast this object to type `$format`. To implement this, simply add a block for this type in the definition for the `\CFX\Brokerage\Asset::cast` function.");
        }
    }




    // Getters

    public function getEmail() { return $this->attributes['email']; }
    public function getPhoneNumber() { return $this->attributes['phoneNumber']; }
    public function getDisplayName() { return $this->attributes['displayName']; }
    public function getTimezone() { return $this->attributes['timezone']; }
    public function getLanguage() { return $this->attributes['language']; }
    public function getOauthTokens() { return $this->relationships['oAuthTokens']->getData(); }

    public function getUsername() { return $this->privateAttributes['username']; }
    public function getFirstName() { return $this->privateAttributes['firstName']; }
    public function getLastName() { return $this->privateAttributes['lastName']; }
    public function getRole() { return $this->privateAttributes['role']; }
    public function getPasswordHash() { return $this->privateAttributes['passwordHash']; }
    public function getPasswordIterations() { return $this->privateAttributes['passwordIterations']; }
    public function getActive() {
        if ($this->privateAttributes['active'] === null) return null;
        else return (bool)$this->privateAttributes['active'];
    }
    public function getForcePasswordReset() {
        if ($this->privateAttributes['forcePasswordReset'] === null) return null;
        else return (bool)$this->privateAttributes['forcePasswordReset'];
    }





    // Setters

    public function setEmail($val) {
        $this->attributes['email'] = $val;

        // Validate

        if (!$this->getEmail()) {
            $this->setError('email', 'required', $this->f->newJsonApiError([
                "status" => 400,
                "title" => "Required Attribute `email` Missing",
                "detail" => "No email found. New users require a valid email to be passed via the `email` field."
            ]));
        } else {
            $this->clearError('email','required');

            if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $this->getEmail())) {
                $this->setError('email', "valid", $this->f->newJsonApiError([
                    "status" => 400,
                    "title" => "Invalid Attribute Value for `email`",
                    "detail" => "The email address you've entered doesn't appear to be valid."
                ]));
            } else {
                $this->clearError('email', "valid");
            }
        }

        // Set username from email, if necessary
        if (!$this->hasErrors('email') && (!$this->getUsername() || $this->getUsername() == $this->getDisplayName())) $this->setUsername($val);

        return $this;
    }
    public function setPhoneNumber($val) {
        $this->attributes['phoneNumber'] = $val;

        // Validations
        if (!$this->getPhoneNumber()) {
            $this->setError('phoneNumber', "required", $this->f->newJsonApiError([
                "status" => 400,
                "title" => "Required Attribute `phoneNumber` Missing",
                "detail" => "No phone number found. New users require a valid phone number to be passed via the `phoneNumber` field."
            ]));
        } else {
            $this->clearError('phoneNumber', "required");

            if (!preg_match("/^\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{4}$/", $this->getPhoneNumber())) {
                $this->setError('phoneNumber', "valid", $this->f->newJsonApiError([
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
        $this->attributes['displayName'] = $val;

        // Validations
        if (!$this->getDisplayName()) {
            $this->setError('displayName', "required", $this->f->newJsonApiError([
                "status" => 400,
                "title" => "Required Attribute `displayName` Missing",
                "detail" => "No name. You must supply a full name via the `displayName` field to create a user."
            ]));
        } else {
            $this->clearError('displayName', "required");
        }

        // Set first name/last name/username if, necessary
        if (!$this->hasErrors('displayName')) {
            $lastName = preg_split("/\\s+/", $val);
            $firstName = array_shift($lastName);
            $lastName = implode(' ',$lastName);
            if (!$this->getFirstName()) $this->setFirstName($firstName);
            if (!$this->getLastName()) $this->setLastName($lastName);
            if (!$this->getUsername()) $this->setUsername($val);
        }

        return $this;
    }
    public function setTimezone($val) {
        $this->attributes['timezone'] = $val;
        return $this;
    }
    public function setLanguage($val) {
        $this->attributes['language'] = $val;
        return $this;
    }
    public function setOAuthTokens(ResourceCollectionInterface $tokens=null) {
        if (!$tokens) $tokens = $this->f->newJsonApiResourceCollection();
        $this->relationships['oAuthTokens']->setData($tokens);
        return $this;
    }
    public function setPassword($word) {
        $hasher = $this->f->newPasswordHasher();
        for ($i = 0; $i < 3; $i++) {
            $hash = $hasher->HashPassword($word, $this->privateAttributes['passwordIterations']);
            if ($hash) break;
        }

        if (!$hash) throw new \RuntimeException("Couldn't generate a valid password hash from the password you entered. Please try again.");

        $this->privateAttributes['passwordHash'] = $hash;

        return $this;
    }
    public function setUsername($val) {
        $this->privateAttributes['username'] = $val;
        return $this;
    }
    public function setFirstName($val) {
        $this->privateAttributes['firstName'] = $val;
        return $this;
    }
    public function setLastName($val) {
        $this->privateAttributes['lastName'] = $val;
        return $this;
    }
    public function setRole($val) {
        $this->privateAttributes['role'] = $val;
        return $this;
    }
    public function setActive($val) {
        if (is_bool($val)) $val = (int)$val;
        $this->privateAttributes['active'] = $val;

        if (!is_int($val)) {
            $this->setError('active', 'valid', $this->f->newJsonApiError([
                'status' => 400,
                'title' => 'Invalid Attribute Value for `active`',
                'detail' => '`active` must be either a boolean value or an integer representation thereof.',
            ]));
        } else {
            $this->clearError('active', 'valid');
        }

        return $this;
    }
    public function setForcePasswordReset($val) {
        if (is_bool($val)) $val = (int)$val;
        $this->privateAttributes['forcePasswordReset'] = $val;

        if (!is_int($val)) {
            $this->setError('forcePasswordReset', 'valid', $this->f->newJsonApiError([
                'status' => 400,
                'title' => 'Invalid Attribute Value for `forcePasswordReset`',
                'detail' => '`forcePasswordReset` must be either a boolean value or an integer representation thereof.',
            ]));
        } else {
            $this->clearError('forcePasswordReset', 'valid');
        }

        return $this;
    }








    // Relationship manipulators

    public function addOAuthToken(OAuthTokenInterface $token) { return $this->add2MRel('oAuthTokens', $token); }
    public function hasOAuthToken(OAuthTokenInterface $token=null) { return $this->has2MRel('oAuthTokens', $token); }
    public function removeOAuthToken(OAuthTokenInterface $token) { return $this->remove2MRel('oAuthTokens', $token); }
    public function fetchOAuthTokens(DatasourceInterface $db) {
        if (in_array('oAuthTokens', $this->initializedRelationships)) return $this->getOAuthTokens();
        $tokens = $db->getOAuthTokensByUserId($this->getId());
        $this->relationships['oAuthTokens']->setData($tokens);
        $this->initializedRelationships[] = 'oAuthTokens';
        return $this->getOAuthTokens();
    }









    /**
     * Create an OAuth access token with the given parameters
     *
     * @param string $apikey The API key gaining access
     * @param int $scopes A bitmask of the scopes for which access is granted
     * @param int $expiration A timestamp at which this token will expire
     * @param DatasourceInterface $db A database to use
     * @return OAuthTokenInterface $token A new OAuth token
     */
    public function grantOAuthAccess($apikey, $scopes, $expiration, DatasourceInterface $db) {
        // Typecheck
        if (!is_string($apikey) && !($apikey instanceof ApiKeyInterface)) throw new \InvalidArgumentException('The token you\'ve passed as the $apikey parameter doesn\'t appear to be a string or an ApiKey object.');
        if (!is_int($scopes)) throw new \InvalidArgumentException('The scopes you\'ve passed in don\'t appear to be in the form of a bitmask.');
        if (!is_int($expiration)) throw new \InvalidArgumentException('The expiration timestamp must be an integer.');

        if (!is_string($apikey)) $apikey = $apikey->getId();

        // More serious checking
        if ($expiration <= time()) throw new \InvalidArgumentException('The expiration timestamp must be in the future. (You sent '.$expiration.' and the current time is '.time().')');

        if ($scopes == 1) throw new \InvalidArgumentException('Scope of value `1` is a reserved scope that cannot be used.');

        $scopesQuery = $db->getAllOAuthScopes();
        
        $scopesTotal = 0;
        foreach($scopesQuery as $row) $scopesTotal += pow(2, $row['id']);
        if ($scopes > $scopesTotal) throw new \InvalidArgumentException("You've passed scopes that aren't defined in the system! Your total scopes cannot be greater than $scopesTotal. (You passed $scopes.)");

        $oauthToken = $this->f->newOAuthToken([
            "attributes" => [
                "scopes" => $scopes,
                "expires" => $expiration,
            ],
            "relationships" => [
                "apiKey" => [
                    "data" => [
                        "type" => "api-keys",
                        "id" => $apikey,
                    ],
                ],
                "user" => [
                    "data" => [
                        "type" => "users",
                        "id" => $this->getId(),
                    ],
                ],
            ],
        ]);

        $db->saveOAuthToken($oauthToken);

        $this->fetchOAuthTokens($db);
        $this->addOAuthToken($oauthToken);

        return $oauthToken;
    }







    // Interface implementations

    public function fetch(DatasourceInterface $db) {
        if ($this->initialized) return $this;

        $data = $db->getSiteUserById($this->getId(), true);
        $this->initializeAttributes($data['attributes']);
        if (array_key_exists('relationships', $data)) $this->initializeRelationships($data['relationships']);
        $this->initialized = true;

        return $this;
    }
}


