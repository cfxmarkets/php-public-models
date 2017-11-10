<?php

namespace CFX\Brokerage;


class Document extends \CFX\JsonApi\AbstractResource implements DocumentInterface
{
    use \CFX\ResourceValidationsTrait;

	protected $resourceType = 'documents';

	protected $attributes = [
        'label' => null,
		'type' => null,
		'url' => null,
        'status' => null,
        'notes' => null,
	];

    protected $relationships = [
        'legalEntity' => null,
        'orderIntent' => null,
    ];

    //
    // WARNING!!
    //
    // If either $validTypes or $validStatuses are ever changed, there must be logic
    // written into setters to translate the old values (coming from the database)
    // into the most applicable new value. This should presumably be done on database
    // migration, but may not be.
    //

    /**
     * @var string[] A list of valid document types
     */
    protected static $validTypes = [
        'id' => "Proof of Identity",
        'ownership' => "Proof of Ownership",
        'agreement' => "Signed Contract",
    ];



    public static function getValidTypes() {
        return static::$validTypes;
    }



    public function getLabel()
    {
        return $this->_getAttributeValue('label');
    }

    public function getType()
    {
        return $this->_getAttributeValue('type');
    }

    public function getUrl()
    {
        return $this->_getAttributeValue('url');
    }

    public function getStatus()
    {
        return $this->_getAttributeValue('status');
    }

    public function getNotes()
    {
        return $this->_getAttributeValue('notes');
    }

    public function getLegalEntity()
    {
        return $this->_getRelationshipValue('legalEntity');
    }

    public function getOrderIntent()
    {
        return $this->_getRelationshipValue('orderIntent');
    }



    public function setLabel($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType('label', $val, 'string', false);
        return $this->_setAttribute('label', $val);
    }

    public function setType($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired('type', $val)) {
            if ($this->validateType('type', $val, 'string')) {
                $this->validateAmong('type', $val, array_keys(static::$validTypes));
            }
        }

        $this->_setAttribute('type', $val);

        // Trigger re-validation for changes to type
        $this->setLegalEntity($this->getLegalEntity());
        $this->setOrderIntent($this->getOrderIntent());

        return $this;
	}

    public function setUrl($val)
    {
        $val = $this->cleanStringValue($val);

        if ($this->validateRequired('url', $val)) {
            if (!preg_match("/^(?:https?:\/\/[\w]+[\w.-_]+)?\/.+$/", $val)) {
				$this->setError('url', 'valid', [
					'title' => 'Invalid `url',
					'detail' => 'You must send a valid value for attribute `url`. It should be in the following format, ex: [`http://www.url.com`] or [`https://www.url.com`].'
				]);
			} else{
				$this->clearError('url', 'valid');
			}
		}

        return $this->_setAttribute('url', $val);
    }

    public function setStatus($val)
    {
        $this->validateReadOnly('status', $val);
        return $this->_setAttribute('status', $val);
    }

    public function setNotes($val)
    {
        $val = $this->cleanStringValue($val);
        $this->validateType('notes', $val, 'string', false);
        return $this->_setAttribute('notes', $val);
    }

    public function setLegalEntity(LegalEntityInterface $val = null)
    {
        if (!$this->hasErrors('type')) {
            if ($val) {
                $this->clearError('legalEntity', 'required');

                if ($this->getType() !== 'id') {
                    $this->setError("legalEntity", "invalidForType", [
                        "title" => "Illegal Entity",
                        "detail" => "Documents of type `{$this->getType()}` cannot have LegalEntities associated with them."
                    ]);
                } else {
                    $this->clearError('legalEntity', "invalidForType");
                }
            } else {
                if ($this->getType() === 'id') {
                    $this->setError("legalEntity", "required", [
                        "title" => "Field `legalEntity` Required",
                        "detail" => "Field `legalEntity` is required for documents of type `{$this->getType()}`",
                    ]);
                } else {
                    $this->clearError("legalEntity", "required");
                }
            }
        } else {
            $this->clearError('legalEntity');
        }

        return $this->_setRelationship('legalEntity', $val);
    }

    public function setOrderIntent(OrderIntentInterface $val = null)
    {
        if (!$this->hasErrors('type')) {
            if ($val) {
                $this->clearError('orderIntent', 'required');

                if (!in_array($this->getType(), [ 'agreement', 'ownership' ])) {
                    $this->setError("orderIntent", "invalidForType", [
                        "title" => "Illegal Order Intent",
                        "detail" => "Documents of type `{$this->getType()}` cannot have OrderIntents associated with them."
                    ]);
                } else {
                    $this->clearError('orderIntent', "invalidForType");
                }
            } else {
                if (in_array($this->getType(), [ 'agreement', 'ownership' ])) {
                    $this->setError("orderIntent", "required", [
                        "title" => "Field `orderIntent` Required",
                        "detail" => "Field `orderIntent` is required for documents of type `{$this->getType()}`",
                    ]);
                } else {
                    $this->clearError("orderIntent", "required");
                }
            }
        } else {
            $this->clearError('orderIntent');
        }

        return $this->_setRelationship('orderIntent', $val);
    }
}

