<?php
namespace CFX\Brokerage;

class User extends \CFX\JsonApi\AbstractResource implements UserInterface {
    use \CFX\JsonApi\Rel2MTrait;
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'users';
    protected $attributes = [
        'email' => null,
        'phoneNumber' => null,
        'displayName' => null,
        'timezone' => 'UM12',
        'language' => 'English',
        'referralKey' => null,
        "authId" => null,
        "selfAccredited" => null,
        "yearsExpAlts" => null,
        "yearsExpReits" => null,
        "yearsExpStocks" => null,
        "yearsExpLp" => null,
        "employmentStatus" => null,
        "employmentSector" => null,
        "employmentPosition" => null,
        "employerName" => null,
        "consultsAdvisor" => null,
        "consultsAccountant" => null,
        "investmentProfile" => null,
        "riskTolerance" => null,
    ];
    protected $relationships = [
        'oAuthTokens' => null,
        'personEntity' => null,
    ];


    public static function getValidInvestmentProfiles()
    {
        return [
            "conservative",
            "growth",
            "speculative",
        ];
    }

    public static function getValidRiskTolerances()
    {
        return [ "low", "medium", "high" ];
    }



    // Getters

    public function getEmail() { return $this->_getAttributeValue('email'); }
    public function getPhoneNumber() { return $this->_getAttributeValue('phoneNumber'); }
    public function getDisplayName() { return $this->_getAttributeValue('displayName'); }
    public function getTimezone() { return $this->_getAttributeValue('timezone'); }
    public function getLanguage() { return $this->_getAttributeValue('language'); }

    public function getReferralKey()
    {
        return $this->_getAttributeValue('referralKey');
    }

    public function getAuthId()
    {
        return $this->_getAttributeValue('authId');
    }

    public function getSelfAccredited()
    {
        return $this->_getAttributeValue("selfAccredited");
    }

    public function getYearsExpAlts()
    {
        return $this->_getAttributeValue("yearsExpAlts");
    }

    public function getYearsExpReits()
    {
        return $this->_getAttributeValue("yearsExpReits");
    }

    public function getYearsExpStocks()
    {
        return $this->_getAttributeValue("yearsExpStocks");
    }

    public function getYearsExpLp()
    {
        return $this->_getAttributeValue("yearsExpLp");
    }

    public function getEmploymentStatus()
    {
        return $this->_getAttributeValue("employmentStatus");
    }

    public function getEmploymentSector()
    {
        return $this->_getAttributeValue("employmentSector");
    }

    public function getEmploymentPosition()
    {
        return $this->_getAttributeValue("employmentPosition");
    }

    public function getEmployerName()
    {
        return $this->_getAttributeValue("employerName");
    }

    public function getConsultsAdvisor()
    {
        return $this->_getAttributeValue("consultsAdvisor");
    }

    public function getConsultsAccountant()
    {
        return $this->_getAttributeValue("consultsAccountant");
    }

    public function getInvestmentProfile()
    {
        return $this->_getAttributeValue("investmentProfile");
    }

    public function getRiskTolerance()
    {
        return $this->_getAttributeValue("riskTolerance");
    }

    public function getOauthTokens() { return $this->get2MRel('oAuthTokens'); }
    public function getPersonEntity()
    {
        return $this->_getRelationshipValue('personEntity');
    }




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
        $val = $this->cleanStringValue($val);
        if (is_string($val)) {
            $val = preg_replace("/[ .-]/", "", $val);
        }

        if ($this->validateType('phoneNumber', $val, 'string', false)) {
            if ($val !== null && !preg_match("/^\+?[0-9]{5,}$/", $val)) {
                $this->setError('phoneNumber', "valid", [
                    "title" => "Invalid Attribute Value for `phoneNumber`",
                    "detail" => "The phone number you've passed is invalid. Phone numbers must be all numbers with no punctuation or spaces and with an optional '+' at the beginning indicating a country code."
                ]);
            } else {
                $this->clearError('phoneNumber', "valid");
            }
        }

