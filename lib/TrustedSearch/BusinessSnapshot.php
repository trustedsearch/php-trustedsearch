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

	/**
	 * Simulates the changes made by trustedsearch location fulfillment.
	 * @param  [type] $uuid          [description]
	 * @param  [type] $apiPublicKey  [description]
	 * @param  [type] $apiPrivateKey [description]
	 * @return [type]                [description]
	 */
	public static function simulate($locationId, $apiPublicKey=null, $apiPrivateKey=null){
		$path = array('test-fulfillment', $locationId);
		$class = get_class();
		$instance = new $class($apiPublicKey, $apiPrivateKey);
		$instance->setPath($path);
		$url = $instance->instanceUrl();
		$requestor = new TrustedSearch_ApiRequestor($apiPublicKey, $apiPrivateKey);
		return $requestor->request('post', $url);
	}

}