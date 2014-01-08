<?php 

class TrustedSearch_ListingTest extends TrustedSearchTestCase{

	
	public function testGetIndex(){
	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('2');

	    try {

			$resource = TrustedSearch_Listing::index(1, array(), 3);
			$data = $resource->getData();
			$pagination = $resource->getPagination();

			if(!empty($data)){
				$record = $data[0];

				//Verify required fields are present.
				$this->assertTrue(array_key_exists('id', $record));
				$this->assertTrue(array_key_exists('location_id', $record));
				$this->assertTrue(array_key_exists('product_id', $record));
				$this->assertTrue(array_key_exists('listing_status_id', $record));
				$this->assertTrue(array_key_exists('username', $record));
				$this->assertTrue(array_key_exists('password', $record));
				$this->assertTrue(array_key_exists('fulfillment_status_id', $record));
				$this->assertTrue(array_key_exists('url', $record));
				$this->assertTrue(array_key_exists('duplicate_url', $record));
				$this->assertTrue(array_key_exists('verification', $record));
				$this->assertTrue(array_key_exists('deleted_at', $record));
				$this->assertTrue(array_key_exists('created_at', $record));
				$this->assertTrue(array_key_exists('updated_at', $record));

				//Verify Pagination
				$this->assertTrue(array_key_exists('total', $pagination));
				$this->assertTrue(array_key_exists('per_page', $pagination));
				$this->assertTrue(array_key_exists('current_page', $pagination));
				$this->assertTrue(array_key_exists('last_page', $pagination));
				$this->assertTrue(array_key_exists('from', $pagination));
				$this->assertTrue(array_key_exists('to', $pagination));

				//Verify Pagination works by getting a set of results and then paging 1 at a time to match the set.
				$resource = TrustedSearch_Listing::index(2, array(), 1);
				$records = $resource->getData();
				$record = $records[0];
				$this->assertEquals($data[1]['id'], $record['id'], "Records don't match.");

				$resource = TrustedSearch_Listing::index(3, array(), 1);
				$records = $resource->getData();
				$record = $records[0];
				$this->assertEquals($data[2]['id'], $record['id'], "Records don't match.");

			}else{

				$this->assertTrue(false, 'Data should come back from index');

			}

	    } catch (TrustedSearch_AuthenticationError $e) {
	    	echo $e->getMessage();
		    $this->assertEquals(401, $e->getCode());
	    }
	}

	public function testGetListingById(){

	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('2');

	    try {
	    	//Grab a list of listings and then grab a single listing.
	    	$resource = TrustedSearch_Listing::index(1, array(), 3);
	    	$data = $resource->getData();
	    	$record = $data[0];

			$resource = TrustedSearch_Listing::get($record['id']);
			$record = $resource->getData();
			if(!empty($data)){

			  	$this->assertTrue(array_key_exists('id', $record));
				$this->assertTrue(array_key_exists('location_id', $record));
				$this->assertTrue(array_key_exists('product_id', $record));
				$this->assertTrue(array_key_exists('listing_status_id', $record));
				$this->assertTrue(array_key_exists('username', $record));
				$this->assertTrue(array_key_exists('password', $record));
				$this->assertTrue(array_key_exists('fulfillment_status_id', $record));
				$this->assertTrue(array_key_exists('url', $record));
				$this->assertTrue(array_key_exists('duplicate_url', $record));
				$this->assertTrue(array_key_exists('verification', $record));
				$this->assertTrue(array_key_exists('deleted_at', $record));
				$this->assertTrue(array_key_exists('created_at', $record));
				$this->assertTrue(array_key_exists('updated_at', $record));

			}else{
				$this->assertTrue(false, 'Data should come back from testGetListingById');
			}

	    } catch (TrustedSearch_AuthenticationError $e) {
	    	echo $e->getMessage();
		    $this->assertEquals(401, $e->getCode());
	    }
	}

	public function testUpdateListing(){
		    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
		    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
		    TrustedSearch::setApiEnvironment('local');
		    TrustedSearch::setApiVersion('2');

		    try {

		    	//Note: You will need to update the id while testing if you clear your local or dev db. 
		    	
		    	//Load a listing. Get the fulfillment_status_id.
		    	
				$listingId = "0a01f030-a4af-4bfa-8116-ab165a488077";
				$listingData = array(
					'fulfillment_status_id' => '999'
				);

		    	$resource = TrustedSearch_Listing::get($listingId);
		    	$original = $resource->getData();

				TrustedSearch_Listing::update($original['id'], $listingData);

				$resource = TrustedSearch_Listing::get($listingId);
		    	$updated = $resource->getData();
				
				if(!empty($original) && !empty($updated)){
					  	$this->assertEquals($original['id'], $updated['id']);
					  	$this->assertTrue($original['fulfillment_status_id'] != 999);
					  	$this->assertTrue($updated['fulfillment_status_id'] == 999);

					  	//Set Data back for next test
					  	$listingData = array(
					  		'fulfillment_status_id' => '23'
					  	);
					  	TrustedSearch_Listing::update($original['id'], $listingData);
						
				}else{
					$this->assertTrue(false, 'Data should come back from testUpdateListing');
				}
		
		    } catch (TrustedSearch_Error $e) {
		    	echo $e->getMessage();
		    	echo json_encode($e->getValidations());
			    $this->assertEquals(401, $e->getCode());
		    }
	
	}

	public function testGetListingByLocationAndName(){

	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('2');

	    try {

	    	//Note: You will need to update the id while testing if you clear your local or dev db. 
			$resource = TrustedSearch_Listing::getByLocationAndProductName('376a15ee-d45c-5890-ac08-aafe3cbc864a', 'yahoolocal');
			$record = $resource->getData();
			if(!empty($record)){
				  	$this->assertTrue(array_key_exists('id', $record));
					$this->assertTrue(array_key_exists('location_id', $record));
					$this->assertTrue(array_key_exists('product_id', $record));
					$this->assertTrue(array_key_exists('listing_status_id', $record));
					$this->assertTrue(array_key_exists('username', $record));
					$this->assertTrue(array_key_exists('password', $record));
					$this->assertTrue(array_key_exists('fulfillment_status_id', $record));
					$this->assertTrue(array_key_exists('url', $record));
					$this->assertTrue(array_key_exists('duplicate_url', $record));
					$this->assertTrue(array_key_exists('verification', $record));
					$this->assertTrue(array_key_exists('deleted_at', $record));
					$this->assertTrue(array_key_exists('created_at', $record));
					$this->assertTrue(array_key_exists('updated_at', $record));
			}else{
				$this->assertTrue(false, 'Data should come back from getByLocationAndProductName');
			}
	
	    } catch (TrustedSearch_AuthenticationError $e) {
	    	echo $e->getMessage();
		    $this->assertEquals(401, $e->getCode());
	    }
	}

	
}