<?php
require_once(LIB_PATH.'/Third/Amazon/MarketplaceWebServiceProducts/Client.php');
require_once(LIB_PATH.'/Third/Amazon/MarketplaceWebServiceProducts/Model/GetMatchingProductForIdRequest.php');
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
			$amazonIdList = array('Id.1'=>$pathArr[3]);
			
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
	
			$result = $this->invokeGetMatchingProductForId($service, $request);
			
			if(!empty($result['AttributeSets']['ns2:ItemAttributes']['ns2:Feature'])){
				foreach($result['AttributeSets']['ns2:ItemAttributes']['ns2:Feature'] as $feature){
					$data['feature'] .= $feature;
				}
			}
			
			$data['title'] = $result['AttributeSets']['ns2:ItemAttributes']['ns2:Title'];
			$data['price'] = $result['AttributeSets']['ns2:ItemAttributes']['ns2:ListPrice']['ns2:Amount'];
			$data['currencyCode'] = $result['AttributeSets']['ns2:ItemAttributes']['ns2:ListPrice']['ns2:CurrencyCode'];
			$data['img'] = $result['AttributeSets']['ns2:ItemAttributes']['ns2:SmallImage']['ns2:URL'];
			$data['img'] = str_replace('_SL75_', '_SL400_', $data['img']);
			$data['thirdurl'] = $amazonurl;
			//$this->renderPage('third/amazonre.phtml',$data);
			
			$code = Tools_Conf::get('Show_Code.aj.succ');
			$this->renderAjax($code,'',$data);
		}

		return true;
	}
	
	private function invokeGetMatchingProductForId(MarketplaceWebServiceProducts_Interface $service, $request){
		try {
			$response = $service->GetMatchingProductForId($request);

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
		
		return $array['GetMatchingProductForIdResponse']['GetMatchingProductForIdResult']['Products']['Product'];
	}
}