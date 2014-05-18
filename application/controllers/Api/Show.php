<?php
class Api_ShowController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = Comm_Context::get('source');
		$this->_context['uid'] = Comm_Context::get('uid');
		$this->_context['sign'] = Comm_Context::get('sign');
		
		$this->_checkFields = array('email' => $this->_context['uid']);
		return true;
	}
	public function doAction(){
		$info['uid'] = $this->_context['uid'];
		
		$re = Dr_User::show($info['uid']);

		$this->renderAjax(Tools_Conf::get('Show_Code.succ'),'',$re);
		return true;
	}
}