<?php
class Api_RegController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = Comm_Context::get('source');
		$this->_context['email'] = Comm_Context::get('email');
		$this->_context['nick'] = Comm_Context::get('nick');
		$this->_context['passwd'] = Comm_Context::get('passwd');
		$this->_context['sign'] = Comm_Context::get('sign');
		
		$this->_checkFields = array('email' => $this->_context['email']);
		return true;
	}
	public function doAction(){
		$info['uid'] = Dr_User::createUid();
		$info['passwd'] = md5($this->_context['passwd']);
		$info['nick'] = $this->_context['nick'];
		$info['email'] = $this->_context['email'];
		
		$re = Dw_User::regByDb($info);
		if($re == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'reg fail';
		}else{
			$code = Tools_Conf::get('Show_Code.api.succ');
		}

		$this->renderAjax($code,$msg);
		return true;
	}
}