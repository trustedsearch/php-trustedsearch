<?php

abstract class TrustedSearch_ApiResource extends TrustedSearch_Object{

  public static function className($class){
    // Useful for namespaces: Foo\TrustedSearch_Charge
    if ($postfix = strrchr($class, '\\'))
      $class = substr($postfix, 1);
    if (substr($class, 0, strlen('TrustedSearch')) == 'TrustedSearch')
      $class = substr($class, strlen('TrustedSearch'));

    $class = str_replace('_', '', $class);
    $name = urlencode($class);
    
    $name[0] = strtolower($name[0]);
    $func = create_function('$c', 'return "-" . strtolower($c[1]);');
    return preg_replace_callback('/([A-Z])/', $func, $name);
   
  }

  public static function classUrl($class){
    $base = self::_scopedLsb($class, 'className', $class);
    //Only append an s if class doesn't end w/ s.  @TODO: add some sort of pluralizer
    return self::versionUrl()."/${base}".((substr($base,-1)=='s'?'':'s'));
  }

  public static function pathUrl($path){
    $base = implode('/', $path);
    return self::versionUrl()."/${base}";
  }

  public static function versionUrl(){
    return "/v".TrustedSearch::getApiVersion();
  }

  public function refresh(){
    $requestor = new TrustedSearch_ApiRequestor($this->_apiPublicKey);
    $url = $this->instanceUrl();

    list($response, $apiPublicKey, $apiPrivateKey) = $requestor->request('get', $url, $this->_apiParams);
    
    $this->refreshFrom($response, $apiPublicKey, $apiPrivateKey);
    return $this;
  }

  public function instanceUrl(){
    $url = '';
    if(!empty($this->_apiPath)){
      $url = $this->_lsb('pathUrl', $this->_apiPath);
    }else{
      $class = get_class($this);
      $url = $this->_lsb('classUrl', $class);
    }

    return $url;
  }

  public function setPath($path = array()){
    $this->_apiPath = $path;
  }

  public function setParams($params = array()){
    $this->_apiParams = $params;
  }

  private static function _validateCall($method, $params=null, $apiPublicKey=null, $apiPrivateKey=null){
    if ($params && !is_array($params)){
      throw new TrustedSearch_Error("You must pass an array as the first argument to TrustedSearch API method calls.  (HINT: an example call to create a charge would be: \"TrustedSearchCharge::create(array('amount' => 100, 'currency' => 'usd', 'card' => array('number' => 4242424242424242, 'exp_month' => 5, 'exp_year' => 2015)))\")");
    }
    
    if ($apiPublicKey && !is_string($apiPublicKey)){
      throw new TrustedSearch_Error('The second argument to TrustedSearch API method calls is an optional per-request public api key, which must be a string.  (HINT: you can set a global apiKey by "TrustedSearch::setApiPublicKey(<apiKey>)")');
    }

    if ($apiPrivateKey && !is_string($apiPrivateKey) ){
      throw new TrustedSearch_Error('The third argument to TrustedSearch API method calls is an optional per-request private api key, which must be a string.  (HINT: you can set a global apiKey by "TrustedSearch::setApiPrivateKey(<apiKey>)")');
    }
  }

  protected static function _scopedRetrieve($class, $id, $apiPublicKey=null, $apiPrivateKey=null){
    $instance = new $class($id, $apiPublicKey, $apiPrivateKey);
    $instance->refresh();
    return $instance;
  }

  protected static function _scopedAll($class, $params=null, $apiPublicKey=null, $apiPrivateKey=null){
    self::_validateCall('all', $params, $apiPublicKey, $apiPrivateKey);
    $requestor = new TrustedSearch_ApiRequestor($apiPublicKey, $apiPrivateKey);
    $url = self::_scopedLsb($class, 'classUrl', $class);
    list($response, $apiPublicKey, $apiPrivateKey) = $requestor->request('get', $url, $params);
    return TrustedSearch_Util::convertToTrustedSearchObject($response, $apiPublicKey, $apiPrivateKey);
  }

  protected static function _scopedCreate($class, $params=null, $body=null, $apiPublicKey=null, $apiPrivateKey=null){
    self::_validateCall('create', $params, $apiPublicKey, $apiPrivateKey);
    $requestor = new TrustedSearch_ApiRequestor($apiPublicKey, $apiPrivateKey);

    $url = self::_scopedLsb($class, 'classUrl', $class);
    
    list($response, $apiPublicKey, $apiPrivateKey) = $requestor->request('post', $url, $params, $body);
    return TrustedSearch_Util::convertToTrustedSearchObject($response, $apiPublicKey, $apiPrivateKey);
  }

  protected function _scopedSave($class){
    self::_validateCall('save');
    $requestor = new TrustedSearch_ApiRequestor($this->_apiPublicKey);
    $params = $this->serializeParameters();

    if (count($params) > 0) {
      $url = $this->instanceUrl();
      list($response, $apiPublicKey, $apiPrivateKey) = $requestor->request('post', $url, $params);
      $this->refreshFrom($response, $apiPublicKey, $apiPrivateKey);
    }
    return $this;
  }

  protected function _scopedDelete($class, $params=null){
    self::_validateCall('delete');
    $requestor = new TrustedSearch_ApiRequestor($this->_apiPublicKey);
    $url = $this->instanceUrl();
    list($response, $apiPublicKey, $apiPrivateKey) = $requestor->request('delete', $url, $params);
    $this->refreshFrom($response, $apiPublicKey, $apiPrivateKey);
    return $this;
  }

  protected static function _customRetrieve($class, $path = array(), $params=array(), $apiPublicKey=null, $apiPrivateKey=null){
    $instance = new $class(null, $apiPublicKey, $apiPrivateKey);
    $instance->setPath($path);
    $instance->setParams($params);
    $instance->refresh();
    return $instance;
  }

  protected static function _customUpdate($class, $path = array(), $params=array(), $body='', $apiPublicKey=null, $apiPrivateKey=null){
    $instance = new $class(null, $apiPublicKey, $apiPrivateKey);
    $instance->setPath($path);
    $instance->setParams($params);
    $url = $instance->instanceUrl();
    $requestor = new TrustedSearch_ApiRequestor($apiPublicKey, $apiPrivateKey);
    
    list($response, $apiPublicKey, $apiPrivateKey) = $requestor->request('put', $url, $params, $body);
    $instance->refreshFrom($response, $apiPublicKey, $apiPrivateKey);
    return $instance;
  }

  protected static function _customCreate($class, $path = array(), $params=array(), $body='', $apiPublicKey=null, $apiPrivateKey=null){
    $instance = new $class(null, $apiPublicKey, $apiPrivateKey);
    $instance->setPath($path);
    $instance->setParams($params);
    $url = $instance->instanceUrl();
    $requestor = new TrustedSearch_ApiRequestor($apiPublicKey, $apiPrivateKey);
    
    list($response, $apiPublicKey, $apiPrivateKey) = $requestor->request('post', $url, $params, $body);
    $instance->refreshFrom($response, $apiPublicKey, $apiPrivateKey);
    return $instance;
  }

}
