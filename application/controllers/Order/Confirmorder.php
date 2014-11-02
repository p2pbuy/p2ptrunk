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
		
		//获得当前用户的收获地址
		$addressInfos = Dr_Order::getAddressByUidByApi(array('uid'=>$this->viewer['uid']));
		
		//获得当前订单的详细内容
		$curBuyOrderInfo = Dr_Order::showBuyOrderByBoidsByApi(array('boids'=>$boid));
		//var_dump($curBuyOrderInfo,$bidPrice);
		
		$data['boid'] = $boid;
		$data['bidprice'] = $bidPrice;
		$data['viewer'] = $this->viewer;
		$data['bid'] = $bid;
		$data['biduid'] = $biduid;
		$data['nick'] = $this->viewer['nick'];
		$data['usertype'] = ($this->viewer['extends']['type'] == 2) ? '我是买手' : '我是买家';
		$data['islogined'] = (empty($this->viewer)) ? false : true;
		$data['curBuyOrderInfo'] = $curBuyOrderInfo[0];
		$data['addressInfos'] = $addressInfos;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}