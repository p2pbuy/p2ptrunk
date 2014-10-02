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
			$content = file_get_contents($thirdUrl);
		}
		
		echo $content;
		return true;
	}
}