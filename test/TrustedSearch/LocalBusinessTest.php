<?php 
class TrustedSearch_LocalBusinessTest extends TrustedSearchTestCase{

	public function testAddLocalBusiness(){
		
		$data = $this->getTestData();
	
	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('1');

	    try {
	      $resource = TrustedSearch_LocalBusiness::create($data);
	      $data = $resource->getData();
	      $this->assertEquals(count($data), 2, 'There should be two results.');
	      $this->assertTrue(!empty($data[0]['externalId']), 'There should be an external id present.');
	      $this->assertTrue(!empty($data[0]['uuid']), "There should be uuid returned.");
	      $this->assertTrue(!empty($data[0]['status']), "There should be status returned.");

	      $this->assertTrue(!empty($data[1]['externalId']), 'There should be an external id present.');
	      $this->assertTrue(!empty($data[1]['uuid']), "There should be uuid returned.");
	      $this->assertTrue(!empty($data[1]['status']), "There should be status returned.");

	    } catch (TrustedSearch_AuthenticationError $e) {
	    	echo $e->getMessage();
		    $this->assertEquals(401, $e->getCode());
	    }
	}

    public function testValidateLocalBusiness(){

        $data = $this->getTestData();

        TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
        TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
        TrustedSearch::setApiEnvironment('local');
        TrustedSearch::setApiVersion('1');

        try {
            $resource = TrustedSearch_LocalBusiness::validate($data);
            $data = $resource->getData();
            $this->assertEquals(count($data), 2, 'There should be two results.');
            $this->assertTrue(!empty($data[0]['externalId']), 'There should be an external id present.');
            $this->assertTrue(!empty($data[0]['uuid']), "There should be uuid returned.");
            $this->assertTrue(!empty($data[0]['status']), "There should be status returned.");

            $this->assertTrue(!empty($data[1]['externalId']), 'There should be an external id present.');
            $this->assertTrue(!empty($data[1]['uuid']), "There should be uuid returned.");
            $this->assertTrue(!empty($data[1]['status']), "There should be status returned.");

        } catch (TrustedSearch_InvalidRequestError $e) {
            //print("Message" . $e->getMessage()."\n");
            $output = json_encode($e->getValidations());
            //print("Validations: " . $output);
            $this->assertEquals(400, $e->getCode());
        }
    }


	public function testGetLocalBusiness(){
		
		
	
	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('1');

	    try {


			$data = $this->getTestData();

			$resource = TrustedSearch_LocalBusiness::create($data);
			$data = $resource->getData();
			$locationId = $data[0]['uuid'];
			$resource = TrustedSearch_LocalBusiness::get($locationId);
			$data = $resource->getData();
			$this->assertEquals($data['business']['name'],"Jeremy's Umbrellas Shop", 'name should match.');

	    } catch (TrustedSearch_AuthenticationError $e) {
	    	echo $e->getMessage();
	    	$this->assertTrue(false, "testGetLocalBusiness failed. this should not happen");
		    $this->assertEquals(401, $e->getCode());
	    }
	}



	public function testAddLocalBusinessFailNoExternalID(){
		$data = $this->getTestData();
		unset($data[0]['externalId']);
	    TrustedSearch::setApiPublicKey($this->getTestCredentials('public_key'));
	    TrustedSearch::setApiPrivateKey($this->getTestCredentials('private_key'));
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('1');

	    try {
	      $resource = TrustedSearch_LocalBusiness::create($data);
	      $data = $resource->getData();
	      $this->assertEquals(count($data), 2, 'There should be two results.');
	      $this->assertTrue(!empty($data[0]['externalId']), 'There should be an external id present.');
	      $this->assertTrue(!empty($data[0]['uuid']), "There should be uuid returned.");
	      $this->assertTrue(!empty($data[0]['status']), "There should be status returned.");

	      $this->assertTrue(!empty($data[1]['externalId']), 'There should be an external id present.');
	      $this->assertTrue(!empty($data[1]['uuid']), "There should be uuid returned.");
	      $this->assertTrue(!empty($data[1]['status']), "There should be status returned.");


	    } catch (TrustedSearch_InvalidRequestError $e) {
	    	//echo $e->getMessage();
		    $this->assertEquals(400, $e->getCode());
	    }
	}


