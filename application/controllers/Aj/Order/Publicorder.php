<?php
/**
 * 公开订单
 * @author liang
 * @version 2014-11-3
 */
class Aj_Order_PublicorderController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['boid'] = Comm_Context::post('boid');
		$info['isshow'] = Comm_Context::post('isshow');
		
		if(empty($info['boid']) || !is_numeric($info['boid'])){
			return false;
		}
		
		//检查当前用户是否是管理员buyer
		if($this->uid != Tools_Conf::get('Manager.uid')){
			return false;
		}
		
		$data['boid'] = $info['boid'];
		$data['isshow'] = $info['isshow'];
		//更新订单isshow属性
		$re = Dw_Order::updateBuyOrderByBoidByApi($data);
		
		$code = Tools_Conf::get('Show_Code.aj.succ');
		$msg = 'succ';
		
		$this->renderAjax($code,$msg);
		return true;
	}
}