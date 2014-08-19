<?php
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
class Aj_Third_AmazonController extends AbstractController{
	public $tpl = 'third/amazon.phtml';
	public $authorize = self::MAYBELOGIN;
	public function indexAction(){
		$amazonurl = Comm_Context::post('amazonurl');
		
		$urlArr = parse_url($amazonurl);
		
		if(empty($amazonurl) || empty($urlArr['host'])){
			$code = Tools_Conf::get('Show_Code.aj.fail');
			$this->renderAjax($code);
		}else{
			$pathArr = explode('/', $urlArr['path']);
			$i = count($pathArr) - 2;
			$amazonIdList = array('Id.1'=>$pathArr[count($pathArr) - 2]);
			
			$serviceUrl = "https://mws.amazonservices.com/Products/2011-10-01";
			$config = array (
				'ServiceURL' => $serviceUrl,
				'ProxyHost' => null,
				'ProxyPort' => -1,
				'MaxErrorRetry' => 3,
			);
			$service = new MarketplaceWebServiceProducts_Client(
	        	AWS_ACCESS_KEY_ID,
	        	AWS_SECRET_ACCESS_KEY,
	        	APPLICATION_NAME,
	        	APPLICATION_VERSION,
	        	$config);
	        	
			$request = new MarketplaceWebServiceProducts_Model_GetMatchingProductForIdRequest();
			$request->setSellerId(MERCHANT_ID);
			$request->setMarketplaceId(MARKETPLACE_ID);
			$request->setIdType('ASIN');
			$request->setIdList($amazonIdList);
	
			$result = $this->invoke($service, $request, 'GetMatchingProductForId');
			var_dump($result,$amazonIdList);exit;
			$matchingProductForIdResult = $result['GetMatchingProductForIdResponse']['GetMatchingProductForIdResult']['Products']['Product'];
			unset($result);
			unset($request);
			
			//测试接口 matchingProduct
			/*$amazonASINList = array('ASIN.1'=>$pathArr[3]);
			$request = new MarketplaceWebServiceProducts_Model_GetMatchingProductRequest();
			$request->setSellerId(MERCHANT_ID);
			$request->setMarketplaceId(MARKETPLACE_ID);
			$request->setASINList($amazonASINList);
			
			$result = $this->invoke($service, $request, 'GetMatchingProduct');
			$matchingProductResult = $result;
			unset($result);
			unset($request);*/
			
			//测试接口 competitivePriceingForASINRequest
			/*$request = new MarketplaceWebServiceProducts_Model_GetCompetitivePricingForASINRequest();
			$request->setSellerId(MERCHANT_ID);
			$request->setMarketplaceId(MARKETPLACE_ID);
			$request->setASINList($amazonASINList);
			
			// object or array of parameters
			$result = $this->invoke($service, $request, 'GetCompetitivePricingForASIN');
			$competitivePriceForASINRequest = $result;
			unset($result);
			unset($request);*/
			
			//测试接口 LowestOfferListingsForASIN
			/*$amazonASINList = array('ASIN.1'=>$pathArr[3]);
			$request = new MarketplaceWebServiceProducts_Model_GetLowestOfferListingsForASINRequest();
			$request->setSellerId(MERCHANT_ID);
			$request->setMarketplaceId(MARKETPLACE_ID);
			$request->setASINList($amazonASINList);
			
			// object or array of parameters
			$result = $this->invoke($service, $request, 'GetLowestOfferListingsForASIN');
			$lowestOfferListingsForASINResult = $result;
			unset($result);
			unset($request);*/
			
			
			
			if(!empty($matchingProductForIdResult['AttributeSets']['ns2:ItemAttributes']['ns2:Feature'])){
				foreach($matchingProductForIdResult['AttributeSets']['ns2:ItemAttributes']['ns2:Feature'] as $feature){
					$data['feature'] .= $feature;
				}
			}
			
			$data['title'] = $matchingProductForIdResult['AttributeSets']['ns2:ItemAttributes']['ns2:Title'];
			$data['price'] = $matchingProductForIdResult['AttributeSets']['ns2:ItemAttributes']['ns2:ListPrice']['ns2:Amount'];
			$data['currencyCode'] = $matchingProductForIdResult['AttributeSets']['ns2:ItemAttributes']['ns2:ListPrice']['ns2:CurrencyCode'];
			$data['img'] = $matchingProductForIdResult['AttributeSets']['ns2:ItemAttributes']['ns2:SmallImage']['ns2:URL'];
			$data['img'] = str_replace('_SL75_', '_SL400_', $data['img']);
			$data['thirdurl'] = $amazonurl;
			//$this->renderPage('third/amazonre.phtml',$data);
			
			$code = Tools_Conf::get('Show_Code.aj.succ');
			$this->renderAjax($code,'',$data);
		}

		return true;
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