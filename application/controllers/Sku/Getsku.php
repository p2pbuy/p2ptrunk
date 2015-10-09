<?php
/**
 * 获取sku
 * @author liang
 * @version 2015-10-9
 */
class Sku_GetskuController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public $tpl = 'sku/getsku.phtml';
	public function hookAction(){
		//如果不是管理员，返回false
		if($this->viewer['uid'] != Tools_Conf::get('Manager.uid')){
			$code = Tools_Conf::get('Show_Code.aj.fail');
			$msg = 'you are not manager';
			$this->renderAjax($code,$msg);
			return false;
		}
		
		$sku_list = Dr_Sku::getSkuByApi();
		
		$data = array('sku_list' => $sku_list['data']);
		$this->renderPage($this->tpl,$data);
		return true;
	}
}