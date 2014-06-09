<?php
/**
 * 竞价接口
 * @author liang
 * @version 2014-5-25
 */
class Api_Bid_BidbuyorderController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = Comm_Context::post('source');
		$this->_context['uid'] = Comm_Context::post('uid');
		$this->_context['bidprice'] = Comm_Context::post('bidprice');
		$this->_context['boid'] = Comm_Context::post('boid');
		$this->_context['sign'] = Comm_Context::post('sign');
		
		$this->_checkFields = array('boid' => $this->_context['boid'],'bidprice' => $this->_context['bidprice'],'uid' => $this->_context['uid']);
		return true;
	}
	public function doAction(){
		$info['boid'] = $this->_context['boid'];
		$info['bidprice'] = $this->_context['bidprice'];
		$info['uid'] = $this->_context['uid'];
		
		$buyOrderInfos = Dr_Order::showBuyOrderByBoids($info['boid']);
		if($buyOrderInfos[0][lock] == 1){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'order has been locked';
		}else{
			$re = Dw_Bid::bidBuyOrderByDb($info);
	
			if($re == false){
				$code = Tools_Conf::get('Show_Code.api.fail');
				$msg = 'bidding fail';
			}else{
				$code = Tools_Conf::get('Show_Code.api.succ');
			}
		}

		$this->renderAjax($code,$msg);
		return true;
	}
}