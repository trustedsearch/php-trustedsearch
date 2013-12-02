<?php

class TrustedSearch_ApiRequestor
{
  public $_apiPublicKey;
  public $_apiPrivateKey;

  public function __construct($apiPublicKey=null, $apiPrivateKey=null)
  {
    $this->_apiPublicKey = $apiPublicKey;
    $this->_apiPrivateKey = $apiPrivateKey;
  }

  public static function apiUrl($url='')
  {
    $apiBase = TrustedSearch::getApiBaseUrl(TrustedSearch::$apiEnvironemnt);
    return "$apiBase$url";
  }

  public static function utf8($value)
  {
    if (is_string($value) && mb_detect_encoding($value, "UTF-8", TRUE) != "UTF-8")
      return utf8_encode($value);
    else
      return $value;
  }

  private static function _encodeObjects($d)
  {
    if ($d instanceof TrustedSearch_ApiResource) {
      return self::utf8($d->id);
    } else if ($d === true) {
      return 'true';
    } else if ($d === false) {
      return 'false';
    } else if (is_array($d)) {
      $res = array();
      foreach ($d as $k => $v)
      	$res[$k] = self::_encodeObjects($v);
      return $res;
    } else {
      return self::utf8($d);
    }
  }

  public static function encode($arr, $prefix=null)
  {
    if (!is_array($arr))
      return $arr;

    $r = array();
    foreach ($arr as $k => $v) {
      if (is_null($v))
        continue;

      if ($prefix && $k && !is_int($k))
        $k = $prefix."[".$k."]";
      else if ($prefix)
        $k = $prefix."[]";

      if (is_array($v)) {
        $r[] = self::encode($v, $k, true);
      } else {
        $r[] = urlencode($k)."=".urlencode($v);
      }
    }

    return implode("&", $r);
  }

  public function request($meth, $url, $params=array(), $body='')
  {
    // echo "\nPARAMS: ".json_encode($params);
    // echo "\nRESOURCE: ".$url;
    // echo "\nBODY: ".json_encode($body);
    list($rbody, $rcode, $myApiPublicKey, $myApiPrivateKey) = $this->_requestRaw($meth, $url, $params, (is_array($body)?json_encode($body):''));
//    echo "\nRespone Code: ".($rcode);
    
    $resp = $this->_interpretResponse($rbody, $rcode);
    return array($resp, $myApiPublicKey, $myApiPrivateKey);
  }

  public function handleApiError($rbody, $rcode, $resp)
  {
    if (!is_array($resp) || !isset($resp['error']))
      throw new TrustedSearch_ApiError("Invalid response object from API: $rbody (HTTP response code was $rcode)", $rcode, $rbody, $resp);
    
    switch ($rcode) {
    case 400:
    case 404:
      throw new TrustedSearch_InvalidRequestError(isset($resp['message']) ? $resp['message'] : null,
                                           isset($resp['param']) ? $resp['param'] : null,
                                           $rcode, $rbody, $resp);
    case 401:
      throw new TrustedSearch_AuthenticationError(isset($resp['message']) ? $resp['message'] : null, $rcode, $rbody, $resp);
    case 402:
      throw new TrustedSearch_CardError(isset($resp['message']) ? $resp['message'] : null,
                                 isset($resp['param']) ? $resp['param'] : null,
                                 isset($resp['code']) ? $resp['code'] : null,
                                 $rcode, $rbody, $resp);
    default:
      throw new TrustedSearch_ApiError(isset($resp['message']) ? $resp['message'] : null, $rcode, $rbody, $resp);
    }
  }

