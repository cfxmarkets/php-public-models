<?php

namespace CFX\Brokerage;


class Document extends \CFX\JsonApi\AbstractResource implements DocumentInterface
{
	protected $resourceType = 'documents';

	protected $attributes = [
        'label' => null,
		'type' => null,
		'url' => null,
        'status' => null,
        'notes' => null,
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
        'id:person' => 'Photo ID',
        'id:ein' => 'Proof of EIN',
        'formation' => "Formation Document",
        'bylaws' => "Bylaws Document",
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



    public function setLabel($val)
    {
        $this->_setAttribute('label', $val);

        if ($val !== null && !is_string($val)) {
            $this->setError('label', 'format', [
                "title" => "Invalid Value for `label`",
                "detail" => "`label` must be a string."
            ]);
        } else {
            $this->clearError('label', 'format');
        }

        return $this;
    }

    public function setType($val)
    {
        $this->_setAttribute('type', $val);

        if ($this->validateRequired('type', $val)) {
            if (!in_array($val, array_keys(static::$validTypes))) {
                $this->setError('type', 'valid', [
                    "title" => "Invalid Value for `type`",
                    "detail" => "`type` must be one of the valid types, `".implode("`, `", array_keys(static::$validTypes))."`."
                ]);
            } else {
                $this->clearError('type', 'valid');
            }
        }

		return $this;
	}

    public function setUrl($val)
    {
        $this->_setAttribute('url', $val);

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

		return $this;
    }

    public function setStatus($val)
    {
        $this->validateReadOnly('status', $val);
        $this->_setAttribute('status', $val);
        return $this;
    }

    public function setNotes($val)
    {
        $this->_setAttribute('notes', $val);

        if ($val && !is_string($val)) {
            $this->setError('notes', 'valid', [
                "title" => "Invalid Value for `notes`",
                "detail" => "`notes` must be a string."
            ]);
        } else {
            $this->clearError('notes', 'valid');
        }

        return $this;
    }
}

