<?php
/**
 * 上传图片
 * @author liang
 * @version 2014-6-17
 */
class Aj_Img_UploadController extends AbstractController{
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		$fileName= '/tmp/phpBs9Bsc';
		$fileStr = file_get_contents($fileName);
		
		
		$url = 'http://127.0.0.1/api/upload/uploadimg?vbb=111';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');	
		curl_setopt($ch, CURLOPT_POSTFIELDS, array('aaa'=>111,'fileStr'=>$fileStr));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ret = curl_exec($ch);
		$info = curl_getinfo($ch);
		$errorMsg = curl_error ( $ch );
		$errorNumber = curl_errno ( $ch );
		curl_close ( $ch );
		
		var_dump($ret);
		return true;
	}
}