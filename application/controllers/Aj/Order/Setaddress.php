<?php
/**
 * 添加新的收货地址 如果收货地址完全一样，则返回相应id
 * @author liang
 * @version 2014-10-3
 */
class Aj_Order_SetaddressController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['name'] = Comm_Context::post('name');
		$info['country'] = Comm_Context::post('country');
		$info['province'] = Comm_Context::post('province');
		$info['city'] = Comm_Context::post('city');
		$info['addrdetail'] = Comm_Context::post('addrdetail');
		$info['mobile'] = Comm_Context::post('mobile');
		$info['uid'] = $this->viewer['uid'];
		
		if(empty($info['name']) || empty($info['country']) || empty($info['province']) || empty($info['city']) || empty($info['addrdetail']) || empty($info['mobile'])){
			$code = Tools_Conf::get('Show_Code.aj.fail');
		}
		
		$result = Dw_Order::setAddressByApi($info);
		
		$this->renderAjax($result['code']);
		
		return true;
	}
}