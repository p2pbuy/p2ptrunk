<?php
/**
 * 买家订单处理页面
 * @author liang5
 * @version 2014-5-25
 */
class Aj_Order_BuyController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		$info['title'] = Comm_Context::post('title');
		$info['description'] = Comm_Context::post('description');
		$info['price'] = Comm_Context::post('price');
		$info['quantity'] = Comm_Context::post('quantity');
		$info['additional'] = Comm_Context::post('additional');
		$info['uid'] = $this->uid;
		
		$result = Dw_Order::createOrderBuyByApi($info);
		$this->renderAjax($result['code']);
		return true;
	}
}