  private function _getDate(){
    $date = new \DateTime();
    return $date->format($date::RFC1123);
  }
  private function _requestRaw($meth, $url, $params = array(), $body = '')
  {
    $apiPublicKey = $this->_apiPublicKey;
    $apiPrivateKey = $this->_apiPrivateKey;
    if (!$apiPublicKey){
      $apiPublicKey = TrustedSearch::$apiPublicKey;
    }
      
    if (!$apiPublicKey){
      throw new TrustedSearch_AuthenticationError('No API Public key provided.  (HINT: set your API key using "TrustedSearch::setApiPublicKey(<API-KEY>)".  You can generate API keys from the TrustedSearch web interface.  See https://trustedsearch.org/api for details, or email support@trustedsearch.org if you have any questions.');
    }
      
    if (!$apiPrivateKey){
      $apiPrivateKey = TrustedSearch::$apiPrivateKey;  
    }
      
    if (!$apiPrivateKey){
      throw new TrustedSearch_AuthenticationError('No API Private key provided.  (HINT: set your API key using "TrustedSearch::setApiPrivateKey(<API-KEY>)".  You can generate API keys from the TrustedSearch web interface.  See https://trustedsearch.org/api for details, or email support@trustedsearch.org if you have any questions.');
    }

    if (!TrustedSearch::getApiVersion()){
      throw new TrustedSearch_AuthenticationError('No API Version specified.  (HINT: set your API key using "TrustedSearch::setApiVersion(<API-KEY>)".  You can generate API keys from the TrustedSearch web interface.  See https://trustedsearch.org/api for details, or email support@trustedsearch.org if you have any questions.');
    }

    $absUrl = $this->apiUrl($url);
    $params = self::_encodeObjects($params);
    
    $langVersion = phpversion();
    $uname = php_uname();
    $ua = array(
      'bindings_version' => TrustedSearch::VERSION,
		  'lang' => 'php',
		  'lang_version' => $langVersion,
		  'publisher' => 'trustedsearch',
		  'uname' => $uname
    );
    
    $headers = array(
      'X-TrustedSearch-Client-User-Agent: ' . json_encode($ua),
		  'User-Agent: TrustedSearch/v1 PhpBindings/' . TrustedSearch::VERSION,
      'Content-Type:   application/json'
    );
    
    if (TrustedSearch::$apiVersion){
      $headers[] = 'TrustedSearch-Version: ' . TrustedSearch::$apiVersion;
    }

    //Handle Authentication/Signature
    switch (TrustedSearch::getApiVersion()) {
      case '1':

        $timestamp = time();
        $request = array(
          'resource' => $url,
          'content' => $body,
          'timestamp' => $timestamp,
          'privateKey' => TrustedSearch::$apiPrivateKey
        );

        $signature = $this->_generateV1Signature($request);
        $params = array_merge($params, array(
          'signature'=>$signature, 
          'apikey'=>TrustedSearch::$apiPublicKey,
          'timestamp' => $timestamp
          )
        );
        # code...
        break;
      
      default:
        # code...
        break;
    }

    //$body = json_encode($body);

      
    list($rbody, $rcode) = $this->_curlRequest($meth, $absUrl, $headers, $params, $body);

    return array($rbody, $rcode, $apiPublicKey, $apiPrivateKey);
  }

  private function _generateV1Signature($request){
    
    $signature = base64_encode( hash_hmac( 'sha1', 
      $request['resource'] . ( (!empty($request['content'])) ? base64_encode(md5($request['content'],true)) : "" ) . $request['timestamp'], $request['privateKey'], true ) 
    );
    
    
    return $signature;
  }

  /**
   * generate a valid hmac based upon content provided.
   * @param  string $privateKey  The private key assigned to the user.
   * @param  string $action      Usually GET, POST, PUT, DELETE
   * @param  string $resource    Full url including query params.
   * @param  string $date        Valide Date in RFC 1123 format
   * @param  string $content     Body of POST/PUT request. Get is likely.
   * @param  string $contentType ['', 'application/json']
   * @return string              base 64 encoded value of values provided.
   */
  private function _generateV2Signature($privateKey, $method = '', $resource = '', $timestamp = '', $content = '', $contentType = ''){

    //Create an array of the parts of the signature.
    $signatureParts = array(
      $method,
      base64_encode(md5($content,true)),
      $contentType,
      $timestamp,
      $resource
    );


    $toSign = implode("", $signatureParts);
    $toSign =  hash_hmac( 'sha1', $toSign, $privateKey );
    $hmac = base64_encode($toSign);
    
    return $hmac;
  }

