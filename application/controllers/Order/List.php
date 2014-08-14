<?php
class Order_ListController extends AbstractController{
	public $tpl = 'order/list.phtml';
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		$buyOrderInfos = Dr_Order::showBuyOrderByApi();
		
		foreach($buyOrderInfos as $buyOrderInfo){
			if($buyOrderInfo['lock'] == 1){
				continue;
			}
			$person = Dr_User::show($buyOrderInfo['uid']);
			$buyOrderInfo['person'] = $person;
			$results[] = $buyOrderInfo;
		}
		
		$data['nick'] = $this->viewer['nick'];
		$data['usertype'] = ($this->viewer['extends']['type'] == 2) ? '我是买手' : '我是买家';
		$data['results'] = $results;
		$data['islogined'] = (empty($this->viewer)) ? false : true;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}
