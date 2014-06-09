<?php
/**
 * 展示买家订单接口
 * @author liang
 * @version 2014-5-25
 */
class Api_Order_ShowbuyorderbyuidController extends Api_AbstractController{
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
		
		$buyOrders = Dr_Order::showBuyOrderByUid($info);
		foreach($buyOrders as $buyOrder){
			$re[$buyOrder['boid']] = $buyOrder;
		}

		if($re == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'get buy order info fail';
			$re = false;
		}else{
			$code = Tools_Conf::get('Show_Code.api.succ');
		}
		$this->renderAjax($code,$msg,$re);
		return true;
	}
}