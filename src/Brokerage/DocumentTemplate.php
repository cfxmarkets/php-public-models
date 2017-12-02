<?php
namespace CFX\Brokerage;

class DocumentTemplate extends \CFX\JsonApi\AbstractResource implements DocumentTemplateInterface
{
    use \CFX\ResourceValidationsTrait;

    protected $resourceType = 'document-templates';
    protected $attributes = [
        'url' => null,
        'status' => 'new',
    ];

    public static function getValidStatuses()
    {
        return [
            'new',
            'reviewing',
            'approved',
            'rejected',
        ];
    }

    public function getUrl()
    {
        return $this->_getAttributeValue('url');
    }

    public function getStatus()
    {
        return $this->_getAttributeValue('status');
    }

    public function setUrl($val)
    {
        $val = $this->cleanStringValue($val);
        if ($this->validateRequired('url', $val)) {
            if ($this->validateType('url', $val, 'non-numeric string')) {
                if (!preg_match("/^(?:https?:\/\/[\w]+[\w._-]+)?\/.+$/", $val)) {
                    $this->setError('url', 'valid', [
                        'title' => 'Invalid URL',
                        'detail' => 'You must send a valid value for attribute `url`. It may be a relative or absolute url, something like `http://www.url.com/path/to/file.pdf`, `https://www.url.com/path/to/file`, or `/path/to/my/file.pdf`.'
                    ]);
                } else{
                    $this->clearError('url', 'valid');
                }
            }
        }
        return $this->_setAttribute('url', $val);
    }

    public function setStatus($val)
    {
        if ($this->validateReadOnly('status', $val)) {
            $this->_setAttribute('status', $val);
        }
        return $this;
    }
}

