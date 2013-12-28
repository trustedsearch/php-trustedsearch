<?php 
class TrustedSearch_PublisherHoursTest extends TrustedSearchTestCase{

	public function testGetPublisherHours(){
		
	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('2');

	    try {

	      $resource = TrustedSearch_PublisherHours::get('yahoolocal', 'MNNONENONEH');
	      $data = $resource->getData();
//	      var_dump(($data));
	      $this->assertEquals($data['status'], 'success');

	    } catch (TrustedSearch_Error $e) {
	    	var_dump(($e));
	    	echo $e->getMessage();
	    	$this->assertTrue(false, "should not get here");
	    	
		    $this->assertEquals(401, $e->getCode());
	    }
	}

}