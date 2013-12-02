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
  

}
