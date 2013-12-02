<?php

echo "Running the TrustedSearch PHP bindings test suite.\n".
     "If you're trying to use the TrustedSearch PHP bindings you'll probably want ".
     "to require('lib/TrustedSearch.php'); instead of this file\n";

require __DIR__.'/../vendor/autoload.php';

function authorizeFromEnv()
{
  $apiPublicKey = getenv('TRUSTEDSEARCH_API_PUBLIC_KEY');
  $apiPrivateKey = getenv('TRUSTEDSEARCH_API_PRIVATE_KEY');
  $apiEnvironemnt = getenv('TRUSTEDSEARCH_API_ENVIRONMENT');
  if (!$apiPublicKey)
    $apiPublicKey = "d7a6454ef686dfad24e08d773bc273eb";
  if (!$apiPrivateKey)
    $apiPrivateKey = "7lOx6Swg9e0yTjQz5laIfJQ9";
  if (!$apiEnvironemnt)
    $apiEnvironemnt = "sandbox";

  TrustedSearch::setApiCredentials($apiPublicKey, $apiPrivateKey);
  TrustedSearch::setApiEnvironment($apiEnvironemnt);
  
}

// Throw an exception on any error
function exception_error_handler($errno, $errstr, $errfile, $errline) {
  throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler('exception_error_handler');
error_reporting(E_ALL | E_STRICT);

require_once(dirname(__FILE__) . '/../lib/TrustedSearch.php');

require_once(dirname(__FILE__) . '/TrustedSearch/TestCase.php');

// require_once(dirname(__FILE__) . '/TrustedSearch/ApiRequestorTest.php');
// require_once(dirname(__FILE__) . '/TrustedSearch/AuthenticationErrorTest.php');
// require_once(dirname(__FILE__) . '/TrustedSearch/Error.php');
// require_once(dirname(__FILE__) . '/TrustedSearch/InvalidRequestErrorTest.php');
// require_once(dirname(__FILE__) . '/TrustedSearch/ObjectTest.php');
// require_once(dirname(__FILE__) . '/TrustedSearch/Token.php');
// require_once(dirname(__FILE__) . '/TrustedSearch/UtilTest.php');


