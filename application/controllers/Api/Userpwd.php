<?php
/**
 * 
 * 检查用户名密码是否正确
 * @author liang
 *
 */
class Api_UserpwdController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = Comm_Context::get('source');
		$this->_context['username'] = Comm_Context::get('username');
		$this->_context['passwd'] = Comm_Context::get('passwd');
		$this->_context['sign'] = Comm_Context::get('sign');
		
		$this->_checkFields = array('username' => $this->_context['username'], 'passwd' => $this->_context['passwd']);
		return true;
	}
	public function doAction(){
		$info['username'] = $this->_context['username'];
		$info['passwd'] = md5($this->_context['passwd']);
		
		$re = Dr_User::userpasswd($info['username'],$info['passwd']);
		if($re == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'passwd was wrong';
		}else{
			$code = Tools_Conf::get('Show_Code.api.succ');
			$data = $re;
		}
		
		$this->renderAjax($code,$msg,$data);
		return true;
	}
}