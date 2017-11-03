<?php
namespace CFX\Brokerage;

interface DocumentInterface extends \CFX\JsonApi\ResourceInterface
{
    public function getLabel();
	public function getType();
	public function getUrl();
    public function getStatus();
    public function getNotes();

    public function setLabel($val);
	public function setType($val);
	public function setUrl($val);
    public function setStatus($val);
    public function setNotes($val);
}
