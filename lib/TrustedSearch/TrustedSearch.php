<?php

abstract class TrustedSearch
{
  public static $apiPublicKey;
  public static $apiPrivateKey;
  public static $apiBase = 'http://api.local.trustedsearch.org';
  public static $apiEnvironemnt = 'production'; // sandbox/production/local 
  public static $apiVersion = null;
  public static $verifySslCerts = true;
  public static $environmentSettings = array(
    'production' => array(
      'baseUrl' => 'https://api.trustedsearch.org'
    ),
    'sandbox' => array(
      'baseUrl' => 'http://api.sandbox.trustedsearch.org'
    ),
    'local' => array(
      'baseUrl' => 'http://api.local.trustedsearch.org'
    )
  );

  const VERSION = '1.0.0';

  public static function getApiKey()
  {
    return self::$apiKey;
  }

  public static function getApiBaseUrl($environment)
  {
    return self::$environmentSettings[$environment]['baseUrl'];
  }

  public static function setApiCredentials($apiPublicKey, $apiPrivateKey){
    self::$apiPublicKey = $apiPublicKey;
    self::$apiPrivateKey = $apiPrivateKey;
  }
  public static function setApiPublicKey($apiPublicKey)
  {
    self::$apiPublicKey = $apiPublicKey;
    
  }

  public static function setApiPrivateKey($apiPrivateKey)
  {
    self::$apiPrivateKey = $apiPrivateKey;
  }

  public static function setApiEnvironment($apiEnvironemnt)
  {
    self::$apiEnvironemnt = $apiEnvironemnt;
  }

  public static function getApiVersion()
  {
    if (!self::$apiVersion){
      throw new TrustedSearch_AuthenticationError('No API Version provided.  (HINT: set your API key using "TrustedSearch::setApiVersion(<API-VERSION>)".  You can generate API keys from the TrustedSearch web interface.  See https://trustedsearch.org/api for details, or email support@trustedsearch.org if you have any questions.');
    }
    return self::$apiVersion;
  }

  public static function setApiVersion($apiVersion)
  {
    self::$apiVersion = $apiVersion;
  }

  public static function getVerifySslCerts() {
    return self::$verifySslCerts;
  }

  public static function setVerifySslCerts($verify) {
    self::$verifySslCerts = $verify;
  }
}
