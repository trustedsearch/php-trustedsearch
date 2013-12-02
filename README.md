php-trustedsearch
=================

Obtain the latest version of the TRUSTEDSearch PHP bindings with:

    git clone https://github.com/trustedsearch/php-trustedsearch

To get started, add the following to your PHP script:

    require_once("/path/to/php-trustedsearch/lib/TrustedSearch.php");

Simple usage looks like:

    TrustedSearch::setApiKey('d8e8fca2dc0f896fd7cb4cb0031ba249');
    ....

## Documentation

Please see [http://developers.trustedsearch.org/](http://developers.trustedsearch.org) for up-to-date documentation.

Packagist: [https://packagist.org/packages/trustedsearch/php-trustedsearch](https://packagist.org/packages/trustedsearch/php-trustedsearch)

## Tests

In order to run tests you have to install PHPUnit (https://packagist.org/packages/phpunit/phpunit) via Composer (http://getcomposer.org/) (recommended way):

    composer.phar update --dev

Run test suite:

    php ./test/TrustedSearch.php