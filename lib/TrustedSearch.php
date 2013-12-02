<?php

// Tested on PHP 5.2, 5.3, 5.4

// This snippet (and some of the curl code) due to the Facebook SDK.
if (!function_exists('curl_init')) {
  throw new Exception('TrustedSearch needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('TrustedSearch needs the JSON PHP extension.');
}
if (!function_exists('mb_detect_encoding')) {
  throw new Exception('TrustedSearch needs the Multibyte String PHP extension.');
}

require __DIR__.'/../vendor/autoload.php';

// TrustedSearch singleton
require(dirname(__FILE__) . '/TrustedSearch/TrustedSearch.php');

// Utilities
require(dirname(__FILE__) . '/TrustedSearch/Util.php');
require(dirname(__FILE__) . '/TrustedSearch/Util/Set.php');

// Errors
require(dirname(__FILE__) . '/TrustedSearch/Error.php');
require(dirname(__FILE__) . '/TrustedSearch/ApiError.php');
require(dirname(__FILE__) . '/TrustedSearch/ApiConnectionError.php');
require(dirname(__FILE__) . '/TrustedSearch/AuthenticationError.php');
require(dirname(__FILE__) . '/TrustedSearch/InvalidRequestError.php');

// Plumbing
require(dirname(__FILE__) . '/TrustedSearch/Object.php');
require(dirname(__FILE__) . '/TrustedSearch/ApiRequestor.php');
require(dirname(__FILE__) . '/TrustedSearch/ApiResource.php');
require(dirname(__FILE__) . '/TrustedSearch/SingletonApiResource.php');
require(dirname(__FILE__) . '/TrustedSearch/AttachedObject.php');
require(dirname(__FILE__) . '/TrustedSearch/List.php');

// TrustedSearch API Resources
require(dirname(__FILE__) . '/TrustedSearch/Token.php');
require(dirname(__FILE__) . '/TrustedSearch/LocalBusiness.php');
require(dirname(__FILE__) . '/TrustedSearch/BusinessSnapshot.php');

