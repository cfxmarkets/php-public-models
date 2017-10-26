<?php

namespace CFX\Brokerage;


class Document extends CFX\JsonApi\AbstractResource implements CFX\Brokerage\DocumentInterface{

	protected static $resourceType = 'documents';
	protected static $attributes = [
		'type' => null,
		'url' => null,
	];

	protected static $validTypes =['',''];



	public function getType() { return $this->attributes['type']; }
	public function setUrl() { return $this->attributes['url']; }


	public function setType($val){
		if($val && $this->attributes['type'] == $val) return;
		$this->attributes['type'] = $val; 

		if(!$val){
			$this->setError('url', 'required', $this->getFactory()->newError([
				'status' => 400,
				'title' => 'Missing value for attribute `url`',
				'details' => 'You must send a value for attribute `url`.'
			]));
		} else {
			$this->clearError('url', 'required');
		}

		return $this;
	}

    /*
    * 
    */

	public function setUrl($val){
		if($val && $this->attribute['url'] == $val) return;
		$this->attribute['url'] = $val;

		if(!$val){
			$this->setError('url', 'required', $this->getFactory()->newError([
				'status' => 400,
				'title' => 'Missing value for attribute `url`',
				'details' => 'You must send a value for attribute `url`.'
			]));
		} else {
			$this->clearError('url', 'required');

			if(!preg_match("/^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/", $this->getUrl())){ // to validate the data set is a url/link address
				$this->setError('url', 'valid', $this->getFactory()->newError([
					'status' => 400,
					'title' => 'Invalid `url',
					'details' => 'You must send a valid value for attribute `url`. It should be in the following format, ex: [`http://www.url.com`] or [`https://www.url.com`].'
				]));

			} else{
				$this->clearError('url', 'valid');
			}
		}

		return $this;

	}


}






















