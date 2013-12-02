<?php 

class TrustedSearch_LocalBusiness extends TrustedSearch_ApiResource{

	public static function create($data=null, $apiPublicKey=null, $apiPrivateKey=null)
	{
	  $class = get_class();
	  return self::_scopedCreate($class, array(), $data, $apiPublicKey, $apiPrivateKey);
	}

}