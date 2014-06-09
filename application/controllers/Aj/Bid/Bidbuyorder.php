<?php
/**
 * 买家订单竞价
 * @author liang
 * @version 2014-6-8
 */
class Aj_Bid_BidbuyorderController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		if($this->viewer['extends']['type'] != 2){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'You must be a sumaggler';
			$this->renderAjax($code,$msg,$data);
			return true;
		}
		
		$info['boid'] = Comm_Context::post('boid');
		$info['bidprice'] = Comm_Context::post('bidprice');
		$info['uid'] = $this->uid;
		
		$result = Dw_Bid::bidBuyOrderByApi($info);

		if($result == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'bid fail';
		}else{
			$code = $result['code'];
			$msg = $result['msg'];
		}
		
		$this->renderAjax($code,$msg);
		return true;
	}
}