<?php
/**
 * 展示订单详情
 * @author liang
 * @version 2014-5-25
 */
class Order_ShowController extends AbstractController{
	public $tpl = 'order/show.phtml';
	//public $authorize = self::MUSTLOGIN;
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		/*if($this->viewer['extends']['type'] != 1){
			echo 'You must be a buyer';
			return true;
		}*/
		
		$boid = Comm_Context::get('boid');
		
		if(empty($boid)){
			return false;
		}
		
		//获得订单信息
		$info['boids'] = $boid;
		$buyOrderInfo = Dr_Order::showBuyOrderByBoidsByApi($info);
		unset($info);
		
		//获得订单的买家昵称
		$buyOrderUserInfo = Dr_User::show($buyOrderInfo[0]['uid']);
		$buyOrderInfo[0]['nick'] = $buyOrderUserInfo[$buyOrderInfo[0]['uid']]['nick'];
		
		//获得订单的竞价
		$info['boids'] = $boid;
		$bidPrices = Dr_Bid::getBidPriceByBoidsByApi($info);
		unset($info);
		
		$data = array();
		$data['orderInfo'] = $buyOrderInfo[0];
		$data['bidPrices'] = $bidPrices[$boid];
		$data['nick'] = $this->viewer['nick'];
		$data['usertype'] = ($this->viewer['extends']['type'] == 2) ? '我是买手' : '我是买家';
		$data['islogined'] = (empty($this->viewer)) ? false : true;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}