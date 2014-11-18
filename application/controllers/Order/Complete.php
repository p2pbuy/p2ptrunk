<?php
/**
 * 订单支付成功页
 * @author liang
 * @version 2014-11-18
 */
class Order_CompleteController extends AbstractController{
	public $tpl = 'order/complete.phtml';
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
		
		$data = array();
		$data['boid'] = $boid;
		$data['nick'] = $this->viewer['nick'];
		$data['islogined'] = (empty($this->viewer)) ? false : true;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}