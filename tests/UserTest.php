<?php

namespace CFX\Brokerage\Tests;



class UserTest extends \PHPUnit\Framework\TestCase {



	public function setupBeforeTest(){

	}



// Set Email

	public function testUserSetEmailSetsErrorOnNullValue(){
		$this->markTestIncomplete();		
	}

	public function testUserSetEmailSetsErrorOnNonVaildInput(){
		$this->markTestIncomplete();		
	}

	public function testUserSetEmailSuccessOnVaildInput(){
		$this->markTestIncomplete();		
	}



// Set Phone Number

	public function testUserSetPhoneNumberSetsErrorOnNullValue(){
		$this->markTestIncomplete();		
	}

	public function testUserSetPhoneNumberSetsErrorOnNonVaildInput(){
		$this->markTestIncomplete();		
	}

	public function testUserSetPhoneNumberSuccessOnVaildInput(){
		$this->markTestIncomplete();		
	}



// Set Display Name

	public function testUserSetDisplayNameSetsErrorOnNullValue(){
		$this->markTestIncomplete();		
	}

	public function testUserSetDisplayNameSuccessOnValidInput(){
		$this->markTestIncomplete();		
	}



/**
* 
*  Relationships 
* 
*/


// Set Legal Entity

	public function testSetLegalEntitySetsErrorOnNullValueIfNoLegalEntitySpecified(){ // Is It done behind the scenes, or are they allowed to change that ?
		$this->markTestIncomplete();		
	}

	public function testSetLegalEntitySetsErrorOnNotFoundLegalEntityInput(){
		$this->markTestIncomplete();
	}

	public function testSetLegalEntitySuccessOnValidInput(){
		$this->markTestIncomplete();
	}





}






