        return $this->_setAttribute('phoneNumber', $val);
    }

    public function setDisplayName($val) {
        $val = $this->cleanStringValue($val);

        if ($this->validateRequired('displayName', $val)) {
            $this->validateType('displayName', $val, 'non-numeric string');
        }

        return $this->_setAttribute('displayName', $val);
    }
    public function setTimezone($val) {
        $this->_setAttribute('timezone', $val);
        return $this;
    }
    public function setLanguage($val) {
        $this->_setAttribute('language', $val);
        return $this;
    }

    public function setReferralKey($val)
    {
        $val = $this->cleanStringValue($val);
        if ($val !== null) {
            if ($this->validateType('referralKey', $val, 'string')) {
                if (!preg_match('/^[a-z0-9]{32}$/', $val)) {
                    $this->setError('referralKey', 'format', [
                        'title' => "Bad Referral Key Format",
                        "detail" => "Referral keys are generated by the CFX system and should be the standard format output by the system.",
                    ]);
                } else {
                    $this->clearError("referralKey", "format");
                }
            }
        } else {
            $this->clearError('referralKey');
        }
        return $this->_setAttribute('referralKey', $val);
    }

    public function setAuthId($val) {
        if ($this->validateReadOnly("authId", $val)) {
            $this->_setAttribute("authId", $val);
        }
        return $this;
    }

    public function setSelfAccredited($val)
    {
        $val = $this->cleanBooleanValue($val);
        $this->validateType("selfAccredited", $val, "boolean", false);
        return $this->_setAttribute("selfAccredited", $val);
    }

    public function setYearsExpAlts($val)
    {
        return $this->_setYearsExp("alts", $val);
    }

    public function setYearsExpReits($val)
    {
        return $this->_setYearsExp("reits", $val);
    }

    public function setYearsExpStocks($val)
    {
        return $this->_setYearsExp("stocks", $val);
    }

    public function setYearsExpLp($val)
    {
        return $this->_setYearsExp("lp", $val);
    }

    public function setEmploymentStatus($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType("employmentStatus", $val, "non-numeric string", false);
        if (is_string($val)) {
            $this->validateFormat("employmentStatus", $val, "/^[A-Za-z].{1,49}$/", false);
        }
        return $this->_setAttribute("employmentStatus", $val);
    }

    public function setEmploymentSector($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType("employmentSector", $val, "non-numeric string", false);
        if (is_string($val)) {
            $this->validateFormat("employmentSector", $val, "/^[A-Za-z].{1,49}$/", false);
        }
        return $this->_setAttribute("employmentSector", $val);
    }

    public function setEmploymentPosition($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType("employmentPosition", $val, "non-numeric string", false);
        if (is_string($val)) {
            $this->validateFormat("employmentPosition", $val, "/^[A-Za-z].{1,127}$/", false);
        }
        return $this->_setAttribute("employmentPosition", $val);
    }

    public function setEmployerName($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType("employerName", $val, "non-numeric string", false);
        if (is_string($val)) {
            $this->validateFormat("employerName", $val, "/^[A-Za-z0-9].{1,253}$/", false);
        }
        return $this->_setAttribute("employerName", $val);
    }

    public function setConsultsAdvisor($val)
    {
        $val = $this->cleanBooleanValue($val);
        $this->validateType("consultsAdvisor", $val, "boolean", false);
        return $this->_setAttribute("consultsAdvisor", $val);
    }

    public function setConsultsAccountant($val)
    {
        $val = $this->cleanBooleanValue($val);
        $this->validateType("consultsAccountant", $val, "boolean", false);
        return $this->_setAttribute("consultsAccountant", $val);
    }

    public function setInvestmentProfile($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateAmong("investmentProfile", $val, self::getValidInvestmentProfiles(), false);
        return $this->_setAttribute("investmentProfile", $val);
    }

    public function setRiskTolerance($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateAmong("riskTolerance", $val, self::getValidRiskTolerances(), false);
        return $this->_setAttribute("riskTolerance", $val);
    }


    public function setOAuthTokens(\CFX\JsonApi\ResourceCollectionInterface $tokens=null) {
        if ($this->validateReadOnly('oAuthTokens', $tokens)) {
            $this->_setRelationship('oAuthTokens', $tokens);
        }
        return $this;
    }

    public function setPersonEntity(LegalEntityInterface $entity = null)
    {
        if ($this->validateReadOnly('personEntity', $entity)) {
            $this->_setRelationship('personEntity', $entity);
        }
        return $this;
    }

    protected function serializeAttribute($name)
    {
        if ($name === "selfAccredited") {
            if (is_bool($this->getSelfAccredited())) {
                return (int)$this->getSelfAccredited();
            }
        }
        return parent::serializeAttribute($name);
    }

    protected function _setYearsExp(string $type, $val)
    {
        if (!in_array($type, [ "alts", "reits", "stocks", "lp" ], true)) {
            throw new \RuntimeException("Unrecognized value '$type' for years of experience");
        }
        $field = "yearsExp".ucfirst($type);
        $val = $this->cleanNumberValue($val);
        if ($this->validateType($field, $val, "int", false) && $val !== null) {
            if ($val < 0 || $val > 100) {
                $this->setError($field, "range", [
                    "title" => "Out of Range",
                    "detail" => "Years of experience must be between 0 and 100"
                ]);
            } else {
                $this->clearError($field, "range");
            }
        }
        return $this->_setAttribute($field, $val);
    }
}


