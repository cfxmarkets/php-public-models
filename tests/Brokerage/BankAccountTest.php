<?php 

namespace CFX\Brokerage\Tests;


class BankAccountTest extends \PHPUnit\Framework\TestCase{


	public function setupBeforeClass(){
	}


// Set Bank Name

	public function testSetBankNameSetsErrorOnNullValue(){
		$this->markTestIncomplete();
	}

	public function testSetBankNameSetsErrorOnNonSringValue(){ // means to prevent sending numbers instead of string.
		$this->markTestIncomplete();
	}

	public function testSetBankNameSuccessOnValidInput(){
		$this->markTestIncomplete();
	}




// Set Type

	public function testSetTypeSetsErrorOnNullValue(){
		$this->markTestIncomplete();
	}

	public function testSetTypeSetsErrorOnNonValidValue(){
		$this->markTestIncomplete();
	}

	public function testSetTypeSuccessOnValidInput(){
		$this->markTestIncomplete();
	}




// Set Account Holder Name

	public function testSetAccountHolderNameSetsErrorOnNullValue(){
		$this->markTestIncomplete();
	}

	public function testSetAccountHolderNameSetsErrorOnNonStringValue(){ // means to prevent sending numbers instead of string.
		$this->markTestIncomplete();
	}

	public function testSetAccountHolderNameSuccessOnValidInput(){
		$this->markTestIncomplete();
	}




// Set Routing Number

	public function testSetRoutingNumberSetsErrorOnNullValue(){
		$this->markTestIncomplete();
	}

	public function testSetRoutingNumberSetsErrorOnNonNumericValue(){
		$this->markTestIncomplete();
	}

	public function testSetRoutingNumberSetsErrorOnNonValidValue(){ // to count  if the value it's less than zero.
		$this->markTestIncomplete();
	}

	public function testSetRoutingNumberSetsErrorOnInvalidInput(){ //Also, maybe it shoud equal to certain number.
		$this->markTestIncomplete();
	}

	public function testSetRoutingNumberSuccessOnValidInput(){
		$this->markTestIncomplete();
	}




// Set Account Number

	public function testSetAccountNumberSetsErrorOnNullValue(){
		$this->markTestIncomplete();
	}

	public function testSetAccountNumberSetsErrorOnNonNumericValue(){
		$this->markTestIncomplete();
	}

	public function testSetAccountNumberSetsErrorOnNonValidValue(){ // to count  if the value it's less than zero. 
		$this->markTestIncomplete();
	}

	public function testSetAccountNumberSetsErrorOnInvalidInput(){ //Also, maybe it shoud equal to certain number.
		$this->markTestIncomplete();
	}

	public function testSetAccountNumberSuccessOnValidInput(){
		$this->markTestIncomplete();
	}


}




















