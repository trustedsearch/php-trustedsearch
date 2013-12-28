<?php 

class TrustedSearch_PublisherHours extends TrustedSearch_ApiResource{
	/**
	 * Internal API: Should not be used by thirdparties or partners.
	 * This API is subject to change and is not included in our TOS nor our SLA.
	 */
	
	/**
	 * Get the hours
	 * @param  string $publisher
	 * @param  string $hoursCode
	 * @param  string $apiPublicKey  [optional key]
	 * @param  string $apiPrivateKey [optional key]
	 * @return TrustedSearch Object           
	 */
	public static function get($publisher, $hoursCode ,$apiPublicKey=null, $apiPrivateKey=null){
		$params = array();
		$path = array('publisher-hours', $publisher, $hoursCode);

		$class = get_class();
		return self::_get($class, $path, $params, $apiPublicKey, $apiPrivateKey);		
	}

}