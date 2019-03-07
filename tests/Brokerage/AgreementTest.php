<?php
namespace CFX\Brokerage;

class AgreementTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\Agreement";

    public function testResourceType()
    {
        $this->assertEquals("agreements", $this->resource->getResourceType());
    }

    public function testTimestamp()
    {
        $field = "timestamp";
        $this->assertInstantiatesValidly($field);
    }

    public function testContract()
    {
        $field = "contract";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ new Contract($this->datasource) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, (new Contract($this->datasource))->setId("abcde12345"), "relationships");
        $this->assertChains($field);

        $this->assertImmutableRelationship(
            $field,
            $this->getFakeExistingResource(),
            (new Contract($this->datasource))->setId("aaaaaaaa")
        );
    }

    public function testEntity()
    {
        $field = "entity";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ new LegalEntity($this->datasource) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, (new LegalEntity($this->datasource))->setId("abcde12345"), "relationships");
        $this->assertChains($field);

        $this->assertImmutableRelationship(
            $field,
            $this->getFakeExistingResource(),
            (new Contract($this->datasource))->setId("aaaaaaaa")
        );
    }

    public function testSigner()
    {
        $field = "signer";
        $this->assertInstantiatesInvalidly($field, "required");
        $this->assertValid($field, [ new User($this->datasource) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, (new User($this->datasource))->setId("abcde12345"), "relationships");
        $this->assertChains($field);

        $this->assertImmutableRelationship(
            $field,
            $this->getFakeExistingResource(),
            (new Contract($this->datasource))->setId("aaaaaaaa")
        );
    }

    protected function getFakeExistingResource(array $data = [])
    {
        $data = array_replace_recursive([
            "id" => "abcde12345",
            "type" => "agreements",
            "attributes" => [
                "timestamp" => "2019-03-01 08:00:00",
            ],
            "relationships" => [
                "contract" => [
                    "data" => [
                        "type" => "contracts",
                        "id" => "11111111",
                    ]
                ],
                "entity" => [
                    "data" => [
                        "type" => "legal-entities",
                        "id" => "2222222",
                    ]
                ],
                "signer" => [
                    "data" => [
                        "type" => "users",
                        "id" => "33333333",
                    ]
                ],
            ],
        ], $data);

        return $this->datasource
            ->addClassToCreate("\\CFX\\Brokerage\\Agreement")
            ->addClassToCreate("\\CFX\\Brokerage\\Contract")
            ->addClassToCreate("\\CFX\\Brokerage\\LegalEntity")
            ->addClassToCreate("\\CFX\\Brokerage\\User")
            ->setCurrentData($data)
            ->get("id=abcde12345")
        ;
    }
}


