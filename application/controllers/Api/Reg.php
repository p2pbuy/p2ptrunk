<?php
class Api_RegController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = $entry = Comm_Context::get('source');
		$this->_context['email'] = Comm_Context::get('email');
		$this->_context['nick'] = Comm_Context::get('nick');
		$this->_context['passwd'] = Comm_Context::get('passwd');
		$this->_context['sign'] = Comm_Context::get('sign');
		
		$this->_checkFields = array('entry' => $entry);
		return true;
	}
	public function doAction(){
		echo 'doAction';
		return true;
	}
}