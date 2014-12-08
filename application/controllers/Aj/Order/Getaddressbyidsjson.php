<?php
/**
 * 获得用户的收货地址
 * @author liang
 * @version 2014-12-8
 */
class Aj_Order_GetaddressbyidsjsonController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['ids'] = Comm_Context::post('ids','int');
		
		$addressInfos = Dr_Order::getAddressByIdsByApi($info);

		$code = Tools_Conf::get('Show_Code.aj.succ');
		
		$this->renderAjax($code,'succ',$addressInfos);
		
		return true;
	}
}