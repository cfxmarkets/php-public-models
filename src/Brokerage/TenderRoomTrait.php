<?php
namespace CFX\Brokerage;

trait TenderRoomTrait
{
    use \CFX\JsonApi\Rel2MTrait;

    public function getPurchaser()
    {
        return $this->_getRelationshipValue('purchaser');
    }

    public function getTenders()
    {
        if (!in_array('tenders', $this->initializedRelationships)) {
            $this->initialize2MRel('tenders');
        }
        return $this->_getRelationshipValue('tenders');
    }

    public function setPurchaser(LegalEntityInterface $val = null)
    {
        $this->validateRequired('purchaser', $val);
        return $this->_setRelationship('purchaser', $val);
    }

    public function setTenders(\CFX\JsonApi\ResourceCollectionInterface $val = null)
    {
        return $this->_setRelationship('tenders', $val);
    }

    public function addTender(TenderInterface $val = null)
    {
        return $this->add2MRel('tenders', $val);
    }

    public function hasTender(TenderInterface $val)
    {
        return $this->has2MRel('tenders', $val);
    }

    public function removeTender(TenderInterface $val)
    {
        return $this->remove2MRel('tenders', $val);
    }
}

