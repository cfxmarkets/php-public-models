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
            } elseif ($type === 'non-string numeric') {
                $result = !is_string($val) && is_numeric($val);
            } elseif ($type === 'string or int') {
                $result = is_string($val) || is_int($val);
            } elseif ($type === 'boolean' || $type === 'bool') {
                $result = is_bool($val);
            } elseif ($type === 'datetime') {
                $result = ($val instanceof \DateTime);
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
                "detail" => "Field `$field` must be a $type value."
            ]);
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
            if ($val == 1 || $val === 0 || $val === '0') {
                $val = (bool)$val;
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
        if (!$val) {
            return $val;
        }

        try {
            if (is_numeric($val)) {
                $val = new \DateTime("@".$val);
            } else {
                $val = new \DateTime($val);
            }
            return $val;
        } catch (\Exception $e) {
            return $val;
        }
    }
}


