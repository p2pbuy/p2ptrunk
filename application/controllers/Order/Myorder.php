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
		$myBuyOrderids = '';
		//获得我发布的订单列表
		$myBuyOrders = Dr_Order::showBuyOrderByUidByApi($info);
		$myTakeOrders = Dr_Order::showTakeOrderByUidByApi($info);
		unset($info);
		$myBuyOrders = ($myBuyOrders) ? $myBuyOrders : array();
		
		foreach($myBuyOrders as $myBuyOrder){
			$myBuyOrderids .= $myBuyOrder['boid'].',';
		}
		$myBuyOrderids = substr($myBuyOrderids, 0, -1);
		
		$info['boids'] = $myBuyOrderids;
		$bidPrices = Dr_Bid::getBidPriceByBoidsByApi($info);
		
		
		$data['viewer'] = $this->viewer;
		$data['myBuyOrders'] = $myBuyOrders;
		$data['myTakeOrders'] = $myTakeOrders;
		$data['bidPrices'] = $bidPrices;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}