	public function getTestData(){
		return array(
			array(
				'audit'=> false,
				'externalId' => 'mary_t123456240',
				'order' => array(
					"onBehalfOf" => "Partner ABC",
					'packages' => array(
						'23'
					),
					'termsAccepted' => true
				),
				'contact' => array(
					'firstName' => 'Mary',
					'lastName' => 'Poppins',
					'email' => 'mary@poppins.com',
					'phone' => '8055551234'
				),
				'business' => array(
					'name' => "Jeremy's Umbrellas Shop",
					'street' => "17 Cherry Tree Lane",
					'city' => "London",
					'state' => "CA",
					'postalCode' => "93001",
					'phoneLocal' => "(805) 555-9876",
					'phoneTollFree'     => '(800) 555-5555',
					'fax'               => '(801) 555-5555',
					'website'           => 'http://www.marysumbrellas.com',
					'email'             => 'info@marysumbrellas.com',
					'slogan'            => "A spoon full of sugar helps the medicine go down.",
					'descriptionLong'   => 'some long desc...',
					'descriptionMedium' => 'some medium desc...',
					'descriptionShort'  => 'some short desc...',
					'keywords'          => 'rain gear, fashion, outdoor gear',
					'paymentMethods'    => array( 'mastercard', 'visa'),
					'category1'			=> 'outdoor',
					'category2'			=> 'fashion',
					'category3'			=> 'rain gear',
					'yearEstablished'   => '1808',
					'productsOffered'   => 'umbrellas, rain coats',
					'languagesSpoken'   => 'english, japanese, spanish',
					'hoursOfOperation'  => 'MF08001700H',
					'numberEmployees' 	=> 23,
					'logoUrl'           => "http://trustedsearch.org/images/imgTS_Logo.png",
					'logoSquareUrl'     => 'http://trustedsearch.org/images/imgTS_Logo.png',
					'imageUrl'=> array(
							'http://trustedsearch.org/images/imgTS_Logo.png',
							'http://trustedsearch.org/images/imgTS_Logo.png',
							'http://trustedsearch.org/images/imgTS_Logo.png',
							'http://trustedsearch.org/images/imgTS_Logo.png',
							'http://trustedsearch.org/images/imgTS_Logo.png',
						),
					'videoUrl' => 'http://www.youtube.com/watch?v=cXuTiAHdxTg'
				)
			),
			array(
				'audit'=> false,
				'externalId' => 'mary_t123456239',
				'order' => array(
					"onBehalfOf" => "Partner ABC",
					'packages' => array(
						'23'
					),
					'termsAccepted' => true
				),
				'contact' => array(
					'firstName' => 'Mary',
					'lastName' => 'Poppins',
					'email' => 'mary@poppins.com',
					'phone' => '8055551234'
				),
				'business' => array(
					'name' => "Jeremy's Umbrellas Shop",
					'street' => "17 Cherry Tree Lane",
					'city' => "London",
					'state' => "CA",
					'postalCode' => "93001",
					'phoneLocal' => "(805) 555-9876",
					'phoneTollFree'     => '(800) 555-5555',
					'fax'               => '(801) 555-5555',
					'website'           => 'http://www.marysumbrellas.com',
					'email'             => 'info@marysumbrellas.com',
					'slogan'            => "A spoon full of sugar helps the medicine go down.",
					'descriptionLong'   => 'some long desc...',
					'descriptionMedium' => 'some medium desc...',
					'descriptionShort'  => 'some short desc...',
					'keywords'          => 'rain gear, fashion, outdoor gear',
					'paymentMethods'    => array( 'mastercard', 'visa'),
					'category1'			=> 'outdoor',
					'category2'			=> 'fashion',
					'category3'			=> 'rain gear',
					'yearEstablished'   => '1808',
					'productsOffered'   => 'umbrellas, rain coats',
					'languagesSpoken'   => 'english, japanese, spanish',
					'hoursOfOperation'  => 'MF08001700H',
					'numberEmployees' 	=> 23,
					'logoUrl'           => "http://trustedsearch.org/images/imgTS_Logo.png",
					'logoSquareUrl'     => 'http://trustedsearch.org/images/imgTS_Logo.png',
					'imageUrl'=> array(
							'http://trustedsearch.org/images/imgTS_Logo.png',
							'http://trustedsearch.org/images/imgTS_Logo.png',
							'http://trustedsearch.org/images/imgTS_Logo.png',
							'http://trustedsearch.org/images/imgTS_Logo.png',
							'http://trustedsearch.org/images/imgTS_Logo.png',
						),
					'videoUrl' => 'http://www.youtube.com/watch?v=cXuTiAHdxTg'
				)
			)
		);  // end data array
	}
}