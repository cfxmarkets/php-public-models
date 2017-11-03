<?php 
namespace CFX\Brokerage;

class DocumentTest extends \PHPUnit\Framework\TestCase
{
    protected $datasource;
    protected $document;

    public function setUp() {
        $this->datasource = new \CFX\JsonApi\Test\MockDatasource();
        $this->document = new Document($this->datasource);
    }

    public function testResourceType() {
        $this->assertEquals('documents', $this->document->getResourceType());
    }

    public function testLabel() {
        // Assert field required
        $this->assertTrue($this->document->hasErrors('label'));

        $val = "My Document";
        $this->document->setLabel($val);
        $this->assertFalse($this->document->hasErrors('label'));
        $this->assertEquals($val, $this->document->getLabel());
    }

    public function testType() {
        // Assert required
        $this->assertTrue($this->document->hasErrors('type'));

        // Assert required again
        $val = "";
        $this->document->setType($val);
        $this->assertTrue($this->document->hasErrors('type'));
        $this->assertEquals($val, $this->document->getType());

        // Throws errors for bad type
        $val = "bunk";
        $this->document->setType($val);
        $this->assertTrue($this->document->hasErrors('type'));
        $this->assertEquals($val, $this->document->getType());

        // No errors for good types
        foreach(Document::getValidTypes() as $t) {
            $this->document->setType($t);
            $this->assertFalse($this->document->hasErrors('type'));
            $this->assertEquals($t, $this->document->getType());
        }
    }

    public function testUrl() {
        // Assert required
        $this->assertTrue($this->document->hasErrors('url'));

        // Assert required again
        $val = "";
        $this->document->setUrl($val);
        $this->assertTrue($this->document->hasErrors('url'));
        $this->assertEquals($val, $this->document->getUrl());

        // Errors for bad input
        $val = "bunk";
        $this->document->setUrl($val);
        $this->assertTrue($this->document->hasErrors('url'));
        $this->assertEquals($val, $this->document->getUrl());

        // No errors for good input
        $val = "/valid/absolute/path.pdf";
        $this->document->setUrl($val);
        $this->assertFalse($this->document->hasErrors('url'));
        $this->assertEquals($val, $this->document->getUrl());

        $val = "https://somehost.com/valid/absolute/path.jpg";
        $this->document->setUrl($val);
        $this->assertFalse($this->document->hasErrors('url'));
        $this->assertEquals($val, $this->document->getUrl());
    }

    public function testStatus() {
        // Default is fine
        $this->assertFalse($this->document->hasErrors('status'));

        // Assert Readonly
        $this->document->setStatus('approved');
        $this->assertTrue($this->document->hasErrors('status'));
        $this->assertEquals('approved', $this->document->getStatus());
        $this->document->setStatus(null);
        $this->assertFalse($this->document->hasErrors('status'));
        $this->assertNull($this->document->getStatus());
    }

    public function testNotes() {
        // Assert not required
        $this->assertFalse($this->document->hasErrors('notes'));

        // Assert not required again
        $val = "";
        $this->document->setNotes($val);
        $this->assertFalse($this->document->hasErrors('notes'));
        $this->assertEquals($val, $this->document->getNotes());

        $val = new \DateTime();
        $this->document->setNotes($val);
        $this->assertTrue($this->document->hasErrors('notes'));

        $val = "These are some notes";
        $this->document->setNotes($val);
        $this->assertFalse($this->document->hasErrors('notes'));
        $this->assertEquals($val, $this->document->getNotes());
    }

    public function testIntegration() {
        $data = [
            "type" => "documents",
            "attributes" => [
                "label" => "My Document",
                "type" => Document::getValidTypes()[0],
                "url" => "/our-server/doc.pdf",
                "notes" => "Here's a quick note about the doc.",
            ],
        ];

        $document = new Document($this->datasource, $data);
        $this->assertFalse($document->hasErrors());
        $this->assertEquals($data, $document->getChanges());
    }

    public function testMethodChaining() {
        $json = $this->document
            ->setLabel('My Document')
            ->setType(Document::getValidTypes()[0])
            ->setUrl("/our-server/doc.pdf")
            ->setNotes('Some notes')
            ->jsonSerialize();

        $this->assertEquals('Some notes', $json['attributes']['notes']);
    }
}

