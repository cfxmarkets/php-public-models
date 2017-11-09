<?php
namespace CFX;

trait ResourceValidationsTrait {
    protected function validateType($field, $val, $type)
    {
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

    protected function validateAmong($field, $val, array $validOptions)
    {
        if (!in_array($val, $validOptions)) {
            $this->setError($field, 'validAmongOptions', [
                "title" => "Invalid Value for Field `$field`",
                "detail" => "Field `$field` must be one of the accepted options: `".implode("`, `", $validOptions)."`"
            ]);
            return false;
        } else {
            $this->clearError($field, 'validAmongOptions');
            return true;
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
}

