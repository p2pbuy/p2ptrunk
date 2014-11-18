<?php
/**
 * 订单详情页
 * @author liang
 * @version 2014-11-18
 */
class Order_DetailController extends AbstractController{
	public $tpl = 'order/detail.phtml';
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
		$orderInfo = Dr_Order::showBuyOrderByBoidsByApi($info);
		
		$info['boids'] = $boid;
		$bidPrices = Dr_Bid::getBidPriceByBoidsByApi($info);
		
		$data = array();
		$data['nick'] = $this->viewer['nick'];
		$data['usertype'] = ($this->viewer['extends']['type'] == 2) ? '我是买手' : '我是买家';
		$data['islogined'] = (empty($this->viewer)) ? false : true;
		$data['bidPrices'] = $bidPrices[$boid];
		$data['orderInfo'] = $orderInfo[0];
		$this->renderPage($this->tpl,$data);
		return true;
	}
}