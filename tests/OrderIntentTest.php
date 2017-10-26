<?php

namespace CFX\Brokerage\Tests;

/**
 * Todo:
 * 
 * * Break into separate file for each class that you're testing
 * * Name files to correspond to classes, e.g., `AssetIntentTest.php`
 * 
 */


class OrderIntentTest extends \PHPUnit\Framework\TestCase {


	public function setupBeforeTest(){

	}


    /**
     * Add priceHigh and priceLow tests to make sure that priceHigh is always required
     * and priceLow is always optional
     */

	/**
	 * Should probably throw exception instead of return false
	 */
	public function testOrderIntentSetTypeShouldReturnFalseOnNonActiveStatus(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentSetTypeSetsErrorOnChangingImmutableValue(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentSetTypeSetsErrorOnNullValue(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentSetTypeSetsErrorOnInvalidType(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentSetTypeSuccessOnVaildInput(){
		$this->markTestIncomplete();
	}




	public function testOrderIntentSetNumSharesSetsErrorOnNullValue(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentSetNumSharesSetsErrorOnNonQuantityValue(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentSetNumSharesSuccessOnVaildInput(){
		$this->markTestIncomplete();
	}




	public function testOrderIntentSetPriceHighSetsErrorOnNullValueWhenRequired(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentSetPriceHighSetsErrorOnNonNumericValue(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentSetPriceHighShouldBeGreaterThanZero(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentSetPriceHighSuccessOnVaildInput()){
		$this->markTestIncomplete();
	}


// PriceLow

	public function testOrderIntentSetPriceLowSetsErrorOnNullValueWhenRequired(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentSetPriceLowSetsErrorOnNonNumericValue(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentSetPriceLowShouldBeGreaterThanZero(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentSetPriceLowSuccessOnVaildInput()){
		$this->markTestIncomplete();
	}


// Status

	public function testOrderIntentStatusIsReadOnlyValue(){
		$this->markTestIncomplete();
	}


//SetUser

	public function testOrderIntentSetUserSetsErrorOnNullValue(){
		$this->markTestIncomplete();
	}

	public function testOrderIntentUserIsImmutableValue(){
		$this->markTestIncomplete();		
	}

	public function testOrderIntentSetUserSetsErrorOnNonValidUser(){
		$this->markTestIncomplete();		
	}

	public function testOrderIntentSetUserSuccessOnVaildInput(){
		$this->markTestIncomplete();		
	}


	/**
	 * Add tests for validStatus validations per field
	 */



/**
* 
*  Relationships 
* 
*/


//SetAsset

	public function testOrderIntentSetAssetSetsErrorOnNullValueIfNoAssetIntentSpecified(){
		$this->markTestIncomplete();		
	}

	public function testOrderIntentSetAssetSetsErrorOnChangingImmutableValue(){
		$this->markTestIncomplete();		
	}

	public function testOrderIntentSetAssetSetsErrorOnNotFoundAssetInput(){
		$this->markTestIncomplete();		
	}

	public function testOrderIntentSetAssetSuccessOnValidInput(){
		$this->markTestIncomplete();		
	}




//SetAssetIntent

	public function testSetAssetIntentsSetsErrorOnNullValueIfNoAssetIntentSpecified(){
		$this->markTestIncomplete();		
	}

	public function testOrderIntentSetAssetSetsErrorOnChangingImmutableValue(){
		$this->markTestIncomplete();		
	}

	public function testOrderIntentSetAssetSetsErrorOnNotFoundAssetInput(){
		$this->markTestIncomplete();		
	}

	public function testOrderIntentSetAssetSuccessOnValidInput(){
		$this->markTestIncomplete();		
	}




// Set Bank Account

	public function testSetBankAccountSetsErrorOnNullValueIfNoBankAccountSpecified(){
		$this->markTestIncomplete();		
	}

	public function testSetBankAccountSetsErrorOnChangingImmutableValue(){
		$this->markTestIncomplete();		
	}

	public function testSetBankAccountSetsErrorOnNotFoundBankAccountInput(){
		$this->markTestIncomplete();		
	}

	public function testSetBankAccountSuccessOnValidInput(){
		$this->markTestIncomplete();		
	}




// Set Document

	public function testSetDocumentSetsErrorOnNullValueIfNoDocumentSpecified(){
		$this->markTestIncomplete();		
	}

	public function testSetDocumentSetsErrorOnChangingImmutableValue(){ // Should it be changeable ?? they might what to change the documents if intent is still submitted.
		$this->markTestIncomplete();		
	}

	public function testSetDocumentSetsErrorOnNotFoundDocumentInput(){
		$this->markTestIncomplete();		
	}

	public function testSetDocumentSuccessOnValidInput(){
		$this->markTestIncomplete();		
	}


}















































