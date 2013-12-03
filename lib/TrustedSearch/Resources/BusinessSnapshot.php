<?php 

class TrustedSearch_BusinessSnapshot extends TrustedSearch_ApiResource{

	/**
	 * Get the latest snapshot data for a given location
	 * @param  string $locationId     required location id
	 * @param  integer $since         [optional unix timestamp to retrieve snapshots from this point in time defaults to all time]
	 * @param  string $apiPublicKey  [optional key]
	 * @param  string $apiPrivateKey [optional key]
	 * @return TrustedSearch Object           
	 */
	public static function get($locationId = null, $since = null, $apiPublicKey=null, $apiPrivateKey=null){
		$path = array();
		$params = array();

		if($locationId){
			$path = array('business-snapshots', $locationId);
		}

		if($since){
			$params = array('since'=>$since);
		}

		$class = get_class();
		return self::_get($class, $path, $params, $apiPublicKey, $apiPrivateKey);		
	}

	/**
	 * Simulates the changes made by trustedsearch location fulfillment.
	 * @param  string $locationId    required location id
	 * @param  string $apiPublicKey  [optional public key]
	 * @param  string $apiPrivateKey [optional private key]
	 * @return array                array w/ response, and public/private keys
	 */
	public static function simulate($locationId, $apiPublicKey=null, $apiPrivateKey=null){
		$path = array('test-fulfillment', $locationId);
		$class = get_class();
		return self::_put($class, $path, array(),'');
	}

}