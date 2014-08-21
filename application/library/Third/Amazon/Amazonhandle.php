<?php
/**
 * 使用amazon接口的handle
 * @author liang5
 * @version 2014-8-21
 */
require_once(LIB_PATH.'/Third/Amazon/MarketplaceWebServiceProducts/Client.php');
require_once(LIB_PATH.'/Third/Amazon/MarketplaceWebServiceProducts/Model/GetMatchingProductForIdRequest.php');
require_once(LIB_PATH.'/Third/Amazon/MarketplaceWebServiceProducts/Model/GetMatchingProductRequest.php');
require_once(LIB_PATH.'/Third/Amazon/MarketplaceWebServiceProducts/Model/GetCompetitivePricingForASINRequest.php');
require_once(LIB_PATH.'/Third/Amazon/MarketplaceWebServiceProducts/Model/GetLowestOfferListingsForASINRequest.php');
define('AWS_ACCESS_KEY_ID', 'AKIAI7NU45HWUD2HWVZQ');
define('AWS_SECRET_ACCESS_KEY', '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');
define('APPLICATION_NAME', 'p2p20140811');
define('APPLICATION_VERSION', '1.0');
define ('MERCHANT_ID', 'A1JP2PRO5B03Q');
define ('MARKETPLACE_ID', 'ATVPDKIKX0DER');
class Third_Amazon_Amazonhandle{
	private $config;
	private $service;
	public function __construct(){
		$serviceUrl = "https://mws.amazonservices.com/Products/2011-10-01";
		$this->config = array (
			'ServiceURL' => $serviceUrl,
			'ProxyHost' => null,
			'ProxyPort' => -1,
			'MaxErrorRetry' => 3,
		);
		$this->service = new MarketplaceWebServiceProducts_Client(
        	AWS_ACCESS_KEY_ID,
        	AWS_SECRET_ACCESS_KEY,
        	APPLICATION_NAME,
        	APPLICATION_VERSION,
        	$this->config);
	}
	
	public function GetMatchingProductForId($params = array()){
		if(empty($params['idType']) || empty($params['id'])){
			return false;
		}
		switch ($params['idType']){
			case 'ASIN' :
				$idName = 'Id';
				break;
			default :
				$idName = 'Id';
				break;
		}
		$i = 1;
		foreach($params['id'] as $id){
			$amazonIdList[$idName.'.'.$i] = $id;
			$i++;
		}

		$request = new MarketplaceWebServiceProducts_Model_GetMatchingProductForIdRequest();
		$request->setSellerId(MERCHANT_ID);
		$request->setMarketplaceId(MARKETPLACE_ID);
		$request->setIdType($params['idType']);
		$request->setIdList($amazonIdList);

		$result = $this->invoke($this->service, $request, 'GetMatchingProductForId');

		unset($request);
		return $result;
	}
	
	private function invoke(MarketplaceWebServiceProducts_Interface $service, $request, $functionName){
		if(empty($functionName)){
			return false;
		}
		
		try {
			$response = $service->$functionName($request);

			//echo ("Service Response\n");
			//echo ("=============================================================================\n");

			$dom = new DOMDocument();
			$dom->loadXML($response->toXML());
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$result = $dom->saveXML();
			$array = Tools_Xml2array::createArray($result);
			//echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");

		} catch (MarketplaceWebServiceProducts_Exception $ex) {
			echo("Caught Exception: " . $ex->getMessage() . "\n");
			echo("Response Status Code: " . $ex->getStatusCode() . "\n");
			echo("Error Code: " . $ex->getErrorCode() . "\n");
			echo("Error Type: " . $ex->getErrorType() . "\n");
			echo("Request ID: " . $ex->getRequestId() . "\n");
			echo("XML: " . $ex->getXML() . "\n");
			echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
		}
		
		return $array;
	}
}