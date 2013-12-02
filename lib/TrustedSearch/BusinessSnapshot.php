<?php 

class TrustedSearch_BusinessSnapshot extends TrustedSearch_ApiResource{

	public static function get($uuid = null, $since = null, $apiPublicKey=null, $apiPrivateKey=null){

		$path = array();
		$params = array();
		
		if($uuid){
			$path = array($uuid);
		}

		if($since){
			$params = array('since'=>$since);
		}

		$class = get_class();
		return self::_customRetrieve($class, $path, $params, $apiPublicKey, $apiPrivateKey);		
	}

}