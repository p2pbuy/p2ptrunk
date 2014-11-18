<?php
/**
 * 支付费用
 * @author liang
 * @version 2014-10-27
 */
class Order_PaymentController extends AbstractController{
	public $tpl = 'order/payment.phtml';
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$boid = Comm_Context::get('boid');
		
		if(empty($boid)){
			return false;
		}
		
		$uid = $this->uid;
		
		//查看是否是当前人的订单
		$buyOrders = Dr_Order::showBuyOrderByUidByApi(array('uid'=>$uid));
		$boids = array_keys($buyOrders);
		if(!in_array($boid, $boids)){
			return false;
		}
		
		//获得当前订单的详细内容
		$curBuyOrderInfo = Dr_Order::showBuyOrderByBoidsByApi(array('boids'=>$boid));
		
		$data['curBuyOrderInfo'] = $curBuyOrderInfo[0];
		$data['nick'] = $this->viewer['nick'];
		$data['alipayUrl'] = '/third/alipay/cdpbu/alipayapi?boid='.$boid.'&title='.$curBuyOrderInfo[0]['title'].'&price='.$curBuyOrderInfo[0]['dealprice'];
		
		$this->renderPage($this->tpl,$data);
		return true;
	}
}