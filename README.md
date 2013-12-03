php-trustedsearch
=================

Obtain the latest version of the TRUSTEDSearch PHP bindings with:

    git clone https://github.com/trustedsearch/php-trustedsearch


## Documentation

Please see [http://developers.trustedsearch.org/](http://developers.trustedsearch.org) for up-to-date documentation.

Packagist: [https://packagist.org/packages/trustedsearch/php-trustedsearch](https://packagist.org/packages/trustedsearch/php-trustedsearch)


## Installation

### Traditional 
To get started, add the following to your PHP script:

    require_once("/path/to/php-trustedsearch/lib/TrustedSearch.php");


### Composer

Add below to your require block in your composer file

	trustedsearch/php-trustedsearch

Then update your composer

	composer update

## Usage

To start using the gem, you need to be given your sandbox and production public & private keys.

### Basic Configuration
```php
	require_once("/path/to/php-trustedsearch/lib/TrustedSearch.php");

	$publicKey = "XXXX";
	$privateKey = "YYYYY";
	TrustedSearch::setApiPublicKey($publicKey);
	TrustedSearch::setApiPrivateKey($privateKey);
    TrustedSearch::setApiEnvironment('sandbox');  //Options are sandbox or production
    TrustedSearch::setApiVersion('1'); //You MUST set this. 1 is currently the only option. There is no default.

```

#### Get All Business for all users locations
See the [API documentation](http://developers.trustedsearch.org/#/get-business-updates) for a list of parameters for each API resource.

```php
$resource = TrustedSearch_DirectoryListing::get();
$data = $resource->getData();
echo json_encode($data);
```

#### Get Business Updates for single location
See the [API documentation](http://developers.trustedsearch.org/#/get-business-updates) for a list of parameters for each API resource.

```php
$testLocation = '45c907bc-6d2f-5f62-9610-5395858d41a0';
$resource = TrustedSearch_DirectoryListing::get($testLocation);
$data = $resource->getData();
echo json_encode($data);
```

#### Get Business Updates since epoch 1380611103
See the [API documentation](http://developers.trustedsearch.org/#/get-business-updates) for a list of parameters for each API resource.

```php
$resource = TrustedSearch_DirectoryListing::since(1380611103);
$data = $resource->getData();
echo json_encode($data);

```

#### Submit New Business Listings

See the [API documentation](http://developers.trustedsearch.org/#/submitting-a-business) for a list of parameters for each API resource.

```php
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

$resource = TrustedSearch_LocalBusiness::create($data);
$data = $resource->getData();
echo json_encode($data);
```

### Testing

#### Testing / Simulating a change in a business listing

```php

$uuid = '45c907bc-6d2f-5f62-9610-5395858d41a0'; //Take from response above.
$response = TrustedSearch_DirectoryListing::simulate($uuid);
echo json_encode($response->getData());

```

### Error Handling
Exceptions are thrown when there is an api issue.

```php

    try {
      $token = TrustedSearch_Token::get($username, $password);
    } catch (TrustedSearch_AuthenticationError $e) {
    	echo $e->getMessage();
	    $this->assertEquals(401, $e->getCode());
    }

```

#### Exceptions

* TrustedSearch_Error  ** Refer to [/lib/TrustedSearch/Errors/Error.php](/lib/TrustedSearch/Errors/Error.php) for special exception handle methods
* TrustedSearch_ApiConnectionError
* TrustedSearch_ApiError
* TrustedSearch_AuthenticationError
* TrustedSearch_InvalidRequestError


Output: (Body is formatted for readability.)

```javascript

Message: Bummer, we couldn't save this record. You might have to fix a few things first and try again.
Body:
{	
	"status"=>"error", 
	"code"=>409, 
	"message"=>"Bummer, we couldn't save this record. You might have to fix a few things first and try again.", 
	"error"=>"ModelSaveFailedException", 
	"debug"=>"Model was unable to save, check validation errors.", 
	"validations"=>{"uuid"=>["The uuid field is required."], 
	"business_name"=>["The business name field is required."]}, 
	"data"=>[]
}
Code: 409

```

## Tests

In order to run tests you have to install PHPUnit (https://packagist.org/packages/phpunit/phpunit) via Composer (http://getcomposer.org/) (recommended way):

    composer.phar update --dev

Run test suite:

    php ./test/TrustedSearch.php

