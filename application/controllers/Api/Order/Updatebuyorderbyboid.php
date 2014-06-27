<?php
/**
 * 根据boid展示买家订单接口
 * @author liang
 * @version 2014-5-25
 */
class Api_Order_UpdatebuyorderbyboidController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = Comm_Context::get('source');
		$this->_context['boid'] = Comm_Context::get('boid');
		$this->_context['sign'] = Comm_Context::get('sign');
		
		$this->_checkFields = array('boid' => $this->_context['boid']);
		return true;
	}
	public function doAction(){
		$re = Dw_Order::updateBuyOrderByBoidByDb($this->_context['boid']);
		
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