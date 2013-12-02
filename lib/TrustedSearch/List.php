<?php

class TrustedSearch_List extends TrustedSearch_Object{
  public static function constructFrom($values, $apiPublicKey=null, $apiPrivateKey=null){
    $class = get_class();
    return self::scopedConstructFrom($class, $values, $apiPublicKey, $apiPrivateKey);
  }

  public function all($params=null){
    $requestor = new TrustedSearch_ApiRequestor($this->_apiPublicKey, $this->_apiPrivateKey);
    list($response, $apiPublicKey, $apiPrivateKey) = $requestor->request('get', $this['url'], $params);
    return TrustedSearch_Util::convertToTrustedSearchObject($response, $apiPublicKey, $apiPrivateKey);
  }

  public function create($params=null){
    $requestor = new TrustedSearch_ApiRequestor($this->_apiPublicKey, $this->_apiPrivateKey);
    list($response, $apiPublicKey, $apiPrivateKey) = $requestor->request('post', $this['url'], $params);
    return TrustedSearch_Util::convertToTrustedSearchObject($response, $apiPublicKey, $apiPrivateKey);
  }

  public function retrieve($id, $params=null){
    $requestor = new TrustedSearch_ApiRequestor($this->_apiPublicKey, $this->_apiPrivateKey);
    $base = $this['url'];
    $id = TrustedSearch_ApiRequestor::utf8($id);
    $extn = urlencode($id);
    list($response, $apiPublicKey, $apiPrivateKey) = $requestor->request('get', "$base/$extn", $params);
    return TrustedSearch_Util::convertToTrustedSearchObject($response, $apiPublicKey, $apiPrivateKey);
  }

}
