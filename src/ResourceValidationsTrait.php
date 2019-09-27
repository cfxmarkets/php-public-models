<?php
namespace CFX;

/**
 * A trait to provide frequently-used validations and value-handling functions for
 * Resource classes
 */
trait ResourceValidationsTrait {
    /**
     * Validates that the value for a given field is of the specified type
     *
     * @param string $field The name of the field (attribute or relationship) being validated
     * @param mixed $val The value to validate
     * @param string $type The type that the value should be
     * @param bool $required Whether or not the value is required (this affects how `null` is handled)
     * @return bool Whether or not the validation has passed
     */
    protected function validateType($field, $val, $type, $required = true)
    {
        if ($val !== null) {
            if ($type === 'string') {
                $result = is_string($val);
            } elseif ($type === 'non-numeric string') {
                $result = is_string($val) && !is_numeric($val);
            } elseif ($type === 'int' || $type === 'integer') {
                $result = is_int($val);
            } elseif ($type === "numeric") {
                $result = is_numeric($val);
            } elseif ($type === 'non-string numeric') {
                $result = !is_string($val) && is_numeric($val);
            } elseif ($type === 'string or int') {
                $result = is_string($val) || is_int($val);
            } elseif ($type === 'boolean' || $type === 'bool') {
                $result = is_bool($val);
            } elseif ($type === 'datetime') {
                $result = ($val instanceof \DateTime);
            } elseif ($type === 'email') {
                $result = is_string($val) && preg_match($this->getKnownFormat("email"), $val);
            } elseif ($type === 'uri') {
                $result = is_string($val) && preg_match($this->getKnownFormat("uri"), $val);
            } elseif ($type === 'url') {
                $result = is_string($val) && preg_match($this->getKnownFormat("url"), $val) && $val !== "";
            } else {
                throw new \RuntimeException("Programmer: Don't know how to validate for type `$type`!");
            }
        } else {
            $result = !$required;
        }

        if ($result) {
            $this->clearError($field, 'validType');
            return true;
        } else {
            $this->setError($field, 'validType', [
                "title" => "Invalid Value for Field `$field`",
                "detail" => "Field `$field` must be a(n) $type value."
            ]);
            return false;
        }
    }


    /**
     * Validates that the value for a given field is of the specified format
     *
     * @param string $field The name of the field (attribute or relationship) being validated
     * @param mixed $val The value to validate
     * @param string $format Either a named format or regexp string
     * @param bool $required Whether or not the value is required (this affects how `null` is handled)
     * @return bool Whether or not the validation has passed
     */
    protected function validateFormat($field, ?string $val, $format, $required = true)
    {
        if ($val !== null) {
            $regexp = $this->getKnownFormat($format);
            if (!$regexp) {
                $regexp = $format;
            }
            $result = preg_match($regexp, $val);
        } else {
            $result = !$required;
        }

        if ($result) {
            $this->clearError($field, 'validFormat');
            return true;
        } else {
            $error = [
                "title" => "Invalid Format for Field `$field`",
                "detail" => "Value for field `$field` must be a(n) $format."
            ];
            if ($format === $regexp) {
                $error["detail"] = "Value for field `$field` must match $format.";
            }
            $this->setError($field, 'validFormat', $error);
            return false;
        }
    }



    /**
     * Validates that the value for a given field is in the given array of valid options
     *
     * @param string $field The name of the field (attribute or relationship) being validated
     * @param mixed $val The value to validate
     * @param array $validOptions The collection of valid options among which the value should be found
     * @param bool $required Whether or not the value is required (this affects how `null` is handled)
     * @return bool Whether or not the validation has passed
     */
    protected function validateAmong($field, $val, array $validOptions, $required = true)
    {
        if ($val !== null) {
            $result = in_array($val, $validOptions, true);
        } else {
            $result = !$required;
        }

        if ($result) {
            $this->clearError($field, 'validAmongOptions');
            return true;
        } else {
            $this->setError($field, 'validAmongOptions', [
                "title" => "Invalid Value for Field `$field`",
                "detail" => "Field `$field` must be one of the accepted options: `".implode("`, `", $validOptions)."`"
            ]);
            return false;
        }
    }

    /**
     * Validates that the value for a given field is numeric (either float, int, or numeric string)
     *
     * @param string $field The name of the field (attribute or relationship) being validated
     * @param mixed $val The value to validate
     * @param bool $required Whether or not the value is required (this affects how `null` is handled)
     * @return bool Whether or not the validation has passed
     */
    protected function validateNumeric($field, $val, $required = true)
    {
        if ($val !== null) {
            $result = is_numeric($val);
        } else {
            $result = !$required;
        }

        if ($result) {
            $this->clearError($field, 'numeric');
            return true;
        } else {
            $this->setError($field, 'numeric', [
                "title" => "Invalid Attribute Value for `$field`",
                "detail" => "The quanity you indicate for this value must be numeric"
            ]);
            return false;
        }
    }

    /**
     * Validates that the given value conforms to the given length specifications
     *
     * @param string $field The name of the field being validated
     * @param string|null $val The value being evaluated
     * @param int $min The minimum length of the string (defaults to 0)
     * @param int $max The maximum length of the string
     * @param bool $required Whether or not the value is required
     * @return bool Whether or not the validation has passed
     */
    protected function validateStrlen(string $field, ?string $val, int $min, int $max, bool $required = true)
    {
        if ($val !== null) {
            $strlen = strlen($val);
            $result = !($strlen < $min || $strlen > $max);
        } else {
            $result = !$required;
        }

        if ($result) {
            $this->clearError($field, "length");
        } else {
            $this->setError($field, "length", [
                "title" => "Length of `$field` Out of Bounds",
                "detail" => "Field `$field` must be between $min and $max characters long."
            ]);
        }
        return $result;
    }

