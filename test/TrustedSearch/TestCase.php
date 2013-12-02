<?php

/**
 * Base class for TrustedSearch test cases, provides some utility methods for creating
 * objects.
 */
abstract class TrustedSearchTestCase extends PHPUnit_Framework_TestCase
{

  public function setup(){
    authorizeFromEnv();
  }
  
  public function getTestCredentials($key = null){
  	$credentials = array(
  		'public_key' => 'd7a6454ef686dfad24e08d773bc273eb',
  		'private_key' => '7lOx6Swg9e0yTjQz5laIfJQ9',
  		'email' => 'tester@trustedsearch.org',
  		'password' => 'test1234'
  	);

  	if($key){
  		return $credentials[$key];
  	}

  	return $credentials;
  }
}
