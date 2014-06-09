<?php
/**
 * 根据订单boid获得竞价接口
 * @author liang
 * @version 2014-5-25
 */
class Api_Bid_GetbidpricebyboidsController extends Api_AbstractController{
	public function checkParams(){
		$this->_context['source'] = Comm_Context::get('source');
		$this->_context['boids'] = Comm_Context::get('boids');
		$this->_context['sign'] = Comm_Context::get('sign');
		
		$this->_checkFields = array('boids' => $this->_context['boids']);
		return true;
	}
	public function doAction(){
		$bidPriceInfos = Dr_Bid::getBidPriceByBoidsByDb($this->_context['boids']);
		foreach($bidPriceInfos as $bidPriceInfo){
			$data[$bidPriceInfo['boid']][] = $bidPriceInfo;
		}

		$this->renderAjax(Tools_Conf::get('Show_Code.api.succ'),'',$data);
		return true;
	}
}