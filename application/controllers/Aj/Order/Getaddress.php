<?php
/**
 * 获得当前用户的收货地址
 * @author liang
 * @version 2014-10-23
 */
class Aj_Order_GetaddressController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['uid'] = $this->viewer['uid'];
		
		$addressInfos = Dr_Order::getAddressByUidByApi($info);

		$code = Tools_Conf::get('Show_Code.aj.succ');
		
		$this->renderAjax($code,'succ',$addressInfos);
		
		return true;
	}
}