<?php

class TrustedSearch_ErrorTest extends TrustedSearchTestCase
{
  public function testCreation()
  {
    try {
      throw new TrustedSearch_Error("hello", 500, "{'foo':'bar'}", array('foo' => 'bar'));
      $this->fail("Did not raise error");
    } catch (TrustedSearch_Error $e) {
      $this->assertEquals("hello", $e->getMessage());
      $this->assertEquals(500, $e->getHttpStatus());
      $this->assertEquals("{'foo':'bar'}", $e->getHttpBody());
      $this->assertEquals(array('foo' => 'bar'), $e->getJsonBody());
    }
  }
}