<?php 
class TrustedSearch_LocalBusinessTest extends TrustedSearchTestCase{

	public function testAddLocalBusiness(){
		$data = array(
			array(
				'audit'=> false,
				'externalId' => 'mary_t123456240',
				'order' => array(
					"onBehalfOf" => "Partner ABC",
					'packages' => array(
						'ut002500'
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
					'logoUrl'           => "http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png",
					'logoSquareUrl'     => 'http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png',
					'imageUrl'=> array(
							'http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png',
							'http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png',
							'http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png',
							'http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png',
							'http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png',
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
						'ut002500'
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
					'logoUrl'           => "http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png",
					'logoSquareUrl'     => 'http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png',
					'imageUrl'=> array(
							'http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png',
							'http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png',
							'http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png',
							'http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png',
							'http://localmarketlaunch.com/wp-content/uploads/2013/09/LML-Logo-Large-300x120.png',
						),
					'videoUrl' => 'http://www.youtube.com/watch?v=cXuTiAHdxTg'
				)
			)
		);  // end data array
	
	    TrustedSearch::setApiPublicKey('d7a6454ef686dfad24e08d773bc273eb');
	    TrustedSearch::setApiPrivateKey('7lOx6Swg9e0yTjQz5laIfJQ9');
	    TrustedSearch::setApiEnvironment('local');
	    TrustedSearch::setApiVersion('1');

	    try {
	      $locations = TrustedSearch_LocalBusiness::create($data);
	      
	      echo $locations[0]['externalId'];
	      echo $locations[0]['uuid'];
	      echo $locations[0]['status'];

	      echo $locations[1]['externalId'];
	      echo $locations[1]['uuid'];
	      echo $locations[1]['status'];


	    } catch (TrustedSearch_AuthenticationError $e) {
	    	echo $e->getMessage();
		    $this->assertEquals(401, $e->getHttpStatus());
	    }
	}
}