<?php
namespace CFX;

trait ResourceTestTrait {
    protected $datasource;
    protected $resource;

    public function setUp()
    {
        $this->datasource = new \CFX\JsonApi\Test\MockDatasource();
        $class = $this->className;
        if (!$class) {
            throw new \RuntimeException(
                "Programmer: you need to provide the name of the class you're testing by setting the ".
                "`protected \$className` property on your test class. (Remember to use the FULLY-QUALIFIED ".
                "class name, including the namespace.)"
            );
        }
        $this->resource = new $class($this->datasource);
    }

    protected function assertInstantiatesValidly($field)
    {
        $this->assertFalse($this->resource->hasErrors($field), "Field `$field` should have been valid on instantiate, but contains errors:\n\n".json_encode($this->resource->getErrors($field), JSON_PRETTY_PRINT));
    }

    protected function assertInstantiatesInvalidly(string $field, string $contains)
    {
        $this->assertTrue($this->resource->hasErrors($field), "Field `$field` should have been invalid on instantiate, but is valid.");
        if ($contains) {
            $this->assertContains($contains, json_encode($this->resource->getErrors($field)), "Errors for field `$field` on instantiate should contain '$contains', but don't.");
        }
    }

    protected function assertInvalid($field, $invalids, $assertSame = null)
    {
        foreach ($invalids as $val) {
            $this->assertErrors($field, $val, true, $assertSame);
        }
    }

    protected function assertValid($field, $valids, $assertSame = null)
    {
        foreach ($valids as $val) {
            $this->assertErrors($field, $val, false, $assertSame);
        }
    }

    protected function assertErrors($field, $val, $has, $assertSame = null)
    {
        $set = 'set'.ucfirst($field);
        $get = 'get'.ucfirst($field);

        if (gettype($val) !== 'object') {
            if (is_bool($val)) {
                $displayVal = 'bool(`'.($val ? "true": "false").'`)';
            } elseif ($val === null) {
                $displayVal = 'null';
            } elseif (is_array($val)) {
                $displayVal = 'array('.count($val).')';
            } else {
                $displayVal = gettype($val)."(`$val`)";
            }
        } else {
            $displayVal = get_class($val);
        }

        $this->resource->$set($val);
        if ($has) {
            $this->assertTrue($this->resource->hasErrors($field), "Value $displayVal for field `$field` should have produced errors, but didn't.");
        } else {
            $this->assertFalse($this->resource->hasErrors($field), "Value $displayVal for field `$field` shouldn't have produced errors, but did.");
        }

        if ($assertSame) {
            $assertSame($val, $this->resource->$get());
        } else {
            $this->assertEquals($val, $this->resource->$get());
        }
    }

    protected function assertChanged($field, $val, $type, \Closure $assertSame = null)
    {
        $set = 'set'.ucfirst($field);
        $get = 'get'.ucfirst($field);

        if (!in_array($type, ['attributes','relationships'], true)) {
            throw new \RuntimeException("`\$type` must be either `attributes` or `relationships`");
        }

        $this->resource->$set($val);
        $changes = $this->resource->getChanges();
        $this->assertTrue(array_key_exists($type, $changes), "You expected there to be changes to one or more $type, but there are none.");
        $this->assertNotNull($changes[$type], "You expected there to be changes to one or more $type, but there are none.");
        $this->assertContains($field, array_keys($changes[$type]));
        if ($assertSame) {
            $assertSame($val, $this->resource->$get());
        } else {
            $change = $this->resource->$get();
            if ($change instanceof \CFX\JsonApi\RelationshipInterface) {
                $change = $change->getData();
            }
            $this->assertSame($val, $change);
        }
    }

    protected function assertChains($field)
    {
        $set = 'set'.ucfirst($field);
        $this->assertSame($this->resource, $this->resource->$set(null), "Method `$this->className::$set` should return the resource object for method chaining.");
    }

    protected function assertReadOnly($field, $val = "test")
    {
        $set = 'set'.ucfirst($field);
        $this->resource->$set($val);
        $errorTypes = array_keys($this->resource->getErrors($field));
        $this->assertContains("readonly", $errorTypes, "Setting readonly field `$this->className::$field` should result in a readonly error on that field.");
    }

    /**
     * Asserts that when a date field is serialized, it is serialized in a way
     * that MySQL will correctly interpret
     */
    public function assertSerializesDateForSql($field)
    {
        $set = "set".ucfirst($field);
        $date = new \DateTime();
        $this->resource->$set($date);
        $changes = $this->resource->getChanges();
        $this->assertContains('attributes', array_keys($changes));
        $this->assertContains($field, array_keys($changes['attributes']));
        $this->assertEquals($date->format("Y-m-d H:i:s"), $changes['attributes'][$field]);
    }

    /**
     * Tests a standard date field
     *
     * Since date values are always the same, this test can be run on any field that
     * accepts a standard date value to make testing simpler.
     *
     * @param string $field The name of the field to test
     * @return void
     */
    protected function _testDateField(string $field, bool $required): void
    {
        $valid = [ 0, '0', 1234567890, -12345566828, '12345', new \DateTime() ];
        $invalid = [ '0000-00-00 00:00:00', true, false, (object)[], [], 'this is not a date' ];
        $null = [ null, '' ];
        if (!$required) {
            $valid += $null;
        } else {
            $invalid += $null;
        }

        $this->assertValid($field, $valid, function($expected, $actual) use ($required, $null) {
            if (in_array($expected, $null, true)) {
                $expected = null;
            }

            if (!$required && $actual === null) {
                return;
            }

            if (is_numeric($expected)) {
                $exp = new \DateTime("@".$expected);
            } else {
                $exp = $expected;
            }
            $this->assertInstanceOf('\\DateTime', $actual);
            $this->assertEquals($exp->format('YmdHis'), $actual->format('YmdHis'));
        });
        $this->assertInvalid($field, $invalid);
        $this->assertChanged($field, 55522233, "attributes", function($expected, $actual) {
            if (is_numeric($expected)) {
                $exp = new \DateTime("@".$expected);
            } else {
                $exp = $expected;
            }

            if (!is_string($actual)) {
                if (is_object($actual) && get_class($actual) === 'DateTime') {
                    $actual = $actual->format("Y-m-d H:i:s");
                } else {
                    $type = gettype($actual);
                    if ($type === 'object') {
                        $type .= "(".get_class($actual).")";
                    }
                    throw new \RuntimeException("Don't know how to check for equality on values of type `$type`.");
                }
            }
            $this->assertEquals($exp->format('Y-m-d H:i:s'), $actual);
        });
        $this->assertChains($field, 332233322);
    }
}

