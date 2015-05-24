<?php
/**
 * 删除物流信息处理程序
 * @author liang
 * @version 2014-12-17
 */
class Aj_Order_DellogisticsinfoController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		/*if($this->viewer['extends']['type'] != 1){
			echo 'You must be a buyer';
			return true;
		}*/
		
		$boid = Comm_Context::post('boid');
		$id = Comm_Context::post('id');
		
		if(empty($boid) || empty($id)){
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
		$data['id'] = $id;
		
		$re = Dw_Order::delLogisticsInfoByIdByApi($data);
		
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