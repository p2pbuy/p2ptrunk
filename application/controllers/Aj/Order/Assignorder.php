<?php
/**
 * 管理员分配订单处理页面
 * @author liang
 * @version 2015-5-24
 */
class Aj_Order_assignorderController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['boid'] = Comm_Context::post('boid');
		$info['assignEmail'] = Comm_Context::post('assignEmail');
		//$info['buid'] = $this->uid;
		
		if($this->viewer['uid'] != Tools_Conf::get('Manager.uid')){
			$code = Tools_Conf::get('Show_Code.aj.fail');
			$msg = 'you are not manager';
		}else{
			//根据assignEmail 查询对应的uid
			$assignUserInfo = Dr_User::getUserInfoByEamilByApi(array('email'=>$info['assignEmail']));
			
			$data['boid'] = $info['boid'];
			$data['uid'] = $assignUserInfo['uid'];
			//分配给别人订单
			$reTakeOrder = Dw_Order::smugglerTakeOrderByApi($data);
			unset($data);
			
			$data['boid'] = $info['boid'];
			$data['lock'] = 2;
			$data['addressid'] = 0;
			$data['dealprice'] = 0;
			$data['status'] = 20;
			//锁定订单
			$reUpdOrder =Dw_Order::updateBuyOrderByBoidByApi($data);
			unset($data);

			if($reTakeOrder['code'] == 100000 || $reUpdOrder == 100000){
				$code = Tools_Conf::get('Show_Code.aj.succ');
				$msg = 'succ';
			}else{
				$code = Tools_Conf::get('Show_Code.aj.fail');
				$msg = $re['msg'];
			}
		}
		
		$this->renderAjax($code,$msg);
		return true;
	}
}