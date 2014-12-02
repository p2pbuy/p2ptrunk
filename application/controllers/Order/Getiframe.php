<?php
/**
 * 获得第三方页面内容
 * @author liang
 * @version 2014-10-2
 */
class Order_GetiframeController extends AbstractController{
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		$thirdUrl = Comm_Context::get('thirdurl');
		
		$headers['CLIENT-IP'] = Tools_Ip::getRandip();
		$headers['X-FORWARDED-FOR'] =  Tools_Ip::getRandip();
		foreach($_SERVER as $key => $value){
			if(strstr($key, 'HTTP_')){
				$key = str_replace('HTTP_', '', $key);
				$headers[$key] = $value;
			}
		}
		$headerArr = array();
		foreach( $headers as $n => $v ) {
			$headerArr[] = $n .':' . $v;
		}
		$headerArr[] = 'Accept: */*';
		$headerArr[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36';
		$headerArr[] = 'Connection: Keep-Alive';
		$user_agent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36';
		
		if(!empty($thirdUrl)){
			$ch = curl_init($thirdUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER , $headerArr );
			curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$content = curl_exec($ch) ;
			$curlInfo = curl_getinfo($ch);
			curl_close($ch);
		}
		if($curlInfo['http_code'] == 302){
			$ch = curl_init($curlInfo['redirect_url']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER , $headerArr );
			curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);
			curl_setopt($ch, CURLOPT_HEADER, false);
			$content = curl_exec($ch) ;
			$curlInfo = curl_getinfo($ch);
			curl_close($ch);
		}
		if($curlInfo['http_code'] == 301){
			$ch = curl_init($curlInfo['redirect_url']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER , $headerArr );
			curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);
			curl_setopt($ch, CURLOPT_HEADER, false);
			$content = curl_exec($ch) ;
			$curlInfo = curl_getinfo($ch);
			curl_close($ch);
		}
		if($curlInfo['http_code'] == 400){
			$content = '暂时无法显示';
		}
		
		$content = preg_replace("/<script[^>]*?>.*?<\/script>/smi", "", $content);
		
		echo $content;
		return true;
	}
}