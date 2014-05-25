<?php
/**
 * 展示买家订单接口
 * @author liang
 * @version 2014-5-25
 */
class Api_Order_ShoworderbuyController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = Comm_Context::get('source');
		$this->_context['count'] = Comm_Context::get('count');
		$this->_context['page'] = Comm_Context::get('page');
		$this->_context['sign'] = Comm_Context::get('sign');
		
		$this->_checkFields = array();
		return true;
	}
	public function doAction(){
		$info['count'] = $this->_context['count'];
		$info['page'] = $this->_context['page'];
		
		$re = Dr_Order::showOrderBuy($info);
		$this->renderAjax(Tools_Conf::get('Show_Code.api.succ'),'',$re);
		return true;
	}
}