<?php
class IndexController extends AbstractController{
	public $tpl = 'index.phtml';
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		$orderBuyInfos = Dr_Order::showOrderBuy();
		
		foreach($orderBuyInfos as $orderBuyInfo){
			$person = Dr_User::show($orderBuyInfo['uid']);
			$orderBuyInfo['person'] = $person;
			$results[] = $orderBuyInfo;
		}
		
		$data['nick'] = $this->viewer['nick'];
		$data['usertype'] = ($this->viewer['extends']['type'] == 2) ? '我是买手' : '我是买家';
		$data['results'] = $results;
		$data['islogined'] = (empty($this->viewer)) ? false : true;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}
