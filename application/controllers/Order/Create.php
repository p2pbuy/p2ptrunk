<?php
/**
 * 买家下求购订单
 * @author liang
 * @version 2014-8-21
 */
class Order_CreateController extends AbstractController{
	public $tpl = 'order/create.phtml';
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		/*if($this->viewer['extends']['type'] != 1){
			echo 'You must be a buyer';
			return true;
		}*/
		
		$from = Comm_Context::post('from');
		$parentASIN = Comm_Context::post('parentASIN');
		$thirdUrl = Comm_Context::post('thirdurl');
		$currentASIN = Comm_Context::post('currentASIN');
		
		if(empty($parentASIN)){
			return false;
		}
		
		$AmazonHandle = new Third_Amazon_Amazonhandle();
		$matchingProductForIdResult = $AmazonHandle->GetMatchingProductForId(array('idType'=>'ASIN','id'=>array($parentASIN)));
		$goods = $matchingProductForIdResult['GetMatchingProductForIdResponse']['GetMatchingProductForIdResult']['Products']['Product'];
		
		$data = array();

		$data['thirdurl'] = $thirdUrl;
		$data['nick'] = $this->viewer['nick'];
		$data['usertype'] = ($this->viewer['extends']['type'] == 2) ? '我是买手' : '我是买家';
		$data['islogined'] = (empty($this->viewer)) ? false : true;
		//$data['relationGoods'] = $goods['Relationships'];
		$data['goods'] = $goods;
		
		$i = 0;
		$j = 0;
		foreach($goods['Relationships']['ns2:VariationChild'] as $relationGoods){
			$i++;
			if($i > 10){
				$j++;
				$i = 0;
			}
			$relationGoodsArr[$j][] = $relationGoods;
		}
		$data['relationGoodsArr'] = $relationGoodsArr;
		
		$this->renderPage($this->tpl,$data);
		return true;
	}
}