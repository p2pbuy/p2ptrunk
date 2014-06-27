<?php
/**
 * 确认订单并付款
 * @author liang
 * @version 2014-6-13
 */
class Order_ConfirmorderController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public $tpl = 'order/confirmorder.phtml';
	public function hookAction(){
		$boid = Comm_Context::post('boid');
		$bidPrice = Comm_Context::post('bidprice');
		$bid = Comm_Context::post('bid');
		$biduid = Comm_Context::post('biduid');
		$uid = $this->uid;
		
		//查看是否是当前人的订单
		$buyOrders = Dr_Order::showBuyOrderByUidByApi(array('uid'=>$uid));
		$boids = array_keys($buyOrders);
		if(!in_array($boid, $boids)){
			return false;
		}
		
		
		$data['boid'] = $boid;
		$data['bidprice'] = $bidPrice;
		$data['viewer'] = $this->viewer;
		$data['usertype'] = ($this->viewer['extends']['type'] == 2) ? '我是买手' : '我是买家';
		$data['bid'] = $bid;
		$data['biduid'] = $biduid;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}