<?php
/**
 * 我的订单列表
 * @author liang
 * @version 2014-6-8
 */
class Order_MyorderController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public $tpl = 'order/myorder.phtml';
	public function hookAction(){
		$info['uid'] = $this->uid;
		$myOrderids = '';
		$myOrders = Dr_Order::showBuyOrderByUidByApi($info);
		unset($info);
		$myOrders = ($myOrders) ? $myOrders : array();
		
		foreach($myOrders as $myOrder){
			$myOrderids .= $myOrder['boid'].',';
		}
		$myOrderids = substr($myOrderids, 0, -1);
		
		$info['boids'] = $myOrderids;
		$bidPrices = Dr_Bid::getBidPriceByBoidsByApi($info);
		
		$data['viewer'] = $this->viewer;
		$data['myOrders'] = $myOrders;
		$data['bidPrices'] = $bidPrices;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}