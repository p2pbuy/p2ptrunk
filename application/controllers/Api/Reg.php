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
		$info['email'] = $this->_context['email'];
		$info['nick'] = $this->_context['nick'];
		$info['passwd'] = $this->_context['passwd'];

		echo 'doAction';
		return true;
	}
}