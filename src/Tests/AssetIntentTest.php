<?php

namespace CFX\Brokerage\Tests;





class AssetIntentTest extends \PHPUnit\Framework\TestCase {



	public function setupBeforeTest(){

	}


// Set Name

	public function testAssetIntentSetNameSetsErrorOnNullValue(){
		$this->markTestIncomplete();		
	}

	public function testAssetIntentSetNameSuccessWithValue(){
		$this->markTestIncomplete();		
	}


// Set SharesOutStanding

	public function testAssetIntentSetSharesOutstandingSetsErrorOnNonIntegerValue(){
		$this->markTestIncomplete();		
	}

	public function testAssetIntentSetSharesOutstandingSuccessOnIntegerValue(){
		$this->markTestIncomplete();		
	}



// Set OfferAmount

	public function testAssetIntentSetOfferAmountSetsErrorOnNonIntegerValue(){
		$this->markTestIncomplete();		
	}

	public function testAssetIntentSetOfferAmountSuccessOnIntegerValue(){
		$this->markTestIncomplete();		
	}


// Set DateOpened

    /**
     * I left this as an integer because I was lazy. This should accept _either_
     * an integer or a DateTime object. It should automatically convert integers
     * to datetime objects. Then it should successfully serialize the datetime object
     * back to unix timestamp integer via the `serializeAttribute` method, which
     * you'll have to override and should test.
     */
	public function testAssetIntentSetDateOpenedSetsErrorOnNonIntegerValue(){
		$this->markTestIncomplete();		
	}

    /**
     * This data validation should be lax, since we don't have a reason to be really
     * strict right now.
     */
	public function testAssetIntentSetDateOpenedSetsErrorOnNonCurrentDateValue(){
		$this->markTestIncomplete();		
	}

	public function testAssetIntentSetDateOpenedSuccessOnIntegerValue(){
		$this->markTestIncomplete();		
	}



	/**
	 * Same as DateOpened
	 */
	public function testAssetIntentSetDateClosedSetsErrorOnNonIntegerValue(){
		$this->markTestIncomplete();		
	}

	public function testAssetIntentSetDateClosedSetsErrorOnNonCurrentDateValue(){
		$this->markTestIncomplete();		
	}

	public function testAssetIntentSetDateClosedSuccessOnIntegerValueAndCurrentDate(){
		$this->markTestIncomplete();		
	}




	public function testAssetIntentSetInitialSharePriceSetsErrorOnNonFloatValue(){
		$this->markTestIncomplete();		
	}

	public function testAssetIntentSetInitialSharePriceSuccessOnFloatValue(){
		$this->markTestIncomplete();		
	}



    /**
     * Public AssetIntent should be READ ONLY. Need to test that we can inflate
     * the object with the correct value, but that we can't set it. (This read-only
     * functionality might be stuff that should be implemented and tested in 
     * `php-jsonapi-objects`, but you should still write a test to ensure that the
     * `asset`, specifically, is a read-only field.
     */

	public function testAssetIntentSetAssetFailsOnValueOfTypeNonAsset(){
		$this->markTestIncomplete();
	}

	public function testAssetIntentSetAssetSucceedsOnValueOfTypeAsset(){
		$this->markTestIncomplete();
	}


}































