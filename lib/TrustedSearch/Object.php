<?php

class TrustedSearch_Object implements ArrayAccess
{
  public static $_permanentAttributes;
  public static $_nestedUpdatableAttributes;

  public static function init()
  {
    self::$_permanentAttributes = new TrustedSearch_Util_Set(array('_apiPublicKey','_apiPrivateKey', 'id'));
    self::$_nestedUpdatableAttributes = new TrustedSearch_Util_Set(array('metadata'));
  }

  protected $_apiPublicKey;
  protected $_apiPrivateKey;
  protected $_apiPath;
  protected $_apiParams;
  protected $_apiBody;
  

  protected $_values;
  protected $_unsavedValues;
  protected $_transientValues;
  protected $_retrieveOptions;

  public function __construct($apiPublicKey=null, $apiPrivateKey=null)
  {
    $this->_apiPublicKey = $apiPublicKey;
    $this->_apiPrivateKey = $apiPrivateKey;
    $this->_values = array();
    $this->_unsavedValues = new TrustedSearch_Util_Set();
    $this->_transientValues = new TrustedSearch_Util_Set();

  }

  // Standard accessor magic methods
  public function __set($k, $v)
  {
    if ($v === ""){
      throw new InvalidArgumentException(
        'You cannot set \''.$k.'\'to an empty string. '
        .'We interpret empty strings as NULL in requests. '
        .'You may set obj->'.$k.' = NULL to delete the property');
    }

    if (self::$_nestedUpdatableAttributes->includes($k) && isset($this->$k) && is_array($v)) {
      $this->$k->replaceWith($v);
    } else {
      // TODO: may want to clear from $_transientValues.  (Won't be user-visible.)
      $this->_values[$k] = $v;
    }
    if (!self::$_permanentAttributes->includes($k))
      $this->_unsavedValues->add($k);
  }
  public function __isset($k)
  {
    return isset($this->_values[$k]);
  }
  public function __unset($k)
  {
    unset($this->_values[$k]);
    $this->_transientValues->add($k);
    $this->_unsavedValues->discard($k);
  }
  public function __get($k)
  {
    if (array_key_exists($k, $this->_values)) {
      return $this->_values[$k];
    } else if ($this->_transientValues->includes($k)) {
      $class = get_class($this);
      $attrs = join(', ', array_keys($this->_values));
      error_log("TrustedSearch Notice: Undefined property of $class instance: $k.  HINT: The $k attribute was set in the past, however.  It was then wiped when refreshing the object with the result returned by TrustedSearch's API, probably as a result of a save().  The attributes currently available on this object are: $attrs");
      return null;
    } else {
      $class = get_class($this);
      error_log("TrustedSearch Notice: Undefined property of $class instance: $k");
      return null;
    }
  }

  // ArrayAccess methods
  public function offsetSet($k, $v)
  {
    $this->$k = $v;
  }

  public function offsetExists($k)
  {
    return array_key_exists($k, $this->_values);
  }

  public function offsetUnset($k)
  {
    unset($this->$k);
  }
  public function offsetGet($k)
  {
    return array_key_exists($k, $this->_values) ? $this->_values[$k] : null;
  }

  public function keys()
  {
    return array_keys($this->_values);
  }

  // This unfortunately needs to be public to be used in Util.php
  public static function scopedConstructFrom($class, $values, $apiPublicKey=null, $apiPrivateKey=null)
  {
    $obj = new $class(isset($values['id']) ? $values['id'] : null, $apiPublicKey, $apiPrivateKey);
    $obj->refreshFrom($values, $apiPublicKey, $apiPrivateKey);
    return $obj;
  }

  public static function constructFrom($values, $apiPublicKey=null, $apiPrivateKey=null)
  {
    $class = get_class();
    return self::scopedConstructFrom($class, $values, $apiPublicKey, $apiPrivateKey);
  }

  public function refreshFrom($values, $apiPublicKey, $apiPrivateKey, $partial=false)
  {
    $this->_apiPublicKey = $apiPublicKey;
    $this->_apiPrivateKey = $apiPrivateKey;


    if ($partial)
      $removed = new TrustedSearch_Util_Set();
    else
      $removed = array_diff(array_keys($this->_values), array_keys($values));

    foreach ($removed as $k) {
      if (self::$_permanentAttributes->includes($k))
        continue;
      unset($this->$k);
    }

    foreach ($values as $k => $v) {
      if (self::$_permanentAttributes->includes($k))
        continue;

      if (self::$_nestedUpdatableAttributes->includes($k) && is_array($v))
        $this->_values[$k] = TrustedSearch_Object::scopedConstructFrom('TrustedSearch_AttachedObject', $v, $apiPublicKey, $apiPrivateKey);
      else
        $this->_values[$k] = TrustedSearch_Util::convertToTrustedSearchObject($v, $apiPublicKey, $apiPrivateKey);

      $this->_transientValues->discard($k);
      $this->_unsavedValues->discard($k);
    }
  }

  public function serializeParameters()
  {
    $params = array();
    if ($this->_unsavedValues) {
      foreach ($this->_unsavedValues->toArray() as $k) {
        $v = $this->$k;
        if ($v === NULL) {
          $v = '';
        }
        $params[$k] = $v;
      }
    }

    // Get nested updates.
    foreach (self::$_nestedUpdatableAttributes->toArray() as $property) {
      if (isset($this->$property) && $this->$property instanceOf TrustedSearch_Object) {
        $params[$property] = $this->$property->serializeParameters();
      }
    }
    return $params;
  }

  // Pretend to have late static bindings, even in PHP 5.2
  protected function _lsb($method)
  {
    $class = get_class($this);
    $args = array_slice(func_get_args(), 1);
    return call_user_func_array(array($class, $method), $args);
  }
  protected static function _scopedLsb($class, $method)
  {
    $args = array_slice(func_get_args(), 2);
    return call_user_func_array(array($class, $method), $args);
  }

  public function __toJSON()
  {
    if (defined('JSON_PRETTY_PRINT'))
      return json_encode($this->__toArray(true), JSON_PRETTY_PRINT);
    else
      return json_encode($this->__toArray(true));
  }

  public function __toString()
  {
    return $this->__toJSON();
  }

  public function __toArray($recursive=false)
  {
    if ($recursive)
      return TrustedSearch_Util::convertTrustedSearchObjectToArray($this->_values);
    else
      return $this->_values;
  }
}


TrustedSearch_Object::init();
