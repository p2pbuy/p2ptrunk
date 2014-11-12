<?php
/**
 * 获得更多orderlist json格式
 * @author liang
 * @version 2014-11-12
 */
class Aj_Order_GetmoreorderjsonController extends AbstractController{
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		$info['page'] = Comm_Context::post('page','int');
		$info['count'] = Comm_Context::post('count','int');
		
		if(empty($info['page']) || empty($info['count'])){
			return false;
		}
		
		$buyOrderInfos = Dr_Order::showBuyOrderByApi($info);
		
		if($buyOrderInfos == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'fail';
			$html = false;
		}else{
			
			$data = $buyOrderInfos;
			$code = Tools_Conf::get('Show_Code.api.succ');
			$msg = 'succ';
		}
		
		$this->renderAjax($code,$msg,$data);
		return true;
	}
}