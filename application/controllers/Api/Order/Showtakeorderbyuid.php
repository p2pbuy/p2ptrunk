<?php
/**
 * 展示买家手已经接到的订单接口
 * @author liang
 * @version 2014-6-27
 */
class Api_Order_ShowtakeorderbyuidController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = Comm_Context::get('source');
		$this->_context['count'] = Comm_Context::get('count');
		$this->_context['page'] = Comm_Context::get('page');
		$this->_context['uid'] = Comm_Context::get('uid');
		$this->_context['sign'] = Comm_Context::get('sign');
		
		$this->_checkFields = array('uid' => $this->_context['uid']);
		return true;
	}
	public function doAction(){
		$info['count'] = $this->_context['count'];
		$info['page'] = $this->_context['page'];
		$info['uid'] = $this->_context['uid'];
		$myTakeOrderids = '';
		
		//获得接到订单的ID
		$myTakeOrders = Dr_Order::showTakeOrderByUid($info);
		foreach($myTakeOrders as $myTakeOrder){
			$myTakeOrderids .= $myTakeOrder['boid'].',';
		}
		$myTakeOrderids = substr($myTakeOrderids, 0, -1);
		
		$myTakeOrders = Dr_Order::showBuyOrderByBoids($myTakeOrderids);
		foreach($myTakeOrders as $myTakeOrder){
			$data[$myTakeOrder['boid']] = $myTakeOrder;
		}

		if($data == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'get take order info fail';
		}else{
			$code = Tools_Conf::get('Show_Code.api.succ');
		}
		$this->renderAjax($code,$msg,$data);
		return true;
	}
}