<?php
/**
 * 买家下求购订单
 * @author liang
 * @version 2014-5-25
 */
class Order_BuyController extends AbstractController{
	public $tpl = 'order/buy.phtml';
	//public $authorize = self::MUSTLOGIN;
	public $authorize = self::NOTLOGIN;
	public function hookAction(){
		/*if($this->viewer['extends']['type'] != 1){
			echo 'You must be a buyer';
			return true;
		}*/
		
		$title = Comm_Context::post('title');
		$description = Comm_Context::post('feature');
		$price = Comm_Context::post('price');
		$img = Comm_Context::post('img');
		$thirdUrl = Comm_Context::get('thirdurl');
		
		$data = array();
		$data['title'] = $title;
		$data['description'] = $description;
		$data['price'] = $price;
		$data['img'] = $img;
		$data['thirdurl'] = $thirdUrl;
		$data['nick'] = $this->viewer['nick'];
		$data['usertype'] = ($this->viewer['extends']['type'] == 2) ? '我是买手' : '我是买家';
		$data['islogined'] = (empty($this->viewer)) ? false : true;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}