  private function _interpretResponse($rbody, $rcode)
  {
    
    try {
      $resp = json_decode($rbody, true);
    } catch (Exception $e) {
      throw new TrustedSearch_ApiError("Invalid response body from API: $rbody (HTTP response code was $rcode)", $rcode, $rbody);
    }

    if ($rcode < 200 || $rcode >= 300) {
      $this->handleApiError($rbody, $rcode, $resp);
    }
    return $resp;
  }

  private function _curlRequest($meth, $absUrl, $headers, $params, $body = '')
  {
    $curl = curl_init();
    $meth = strtolower($meth);
    $opts = array();
    if ($meth == 'get') {
      $opts[CURLOPT_HTTPGET] = 1;
      if (count($params) > 0) {
        	$encoded = self::encode($params);
        	$absUrl = "$absUrl?$encoded";
      }
    }else if ($meth == 'post') {

      if (count($params) > 0) {
          $encoded = self::encode($params);
          $absUrl = "$absUrl?$encoded";
      }
      $opts[CURLOPT_POST] = 1;

      if(!empty($body)){
        $opts[CURLOPT_POSTFIELDS] = self::encode($body);  
      }
    }else if ($meth == 'put')  {
      $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
      if (count($params) > 0) {
        $encoded = self::encode($params);
        $absUrl = "$absUrl?$encoded";
      }
      if(!empty($body)){
        $opts[CURLOPT_POSTFIELDS] = self::encode($body);  
      } 
    }else if ($meth == 'delete')  {
      $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
      if (count($params) > 0) {
      	$encoded = self::encode($params);
      	$absUrl = "$absUrl?$encoded";
      }
    } else {
      throw new TrustedSearch_ApiError("Unrecognized method $meth");
    }

    $absUrl = self::utf8($absUrl);
    $opts[CURLOPT_URL] = $absUrl;
    $opts[CURLOPT_RETURNTRANSFER] = true;
    $opts[CURLOPT_CONNECTTIMEOUT] = 30;
    
    $opts[CURLOPT_RETURNTRANSFER] = true;
    $opts[CURLOPT_HTTPHEADER] = $headers;
    if (!TrustedSearch::$verifySslCerts)
      $opts[CURLOPT_SSL_VERIFYPEER] = false;

    curl_setopt_array($curl, $opts);
    $rbody = curl_exec($curl);

    $errno = curl_errno($curl);
    if ($errno == CURLE_SSL_CACERT ||
      	$errno == CURLE_SSL_PEER_CERTIFICATE ||
      	$errno == 77 // CURLE_SSL_CACERT_BADFILE (constant not defined in PHP though)
      ){
      array_push($headers, 'X-TrustedSearch-Client-Info: {"ca":"using TrustedSearch-supplied CA bundle"}');
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__) . '/../data/ca-certificates.crt');
      $rbody = curl_exec($curl);
    }

    if ($rbody === false) {
      $errno = curl_errno($curl);
      $message = curl_error($curl);
      curl_close($curl);
      $this->handleCurlError($errno, $message);
    }

    $rcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    return array($rbody, $rcode);
  }

  public function handleCurlError($errno, $message)
  {
    $apiBase = TrustedSearch::$apiBase;
    switch ($errno) {
    case CURLE_COULDNT_CONNECT:
    case CURLE_COULDNT_RESOLVE_HOST:
    case CURLE_OPERATION_TIMEOUTED:
      $msg = "Could not connect to TrustedSearch ($apiBase).  Please check your internet connection and try again.  If this problem persists, you should check TrustedSearch's service status at https://twitter.com/trustedsearchstatus, or let us know at support@trustedsearch.org.";
      break;
    case CURLE_SSL_CACERT:
    case CURLE_SSL_PEER_CERTIFICATE:
      $msg = "Could not verify TrustedSearch's SSL certificate.  Please make sure that your network is not intercepting certificates.  (Try going to $apiBase in your browser.)  If this problem persists, let us know at support@trustedsearch.org.";
      break;
    default:
      $msg = "Unexpected error communicating with TrustedSearch.  If this problem persists, let us know at support@trustedsearch.org.";
    }

    $msg .= "\n\n(Network error [errno $errno]: $message)";
    throw new TrustedSearch_ApiConnectionError($msg);
  }
}