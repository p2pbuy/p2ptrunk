<?php
/**
 * 创建买家订单接口
 * @author liang
 * @version 2014-5-25
 */
class Api_Order_CreateorderbuyController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = Comm_Context::post('source');
		$this->_context['uid'] = Comm_Context::post('uid');
		$this->_context['title'] = Comm_Context::post('title');
		$this->_context['description'] = Comm_Context::post('description');
		$this->_context['price'] = Comm_Context::post('price');
		$this->_context['quantity'] = Comm_Context::post('quantity');
		$this->_context['additional'] = Comm_Context::post('additional');
		$this->_context['sign'] = Comm_Context::post('sign');
		
		$this->_checkFields = array('uid' => $this->_context['uid'],'quantity' => $this->_context['quantity']);
		return true;
	}
	public function doAction(){
		$info['uid'] = $this->_context['uid'];
		$info['title'] = $this->_context['title'];
		$info['description'] = $this->_context['description'];
		$info['price'] = $this->_context['price'];
		$info['quantity'] = $this->_context['quantity'];
		$info['additional'] = $this->_context['additional'];
		
		$re = Dw_Order::createOrderBuyByDb($info);
		if($re == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'create buyorder fail';
		}else{
			$code = Tools_Conf::get('Show_Code.api.succ');
		}

		$this->renderAjax($code,$msg);
		return true;
	}
}