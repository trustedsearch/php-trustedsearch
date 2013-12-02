<?php 

class TrustedSearch_BusinessSnapshotTest extends TrustedSearchTestCase{

	public function testGetBusinessSnapshot(){

	    TrustedSearch::setApiPublicKey('d7a6454ef686dfad24e08d773bc273eb');
	    TrustedSearch::setApiPrivateKey('7lOx6Swg9e0yTjQz5laIfJQ9');
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('1');

	    try {
	      $snapshots = TrustedSearch_BusinessSnapshot::get();
	      echo $snapshots[0]['business']['city'];
	      //var_dump(($snapshots));


	    } catch (TrustedSearch_AuthenticationError $e) {
	    	echo $e->getMessage();
		    $this->assertEquals(401, $e->getHttpStatus());
	    }
	}

}