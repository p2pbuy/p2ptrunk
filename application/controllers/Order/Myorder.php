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
		$bidPricesTmp = Dr_Bid::getBidPriceByBoidsByApi($info);
		
		if($bidPricesTmp){
			//按照同一uid排重出价
			foreach($bidPricesTmp as $boid => $bidPriceTmp){
				foreach($bidPriceTmp as $bidPrice){
					$bidPriceByUid[$bidPrice['uid']] = $bidPrice;
				}
				$bidPrices[$boid] = $bidPriceByUid;
			}
		}
		
		
		$data['viewer'] = $this->viewer;
		$data['myBuyOrders'] = $myBuyOrders;
		$data['myTakeOrders'] = ($myTakeOrders) ? $myTakeOrders : array();
		$data['myBidOrders'] = ($myBidOrders) ? $myBidOrders : array();
		$data['bidPrices'] = $bidPrices;
		$data['nick'] = $this->viewer['nick'];
		$data['usertype'] = ($this->viewer['extends']['type'] == 2) ? '我是买手' : '我是买家';
		$data['islogined'] = (empty($this->viewer)) ? false : true;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}