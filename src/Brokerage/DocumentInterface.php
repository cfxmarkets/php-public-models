<?php

namespace CFX\Brokerage;


interface DocumentInterface extends \CFX\JsponApi\ResourceInterface{


// Getters
	public function getType();
	public function getUrl();


// Setters
	public function setType($val);
	public function setUrl($val);

}