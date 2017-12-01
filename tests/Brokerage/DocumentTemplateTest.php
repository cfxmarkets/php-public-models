<?php
namespace CFX\Brokerage;

class DocumentTemplateTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\DocumentTemplate";

    public function testResourceType()
    {
        $this->assertEquals('document-templates', $this->resource->getResourceType());
    }

    public function testUrl()
    {
        $field = 'url';
        $this->assertValid($field, [ 'https://something.com/my/path/to/file.pdf', '/a/local/path/to/file.pdf', '/local/file/without/ext' ]);
        $this->assertInvalid($field, [ null, '', new \DateTime(), 0, 12345, true, false, 'custom:protocol/for/file.pdf' ]);
        $this->assertChanged($field, "/our/file.pdf", "attributes");
        $this->assertChains($field);
    }

    public function testStatus()
    {
        $field = 'status';
        $this->assertReadOnly($field);
        $this->assertChains($field);
    }
}

