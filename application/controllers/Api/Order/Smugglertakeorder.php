<?php
/**
 * 走私者接单
 * @author liang
 * @version 2014-5-28
 */
class Api_Order_SmugglertakeorderController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = Comm_Context::post('source');
		$this->_context['boid'] = Comm_Context::post('boid');
		$this->_context['uid'] = Comm_Context::post('uid');
		$this->_context['sign'] = Comm_Context::post('sign');
		
		$this->_checkFields = array('boid' => $this->_context['boid'],'uid' => $this->_context['uid']);
		return true;
	}
	public function doAction(){
		$info['boid'] = $this->_context['boid'];
		$info['uid'] = $this->_context['uid'];
		
		$userInfo = Dr_User::show($info['uid']);
		/*if($userInfo['extends']['type'] != 2){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'you must be a smuggler';
			$this->renderAjax($code,$msg);
			return true;
		}*/
		
		$re = Dw_Order::smugglerTakeOrderByDb($info);
		if($re == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'order has been token';
		}else{
			$code = Tools_Conf::get('Show_Code.api.succ');
			$msg = '';
		}

		$this->renderAjax($code,$msg);
		return true;
	}
}