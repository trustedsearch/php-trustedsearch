<?php

class TrustedSearch_InvalidRequestErrorTest extends TrustedSearchTestCase
{
  public function testInvalidObject()
  {
    authorizeFromEnv();
    try {
      TrustedSearch_Token::get('invalid');
    } catch (TrustedSearch_InvalidRequestError $e) {
      $this->assertEqual(401, $e->getHttpStatus());
    }
  }

  
}
