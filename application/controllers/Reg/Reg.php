<?php
/**
 * 注册页面
 * Enter description here ...
 * @author liang
 *
 */
class Reg_RegController extends AbstractController{
	public $tpl = 'reg/reg.phtml';
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		$data = array();
		$this->renderPage($this->tpl,$data);
		return true;
	}
}