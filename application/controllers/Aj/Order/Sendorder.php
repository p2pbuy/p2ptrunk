<?php
/**
 * 发货
 * @author liang
 * @version 2014-12-16
 */
class Aj_Order_SendorderController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['boid'] = Comm_Context::post('boid');
		
		if(empty($info['boid']) || !is_numeric($info['boid'])){
			return false;
		}
		
		$data['uid'] = $this->viewer['uid'];
		$tokenOrderInfo = Dr_Order::showTakeOrderByUidByApi($data);
		$tokenOrderBoids = array_keys($tokenOrderInfo);
		
		
		//检查当前用户是否是管理员buyer
		if(!in_array($info['boid'],$tokenOrderBoids)){
			return false;
		}
		
		$data['boid'] = $info['boid'];
		$data['status'] = 40;
		//更新订单为发货
		$re = Dw_Order::updateBuyOrderByBoidByApi($data);
		
		$code = Tools_Conf::get('Show_Code.aj.succ');
		$msg = 'succ';
		
		$this->renderAjax($code,$msg);
		return true;
	}
}