<?php
/*
 * 支付宝支付接口
 * Cdpbu create_direct_pay_by_user
 */
class Third_Alipay_Cdpbu_CallbackController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$params = $_GET;
		
		//将返回信息入库
		$data['uid'] = $this->viewer['uid'];
		$data['boid'] = $params['out_trade_no'];
		$data['resultinfo'] = serialize($params);
		$data['result'] = $params['is_success'];
		
		Dw_Alipay::insertResult($data);
		unset($data);
		
		//更新订单status为30
		$data['boid'] = $params['out_trade_no'];;
		$data['status'] = 30;

		Dw_Order::updateBuyOrderByBoidByApi($data);
		unset($data);
		
		//跳转到成功页面
		header('Location:/order/complete?boid='.$params['out_trade_no']);
		
		return true;
	}
}