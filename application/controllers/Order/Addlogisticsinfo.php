<?php
/**
 * 添加物流信息页
 * @author liang
 * @version 2014-12-16
 */
class Order_AddlogisticsinfoController extends AbstractController{
	public $tpl = 'order/addlogisticsinfo.phtml';
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		/*if($this->viewer['extends']['type'] != 1){
			echo 'You must be a buyer';
			return true;
		}*/
		
		$boid = Comm_Context::get('boid');
		
		if(empty($boid)){
			return false;
		}
		
		$info['boid'] = $boid;
		$logisticsInfos = Dr_Order::getLogisticsInfoByBoidByApi($info);
		
		$data = array();
		$data['boid'] = $boid;
		$data['nick'] = $this->viewer['nick'];
		$data['islogined'] = (empty($this->viewer)) ? false : true;
		$data['logisticsInfos'] = $logisticsInfos;
		$this->renderPage($this->tpl,$data);
		return true;
	}
}