<?php
namespace CFX\Brokerage;

class LoginRequest extends \CFX\JsonApi\AbstractResource implements LoginRequestInterface
{
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'login-requests';
    protected $attributes = [
        'email' => null,
        'expiration' => null,
    ];

    public function getEmail()
    {
        return $this->_getAttributeValue('email');
    }

    public function getExpiration()
    {
        return $this->_getAttributeValue('expiration');
    }

    public function setEmail($val = null): LoginRequestInterface
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired('email', $val)) {
            if ($this->validateType('email', $val, 'string')) {
                if ($this->validateType('email', $val, 'email')) {
                    $this->validateImmutable('email', $val);
                }
            }
        }
        return $this->_setAttribute('email', $val);
    }

    protected function setExpiration($val = null): LoginRequestInterface
    {
        $val = $this->cleanDateTimeValue($val);
        if ($this->validateRequired('expiration', $val)) {
            $this->validateType('expiration', $val, 'datetime');
        }
        return $this->_setAttribute('expiration', $val);
    }

    protected function serializeAttribute($name) {
        if ($name === 'expiration') {
            $val = $this->attributes[$name];
            if ($val instanceof \DateTime) {
                $val = $val->format("U");
            }
            return $val;
        }

        return parent::serializeAttribute($name);
    }
}


