<?php
class IndexController extends AbstractController{
	public $tpl = 'index.phtml';
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		$orderBuyInfos = Dr_Order::showOrderBuy();
		
		$data['orderBuyInfos'] = $orderBuyInfos;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}
