<?php
namespace CFX\Brokerage;

interface AddressInterface extends \CFX\JsonApi\ResourceInterface {
 	public function getLabel();
    public function getStreet1();
    public function getStreet2();
    public function getCity();
    public function getState();
    public function getZip();
    public function getCountry();
    public function getMeta();



    public function setLabel($val);
	public function setStreet1($val);
    public function setStreet2($val);
    public function setCity($val);
    public function setState($val);
    public function setZip($val);
    public function setCountry($val);
    public function setMeta($val);
}
