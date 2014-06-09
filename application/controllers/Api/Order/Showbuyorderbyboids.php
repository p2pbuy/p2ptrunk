<?php
/**
 * 根据boid展示买家订单接口
 * @author liang
 * @version 2014-5-25
 */
class Api_Order_ShowbuyorderbyboidsController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = Comm_Context::get('source');
		$this->_context['boids'] = Comm_Context::get('boids');
		$this->_context['sign'] = Comm_Context::get('sign');
		
		$this->_checkFields = array('boids' => $this->_context['boids']);
		return true;
	}
	public function doAction(){
		$re = Dr_Order::showBuyOrderByBoids($this->_context['boids']);
		
		if($re == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'order not exsist';
		}else{
			$code = Tools_Conf::get('Show_Code.api.succ');
		}
		$this->renderAjax($code,$msg,$re);
		return true;
	}
}