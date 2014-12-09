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
		$showType = (Comm_Context::get('showtype','str')) ? Comm_Context::get('showtype','str') : 'myorder';
		
		$info['uid'] = $this->uid;
		$myBuyOrderids = '';
		$myBidOrders = array();
		
		//获得我发布的订单列表
		switch($showType){
			case '':
			case 'myorder':
				//我的订单
				$myBuyOrders = Dr_Order::showBuyOrderByUidByApi($info);
				break;
			case 'tokenorder':
				//我出过价的订单
				$myTakeOrders = Dr_Order::showTakeOrderByUidByApi($info);
				break;
			case 'bidorder':
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
				break;
			default:
				break;
		}
		
		//如果是管理员，展示所有订单
		if($this->viewer['uid'] == Tools_Conf::get('Manager.uid')){
			$allMyOrders = Dr_Order::showBuyOrderByApi();
			$data['isShowAllBuyOrder'] = true;
		}
		
		$data['viewer'] = $this->viewer;
		$data['myBuyOrders'] = $myBuyOrders;
		$data['myTakeOrders'] = ($myTakeOrders) ? $myTakeOrders : array();
		$data['myBidOrders'] = ($myBidOrders) ? $myBidOrders : array();
		$data['allBuyOrders'] = ($allMyOrders) ? $allMyOrders : array();
		$data['bidPrices'] = $bidPrices;
		$data['showType'] = $showType;
		$data['nick'] = $this->viewer['nick'];
		$data['usertype'] = ($this->viewer['extends']['type'] == 2) ? '我是买手' : '我是买家';
		$data['islogined'] = (empty($this->viewer)) ? false : true;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}