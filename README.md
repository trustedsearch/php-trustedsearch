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


## Tests

In order to run tests you have to install PHPUnit (https://packagist.org/packages/phpunit/phpunit) via Composer (http://getcomposer.org/) (recommended way):

    composer.phar update --dev

Run test suite:

    php ./test/TrustedSearch.php


### API Examples

