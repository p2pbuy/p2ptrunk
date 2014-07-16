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
		$this->_context['filetype'] = Comm_Context::get('filetype');
		$this->_context['sign'] = Comm_Context::get('sign');
		if(empty($this->_context['filename'])){
			return false;
		}
		
		$this->_checkFields = array('filename'=>$this->_context['filename'],'filetype'=>$this->_context['filetype']);
		return true;
	}
	
	public function doAction(){
		switch($this->_context['filetype']){
			//'image/gif','image/jpeg','image/png','image/pjpeg','image/x-png'
			case 'image/gif' :
				$filetype = 'gif';
				break;
			case 'image/jpeg' :
				$filetype = 'jpg';
				break;
			case 'image/png' :
				$filetype = 'png';
				break;
			case 'image/pjpeg' :
				$filetype = 'jpg';
				break;
			case 'image/x-png' :
				$filetype = 'png';
				break;
			default:
				$filetype = 'jpg';
				break;
		}
		$file = $this->filePath.$this->_context['filename'].'.'.$filetype;
		
		try{
			$fp = @fopen($file, 'w');
			fwrite($fp, $this->_context['fileStr']);
			fclose($fp);
			$code = Tools_Conf::get('Show_Code.api.succ');
		}catch(Exception $e){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'upload failed';
		}
		
		$this->renderAjax($code,$msg,array('imgurl'=>'/img/'.$this->_context['filename'].'.'.$filetype));
		return true;
	}
}