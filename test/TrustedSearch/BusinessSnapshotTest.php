<?php 

class TrustedSearch_BusinessSnapshotTest extends TrustedSearchTestCase{

	public function testGetBusinessSnapshot(){

	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('1');

	    try {
	      $resource = TrustedSearch_BusinessSnapshot::get();
	      $data = $resource->getData();
	      $this->assertTrue(array_key_exists('uuid', $data[0]));
	      $this->assertTrue(array_key_exists('externalId', $data[0]));
	      $this->assertTrue(array_key_exists('received', $data[0]));
	      $this->assertTrue(array_key_exists('business', $data[0]));

	    } catch (TrustedSearch_AuthenticationError $e) {
	    	echo $e->getMessage();
		    $this->assertEquals(401, $e->getHttpStatus());
	    }
	}

	public function testGetBusinessSnapshotSince(){

	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('1');

	    try {
	      $resource = TrustedSearch_BusinessSnapshot::get(null, 1385964120);
	      $data = $resource->getData();
	      $this->assertTrue(array_key_exists('uuid', $data[0]));
	      $this->assertTrue(array_key_exists('externalId', $data[0]));
	      $this->assertTrue(array_key_exists('received', $data[0]));
	      $this->assertTrue(array_key_exists('business', $data[0]));

	    } catch (TrustedSearch_AuthenticationError $e) {
	    	echo $e->getMessage();
		    $this->assertEquals(401, $e->getHttpStatus());
	    }
	}
	
	//@Travis Not sure why this is only returning a timestamp.
	public function testGetBusinessSnapshotLocation(){

	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('1');

	    try {
	    	$testLocation = '45c907bc-6d2f-5f62-9610-5395858d41a0';
			$resource = TrustedSearch_BusinessSnapshot::get($testLocation);
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
		    TrustedSearch::setApiPublicKey('d7a6454ef686dfad24e08d773bc273eb');
		    TrustedSearch::setApiPrivateKey('7lOx6Swg9e0yTjQz5laIfJQ9');
		    TrustedSearch::setApiEnvironment('local');
		    TrustedSearch::setApiVersion('1');
		    try {

		    	$uuid = '45c907bc-6d2f-5f62-9610-5395858d41a0'; //Take from response above.
		    	
		      	$response = TrustedSearch_BusinessSnapshot::simulate();
		      	var_dump(($response));

		    } catch (TrustedSearch_AuthenticationError $e) {
		    	echo $e->getMessage();
			    $this->assertEquals(401, $e->getHttpStatus());
		    }
	}
}