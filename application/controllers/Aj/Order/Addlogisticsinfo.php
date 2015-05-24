<?php
/**
 * 添加物流信息处理程序
 * @author liang
 * @version 2014-12-17
 */
class Aj_Order_AddlogisticsinfoController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		/*if($this->viewer['extends']['type'] != 1){
			echo 'You must be a buyer';
			return true;
		}*/
		
		$boid = Comm_Context::post('boid');
		$info = Comm_Context::post('info');
		$createtime = Comm_Context::post('createtime');
		$operator = Comm_Context::post('operator');
		
		if(empty($boid)){
			return false;
		}
		
		$data['uid'] = $this->viewer['uid'];
		$tokenOrderInfo = Dr_Order::showTakeOrderByUidByApi($data);
		$tokenOrderBoids = array_keys($tokenOrderInfo);
		unset($data);
		
		//检查当前用户是否是管理员buyer
		if(!in_array($boid,$tokenOrderBoids)){
			return false;
		}
		
		$data['boid'] = $boid;
		$data['info'] = $info;
		$data['createtime'] = $createtime;
		$data['operator'] = $operator;
		
		$re = Dw_Order::addLogisticsInfoByApi($data);
		
		if($re == false){
			$code = Tools_Conf::get('Show_Code.aj.fail');
			$msg = 'fail';
		}else{
			$code = Tools_Conf::get('Show_Code.aj.succ');
			$msg = 'succ';
		}
		
		$this->renderAjax($code,$msg);
		
		return true;
	}
}