    /**
     * Validates that the given resource actually exists in the database
     *
     * @param string $field The name of the field (attribute or relationship) being validated
     * @param \CFX\JsonApi\ResourceInterface $r The resource to validate
     * @param bool $required Whether or not the resource is required (this affects how `null` is handled)
     * @return bool Whether or not the validation has passed
     */
    protected function validateRelatedResourceExists($field, \CFX\JsonApi\ResourceInterface $r, $required = true)
    {
        if ($r !== null) {
            try {
                $r->initialize();
                $result = true;
            } catch (ResourceNotFoundException $e) {
                $result = false;
            }
        } else {
            $result = !$required;
        }

        if ($result) {
            $this->clearError($field, 'exists');
            return true;
        } else {
            $this->setError($field, 'exists', [
                "title" => "Invalid Relationship `$field`",
                "detail" => "The `$field` you've indicated for this order is not currently in our system."
            ]);
            return false;
        }
    }

    /**
     * Validates that the given value has not been changed since the first time it was set
     *
     * @param string $field The name of the field (attribute or relationship) being validated
     * @param mixed $val The value to validate
     * @param bool $required Whether or not the resource is required (this affects how `null` is handled)
     * @return bool Whether or not the validation has passed
     */
    protected function validateImmutable($field, $val, $required = true)
    {
        if ($this->getInitial($field) !== null && $this->valueDiffersFromInitial($field, $val)) {
            $this->setError($field, 'immutable', [
                "title" => "`$field` is Immutable",
                "detail" => "You can't change the `$field` field of this resource once it's been set.",
            ]);
            return false;
        } else {
            $this->clearError($field, 'immutable');
            return true;
        }
    }

    /**
     * Cleans a value that is expected to be a string
     *
     * If the value _is_ a string, this trims it and sets it to null if it's an empty string. If the value
     * is an integer, it coerces it into a string. Otherwise, it leaves the value alone.
     *
     * @param mixed $val The value to clean
     * @return mixed The cleaned string or null or the original value, if not stringish
     */
    protected function cleanStringValue($val)
    {
        if ($val !== null) {
            if (is_string($val)) {
                $val = trim($val);
                if ($val === '') {
                    $val = null;
                }
            } elseif (is_int($val)) {
                $val = (string)$val;
            }
        }
        return $val;
    }

    /**
     * Cleans a value that is expected to be a boolean
     *
     * If the value is a string or integer that can evaluate to a boolean, this coerces it into a boolean. Otherwise,
     * it leaves the value alone.
     *
     * @param mixed $val The value to clean
     * @return mixed A boolean value or the original value, if not boolish
     */
    protected function cleanBooleanValue($val)
    {
        if ($val !== null) {
            if ($val === 1 || $val === '1' || $val === 0 || $val === '0') {
                $val = (bool)$val;
            } elseif (is_string($val) && trim($val) === '') {
                $val = null;
            }
        }
        return $val;
    }

    /**
     * Cleans a value that is expected to be a number
     *
     * If the value is a string, this coerces it into an int or float by multiplying by 1. Otherwise,
     * it leaves the value alone.
     *
     * @param mixed $val The value to clean
     * @return mixed An int or float value or the original value, if not numeric
     */
    protected function cleanNumberValue($val)
    {
        if ($val !== null) {
            if (is_string($val)) {
                if (trim($val) === '') {
                    $val = null;
                } elseif (is_numeric($val)) {
                    $val = $val*1;
                }
            }
        }
        return $val;
    }

    /**
     * Attempts to convert an integer or string into a DateTime object
     *
     * @param mixed $val The value to clean
     * @return mixed A DateTime object or the original value, if not coercible
     */
    protected function cleanDateTimeValue($val)
    {
        // Uninterpretable values get returned as is
        if ((is_string($val) && substr($val, 0, 4) === '0000') || $val === false) {
            return $val;
        }

        // null and null-equivalent get returned as null
        if ($val === '' || $val === null) {
            return null;
        }

        // For everything else, we try to make a date out of it
        try {
            if (is_numeric($val)) {
                $val = new \DateTime("@".$val);
            } else {
                $val = new \DateTime($val);
            }
            return $val;
        } catch (\Throwable $e) {
            return $val;
        }
    }

    /**
     * Returns a list of known formats for validation
     *
     * @param string $formatName The name of the format to get
     * @return string|null The regexp string representing the requested format, or null if format is not known
     */
    protected function getKnownFormat(string $formatName)
    {
        $knownFormats = [
            "email" => "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,}$/ix",
            "swiftCode" => "/^[A-Za-z]{6}[A-Za-z0-9]{2}[0-9A-Za-z]{0,3}$/",
            "uri" => "/^\w+:(\/\/)?[^\s]+$/",
            "url" => "/^((\w+:)?\/\/[^\s\/]+)?(\/[^\s]+)*\/?$/",
        ];

        if (array_key_exists($formatName, $knownFormats)) {
            return $knownFormats[$formatName];
        } else {
            return null;
        }
    }
}


