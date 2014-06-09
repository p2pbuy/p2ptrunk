<?php
/**
 * 买手接单页面
 * @author liang
 * @version 2014-6-8
 */
class Order_TakeorderController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public $tpl = 'order/takeorder.phtml';
	public function hookAction(){
		if($this->viewer['extends']['type'] != 2){
			echo 'You must be a sumaggler';
			return true;
		}
		
		$boids = Comm_Context::get('boids');
		if(empty($boids)){
			return false;
		}
		
		$info['boids'] = $boids;
		$buyOrders = Dr_Order::showBuyOrderByBoidsByApi($info);
		$data['buyOrder'] = $buyOrders[0];
		
		$this->renderPage($this->tpl,$data);
		return true;
	}
}