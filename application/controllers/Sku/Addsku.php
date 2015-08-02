<?php
/**
 * 添加sku
 * @author liang
 * @version 2014-8-2
 */
class Sku_AddskuController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public $tpl = 'sku/addsku.phtml';
	public function hookAction(){
		//如果不是管理员，返回false
		if($this->viewer['uid'] != Tools_Conf::get('Manager.uid')){
			$code = Tools_Conf::get('Show_Code.aj.fail');
			$msg = 'you are not manager';
			$this->renderAjax($code,$msg);
			return false;
		}
		
		$data = array();
		$this->renderPage($this->tpl,$data);
		return true;
	}
}