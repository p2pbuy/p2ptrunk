<?php
abstract class Api_AbstractController extends Yaf_Controller_Abstract {
	protected $_context = array ();
	protected $_output = array ();
	protected $_checkFields = array ();
	protected $_exceptionCode = '';
	abstract public function checkParams();
	abstract public function doAction();
	public function indexAction(){
		$this->_exceptionCode = Tools_Conf::get('Exception_Code.API.EXCEPTION.CODE');
		try{
			$this->checkParams();
			$this->acl();
			$this->doAction();
		}catch(Exception $e){
			Comm_Render::renderAjax($this->_exceptionCode,$e->getMessage());
		}
		return true;
	}
	public function acl(){
		//获得acl配置
		$aclConf = Tools_Conf::get('Api_ACL');
		//判断是否有权访问
		$urlAcl = explode(',', $aclConf[$this->_context['source']]['acl']);
		$urlArray = parse_url($_SERVER['REQUEST_URI']);
		if(!in_array($urlArray['path'], $urlAcl)){
			throw new Comm_Exception('request deny');
		}
		
		//判断签名是否相等
		foreach($this->_checkFields as $value){
			$_checkFieldstr .= $value;
		}
		$sign = md5($aclConf[$this->_context['source']]['name'].$_checkFieldstr.$aclConf[$this->_context['source']]['secret_key']);
		if($sign != $this->_context['sign']){
			throw new Comm_Exception('sign was wrong');
		}
		
		return true;
	}
	public function renderAjax($code, $msg = '', $data = array()){
		echo json_encode(array('code'=>$code,'msg'=>$msg,'data'=>$data));
		return true;
	}
}