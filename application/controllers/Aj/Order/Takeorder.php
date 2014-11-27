<?php
/**
 * 走私者接单处理页面
 * @author liang
 * @version 2014-5-25
 */
class Aj_Order_TakeorderController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['boid'] = Comm_Context::post('boid');
		$info['biduid'] = Comm_Context::post('biduid');
		$info['bidprice'] = Comm_Context::post('bidprice');
		$info['bid'] = Comm_Context::post('bid');
		$info['buid'] = $this->uid;
		$info['addressid'] = Comm_Context::post('addressid');
		//检查订单是否是当前买家的订单
		$data['uid'] = $info['buid'];
		$buyOrders = Dr_Order::showBuyOrderByUidByApi($data);
		unset($data);
		foreach($buyOrders as $buyOrder){
			$myOrders[] = $buyOrder['boid'];
		}
		if(!in_array($info['boid'], $myOrders)){
			$code = Tools_Conf::get('Show_Code.aj.fail');
			$msg = 'The order is not your order';
		}else{
			$data['boid'] = $info['boid'];
			$data['uid'] = $info['biduid'];
			//买手认领订单
			$reTakeOrder = Dw_Order::smugglerTakeOrderByApi($data);
			unset($data);
			
			$data['boid'] = $info['boid'];
			$data['lock'] = 2;
			$data['addressid'] = $info['addressid'];
			$data['dealprice'] = $info['bidprice'];
			$data['status'] = 20;
			//锁定订单
			$reUpdOrder =Dw_Order::updateBuyOrderByBoidByApi($data);
			unset($data);

			if($reTakeOrder['code'] == 100000 || $reUpdOrder == 100000){
				$code = Tools_Conf::get('Show_Code.aj.succ');
				$msg = 'succ';
			}else{
				$code = Tools_Conf::get('Show_Code.aj.fail');
				$msg = $re['msg'];
			}
		}
		
		$this->renderAjax($code,$msg);
		return true;
	}
}