<?php
/**
 * 根据boid获取订单信息
 * @author liang
 * @version 2014-11-3
 */
class Aj_Order_GetorderinfobyboidsController extends AbstractController{
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		$info['boids'] = Comm_Context::get('boids','str');
		
		if(empty($info['boids'])){
			return false;
		}
		
		$buyOrderInfos = Dr_Order::showBuyOrderByBoidsByApi($info);
		
		if($buyOrderInfos == false){
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'fail';
			$html = false;
		}else{
			foreach($buyOrderInfos as $buyOrderInfo){
				$results[$buyOrderInfo['boid']] = $buyOrderInfo;
			}
			
			$code = Tools_Conf::get('Show_Code.api.succ');
			$msg = 'succ';
		}
		
		$this->renderAjax($code,$msg,$results);
		return true;
	}
}