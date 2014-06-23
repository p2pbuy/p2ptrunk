<?php
/**
 * 买家下求购订单
 * @author liang
 * @version 2014-5-25
 */
class Order_BuyController extends AbstractController{
	public $tpl = 'order/buy.phtml';
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		/*if($this->viewer['extends']['type'] != 1){
			echo 'You must be a buyer';
			return true;
		}*/
		
		$data = array();
		$this->renderPage($this->tpl,$data);
		return true;
	}
}