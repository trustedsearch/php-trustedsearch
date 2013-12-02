<?php

abstract class TrustedSearch_Util{
  
  public static function isList($array){
    if (!is_array($array))
      return false;

    // TODO: this isn't actually correct in general, but it's correct given TrustedSearch's responses
    foreach (array_keys($array) as $k) {
      if (!is_numeric($k))
        return false;
    }
    return true;
  }

  public static function convertTrustedSearchObjectToArray($values){
    $results = array();
    foreach ($values as $k => $v) {
      // FIXME: this is an encapsulation violation
      if ($k[0] == '_') {
        continue;
      }
      if ($v instanceof TrustedSearch_Object) {
        $results[$k] = $v->__toArray(true);
      }
      else if (is_array($v)) {
        $results[$k] = self::convertTrustedSearchObjectToArray($v);
      }
      else {
        $results[$k] = $v;
      }
    }
    return $results;
  }

  public static function convertToTrustedSearchObject($resp, $apiKey){
    $types = array(
      'token' => 'TrustedSearch_Token',
      'local_business' => 'TrustedSearch_LocalBusiness',
      'business_snapshots' => 'TrustedSearch_BusinessSnapshots',
    );
    
    if (self::isList($resp)) {
      $mapped = array();
      foreach ($resp as $i)
        array_push($mapped, self::convertToTrustedSearchObject($i, $apiKey));
      return $mapped;
    } else if (is_array($resp)) {
      if (isset($resp['object']) && is_string($resp['object']) && isset($types[$resp['object']]))
        $class = $types[$resp['object']];
      else
        $class = 'TrustedSearch_Object';
      return TrustedSearch_Object::scopedConstructFrom($class, $resp, $apiKey);
    } else {
      return $resp;
    }
  }
}
