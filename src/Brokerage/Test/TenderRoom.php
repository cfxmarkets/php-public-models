<?php
namespace CFX\Brokerage\Test;

class TenderRoom extends \CFX\Brokerage\TenderRoom
{
    // Have to override this to make testing more sane. Should really refactor MockDatasource to handle to-many relationships better
    protected function initialize2MRel($name) {
        if ($name === 'tenders') {
            $collection = $this->datasource->newCollection();
        } else {
            $collection = $this->datasource->getRelated($name, $this->getId());
        }

        // Get any relationships that may have been added before the relationship was initialized
        $currentMembers = [];
        if ($this->relationships[$name] !== null && $this->relationships[$name]->getData()) {
            $currentMembers = $this->relationships[$name]->getData();
        }

        $this->trackChanges = false;
        $this->_setRelationship($name, $collection);
        $this->initializedRelationships[$name] = $name;
        $this->initialState['relationships'][$name] = $collection->summarize();
        $this->trackChanges = true;

        foreach($currentMembers as $rel) {
            $this->add2MRel($name, $rel);
        }
    }
}

