<?php
/**
 * 根据用户uid获得竞价信息
 * @author liang
 * @version 2014-7-16
 */
class Api_Bid_GetbidinfobyuidController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = Comm_Context::get('source');
		$this->_context['uid'] = Comm_Context::get('uid');
		$this->_context['sign'] = Comm_Context::get('sign');
		
		$this->_checkFields = array('uid' => $this->_context['uid']);
		return true;
	}
	public function doAction(){
		$bidInfo = Dr_Bid::getBidInfoByUidByDb($this->_context['uid']);

		$this->renderAjax(Tools_Conf::get('Show_Code.api.succ'),'',$bidInfo);
		return true;
	}
}