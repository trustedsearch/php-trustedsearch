<?php 
/**
 * Listings API :
 * Requires V2:
 */
class TrustedSearch_Listing extends TrustedSearch_ApiResource{

	/**
	 * Page through listings associated w/ publisher.
	 * @param  integer $page    page to return in result set.
	 * @param  array   $filters fields to limit results set to. Applies a SQL  WHERE X AND Y AND Z
	 * @param  integer  $perPage results to return per page.
	 * @param  string  $sort    [asc, desc] defaults to asc.
	 * @param  string  $orderBy field to sort on.
	 * @return array   with record and pagination data. Refer do docs for more detail.
	 */
	public static function index($page=0, $filters = array(), $perPage = null, $sort = null, $orderBy = null, $apiPublicKey=null, $apiPrivateKey=null){

		$path = array();
		$params = array(
			'page' => $page
		);

		//Add filters
		foreach ($filters as $key => $value) {
			$params[$key] = $value;
		}

		if($perPage){
			$params['per_page'] = $perPage;
		}

		if($sort){
			$params['sort'] = $sort;
		}

		if($orderBy){
			$params['orderBy'] = $orderBy;
		}

		$class = get_class();
		return self::_get($class, $path, $params, $apiPublicKey, $apiPrivateKey);	
	}


	/**
	 * Get the latest snapshot data for a given location
	 * @param  string $locationId     required location id
	 * @param  string $apiPublicKey  [optional key]
	 * @param  string $apiPrivateKey [optional key]
	 * @return TrustedSearch Object           
	 */
	public static function get($listingId, $apiPublicKey=null, $apiPrivateKey=null){
		$path = array();
		$params = array();

		if($listingId){
			$path = array('listings', $listingId);
		}

		$class = get_class();
		return self::_get($class, $path, $params, $apiPublicKey, $apiPrivateKey);		
	}


	/**
	 * Update a listing record.
	 * @param  [type] $listingId     the id of the listing to update.
	 * @param  [type] $data          the listing data to edit.
	 * @param  [type] $apiPublicKey  [description]
	 * @param  [type] $apiPrivateKey [description]
	 * @return [type]                [description]
	 */
	public static function update($listingId, $data, $apiPublicKey=null, $apiPrivateKey=null){
		$path = array();
		$params = array();
		$body = $data;
		$path = array('listings', $listingId);
		$class = get_class();
		return self::_put($class, $path, $params, $body, $apiPublicKey, $apiPrivateKey);	
	}

	/**
	 * Get the latest snapshot data for account since a given point in time.
	 * @param  integer $since         [optional unix timestamp to retrieve snapshots from this point in time defaults to all time]
	 * @param  string $apiPublicKey  [optional key]
	 * @param  string $apiPrivateKey [optional key]
	 * @return TrustedSearch Object           
	 */
	public static function getByLocationAndProductName($locationId, $productName, $apiPublicKey=null, $apiPrivateKey=null){
		$params = array();
		$path = array('listings/by-location-and-product-name', $locationId, $productName);
		$class = get_class();
		return self::_get($class, $path, $params, $apiPublicKey, $apiPrivateKey);		
	}

	

}