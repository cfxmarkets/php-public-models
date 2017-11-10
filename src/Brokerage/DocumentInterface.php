<?php
namespace CFX\Brokerage;

interface DocumentInterface extends \CFX\JsonApi\ResourceInterface
{
    public function getLabel();
	public function getType();
	public function getUrl();
    public function getStatus();
    public function getNotes();
    public function getLegalEntity();
    public function getOrderIntent();

    public function setLabel($val);
	public function setType($val);
	public function setUrl($val);
    public function setStatus($val);
    public function setNotes($val);
    public function setLegalEntity(LegalEntityInterface $val = null);
    public function setOrderIntent(OrderIntentInterface $val = null);
}
