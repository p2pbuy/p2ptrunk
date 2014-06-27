<?php
/**
 * 上传图片
 * @author liang
 * @version 2014-6-17
 */
class Api_Img_UploadController extends Api_AbstractController{
	private $filePath = '/Data/www/htdocs/pic/';
	public function checkParams(){
		$this->_context['fileStr'] = file_get_contents('php://input');
		$this->_context['fileName'] = Comm_Context::post('filename');
		if(empty($this->_context['fileName'])){
			return false;
		}
		
		$this->_checkFields = array('fileName'=>$this->_context['fileName']);
		return true;
	}
	
	public function doAction(){
		$file = $this->filePath.$fileName;
		
		$fp = fopen($file, 'w');
		fwrite($fp, $fileStr);
		fclose($fp);
		return true;
	}
}