<?php

abstract class TrustedSearch_ApiResource extends TrustedSearch_Object{

  protected $_apiRequestPath;
  protected $_apiRequestParams;
  protected $_apiRequestBody;

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
    if(!empty($this->_apiRequestPath)){
      $url = $this->_lsb('pathUrl', $this->_apiRequestPath);
    }else{
      $class = get_class($this);
      $url = $this->_lsb('classUrl', $class);
    }

    return $url;
  }

  public function setPath($path = array()){
    if(!empty($path)){
      $this->_apiRequestPath = $path;  
    }
  }

  public function setParams($params = array()){
    if(!empty($params)){
      $this->_apiRequestParams = $params;  
    }
  }

  public function setResponse($response){
    $this->_apiResponse = $response;
  }

  public function getResponse(){
    return $this->_apiResponse;
  }

  public function getData(){
    $data = $this->getResponse();
    return $data['body'];
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

  protected static function _get($class, $path = array(), $params=array(), $apiPublicKey=null, $apiPrivateKey=null, $authenticate = true){
    $instance = new $class(null, $apiPublicKey, $apiPrivateKey);
    $instance->setPath($path);
    $instance->setParams($params);
    $url = $instance->instanceUrl();
    $requestor = new TrustedSearch_ApiRequestor($apiPublicKey, $apiPrivateKey);
    if(!$authenticate){
      $requestor->disableAuthentication();  
    }
    $response = $requestor->request('get', $url, $params);
    $instance->setResponse($response);
    return $instance;

  }

  protected static function _put($class, $path = array(), $params=array(), $body='', $apiPublicKey=null, $apiPrivateKey=null, $authenticate = true){
    $instance = new $class(null, $apiPublicKey, $apiPrivateKey);
    $instance->setPath($path);
    $instance->setParams($params);
    $url = $instance->instanceUrl();
    $requestor = new TrustedSearch_ApiRequestor($apiPublicKey, $apiPrivateKey);
    if(!$authenticate){
      $requestor->disableAuthentication();  
    }
    $response = $requestor->request('put', $url, $params, $body);
    $instance->setResponse($response);
    return $instance;
  }

  protected static function _post($class, $path = array(), $params=array(), $body='', $apiPublicKey=null, $apiPrivateKey=null, $authenticate = true){
    $instance = new $class(null, $apiPublicKey, $apiPrivateKey);
    $instance->setPath($path);
    $instance->setParams($params);
    $url = $instance->instanceUrl();
    $requestor = new TrustedSearch_ApiRequestor($apiPublicKey, $apiPrivateKey);
    if(!$authenticate){
      $requestor->disableAuthentication();  
    }
    
    $response = $requestor->request('post', $url, $params, $body);
    $instance->setResponse($response);
    return $instance;
  }

}
