<?php

class TrustedSearch_TokenTest extends TrustedSearchTestCase
{
  /**
   * @REQUIRED: php artisan lml-user:add test@test.com test1234 1 on local or staging env.
   * @return [type] [description]
   */
  public function testInvalidCredentials()
  {
    
    TrustedSearch::setApiEnvironment('local');
    TrustedSearch::setApiVersion('1');
    $username = 'test@test.com';
    $password = 'test'; //<< this i wrong and so the teswt should fail auth.

    try {
      $token = TrustedSearch_Token::get($username, $password);
      //var_dump($token['userSettings']['client_view']);
    } catch (TrustedSearch_AuthenticationError $e) {
    	echo $e->getMessage();
      echo "HI";
	    $this->assertEquals(401, $e->getCode());
    }
  }

  /**
   * @REQUIRED: php artisan lml-user:add test@test.com test1234 1 on local or staging env.
   * @return [type] [description]
   */
  public function testValidCredentials()
  {
    
    TrustedSearch::setApiEnvironment('local');
    TrustedSearch::setApiVersion('1');

    $username = $this->getTestCredentials('email');
    $password = $this->getTestCredentials('password');

    try {
      $resource = TrustedSearch_Token::get($username, $password);
      $data = $resource->getData();
      $this->assertTrue(!empty($data['token']), 'Token field should exist');
    } catch (TrustedSearch_AuthenticationError $e) {
    	echo $e->getMessage();   
    }
  }
}
