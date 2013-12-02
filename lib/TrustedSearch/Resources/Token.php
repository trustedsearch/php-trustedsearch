<?php

class TrustedSearch_Token extends TrustedSearch_ApiResource
{

  /**
   * Get a token
   * @param  String $username      accounts username
   * @param  String $password      accounts password
   * @param  String $apiPublicKey  [account public key]
   * @param  String $apiPrivateKey [account private key]
   * @return Object                Token object
   */
  public static function get($username, $password, $apiPublicKey=null, $apiPrivateKey=null){
    $class = get_class();
    $path = array('tokens', $username);
    $params = array('pwd'=>$password);
    return self::_customRetrieve($class, $path, $params, $apiPublicKey, $apiPrivateKey);
  }

  
}
