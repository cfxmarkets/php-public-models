<?php
namespace CFX\Brokerage;

class DealRoomTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\DealRoom";

    public function testResourceType()
    {
        $this->assertEquals('deal-rooms', $this->resource->getResourceType());
    }

    public function testTitle()
    {
        $field = 'title';
        $this->assertValid($field, [ "This is a title" ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime(), 111423 ]);
        $this->assertChanged($field, "New Title", "attributes");
        $this->assertChains($field);
    }

    public function testSlug()
    {
        $field = 'slug';
        $this->assertValid($field, [ "this-is-a-slug", "onewordslug" ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime(), 12345 ]);
        $this->assertChanged($field, "new-slug", "attributes");
        $this->assertChains($field);
    }

    public function testSummary()
    {
        $field = 'summary';
        $this->assertValid($field, [ "This is a deal room meant for dealing." ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime(), 12345 ]);
        $this->assertChanged($field, "This is a new summary", "attributes");
        $this->assertChains($field);
    }

    public function testBodyText()
    {
        $field = 'bodyText';
        $this->assertValid($field, [ "This is a longer description of a deal room" ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime(), 12345 ]);
        $this->assertChanged($field, "Nother description", "attributes");
        $this->assertChains($field);
    }

    public function testRestriction()
    {
        $field = 'restriction';
        $this->assertValid($field, [ "buy", "sell", null ]);
        $this->assertInvalid($field, [ 0, new \DateTime(), 12345, 'notincluded' ]);
        $this->assertChanged($field, "sell", "attributes");
        $this->assertChains($field, "buy");
    }

    public function testOpenDate()
    {
        $field = 'openDate';
        $this->_testDateField($field, true);
        $this->assertSerializesDateForSql($field);
    }

    public function testCloseDate()
    {
        $field = 'closeDate';
        $this->_testDateField($field, true);
        $this->assertSerializesDateForSql($field);
    }

    public function testAccess()
    {
        $field = 'access';
        $this->assertValid($field, [ "public", "private" ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime(), 12345, 'notincluded' ]);
        $this->assertChanged($field, "private", "attributes");
        $this->assertChains($field);
    }

    public function testAccessKey()
    {
        $field = 'accessKey';
        $this->assertReadOnly($field);
    }

    public function testAdmins()
    {
        $this->markTestIncomplete();
        $field = 'admins';
        $this->assertValid($field, [ "12345", 11111, 2222.51 ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime() ]);
        $this->assertChanged($field, 5522, "attributes");
        $this->assertChains($field);
    }

    public function testPartners()
    {
        $this->markTestIncomplete();
        $field = 'partners';
        $this->assertValid($field, [ "12345", 11111, 2222.51 ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime() ]);
        $this->assertChanged($field, 5522, "attributes");
        $this->assertChains($field);
    }

    public function testParticipants()
    {
        $this->markTestIncomplete();
        $field = 'participants';
        $this->assertValid($field, [ "12345", 11111, 2222.51 ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime() ]);
        $this->assertChanged($field, 5522, "attributes");
        $this->assertChains($field);
    }

    public function testOrders()
    {
        $this->markTestIncomplete();
        $field = 'orders';
        $this->assertValid($field, [ "12345", 11111, 2222.51 ]);
        $this->assertInvalid($field, [ null, '', 0, new \DateTime() ]);
        $this->assertChanged($field, 5522, "attributes");
        $this->assertChains($field);
    }

    public function testExchange()
    {
        $field = 'exchange';
        $this->assertValid($field, [ null ]);
        $this->assertChains($field, null);
    }
}



