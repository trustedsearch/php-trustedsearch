<?php 

class TrustedSearch_DirectoryListingTest extends TrustedSearchTestCase{

	public function testGetDirectoryListing(){

	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('1');

	    try {
	      $resource = TrustedSearch_DirectoryListing::get();
	      $data = $resource->getData();
	      if(!empty($data)){

		      $this->assertTrue(array_key_exists('uuid', $data[0]));
		      $this->assertTrue(array_key_exists('externalId', $data[0]));
		      $this->assertTrue(array_key_exists('received', $data[0]));
		      $this->assertTrue(array_key_exists('business', $data[0]));	
	      }else{
	      	$this->assertTrue(false, 'Data should come back from testGetDirectoryListing');
	      }

	    } catch (TrustedSearch_AuthenticationError $e) {
	    	echo $e->getMessage();
		    $this->assertEquals(401, $e->getHttpStatus());
	    }
	}

	public function testGetDirectoryListingSince(){

	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('1');

	    try {
			$resource = TrustedSearch_DirectoryListing::since(1385964120);
			$data = $resource->getData();
			if(!empty($data)){
				$this->assertTrue(array_key_exists('uuid', $data[0]));
				$this->assertTrue(array_key_exists('externalId', $data[0]));
				$this->assertTrue(array_key_exists('received', $data[0]));
				$this->assertTrue(array_key_exists('business', $data[0]));	
			}else{
				$this->assertTrue(false, 'Data should come back from testGetDirectoryListingSince');
			}
	
	    } catch (TrustedSearch_AuthenticationError $e) {
	    	echo $e->getMessage();
		    $this->assertEquals(401, $e->getHttpStatus());
	    }
	}

	//@Travis Not sure why this is only returning a timestamp.
	public function testGetDirectoryListingLocation(){

	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('1');

	    try {
	    	$testLocation = '45c907bc-6d2f-5f62-9610-5395858d41a0';
			$resource = TrustedSearch_DirectoryListing::get($testLocation);
			$data = $resource->getData();
			$this->assertTrue(array_key_exists('uuid', $data));
			$this->assertTrue(array_key_exists('externalId', $data));
			$this->assertTrue(array_key_exists('received', $data));
			$this->assertTrue(array_key_exists('business', $data));

	    } catch (TrustedSearch_AuthenticationError $e) {
	    	echo $e->getMessage();
		    $this->assertEquals(401, $e->getHttpStatus());
	    }
	}

	public function testSimulateFulfillment(){
		    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
		    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
		    TrustedSearch::setApiEnvironment('local');
		    TrustedSearch::setApiVersion('1');
		    try {

		    	$uuid = '45c907bc-6d2f-5f62-9610-5395858d41a0'; //Take from response above.
		    	
		      	$response = TrustedSearch_DirectoryListing::simulate($uuid);
		      	echo json_encode($response->getData());

		    } catch (TrustedSearch_AuthenticationError $e) {
		    	echo $e->getMessage();
			    $this->assertEquals(401, $e->getHttpStatus());
		    }
	}
}