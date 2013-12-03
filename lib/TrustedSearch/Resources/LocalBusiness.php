<?php 

class TrustedSearch_LocalBusiness extends TrustedSearch_ApiResource{

	/**
	 * Create a new locations for fulfillment.
	 * @param  array $data          an array of location orders. 
	 * @param  string $apiPublicKey  [optional public key]
	 * @param  string $apiPrivateKey [optional private key]
	 * @return TrustedSearch LocalBusiness Object
	 */
	public static function create($data=null, $apiPublicKey=null, $apiPrivateKey=null){
	  $class = get_class();
	  return self::_post($class, array(), array(),$data, $apiPublicKey, $apiPrivateKey);
	}

}