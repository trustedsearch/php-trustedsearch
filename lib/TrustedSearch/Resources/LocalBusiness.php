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

	/**
	 * Get the location data
	 * @param  string $locationId     required location id
	 * @param  string $apiPublicKey  [optional key]
	 * @param  string $apiPrivateKey [optional key]
	 * @return TrustedSearch Object           
	 */
	public static function get($locationId = null,$apiPublicKey=null, $apiPrivateKey=null){
		$path = array();
		$params = array();

		if($locationId){
			$path = array('local-business', $locationId);
		}

		$class = get_class();
		return self::_get($class, $path, $params, $apiPublicKey, $apiPrivateKey);		
	}

    public static function validate($data=null, $apiPublicKey=null, $apiPrivateKey=null){
        $path = array('validate');
        $class = get_class();
        return self::_post($class, $path, array(),$data, $apiPublicKey, $apiPrivateKey);
    }



}