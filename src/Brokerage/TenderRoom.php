<?php
namespace CFX\Brokerage;

class TenderRoom extends DealRoom implements TenderRoomInterface
{
    use TenderRoomTrait;

    protected $resourceType = 'tender-rooms';

    public function __construct(\CFX\JsonApi\DatasourceInterface $datasource, array $data = null)
    {
        $this->relationships['purchaser'] = null;
        $this->attributes['purchaserName'] = null;
        $this->relationships['tenders'] = null;
        parent::__construct($datasource, $data);
    }
}

