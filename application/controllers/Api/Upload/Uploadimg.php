<?php
/**
 * 上传图片
 * @author liang
 * @version 2014-6-17
 */
class Api_Upload_UploadimgController extends Api_AbstractController{
	private $filePath = '/Data/www/htdocs/res/img/';
	public function checkParams(){
		$this->_context['source'] = Comm_Context::get('source');
		$this->_context['fileStr'] = file_get_contents('php://input');
		$this->_context['filename'] = Comm_Context::get('filename');
		$this->_context['sign'] = Comm_Context::get('sign');
		if(empty($this->_context['filename'])){
			return false;
		}
		
		$this->_checkFields = array('filename'=>$this->_context['filename']);
		return true;
	}
	
	public function doAction(){
		$file = $this->filePath.$this->_context['filename'].'.png';
		
		try{
			$fp = @fopen($file, 'w');
			fwrite($fp, $this->_context['fileStr']);
			fclose($fp);
			$code = Tools_Conf::get('Show_Code.api.succ');
		}catch(Exception $e){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'upload failed';
		}
		
		$this->renderAjax($code,$msg,array('imgurl'=>'/img/'.$this->_context['filename'].'.png'));
		return true;
	}
}