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
    TrustedSearch::setApiVersion('1'); //You MUST set this 1 is currently the only option

```


## Tests

In order to run tests you have to install PHPUnit (https://packagist.org/packages/phpunit/phpunit) via Composer (http://getcomposer.org/) (recommended way):

    composer.phar update --dev

Run test suite:

    php ./test/TrustedSearch.php


### API Examples

