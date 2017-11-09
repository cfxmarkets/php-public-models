<?php 
namespace CFX\Brokerage;

class DocumentTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\Document";

    public function testResourceType() {
        $this->assertEquals('documents', $this->resource->getResourceType());
    }

    public function testLabel() {
        $this->assertValid('label', [null, '', 'My Document']);
    }

    public function testType() {
        // Assert required
        $this->assertTrue($this->resource->hasErrors('type'));

        // Assert required again
        $val = "";
        $this->resource->setType($val);
        $this->assertTrue($this->resource->hasErrors('type'));
        $this->assertEquals($val, $this->resource->getType());

        // Throws errors for bad type
        $val = "bunk";
        $this->resource->setType($val);
        $this->assertTrue($this->resource->hasErrors('type'));
        $this->assertEquals($val, $this->resource->getType());

        // No errors for good types
        foreach(array_keys(Document::getValidTypes()) as $t) {
            $this->resource->setType($t);
            $this->assertFalse($this->resource->hasErrors('type'));
            $this->assertEquals($t, $this->resource->getType());
        }
    }

    public function testUrl() {
        // Assert required
        $this->assertTrue($this->resource->hasErrors('url'));

        // Assert required again
        $val = "";
        $this->resource->setUrl($val);
        $this->assertTrue($this->resource->hasErrors('url'));
        $this->assertEquals($val, $this->resource->getUrl());

        // Errors for bad input
        $val = "bunk";
        $this->resource->setUrl($val);
        $this->assertTrue($this->resource->hasErrors('url'));
        $this->assertEquals($val, $this->resource->getUrl());

        // No errors for good input
        $val = "/valid/absolute/path.pdf";
        $this->resource->setUrl($val);
        $this->assertFalse($this->resource->hasErrors('url'));
        $this->assertEquals($val, $this->resource->getUrl());

        $val = "https://somehost.com/valid/absolute/path.jpg";
        $this->resource->setUrl($val);
        $this->assertFalse($this->resource->hasErrors('url'));
        $this->assertEquals($val, $this->resource->getUrl());
    }

    public function testStatus() {
        // Default is fine
        $this->assertFalse($this->resource->hasErrors('status'));

        // Assert Readonly
        $this->resource->setStatus('approved');
        $this->assertTrue($this->resource->hasErrors('status'));
        $this->assertEquals('approved', $this->resource->getStatus());
        $this->resource->setStatus(null);
        $this->assertFalse($this->resource->hasErrors('status'));
        $this->assertNull($this->resource->getStatus());
    }

    public function testNotes() {
        // Assert not required
        $this->assertFalse($this->resource->hasErrors('notes'));

        // Assert not required again
        $val = "";
        $this->resource->setNotes($val);
        $this->assertFalse($this->resource->hasErrors('notes'));
        $this->assertEquals($val, $this->resource->getNotes());

        $val = new \DateTime();
        $this->resource->setNotes($val);
        $this->assertTrue($this->resource->hasErrors('notes'));

        $val = "These are some notes";
        $this->resource->setNotes($val);
        $this->assertFalse($this->resource->hasErrors('notes'));
        $this->assertEquals($val, $this->resource->getNotes());
    }

    public function testIntegration() {
        $data = [
            "type" => "documents",
            "attributes" => [
                "label" => "My Document",
                "type" => array_keys(Document::getValidTypes())[0],
                "url" => "/our-server/doc.pdf",
                "notes" => "Here's a quick note about the doc.",
            ],
        ];

        $document = new Document($this->datasource, $data);
        $this->assertFalse($document->hasErrors());
        $this->assertEquals($data, $document->getChanges());
    }

    public function testMethodChaining() {
        $json = $this->resource
            ->setLabel('My Document')
            ->setType(Document::getValidTypes()[0])
            ->setUrl("/our-server/doc.pdf")
            ->setNotes('Some notes')
            ->jsonSerialize();

        $this->assertEquals('Some notes', $json['attributes']['notes']);
    }
}

