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
		
		if(!empty($thirdUrl)){
			$ch = curl_init($thirdUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$content = curl_exec($ch) ;
			curl_close($ch);
		}
		
		$content = preg_replace("/<script[^>]*?>.*?<\/script>/smi", "", $content);
		
		echo $content;
		return true;
	}
}