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
		
		//发送邮件
		$mail = new Tools_Mail();
		$mail->IsSMTP();
		//开启调试模式
		//$mail->SMTPDebug = true;
		//$mail->Timeout = 10;
		$mail->SMTPAuth = true;
		$mail->From = 'service@p2pbuy.net';
		$mail->FromName = 'service';
		$mail->IsHTML(true);
		$mail->Body = '订单号：'.$data['boid'].'</br>';
		$mail->ClearAddresses();
		$mail->AddAddress('leoncui57@hotmail.com');
		$mail->Subject = $this->viewer['nick'].'付款了';
		$mail->Send();
		
		//跳转到成功页面
		header('Location:/order/complete?boid='.$params['out_trade_no']);
		
		return true;
	}
}