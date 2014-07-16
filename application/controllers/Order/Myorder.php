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
		$myBidOrders = array();
		
		//获得我发布的订单列表
		$myBuyOrders = Dr_Order::showBuyOrderByUidByApi($info);
		$myTakeOrders = Dr_Order::showTakeOrderByUidByApi($info);
		//我的出价信息
		$myBidInfos = Dr_Bid::getBidInfoByUidByApi($info);
		unset($info);
		//我曾经出过价的订单
		foreach($myBidInfos as $myBidInfo){
			$boids .= $myBidInfo['boid'].',';
		}
		$boids = substr($boids,0,-1);
		$info['boids'] = $boids;
		$myBidOrders = Dr_Order::showBuyOrderByBoidsByApi($info);

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
		$data['myBidOrders'] = $myBidOrders;
		$data['bidPrices'] = $bidPrices;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}