<?php
namespace CFX;

trait ResourceValidationsTrait {
    protected function validateType($field, $val, $type, $required = true)
    {
        if ($val !== null) {
            if ($type === 'string') {
                $result = is_string($val);
            } elseif ($type === 'int' || $type === 'integer') {
                $result = is_int($val);
            } elseif ($type === 'string or int') {
                $result = is_string($val) || is_int($val);
            } elseif ($type === 'boolean' || $type === 'bool') {
                $result = is_bool($val);
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

    protected function validateAmong($field, $val, array $validOptions, $required = true)
    {
        if ($val !== null) {
            $result = in_array($val, $validOptions);
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

    protected function cleanBooleanValue($val)
    {
        if ($val !== null) {
            if ($val == 1 || $val === 0 || $val === '0') {
                $val = (bool)$val;
            }
        }
        return $val;
    }

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
}

