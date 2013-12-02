<?php 

class TrustedSearch_BusinessSnapshotTest extends TrustedSearchTestCase{

	public function testGetBusinessSnapshot(){

	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('1');

	    try {
	      $snapshots = TrustedSearch_BusinessSnapshot::get();
	      var_dump(($snapshots[0]['uuid']));


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
		    	
		      	$response = TrustedSearch_BusinessSnapshot::simulate($uuid);
		      	var_dump(($response[0]));

		    } catch (TrustedSearch_AuthenticationError $e) {
		    	echo $e->getMessage();
			    $this->assertEquals(401, $e->getHttpStatus());
		    }
	}
}