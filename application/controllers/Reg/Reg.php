<?php
/**
 * 注册页面
 * Enter description here ...
 * @author liang
 *
 */
class Reg_RegController extends AbstractController{
	private $tpl = 'reg/reg.phtml';
	public function hookAction(){
		$data = array();
		$this->renderPage($this->tpl,$data);
		return true;
	}
}