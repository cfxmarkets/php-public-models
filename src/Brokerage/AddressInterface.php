<?php


namespace CFX\Brokerage;

interface AddressInterface extends \CFX\JsonApi\ResourceInterface {

 

 	public function getLabel();
    public function getStreetOne();
    public function getStreetTwo();
    public function getCity();
    public function getState();
    public function getZip();
    public function getCountry();



    public function setLabel($val);
	public function setStreetOne($val);
    public function setStreetTwo($val);
    public function setCity($val);
    public function setState($val);
    public function setZip($val);
    public function setCountry($val);
    

}