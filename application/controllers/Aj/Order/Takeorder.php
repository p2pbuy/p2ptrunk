<?php
/**
 * 走私者接单处理页面
 * @author liang5
 * @version 2014-5-25
 */
class Aj_Order_TakeorderController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['boid'] = Comm_Context::post('boid');
		$info['uid'] = $this->uid;
		
		$result = Dw_Order::smugglerTakeOrderByApi($info);
		
		$this->renderAjax($result['code'],$result['msg']);
		return true;
	}
}