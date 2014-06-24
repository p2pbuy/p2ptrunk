<?php
/**
 * 获得更多orderlist
 * @author liang5
 * @version 2014-6-24
 */
class Aj_Order_GetmoreorderController extends AbstractController{
	public $authorize = self::MAYBELOGIN;
	public $tpl = 'aj/order/getmoreorder.phtml';
	public function hookAction(){
		$info['page'] = Comm_Context::post('page','int');
		$info['count'] = Comm_Context::post('count','int');
		
		$buyOrderInfos = Dr_Order::showBuyOrderByApi($info);
		
		if($buyOrderInfos == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'fail';
			$html = false;
		}else{
			foreach($buyOrderInfos as $buyOrderInfo){
				$person = Dr_User::show($buyOrderInfo['uid']);
				$buyOrderInfo['person'] = $person;
				$results[] = $buyOrderInfo;
			}
			
			$data['results'] = $results;
			$code = Tools_Conf::get('Show_Code.api.succ');
			$msg = 'succ';
			$html = $this->renderHtml($this->tpl,$data);;
		}
		
		$this->renderAjax($code,$msg,array('html'=>$html));
		return true;
	}
}