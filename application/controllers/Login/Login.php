<?php
/**
 * 未登录首页
 * @author liang
 * 2014-5-22
 */
class Login_LoginController extends AbstractController{
	public $tpl = 'login/login.phtml';
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		$data = array();
		$this->renderPage($this->tpl,$data);
		return true;
	}
}