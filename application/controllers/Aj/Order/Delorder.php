<?php
/**
 * 删除订单
 * @author liang
 * @version 2014-11-12
 */
class Aj_Order_DelorderController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['boid'] = Comm_Context::post('boid');
		$info['uid'] = $this->viewer['uid'];
		
		if(empty($info['boid']) || empty($info['uid'])){
			return true;
		}
		
		//检查是否是管理员
		if($this->viewer['uid'] != Tools_Conf::get('Manager.uid')){
			return true;
		}
		
		//删除订单
		Dw_Order::delBuyOrderByBoidByApi($info);
		
		$this->renderAjax(Tools_Conf::get('Show_Code.aj.succ'));
		
		return true;
	}
}