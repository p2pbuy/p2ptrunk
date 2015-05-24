<?php
/**
 * 分配定单页面
 * @author liang
 * @version 2015-5-24
 */
class Order_AssignorderController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public $tpl = 'order/assignorder.phtml';
	public function hookAction(){
		/*if($this->viewer['extends']['type'] != 2){
			echo 'You must be a sumaggler';
			return true;
		}*/
		
		$boids = Comm_Context::get('boids');
		if(empty($boids)){
			return false;
		}
		
		//如果是管理员，展示所有订单
		if($this->viewer['uid'] == Tools_Conf::get('Manager.uid')){
			$data['isManager'] = true;
		}
		
		$info['boids'] = $boids;
		$buyOrders = Dr_Order::showBuyOrderByBoidsByApi($info);
		$data['buyOrder'] = $buyOrders[0];
		$data['nick'] = $this->viewer['nick'];
		$data['usertype'] = ($this->viewer['extends']['type'] == 2) ? '我是买手' : '我是买家';
		$data['islogined'] = (empty($this->viewer)) ? false : true;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}