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

//Load autoload file if exists
$trustedsearch_autoload_path = __DIR__.'/../vendor/autoload.php';
if(file_exists($trustedsearch_autoload_path)){
	require_once $trustedsearch_autoload_path;	
}

// TrustedSearch singleton
require_once(dirname(__FILE__) . '/TrustedSearch/TrustedSearch.php');

// Utilities
require_once(dirname(__FILE__) . '/TrustedSearch/Util.php');
require_once(dirname(__FILE__) . '/TrustedSearch/Util/Set.php');

// Errors
require_once(dirname(__FILE__) . '/TrustedSearch/Errors/Error.php');
require_once(dirname(__FILE__) . '/TrustedSearch/Errors/ApiError.php');
require_once(dirname(__FILE__) . '/TrustedSearch/Errors/ApiConnectionError.php');
require_once(dirname(__FILE__) . '/TrustedSearch/Errors/AuthenticationError.php');
require_once(dirname(__FILE__) . '/TrustedSearch/Errors/InvalidRequestError.php');

// Plumbing
require_once(dirname(__FILE__) . '/TrustedSearch/Object.php');
require_once(dirname(__FILE__) . '/TrustedSearch/ApiRequestor.php');
require_once(dirname(__FILE__) . '/TrustedSearch/ApiResource.php');
require_once(dirname(__FILE__) . '/TrustedSearch/AttachedObject.php');

// TrustedSearch API Resources v1
require_once(dirname(__FILE__) . '/TrustedSearch/Resources/Token.php');
require_once(dirname(__FILE__) . '/TrustedSearch/Resources/LocalBusiness.php');
require_once(dirname(__FILE__) . '/TrustedSearch/Resources/DirectoryListing.php');

// TrustedSearch API Resources v2
require_once(dirname(__FILE__) . '/TrustedSearch/Resources/PublisherHours.php');
require_once(dirname(__FILE__) . '/TrustedSearch/Resources/Listing.php');

