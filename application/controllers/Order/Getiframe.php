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
		$headerArr[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
		$headerArr[] = 'Accept-Encoding: gzip, deflate';
		$headerArr[] = 'Accept-Language: zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3';
		$headerArr[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36';
		$headerArr[] = 'Connection: Keep-Alive';
		$headerArr[] = 'Host: redirect.viglink.com';
		$headerArr[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36';
		//$user_agent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36';
		
		if(!empty($thirdUrl)){
			$ch = curl_init($thirdUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($ch, CURLOPT_HTTPHEADER , $headerArr );
			//curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$content = curl_exec($ch) ;
			$curlInfo = curl_getinfo($ch);
			curl_close($ch);
		}
		
		//兼容302 301跳转 重复5次就结束
		$i = 0;
		while($curlInfo['http_code'] == 302 || $curlInfo['http_code'] == 301){
			$url = $curlInfo['redirect_url'];
			$i++;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($ch, CURLOPT_HTTPHEADER , $headerArr );
			//curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);
			curl_setopt($ch, CURLOPT_HEADER, false);
			$content = curl_exec($ch) ;
			$curlInfo = curl_getinfo($ch);
			curl_close($ch);
			if($i > 5){
				break;
			}
		}

		if($curlInfo['http_code'] == 400 || $curlInfo['http_code'] != 200){
			$content = '暂时无法显示';
		}
		
		//获得url域名
		$urlArr = parse_url($url);
		
		if(in_array($urlArr['host'],Tools_Conf::get('Domain.domain.noflitejs'))){
			$content = preg_replace("/<script[^>]*?>.*?<\/script>/smi", "", $content);
		}
		
		
		echo $content;
		return true;
	}
}