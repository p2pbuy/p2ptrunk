<?php
/**
 * 上传图片
 * @author liang
 * @version 2014-6-17
 */
class Api_Img_UploadController extends Api_AbstractController{
	public function checkParams(){
		$fileStr = file_get_contents('php://input');
		$fileName = '/tmp/test.png';
		
		$fp = fopen($fileName, 'w');
		fwrite($fp, $fileStr);
		fclose($fp);
		
		return true;
	}
	
	public function doAction(){
		return true;
	}
}