<?php

class TrustedSearch_ApiRequestorTest extends TrustedSearchTestCase
{
  public function testEncode()
  {
    $a = array('my' => 'value', 'that' => array('your' => 'example'), 'bar' => 1, 'baz' => null);
    $enc = TrustedSearch_APIRequestor::encode($a);
    $this->assertEquals($enc, 'my=value&that%5Byour%5D=example&bar=1');

    $a = array('that' => array('your' => 'example', 'foo' => null));
    $enc = TrustedSearch_APIRequestor::encode($a);
    $this->assertEquals($enc, 'that%5Byour%5D=example');

    $a = array('that' => 'example', 'foo' => array('bar', 'baz'));
    $enc = TrustedSearch_APIRequestor::encode($a);
    $this->assertEquals($enc, 'that=example&foo%5B%5D=bar&foo%5B%5D=baz');

    $a = array('my' => 'value', 'that' => array('your' => array('cheese', 'whiz', null)), 'bar' => 1, 'baz' => null);
    $enc = TrustedSearch_APIRequestor::encode($a);
    $this->assertEquals($enc, 'my=value&that%5Byour%5D%5B%5D=cheese&that%5Byour%5D%5B%5D=whiz&bar=1');
  }

  public function testUtf8()
  {
    // UTF-8 string
    $x = "\xc3\xa9";
    $this->assertEquals(TrustedSearch_ApiRequestor::utf8($x), $x);

    // Latin-1 string
    $x = "\xe9";
    $this->assertEquals(TrustedSearch_ApiRequestor::utf8($x), "\xc3\xa9");

    // Not a string
    $x = TRUE;
    $this->assertEquals(TrustedSearch_ApiRequestor::utf8($x), $x);
  }

  public function testEncodeObjects()
  {
    // I have to do some work here because this is normally
    // private. This is just for testing! 
    // Also it only works on PHP >= 5.3
    // 
    if (version_compare(PHP_VERSION, '5.3.2', '>=')) {
      $reflector = new ReflectionClass('TrustedSearch_APIRequestor');
      $method = $reflector->getMethod('_encodeObjects');
      $method->setAccessible(true);

      // Preserves UTF-8
      $v = array('token' => "☃");
      $enc = $method->invoke(null, $v);
      $this->assertEquals($enc, $v);

      // Encodes latin-1 -> UTF-8
      $v = array('token' => "\xe9");
      $enc = $method->invoke(null, $v);
      $this->assertEquals($enc, array('token' => "\xc3\xa9"));
    }
  }
}
