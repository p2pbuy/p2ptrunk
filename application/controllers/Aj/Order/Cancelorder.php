<?php
/**
 * 取消订单，将订单状态status设置为0
 * @author liang
 * @version 2014-11-12
 */
class Aj_Order_CancelorderController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['boid'] = Comm_Context::post('boid');
		$info['uid'] = $this->viewer['uid'];
		
		if(empty($info['boid']) || empty($info['uid'])){
			$this->renderAjax(Tools_Conf::get('Show_Code.aj.fail'),'取消失败');
			return true;
		}
		
		//检查是否是当前用户的订单
		$data['boids'] = $info['boid'];
		$buyOrderInfos = Dr_Order::showBuyOrderByBoidsByApi($data);
		
		if($buyOrderInfos[0]['uid'] != $info['uid']){
			$this->renderAjax(Tools_Conf::get('Show_Code.aj.fail'),'取消失败');
			return true;
		}
		
		//检查订单是否被锁定
		if($buyOrderInfos[0]['lock'] == 1){
			$this->renderAjax(Tools_Conf::get('Show_Code.aj.fail'),'订单已经付款并锁定，不能取消');
			return true;
		}
		unset($data);
		
		$data['boid'] = $info['boid'];
		$data['status'] = 0;
		
		//取消订单
		Dw_Order::updateBuyOrderByBoidByApi($data);
		
		$this->renderAjax(Tools_Conf::get('Show_Code.aj.succ'));
		
		return true;
	}
}