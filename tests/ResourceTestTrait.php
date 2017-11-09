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

    protected function assertChanged($field, $val, $type, $assertSame = null)
    {
        $set = 'set'.ucfirst($field);

        if (!in_array($type, ['attributes','relationships'])) {
            throw new \RuntimeException("`\$type` must be either `attributes` or `relationships`");
        }

        $this->resource->$set($val);
        $changes = $this->resource->getChanges();
        $this->assertNotNull($changes[$type]);
        $this->assertContains($field, array_keys($changes[$type]));
        if ($assertSame) {
            $assertSame($val, $changes[$type][$field]);
        } else {
            $change = $changes[$type][$field];
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

    protected function assertReadonly($field, $val = "test")
    {
        $set = 'set'.ucfirst($field);
        $this->resource->$set($val);
        $errorTypes = array_keys($this->resource->getErrors($field));
        $this->assertContains("readonly", $errorTypes, "Setting readonly field `$this->className::$field` should result in a readonly error on that field.");
    }
}

